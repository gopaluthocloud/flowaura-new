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

        // Clear any existing tokens when environment changes
        clearAuthTokens();
    }
}

// Run first
setEnvCookieFromUrl();


/* -------- READ COOKIE -------- */

function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) {
            return c.substring(nameEQ.length, c.length);
        }
    }
    return null;
}

// Get current environment
function getCurrentEnv() {
    const envType = getCookie("envType");
    return envType || "prod"; // Default to prod if no cookie
}

// Get environment-specific storage key
function getEnvStorageKey(baseKey) {
    const env = getCurrentEnv();
    return `${baseKey}_${env}`;
}


// Get environment-specific API base
function getApiBase() {
    const currentEnv = getCurrentEnv();
    if (currentEnv === "dev") {
        return "https://restadmindev.utho.com/v2";
    } else {
        return "https://restadmin.utho.com/v2";
    }
}

async function getLoggedAdmin() {
    return await callApi('admininfo');
}


// Set API_BASE based on environment
const API_BASE = getApiBase();
// console.log("Current environment:", getCurrentEnv(), "API Base:", API_BASE);


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
        // console.log("Auth token retrieved from storage");
        return token;
    }

    // Check URL parameters for token (if passed)
    const urlParams = new URLSearchParams(window.location.search);
    const urlToken = urlParams.get("token");
    if (urlToken) {
        // console.log("Auth token retrieved from URL");
        return urlToken;
    }

    // If no token found, show error and redirect to login
    console.error("Auth token not found");
    showAuthError();
    return null;
}

function getAuthToken() {
    const envKey = getEnvStorageKey('auth_token');

    // First check sessionStorage (for current session)
    let token = sessionStorage.getItem(envKey);

    // If not found in sessionStorage, check localStorage (for "Remember me")
    if (!token) {
        token = localStorage.getItem(envKey);
    }

    // If token found, return it
    if (token) {
        // console.log(`Auth token retrieved for ${getCurrentEnv()} environment`);
        return token;
    }

    // Check URL parameters for token (if passed)
    const urlParams = new URLSearchParams(window.location.search);
    const urlToken = urlParams.get("token");
    if (urlToken) {
        // console.log("Auth token retrieved from URL");
        return urlToken;
    }

    // If no token found, show error and redirect to login
    console.warn("Auth token not found");
    return null;

}

function getLoggedUser() {
    const envKey = getEnvStorageKey('username');

    return (
        sessionStorage.getItem(envKey) ||
        localStorage.getItem(envKey)
    );
}


function storeAuthToken(token, remember = false) {
    const envKey = getEnvStorageKey('auth_token');
    const env = getCurrentEnv();

    if (remember) {
        localStorage.setItem(envKey, token);
        console.log(`Token stored in localStorage for ${env} environment`);
    } else {
        sessionStorage.setItem(envKey, token);
        console.log(`Token stored in sessionStorage for ${env} environment`);
    }
}

function updateAuthToken(newToken) {
    const envKey = getEnvStorageKey('auth_token');

    // Check where the current token is stored and update accordingly
    if (sessionStorage.getItem(envKey)) {
        sessionStorage.setItem(envKey, newToken);
    } else if (localStorage.getItem(envKey)) {
        localStorage.setItem(envKey, newToken);
    }
    console.log(`Auth token updated for ${getCurrentEnv()} environment`);
}

function clearAuthTokens() {
    // Clear both dev and prod tokens from all storage
    const envs = ['dev', 'prod'];

    envs.forEach(env => {
        // Clear sessionStorage
        sessionStorage.removeItem(`auth_token_${env}`);
        sessionStorage.removeItem(`username_${env}`);

        // Clear localStorage
        localStorage.removeItem(`auth_token_${env}`);
        localStorage.removeItem(`username_${env}`);

        console.log(`Cleared ${env} environment tokens`);
    });

    // Clear generic tokens (for backward compatibility)
    sessionStorage.removeItem('auth_token');
    sessionStorage.removeItem('username');
    localStorage.removeItem('auth_token');
    localStorage.removeItem('username');

    // Clear all cookies
    const cookies = document.cookie.split(";");
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i];
        const eqPos = cookie.indexOf("=");
        const name = eqPos > -1 ? cookie.substr(0, eqPos).trim() : cookie.trim();
        // Set each cookie to expire
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
    }

    console.log("All auth tokens and cookies cleared");
}

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
        window.location.href = `../login/login.php?envType=${getCurrentEnv()}`;
    }, 2000);
}



// Function to logout and clear tokens
function logout() {
    const envKey = getEnvStorageKey('auth_token');
    const usernameKey = getEnvStorageKey('username');

    // Clear environment-specific tokens
    sessionStorage.removeItem(envKey);
    sessionStorage.removeItem(usernameKey);
    localStorage.removeItem(envKey);
    localStorage.removeItem(usernameKey);

    // Also clear generic tokens for backward compatibility
    sessionStorage.removeItem('auth_token');
    sessionStorage.removeItem('username');
    localStorage.removeItem('auth_token');
    localStorage.removeItem('username');

    // Redirect to login with current environment
    window.location.href = `../login/login.php?envType=${getCurrentEnv()}`;
}

/* -------- API CALL FUNCTION -------- */

async function callApi(endpoint, params = {}, method = "GET") {
    try {
        const token = getAuthToken();
        if (!token) {
            console.error("Auth token not found");
            // If no token, redirect to login with current environment
            window.location.href = `../login/login.php?envType=${getCurrentEnv()}`;
            return null;
        }

        let url = `${API_BASE}/${endpoint}`;
        // console.log(url);

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

            // console.log("API Call:", method, url);
        }

        // POST / PUT
        if (method !== "GET") {
            options.body = JSON.stringify(params);
        }

        const response = await fetch(url, options);

        // console.log(`API Response [${endpoint}]:`, response.status, response.statusText);

        if (response.status === 401) {
            console.warn("Token expired or invalid for", getCurrentEnv(), "environment");
            // Clear the invalid token
            const envKey = getEnvStorageKey('auth_token');
            sessionStorage.removeItem(envKey);
            localStorage.removeItem(envKey);

            // Show error and redirect
            showAuthError();
            return null;
        }

        if (response.status === 403) {
            console.error("API Key not available for", getCurrentEnv(), "environment");
            // This might mean the token is for wrong environment
            clearAuthTokens();
            alert(`API Key error: The token you're using is not valid for the ${getCurrentEnv().toUpperCase()} environment. Please login again.`);
            window.location.href = `../login/login.php?envType=${getCurrentEnv()}`;
            return null;
        }

        if (!response.ok) {
            throw new Error(`API Error ${response.status}: ${response.statusText}`);
        }

        const data = await response.json();

        // Check if response indicates authentication failure
        if (data.rcode === "error" && data.rmessage &&
            (data.rmessage.toLowerCase().includes("unauthorized") ||
                data.rmessage.toLowerCase().includes("token") ||
                data.rmessage.toLowerCase().includes("auth") ||
                data.rmessage.toLowerCase().includes("api key"))) {
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
            alert("Network error. Please check your internet connection.");
        }

        return null;
    }
}


/* -------- INITIALIZATION -------- */

// Check if user is logged in when page loads
document.addEventListener('DOMContentLoaded', function () {

    setEnvCookieFromUrl();

    const currentEnv = getCurrentEnv();
    const token = getAuthToken();
    const currentPage = window.location.pathname;

    // Allow login page
    if (currentPage.includes('login.php')) {
        return;
    }

    // Redirect only here
    if (!token) {
        window.location.href = `../login/login.php?envType=${currentEnv}`;
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

// Export functions for use in other files
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        callApi,
        getAuthToken,
        storeAuthToken,
        updateAuthToken,
        logout,
        getCurrentEnv,
        clearAuthTokens
    };
}
