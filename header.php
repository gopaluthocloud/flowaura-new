<style>
    /* User Dropdown Styles */
    .user-dropdown {
        position: relative;
        display: inline-block;
    }

    .user-avatar.dropdown-toggle {
        cursor: pointer;
        transition: all 0.2s;
    }

    .user-avatar.dropdown-toggle:hover {
        background: var(--primary-color);
        color: white;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        min-width: 220px;
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        padding: 0;
        margin-top: 8px;
        z-index: 1000;
        display: none;
    }

    .dropdown-menu.show {
        display: block;
    }

    .user-info-header {
        padding: 12px 16px;
        border-bottom: 1px solid var(--border-color);
        background: #F9FAFB;
    }

    .user-fullname {
        font-weight: 600;
        margin-bottom: 2px;
        color: #1F2937;
        font-size: 14px;
    }

    .user-email {
        font-size: 12px;
        color: #6B7280;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        padding: 10px 16px;
        color: #1F2937;
        text-decoration: none;
        font-size: 13px;
        font-weight: 400;
        transition: all 0.2s;
        background: none;
        border: none;
        width: 100%;
        text-align: left;
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
    }

    .dropdown-divider {
        height: 1px;
        background: var(--border-color);
        margin: 4px 0;
        border: none;
    }
</style>

<div class="top-header">
    <div class="header-content">
        <div class="header-title">
            <h1>Sales & Leads Dashboard</h1>
            <small>Track all sales & contacts in one place</small>
        </div>
        <div class="header-actions">
            <!-- User Avatar with Dropdown -->
            <div class="user-dropdown">
                <div class="user-avatar dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <!-- Will be filled by JavaScript -->
                    U
                </div>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <!-- User info will be populated by JavaScript -->
                    <li class="user-info-header" id="userInfoHeader">
                        <div class="user-fullname">Loading user...</div>
                        <div class="user-email">Loading...</div>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item text-danger" href="#" onclick="logout()"><i
                                class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    // Dropdown toggle functionality
    document.addEventListener('DOMContentLoaded', function () {
        const userDropdown = document.getElementById('userDropdown');
        const dropdownMenu = userDropdown.nextElementSibling;

        userDropdown.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdownMenu.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function () {
            dropdownMenu.classList.remove('show');
        });

        // Prevent dropdown from closing when clicking inside it
        dropdownMenu.addEventListener('click', function (e) {
            e.stopPropagation();
        });

        // Load and display user data from sessionStorage
        loadUserDataFromStorage();
    });

    // Function to load user data from sessionStorage
    function loadUserDataFromStorage() {
        try {
            // Check what's available in storage (for debugging)
            console.log('Checking sessionStorage for user data...');
            console.log('All sessionStorage keys:', Object.keys(sessionStorage));

            // Try to get user data from different possible storage locations
            let userData = {};
            let storageSource = '';

            // Check sessionStorage first
            const sessionData = sessionStorage.getItem('user_data');
            if (sessionData) {
                try {
                    userData = JSON.parse(sessionData);
                    storageSource = 'sessionStorage (user_data)';
                } catch (e) {
                    console.error('Error parsing sessionStorage user_data:', e);
                }
            }

            // If not found, check localStorage
            if (!userData || Object.keys(userData).length === 0) {
                const localData = localStorage.getItem('user_data');
                if (localData) {
                    try {
                        userData = JSON.parse(localData);
                        storageSource = 'localStorage (user_data)';
                    } catch (e) {
                        console.error('Error parsing localStorage user_data:', e);
                    }
                }
            }

            // Check for individual fields if user_data object is empty
            if (!userData || Object.keys(userData).length === 0) {
                userData = {
                    firstname: sessionStorage.getItem('firstname') || localStorage.getItem('firstname') || '',
                    lastname: sessionStorage.getItem('lastname') || localStorage.getItem('lastname') || '',
                    username: sessionStorage.getItem('username') || localStorage.getItem('username') || 'User',
                    email: sessionStorage.getItem('email') || localStorage.getItem('email') || ''
                };
                storageSource = 'individual fields';
            }

            console.log('User data loaded from:', storageSource);
            console.log('User data:', userData);

            // Extract user information
            const firstName = userData.firstname || userData.first_name || userData.fname || '';
            const lastName = userData.lastname || userData.last_name || userData.lname || '';
            const userName = userData.username || userData.name || userData.user_name || 'User';
            const userEmail = userData.email || userData.email_address || '';

            // Get initials for avatar
            let initials = 'U'; // Default
            if (firstName && lastName) {
                initials = (firstName.charAt(0) + lastName.charAt(0)).toUpperCase();
            } else if (firstName) {
                initials = firstName.charAt(0).toUpperCase();
            } else if (userName) {
                initials = userName.charAt(0).toUpperCase();
                // If username is email, use first letter before @
                if (userName.includes('@')) {
                    initials = userName.charAt(0).toUpperCase();
                }
            }

            // Update avatar
            const avatar = document.getElementById('userDropdown');
            if (avatar) {
                avatar.textContent = initials;
                // Add a title (tooltip) with the full name
                const fullName = firstName && lastName ?
                    `${firstName} ${lastName}` :
                    userName;
                avatar.title = fullName;
            }

            // Update dropdown user info
            const userInfoHeader = document.getElementById('userInfoHeader');
            if (userInfoHeader) {
                const fullName = firstName && lastName ?
                    `${firstName} ${lastName}` :
                    userName;

                userInfoHeader.innerHTML = `
                    <div class="user-fullname">${fullName}</div>
                    ${userEmail ? `<div class="user-email">${userEmail}</div>` : ''}
                `;
            }

        } catch (error) {
            console.error('Error loading user data from storage:', error);
            // Set default values
            const avatar = document.getElementById('userDropdown');
            if (avatar) {
                avatar.textContent = 'U';
                avatar.title = 'User';
            }
        }
    }

    // Fallback functions in case they don't exist in main file
    if (typeof showLoader !== 'function') {
        window.showLoader = function (text = 'Loading...') {
            console.log('Fallback showLoader:', text);
        };
    }

    if (typeof hideLoader !== 'function') {
        window.hideLoader = function () {
            console.log('Fallback hideLoader');
        };
    }

    if (typeof softAlert !== 'function') {
        window.softAlert = function (message, type = 'success', duration = 3000) {
            alert(message); // Simple fallback
        };
    }

    // Logout function - Self-contained version
    async function logout() {
        try {
            // Show confirmation dialog
            const confirmLogout = confirm("Are you sure you want to logout?");
            if (!confirmLogout) return;

            // Show loader if available
            if (typeof showLoader === 'function') {
                showLoader('Logging out...');
            } else {
                console.log('Logging out...');
            }

            // Clear all authentication tokens and user data
            localStorage.clear();
            sessionStorage.clear();

            // Clear cookies
            document.cookie.split(";").forEach(function (c) {
                document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/");
            });

            // Show success message if available
            if (typeof softAlert === 'function') {
                softAlert('Logged out successfully!', 'success', 2000);
            } else {
                alert('Logged out successfully!');
            }

            // Wait a moment before redirecting
            setTimeout(() => {
                // Redirect to login page - using absolute path
                window.location.href = '/login/login.php';
                // Alternative: window.location.href = 'http://flowaura_dev.local/login/login.php';
            }, 1500);

        } catch (error) {
            console.error('Logout error:', error);

            // Show error message if available
            if (typeof softAlert === 'function') {
                softAlert('Error during logout', 'error');
            } else {
                alert('Error during logout');
            }

            // Hide loader if available
            if (typeof hideLoader === 'function') {
                hideLoader();
            }
        }
    }
</script>