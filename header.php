<style>
    /* User Dropdown Styles */
    .user-dropdown {
        position: relative;
        display: inline-block;
    }

    .user-avatar.dropdown-toggle {
        cursor: pointer;
        transition: all 0.2s;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        background: var(--light-bg);
        color: var(--dark-text);
        border: 2px solid transparent;
        font-size: 14px;
        text-transform: uppercase;
    }

    .user-avatar.dropdown-toggle:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-light);
        transform: scale(1.05);
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        min-width: 240px;
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        padding: 0;
        margin-top: 8px;
        z-index: 1000;
        display: none;
        opacity: 0;
        transform: translateY(-10px);
        transition: opacity 0.2s, transform 0.2s;
    }

    .dropdown-menu.show {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    .user-info-header {
        padding: 16px;
        border-bottom: 1px solid var(--border-color);
        background: #F9FAFB;
        border-radius: 8px 8px 0 0;
    }

    .user-fullname {
        font-weight: 600;
        margin-bottom: 4px;
        color: #1F2937;
        font-size: 15px;
    }

    .user-email {
        font-size: 13px;
        color: #6B7280;
        word-break: break-word;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        color: #1F2937;
        text-decoration: none;
        font-size: 14px;
        font-weight: 400;
        transition: all 0.2s;
        background: none;
        border: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
    }

    .dropdown-item i {
        width: 20px;
        margin-right: 10px;
        font-size: 16px;
    }

    .dropdown-item:hover {
        background: #F3F4F6;
        color: var(--primary-color);
    }

    .dropdown-item.text-danger {
        color: var(--danger-color) !important;
    }

    .dropdown-item.text-danger:hover {
        background: #FEE2E2;
        color: var(--danger-dark) !important;
    }

    .dropdown-divider {
        height: 1px;
        background: var(--border-color);
        margin: 4px 0;
        border: none;
    }

    /* Header Styles */
    .top-header {
        background: white;
        border-bottom: 1px solid var(--border-color);
        padding: 1rem 1.5rem;
        position: sticky;
        top: 0;
        z-index: 999;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1400px;
        margin: 0 auto;
    }

    .header-title h1 {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
        color: #1F2937;
    }

    .header-title small {
        font-size: 0.875rem;
        color: #6B7280;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    /* Notification badge */
    .notification-badge {
        position: relative;
        cursor: pointer;
        font-size: 1.25rem;
        color: #6B7280;
    }

    .notification-badge .badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: var(--danger-color);
        color: white;
        font-size: 0.7rem;
        min-width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<div class="top-header">
    <div class="header-content">
        <div class="header-title">
            <h1>Sales & Leads Dashboard</h1>
            <small>Track all sales & contacts in one place</small>
        </div>
        <div class="header-actions">
            <!-- Notifications (optional) -->
            <!-- <div class="notification-badge" id="notificationIcon" title="Notifications">
                <i class="bi bi-bell"></i>
                <span class="badge" id="notificationCount">0</span>
            </div> -->

            <!-- User Avatar with Dropdown -->
            <div class="user-dropdown">
                <div class="user-avatar dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false" title="Account Menu">
                    <!-- Will be filled by JavaScript -->
                    <span id="avatarInitials">U</span>
                </div>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li class="user-info-header" id="userInfoHeader">
                        <div class="user-fullname" id="userFullName">Loading user...</div>
                        <div class="user-email" id="userEmail">Loading...</div>
                    </li>
                    <!-- <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="/profile" id="profileLink">
                            <i class="bi bi-person-circle"></i>My Profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="/settings">
                            <i class="bi bi-gear"></i>Settings
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li> -->
                    <li>
                        <button class="dropdown-item text-danger" onclick="logout()">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
// Include api.js to access getLoggedUser function
document.addEventListener("DOMContentLoaded", () => {
    loadUserData();
});

async function loadUserData() {
    try {
        // Get username from storage
        const username = getLoggedUser();
        
        if (!username) {
            console.warn("No username found in storage");
            return;
        }
        
        // Try to get user details from API
        const userData = await getUserDetails(username);
        
        // Update avatar and user info
        updateUserDisplay(userData || { username: username });
        
    } catch (error) {
        console.error("Error loading user data:", error);
        // Fallback to just showing the username
        const username = getLoggedUser();
        if (username) {
            updateUserDisplay({ username: username });
        }
    }
}

async function getUserDetails(username) {
    try {
        // Try to fetch user details from API if available
        // This endpoint might need to be adjusted based on your API
        const response = await callApi('staff', { username: username });
        
        if (response && response.staff && response.staff.length > 0) {
            return response.staff[0];
        }
        
        // If no staff data, return null
        return null;
        
    } catch (error) {
        console.log("Could not fetch user details, using username only");
        return null;
    }
}

function updateUserDisplay(userData) {
    const avatarElement = document.getElementById('userDropdown');
    const avatarInitials = document.getElementById('avatarInitials');
    const userFullNameElement = document.getElementById('userFullName');
    const userEmailElement = document.getElementById('userEmail');
    
    // Extract user information
    const firstName = userData.firstname || userData.first_name || '';
    const lastName = userData.lastname || userData.last_name || '';
    const username = userData.username || getLoggedUser() || 'User';
    const email = userData.email || userData.email_address || '';
    
    // Generate initials for avatar
    let initials = 'U'; // Default
    
    if (firstName && lastName) {
        // First letter of first name + first letter of last name
        initials = (firstName.charAt(0) + lastName.charAt(0)).toUpperCase();
    } else if (firstName) {
        // First two letters of first name
        initials = firstName.substring(0, 2).toUpperCase();
    } else if (username) {
        // First two letters of username (skip @ if email)
        const cleanName = username.split('@')[0];
        initials = cleanName.substring(0, 2).toUpperCase();
    }
    
    // Update avatar
    if (avatarInitials) {
        avatarInitials.textContent = initials;
    }
    
    if (avatarElement) {
        // Set background color based on initials for consistency
        const colors = ['#4F46E5', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'];
        const colorIndex = (initials.charCodeAt(0) + (initials.charCodeAt(1) || 0)) % colors.length;
        avatarElement.style.backgroundColor = colors[colorIndex];
        avatarElement.style.color = 'white';
        
        // Set tooltip
        const fullName = firstName && lastName ? `${firstName} ${lastName}` : username;
        avatarElement.title = fullName;
    }
    
    // Update dropdown info
    if (userFullNameElement) {
        const fullName = firstName && lastName ? `${firstName} ${lastName}` : username;
        userFullNameElement.textContent = fullName;
    }
    
    if (userEmailElement && email) {
        userEmailElement.textContent = email;
    } else if (userEmailElement && username.includes('@')) {
        userEmailElement.textContent = username;
    } else if (userEmailElement) {
        userEmailElement.textContent = '';
    }
    
    // Update profile link if user has ID
    if (userData.id) {
        const profileLink = document.getElementById('profileLink');
        if (profileLink) {
            profileLink.href = `/profile?id=${userData.id}`;
        }
    }
}

// Fallback function if callApi is not available
if (typeof callApi === 'undefined') {
    window.callApi = async function(endpoint, params = {}) {
        console.warn('callApi not available, returning mock data');
        
        // Return mock user data for demonstration
        if (endpoint === 'staff') {
            const username = getLoggedUser();
            return {
                staff: [{
                    id: 1,
                    firstname: username ? username.split('.')[0] : 'John',
                    lastname: 'Doe',
                    email: username ? `${username}@example.com` : 'john.doe@example.com'
                }]
            };
        }
        
        return null;
    };
}
</script>

<script>
    // Global variables
    let userData = null;

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', function () {
        initializeDropdown();
        setupEventListeners();
        checkNotifications();
        
        // Load user data (this will override the initial loadUserData if needed)
        loadUserDataFromStorage();
    });

    // Dropdown toggle functionality
    function initializeDropdown() {
        const userDropdown = document.getElementById('userDropdown');
        const dropdownMenu = userDropdown?.nextElementSibling;

        if (!userDropdown || !dropdownMenu) return;

        userDropdown.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdownMenu.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function (e) {
            if (!dropdownMenu.contains(e.target) && !userDropdown.contains(e.target)) {
                dropdownMenu.classList.remove('show');
            }
        });

        // Prevent dropdown from closing when clicking inside it
        dropdownMenu.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    }

    // Function to load user data from storage
    function loadUserDataFromStorage() {
        try {
            // Try to get user data from sessionStorage first, then localStorage
            let storedData = sessionStorage.getItem('user_data') || localStorage.getItem('user_data');

            if (!storedData) {
                console.warn('No user data found in storage');
                // Don't set default here - let the other loadUserData function handle it
                return;
            }

            userData = JSON.parse(storedData);
            console.log('User data loaded from storage:', userData);

            // Update display with stored data
            updateUserDisplay(userData);

        } catch (error) {
            console.error('Error loading user data from storage:', error);
        }
    }

    // Set up additional event listeners
    function setupEventListeners() {
        // Profile link click
        const profileLink = document.getElementById('profileLink');
        if (profileLink) {
            profileLink.addEventListener('click', function (e) {
                e.preventDefault();
                window.location.href = '/profile';
            });
        }

        // Notification icon click
        const notificationIcon = document.getElementById('notificationIcon');
        if (notificationIcon) {
            notificationIcon.addEventListener('click', function () {
                console.log('Notifications clicked');
            });
        }
    }

    // Check for notifications
    function checkNotifications() {
        const notificationCount = document.getElementById('notificationCount');
        if (notificationCount) {
            notificationCount.style.display = 'none';
        }
    }

    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Logout function (same as before, but updated to work with the main logout)
    function logout() {
        // Call the main logout function from sales-dashboard.php
        if (typeof window.logout === 'function') {
            window.logout();
        } else {
            // Fallback if main logout function is not available
            const confirmLogout = confirm("Are you sure you want to logout?");
            if (!confirmLogout) return;
            
            // Clear all authentication data
            localStorage.removeItem('user_data');
            localStorage.removeItem('auth_token');
            localStorage.removeItem('session_token');
            
            sessionStorage.clear();
            
            // Clear cookies
            document.cookie.split(";").forEach(function (c) {
                document.cookie = c.replace(/^ +/, "")
                    .replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/;domain=" + window.location.hostname);
            });
            
            document.cookie = "PHPSESSID=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            
            // Redirect to login page
            window.location.href = '../login/login.php';
        }
    }

    // Export functions for external use if needed
    window.userHeader = {
        reloadUserData: loadUserDataFromStorage,
        getUserData: () => userData,
        logout: logout
    };
</script>