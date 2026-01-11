<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join the Network - AIU Alumni</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-image" style="background-image: url('images/graduation.jpg');">
            <div style="position: absolute; bottom: 50px; left: 50px; color: white; z-index: 2;">
                <h1>A Community for Life.</h1>
                <p>Join over 1,500 graduates making a difference across the globe.</p>
            </div>
        </div>

        <div class="auth-form-wrapper" style="overflow-y: auto; padding: 2rem 10%;">
            <div style="max-width: 500px; width: 100%; margin: 0 auto; padding-top: 2rem;">
                <div class="logo" style="margin-bottom: 1rem;">AIU ALUMNI.</div>
                
                <h2 style="margin-bottom: 0.5rem;">Create Account</h2>
                <p style="margin-bottom: 2rem; color: #666;">Already have an account? <a href="login.html" style="color: var(--primary); font-weight: 600;">Log In</a></p>

                <form id="registerForm">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" placeholder="e.g. Ahmad" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" placeholder="e.g. Albukhary" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Student ID (Matric No.)</label>
                        <input type="text" placeholder="e.g. AIU1800123" required>
                        <small style="color: #999; font-size: 0.8rem;">Required for verification</small>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label>Graduation Year</label>
                            <select style="width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 8px; background: #fafafa;">
                                <option>2024</option>
                                <option>2023</option>
                                <option>2022</option>
                                <option>2021</option>
                                <option>2020</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>School</label>
                            <select style="width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 8px; background: #fafafa;">
                                <option>Business & Social Sciences</option>
                                <option>Education & Human Sciences</option>
                                <option>Computing & Informatics</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" placeholder="you@example.com" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" placeholder="Create a strong password" required>
                    </div>

                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" placeholder="Confirm password" required>
                    </div>

                    <div class="form-group" style="display: flex; gap: 10px; align-items: flex-start;">
                        <input type="checkbox" style="width: auto; margin-top: 5px;" required>
                        <span style="font-size: 0.9rem; color: #666;">I agree to the <a href="#" style="color: var(--primary);">Terms of Service</a> and <a href="#" style="color: var(--primary);">Privacy Policy</a>.</span>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">Create Account</button>
                </form>
                <div style="height: 50px;"></div> </div>
        </div>
    </div>
    <script src="js/auth.js"></script>
</body>
</html>