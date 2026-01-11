<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AIU Alumni</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-image">
            <div style="position: absolute; bottom: 50px; left: 50px; color: white; z-index: 2;">
                <h1>Welcome Back.</h1>
                <p>Access your alumni benefits, network with peers, and stay updated.</p>
            </div>
        </div>

        <div class="auth-form-wrapper">
            <div style="max-width: 400px; width: 100%; margin: 0 auto;">
                <div class="logo" style="margin-bottom: 2rem;">AIU ALUMNI.</div>
                
                <h2 style="margin-bottom: 0.5rem;">Log In</h2>
                <p style="margin-bottom: 2rem; color: #666;">Don't have an account? <a href="register.html" style="color: var(--primary); font-weight: 600;">Register here</a></p>

                <form id="loginForm">
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" placeholder="student@aiu.edu.my" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" placeholder="••••••••" required>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-bottom: 2rem; font-size: 0.9rem;">
                        <label><input type="checkbox"> Remember me</label>
                        <a href="#" style="color: var(--primary);">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">Sign In</button>
                </form>

                <div style="margin-top: 2rem; text-align: center; position: relative;">
                    <span style="background: white; padding: 0 10px; color: #999; position: relative; z-index: 1;">Or continue with</span>
                    <hr style="position: absolute; top: 50%; width: 100%; border: 0; border-top: 1px solid #eee; z-index: 0;">
                </div>

                <div style="margin-top: 1.5rem; display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <button class="btn btn-outline" style="border-color: #ddd; color: #666;">Google</button>
                    <button class="btn btn-outline" style="border-color: #ddd; color: #666;">LinkedIn</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="js/auth.js"></script>
</body>
</html>