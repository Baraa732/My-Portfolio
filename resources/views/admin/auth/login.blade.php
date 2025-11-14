<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Login - Portfolio</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
 <style>
   :root {
    --primary: #1a365d;
    --primary-light: #2d4a8a;
    --primary-dark: #0f1e3d;
    --secondary: #2d3748;
    --accent: #4c6fff;
    --dark: #1a202c;
    --darker: #0f1419;
    --light: #ffffff;
    --gray: #f7fafc;
    --gradient: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    --gradient-dark: linear-gradient(135deg, var(--dark) 0%, var(--secondary) 100%);
    --shadow: 0 10px 30px rgba(26, 54, 93, 0.15);
    --shadow-lg: 0 20px 50px rgba(26, 54, 93, 0.25);
    --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--gradient-dark);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
}

/* Enhanced Animated Background */
.background-animation {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
    overflow: hidden;
}

/* Floating Particles */
.particles {
    position: absolute;
    width: 100%;
    height: 100%;
}

.particle {
    position: absolute;
    background: rgba(76, 111, 255, 0.1);
    border-radius: 50%;
    animation: floatParticle 20s linear infinite;
}

.particle:nth-child(1) { width: 4px; height: 4px; top: 20%; left: 10%; animation-delay: 0s; animation-duration: 25s; }
.particle:nth-child(2) { width: 6px; height: 6px; top: 60%; left: 80%; animation-delay: 2s; animation-duration: 30s; }
.particle:nth-child(3) { width: 3px; height: 3px; top: 80%; left: 20%; animation-delay: 4s; animation-duration: 20s; }
.particle:nth-child(4) { width: 5px; height: 5px; top: 40%; left: 90%; animation-delay: 6s; animation-duration: 35s; }

/* Animated Grid */
.animated-grid {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: 
        linear-gradient(90deg, transparent 95%, rgba(76, 111, 255, 0.03) 95%),
        linear-gradient(transparent 95%, rgba(76, 111, 255, 0.03) 95%);
    background-size: 50px 50px;
    animation: gridMove 40s linear infinite;
    opacity: 0.3;
}

/* Floating Shapes */
.floating-shapes {
    position: absolute;
    width: 100%;
    height: 100%;
}

.floating-shape {
    position: absolute;
    background: linear-gradient(135deg, rgba(76, 111, 255, 0.05), rgba(26, 54, 93, 0.05));
    border: 1px solid rgba(76, 111, 255, 0.1);
    border-radius: 20px;
    backdrop-filter: blur(10px);
    animation: floatShape 25s ease-in-out infinite;
}

.floating-shape:nth-child(1) { width: 120px; height: 120px; top: 10%; left: 5%; animation-delay: 0s; animation-duration: 30s; }
.floating-shape:nth-child(2) { width: 80px; height: 80px; top: 70%; left: 85%; animation-delay: 5s; animation-duration: 25s; border-radius: 50%; }
.floating-shape:nth-child(3) { width: 100px; height: 100px; top: 80%; left: 10%; animation-delay: 10s; animation-duration: 35s; border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }

/* Gradient Orbs */
.gradient-orbs {
    position: absolute;
    width: 100%;
    height: 100%;
}

.gradient-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(40px);
    opacity: 0.3;
    animation: orbFloat 20s ease-in-out infinite;
}

.gradient-orb:nth-child(1) { width: 300px; height: 300px; top: -150px; left: -150px; background: radial-gradient(circle, var(--accent) 0%, transparent 70%); animation-delay: 0s; animation-duration: 25s; }
.gradient-orb:nth-child(2) { width: 400px; height: 400px; bottom: -200px; right: -200px; background: radial-gradient(circle, var(--primary) 0%, transparent 70%); animation-delay: 10s; animation-duration: 30s; }

/* Enhanced Animations */
@keyframes floatParticle {
    0% { transform: translateY(100vh) translateX(0) rotate(0deg); opacity: 0; }
    10% { opacity: 0.7; }
    90% { opacity: 0.7; }
    100% { transform: translateY(-100px) translateX(100px) rotate(360deg); opacity: 0; }
}

@keyframes gridMove {
    0% { transform: translate(0, 0); }
    100% { transform: translate(50px, 50px); }
}

@keyframes floatShape {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    25% { transform: translate(20px, -20px) rotate(5deg); }
    50% { transform: translate(-15px, 15px) rotate(-5deg); }
    75% { transform: translate(10px, -10px) rotate(3deg); }
}

@keyframes orbFloat {
    0%, 100% { transform: translate(0, 0) scale(1); }
    25% { transform: translate(50px, 30px) scale(1.1); }
    50% { transform: translate(-30px, 50px) scale(0.9); }
    75% { transform: translate(40px, -20px) scale(1.05); }
}

@keyframes fadeInUp {
    to { transform: translateY(0); opacity: 1; }
}

@keyframes slideIn {
    to { transform: scaleX(1); }
}

@keyframes slideInRight {
    to { opacity: 1; transform: translateX(0); }
}

@keyframes fadeIn {
    to { opacity: 1; }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

/* Enhanced Login Container */
.login-container {
    background: linear-gradient(145deg, rgba(26, 54, 93, 0.4), rgba(15, 20, 25, 0.6));
    backdrop-filter: blur(40px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 3rem;
    width: 100%;
    max-width: 420px;
    box-shadow: var(--shadow-lg);
    transform: translateY(20px);
    opacity: 0;
    animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    position: relative;
    overflow: hidden;
}

.login-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: var(--gradient);
    transform: scaleX(0);
    transform-origin: left;
    animation: slideIn 1s 0.5s forwards;
}

.login-container::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(76, 111, 255, 0.1), transparent);
    transition: var(--transition);
}

.login-container:hover::after {
    left: 100%;
}

/* Enhanced Login Header */
.login-header {
    text-align: center;
    margin-bottom: 2.5rem;
    position: relative;
}

.login-header h1 {
    color: var(--light);
    font-size: 2.2rem;
    font-weight: 800;
    background: var(--gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
    letter-spacing: -0.5px;
    line-height: 1.1;
}

.login-header p {
    color: var(--gray);
    font-size: 0.95rem;
    font-weight: 500;
}

/* Enhanced Form Elements */
.form-group {
    margin-bottom: 1.8rem;
    position: relative;
    opacity: 0;
    transform: translateX(-20px);
    animation: slideInRight 0.6s forwards;
}

.form-group:nth-child(1) { animation-delay: 0.7s; }
.form-group:nth-child(2) { animation-delay: 0.9s; }

.form-label {
    display: block;
    color: var(--light);
    margin-bottom: 0.7rem;
    font-weight: 600;
    font-size: 0.95rem;
    transition: var(--transition);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.input-container {
    position: relative;
}

.form-control {
    width: 100%;
    padding: 1.1rem 1rem 1.1rem 3rem;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    color: var(--light);
    font-size: 1rem;
    transition: var(--transition);
    backdrop-filter: blur(10px);
    font-family: inherit;
}

.form-control:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(76, 111, 255, 0.1);
    transform: translateY(-2px);
    background: rgba(255, 255, 255, 0.08);
}

.form-control::placeholder {
    color: var(--gray);
    font-weight: 500;
}

.input-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray);
    transition: var(--transition);
    font-size: 1.1rem;
}

.form-control:focus + .input-icon {
    color: var(--accent);
    transform: translateY(-50%) scale(1.1);
}

/* Enhanced Button */
.btn {
    width: 100%;
    padding: 1.2rem;
    background: var(--gradient);
    border: none;
    border-radius: 12px;
    color: var(--light);
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
    opacity: 0;
    animation: fadeIn 0.8s 1.1s forwards;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    backdrop-filter: blur(10px);
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: var(--transition);
}

.btn:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

.btn:hover::before {
    left: 100%;
}

/* Enhanced Password Toggle */
.password-toggle {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--gray);
    cursor: pointer;
    transition: var(--transition);
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
}

.password-toggle:hover {
    color: var(--accent);
    background: rgba(76, 111, 255, 0.1);
}

/* Enhanced Error Message */
.error-message {
    color: #ef4444;
    font-size: 0.85rem;
    margin-top: 0.5rem;
    padding: 0.75rem;
    background: rgba(239, 68, 68, 0.1);
    border-radius: 8px;
    border-left: 3px solid #ef4444;
    animation: shake 0.5s ease-in-out;
    font-weight: 500;
}

/* Enhanced Responsive Design */
@media (max-width: 480px) {
    .login-container {
        padding: 2rem;
        margin: 1rem;
    }
    
    .login-header h1 {
        font-size: 1.8rem;
    }
    
    .form-control {
        padding: 1rem 1rem 1rem 2.5rem;
    }
    
    .input-icon {
        left: 0.75rem;
        font-size: 1rem;
    }
    
    .floating-shape,
    .gradient-orb:nth-child(2) {
        display: none;
    }
}

@media (max-width: 360px) {
    .login-container {
        padding: 1.5rem;
    }
    
    .login-header h1 {
        font-size: 1.6rem;
    }
    
    .btn {
        padding: 1rem;
    }
}

/* Accessibility & Performance */
@media (prefers-reduced-motion: reduce) {
    .particle,
    .animated-grid,
    .floating-shape,
    .gradient-orb,
    .login-container,
    .form-group,
    .btn {
        animation: none;
        transition: none;
    }
    
    .login-container {
        transform: translateY(0);
        opacity: 1;
    }
    
    .form-group {
        transform: translateX(0);
        opacity: 1;
    }
    
    .btn {
        opacity: 1;
    }
}

@media (hover: none) {
    .login-container:hover::after {
        left: -100%;
    }
    
    .btn:hover {
        transform: none;
    }
    
    .form-control:focus {
        transform: none;
    }
}

/* Touch Device Optimizations */
@media (pointer: coarse) {
    .form-control,
    .btn {
        min-height: 50px;
    }
    
    .password-toggle {
        min-width: 44px;
        min-height: 44px;
    }
}
 </style>
</head>

<body>
   <div class="bg-shapes">
      <div class="shape"></div>
      <div class="shape"></div>
      <div class="shape"></div>
      <div class="shape"></div>
      <div class="shape"></div>
   </div>

   <div class="login-container">
      <div class="login-header">
         <h1>Admin Login</h1>
         <p>Access your dashboard</p>
      </div>

      <form method="POST" action="{{ route('admin.login.submit') }}">
         @csrf

         <div class="form-group">
            <label class="form-label">Email</label>
            <div class="input-container">
               <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
               <i class="fas fa-envelope input-icon"></i>
            </div>
            @error('email')
               <div class="error-message">{{ $message }}</div>
            @enderror
         </div>

         <div class="form-group">
            <label class="form-label">Password</label>
            <div class="input-container">
               <input type="password" name="password" id="password" class="form-control" required>
               <i class="fas fa-lock input-icon"></i>
               <button type="button" class="password-toggle" id="togglePassword">
                  <i class="fas fa-eye"></i>
               </button>
            </div>
            @error('password')
               <div class="error-message">{{ $message }}</div>
            @enderror
         </div>

         <button type="submit" class="btn">Login</button>
      </form>
   </div>

   <script>
      // Password toggle functionality
      document.getElementById('togglePassword').addEventListener('click', function () {
         const passwordInput = document.getElementById('password');
         const icon = this.querySelector('i');

         if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
         } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
         }
      });

      // Add focus animation to form inputs
      document.querySelectorAll('.form-control').forEach(input => {
         input.addEventListener('focus', function () {
            this.parentElement.classList.add('focused');
         });

         input.addEventListener('blur', function () {
            if (this.value === '') {
               this.parentElement.classList.remove('focused');
            }
         });
      });
   </script>
</body>

</html>
