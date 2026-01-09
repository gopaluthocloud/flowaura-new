/* -------- SET COOKIE FROM URL FIRST -------- */

function setEnvCookieFromUrl() {
    const urlParams = new URLSearchParams(window.location.search);
    const envType = urlParams.get("envType");

    if (envType) {
        // Check if we're on HTTPS or HTTP to decide about Secure flag
        const isSecure = window.location.protocol === 'https:';
        const secureFlag = isSecure ? '; Secure' : '';
        
        // Set cookie (1 day expiry) - only use Secure flag for HTTPS
        document.cookie = `envType=${envType}; path=/; max-age=86400${secureFlag}`;
        console.log("Env cookie set to:", envType, "Secure flag:", isSecure);
    }
}

// Run first
setEnvCookieFromUrl();


/* -------- READ COOKIE -------- */

function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) {
            return c.substring(nameEQ.length, c.length);
        }
    }
    return null;
}

var envType = getCookie("envType");

// DEFAULT = DEV (as per your login API)
var API_BASE = "https://restadmindev.utho.com/v2";

// PROD (if envType is not "dev")
if (envType !== "dev") {
    // alert(envType);
    API_BASE = "https://restadmin.utho.com/v2";
}

console.log("API BASE:", API_BASE, "envType from cookie:", envType);


/* -------- AUTH TOKEN -------- */

function getAuthToken() {
    // First check sessionStorage (for current session)
    let token = sessionStorage.getItem('auth_token');
    
    // If not found in sessionStorage, check localStorage (for "Remember me")
    if (!token) {
        token = localStorage.getItem('auth_token');
    }
    
    // If token found, return it
    if (token) {
        console.log("Auth token retrieved from storage");
        return token;
    }
    
    // Check URL parameters for token (if passed)
    const urlParams = new URLSearchParams(window.location.search);
    const urlToken = urlParams.get("token");
    if (urlToken) {
        console.log("Auth token retrieved from URL");
        return urlToken;
    }
    
    // If no token found, show error and redirect to login
    console.error("Auth token not found");
    showAuthError();
    return null;
}

// Function to show authentication error and redirect
function showAuthError() {
    // Create or show error message
    const errorDiv = document.createElement('div');
    errorDiv.style.cssText = `
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: #fee2e2;
        color: #dc2626;
        padding: 15px 20px;
        border-radius: 8px;
        border: 1px solid #fecaca;
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    `;
    
    errorDiv.innerHTML = `
        <i class="fas fa-exclamation-triangle"></i>
        <span>Session expired. Redirecting to login...</span>
    `;
    
    document.body.appendChild(errorDiv);
    
    // Redirect to login page after 2 seconds
    setTimeout(() => {
        window.location.href = 'login.php';
    }, 2000);
}

// Function to update auth token (if needed after refresh)
function updateAuthToken(newToken) {
    // Check where the current token is stored and update accordingly
    if (sessionStorage.getItem('auth_token')) {
        sessionStorage.setItem('auth_token', newToken);
    } else if (localStorage.getItem('auth_token')) {
        localStorage.setItem('auth_token', newToken);
    }
    console.log("Auth token updated");
}

// Function to logout and clear tokens
function logout() {
    sessionStorage.removeItem('auth_token');
    sessionStorage.removeItem('username');
    localStorage.removeItem('auth_token');
    localStorage.removeItem('username');
    window.location.href = 'login.php';
}


/* -------- API CALL FUNCTION -------- */

async function callApi(endpoint, params = {}, method = "GET") {
    try {
        const token = getAuthToken();
        if (!token) {
            // console.error("Auth token not found");
            // If no token, redirect to login
            window.location.href = 'login.php';
            return null;
        }

        let url = `${API_BASE}/${endpoint}`;

        const options = {
            method,
            headers: {
                "Accept": "application/json",
                "Content-Type": "application/json",
                "Authorization": `Bearer ${token}`
            }
        };

        // GET
        if (method === "GET" && Object.keys(params).length) {
            const cleanParams = Object.fromEntries(
                Object.entries(params)
                    .filter(([_, v]) => v !== undefined && v !== null && v !== "")
            );

            const queryString = new URLSearchParams(cleanParams).toString();

            if (queryString) {
                url += "?" + queryString;
            }

            console.log("Final URL:", url);
        }

        // POST / PUT
        if (method !== "GET") {
            options.body = JSON.stringify(params);
        }

        const response = await fetch(url, options);

        if (response.status === 401) {
            console.warn("Token expired or invalid");
            // Token expired, logout and redirect
            logout();
            return null;
        }

        if (!response.ok) {
            throw new Error(`API Error ${response.status}`);
        }

        const data = await response.json();
        
        // Check if response indicates authentication failure
        if (data.rcode === "error" && data.rmessage && 
            (data.rmessage.toLowerCase().includes("unauthorized") || 
             data.rmessage.toLowerCase().includes("token") ||
             data.rmessage.toLowerCase().includes("auth"))) {
            console.warn("Authentication failed:", data.rmessage);
            logout();
            return null;
        }

        return data;

    } catch (err) {
        console.error("API Error:", err);
        
        // Handle network errors
        if (err.message.includes("Failed to fetch") || err.message.includes("NetworkError")) {
            console.error("Network error - please check your connection");
            // You could show a network error toast here
        }
        
        return null;
    }
}



/* -------- INITIALIZATION -------- */

// Check if user is logged in when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Set cookie from URL if present
    setEnvCookieFromUrl();
    
    // Read the envType cookie after setting it
    const envType = getCookie("envType");
    console.log("On page load - envType cookie:", envType);
    
    const token = getAuthToken();
    const currentPage = window.location.pathname;
    
    // If no token and not on login page, redirect to login
    if (!token && !currentPage.includes('login.php')) {
        console.warn("No auth token found, redirecting to login");
        window.location.href = 'login.php';
    }
    
    // If token exists, you can optionally validate it with the server
    if (token && currentPage !== 'login.php') {
        // Example: Validate token with server (optional)
        // validateTokenWithServer(token);
    }
});

// Optional: Token validation function
async function validateTokenWithServer(token) {
    try {
        const response = await fetch(`${API_BASE}/validate`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) {
            // Token is invalid
            logout();
        }
    } catch (error) {
        console.error("Token validation error:", error);
    }
}