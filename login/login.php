<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sales Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* ... keep your existing styles ... */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
            display: flex;
            min-height: 500px;
        }

        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            color: #fff;
        }

        .login-left img {
            max-width: 200px;
            margin-bottom: 30px;
            filter: brightness(0) invert(1);
        }

        .login-left h2 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 15px;
            text-align: center;
        }

        .login-left p {
            font-size: 14px;
            opacity: 0.8;
            text-align: center;
            line-height: 1.6;
        }

        .login-right {
            flex: 1;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-right h3 {
            font-size: 28px;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 10px;
        }

        .login-right .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
            font-size: 14px;
        }

        .form-group .input-wrapper {
            position: relative;
        }

        .form-group .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 16px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-group input::placeholder {
            color: #aaa;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
            font-size: 16px;
        }

        .password-toggle:hover {
            color: #667eea;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #667eea;
            cursor: pointer;
        }

        .remember-me span {
            font-size: 14px;
            color: #666;
        }

        .forgot-password {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-danger {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background: #dcfce7;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid #fff;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            display: none;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                max-width: 400px;
            }

            .login-left {
                padding: 30px;
            }

            .login-left img {
                max-width: 150px;
            }

            .login-left h2 {
                font-size: 22px;
            }

            .login-right {
                padding: 30px;
            }

            .login-right h3 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- Left Panel -->
        <div class="login-left">
            <img src="../src/assets/logo_black.png" alt="Company Logo">
            <h2>Welcome Back!</h2>
            <p>Access your sales dashboard, manage leads, track performance, and grow your business with our
                comprehensive CRM solution.</p>
        </div>

        <!-- Right Panel -->
        <div class="login-right">
            <h3>Sign In</h3>
            <p class="subtitle">Enter your credentials to access your account</p>

            <div id="alertBox" class="alert" style="display: none;">
                <i class="fas fa-exclamation-circle"></i>
                <span id="alertMessage"></span>
            </div>

            <form id="loginForm" onsubmit="return handleLogin(event)">
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" id="username" name="username" placeholder="Enter your username" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <!-- <i class="fas fa-eye password-toggle" onclick="togglePassword()"></i> -->
                    </div>
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" id="rememberMe" name="rememberMe">
                        <span>Remember me</span>
                    </label>
                </div>

                <button type="submit" class="btn-login" id="loginBtn">
                    <span class="spinner" id="loginSpinner"></span>
                    <span id="loginText">Sign In</span>
                    <i class="fas fa-arrow-right" id="loginArrow"></i>
                </button>
            </form>
        </div>
    </div>

    <script>
        // ==================== COOKIE FUNCTIONS ====================
        
        // Set cookie from URL parameters (for envType)
        function setEnvCookieFromUrl() {
            const urlParams = new URLSearchParams(window.location.search);
            const envType = urlParams.get("envType");

            if (envType) {
                // Set cookie with proper path and without Secure flag for local development
                // Use path=/ to make it accessible across all pages
                // Remove Secure flag for HTTP local development
                const cookieString = `envType=${envType}; path=/; max-age=86400`; // 1 day
                document.cookie = cookieString;
                console.log("Env cookie set:", cookieString);
                
                // Also show debug info
                console.log("Current URL:", window.location.href);
                console.log("Found envType parameter:", envType);
                
                // Test if cookie was set
                setTimeout(() => {
                    console.log("All cookies after setting:", document.cookie);
                    console.log("envType cookie value:", getCookie("envType"));
                }, 100);
            } else {
                console.log("No envType parameter found in URL");
            }
        }

        // Get cookie by name
        function getCookie(name) {
            const nameEQ = name + "=";
            const ca = document.cookie.split(';');
            for(let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) {
                    const value = c.substring(nameEQ.length, c.length);
                    console.log(`Found cookie ${name}=${value}`);
                    return value;
                }
            }
            console.log(`Cookie ${name} not found`);
            return null;
        }

        // ==================== PAGE INITIALIZATION ====================
        
        // Call setEnvCookieFromUrl immediately when page loads
        setEnvCookieFromUrl();

        // ==================== PASSWORD FUNCTIONS ====================
        
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // ==================== ALERT FUNCTIONS ====================
        
        // Show alert message
        function showAlert(message, type = 'danger') {
            const alertBox = document.getElementById('alertBox');
            const alertMessage = document.getElementById('alertMessage');
            const alertIcon = alertBox.querySelector('i');

            alertMessage.textContent = message;
            alertBox.className = 'alert alert-' + type;
            alertIcon.className = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
            alertBox.style.display = 'flex';
        }

        // Hide alert
        function hideAlert() {
            document.getElementById('alertBox').style.display = 'none';
        }

        // ==================== LOADING STATE ====================
        
        // Set loading state
        function setLoading(loading) {
            const btn = document.getElementById('loginBtn');
            const spinner = document.getElementById('loginSpinner');
            const text = document.getElementById('loginText');
            const arrow = document.getElementById('loginArrow');

            if (loading) {
                btn.disabled = true;
                spinner.style.display = 'block';
                text.textContent = 'Signing In...';
                arrow.style.display = 'none';
            } else {
                btn.disabled = false;
                spinner.style.display = 'none';
                text.textContent = 'Sign In';
                arrow.style.display = 'inline';
            }
        }

        // ==================== LOGIN FUNCTION ====================
        
        // Handle login form submission
        function handleLogin(event) {
            event.preventDefault();
            hideAlert();

            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            const rememberMe = document.getElementById('rememberMe').checked;

            // Basic validation
            if (!username || !password) {
                showAlert('Please enter both username and password');
                return false;
            }

            if (username.length < 3) {
                showAlert('Username must be at least 3 characters');
                return false;
            }

            if (password.length < 4) {
                showAlert('Password must be at least 4 characters');
                return false;
            }

            setLoading(true);

            // Check environment type from cookie
            const envType = getCookie("envType") || "dev";
            console.log("Using envType from cookie:", envType);
            
            // Choose API base URL based on envType
            let API_BASE = "https://restadmindev.utho.com/v2";
            if (envType !== "dev") {
                API_BASE = "https://restadmin.utho.com/v2";
            }
            
            // Build the URL with encoded parameters
            const apiUrl = `${API_BASE}/auth/?username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`;

            console.log('API URL:', apiUrl);
            console.log('Environment:', envType);

            fetch(apiUrl, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                },
            })
                .then(async response => {
                    const responseText = await response.text();
                    console.log('Raw response:', responseText);

                    try {
                        const data = JSON.parse(responseText);
                        setLoading(false);
                        console.log('Parsed data:', data);

                        if (data.rcode === "success") {
                            showAlert('Login successful! Redirecting...', 'success');

                            // Store token
                            if (rememberMe) {
                                localStorage.setItem('auth_token', data.token);
                            } else {
                                sessionStorage.setItem('auth_token', data.token);
                            }

                            // Store username
                            sessionStorage.setItem('username', username);

                            // Redirect to dashboard after 1 second
                            setTimeout(() => {
                                window.location.href = '../sales/sales-dashboard.php';
                            }, 1000);
                        } else {
                            showAlert(data.rmessage || 'Login failed');
                        }
                    } catch (jsonError) {
                        setLoading(false);
                        console.error('JSON parsing error:', jsonError);

                        if (responseText.includes('<!DOCTYPE') || responseText.includes('<html')) {
                            showAlert('Server error: Received HTML instead of JSON. Check the API endpoint.');
                        } else if (responseText.trim() === '') {
                            showAlert('Server returned empty response. Check the API endpoint.');
                        } else {
                            showAlert('Invalid server response: ' + responseText.substring(0, 100));
                        }
                    }
                })
                .catch(error => {
                    setLoading(false);
                    console.error('Network error:', error);
                    showAlert('Connection error. Please try again.');
                });

            return false;
        }

        // ==================== CHECK EXISTING SESSION ====================
        
        // Check if already logged in
        document.addEventListener('DOMContentLoaded', function () {
            // Log current cookies for debugging
            console.log("All cookies on page load:", document.cookie);
            console.log("envType cookie:", getCookie("envType"));
            
            const token = localStorage.getItem('auth_token') || sessionStorage.getItem('auth_token');
            if (token) {
                console.log("Found existing token, redirecting to dashboard");
                window.location.href = 'sales/sales-dashboard.php';
            }
        });
    </script>
</body>

</html>