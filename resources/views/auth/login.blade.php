<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - SPK Wisata Sumatera Utara</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --primary-light: #6c8cff;
            --secondary: #7209b7;
            --secondary-light: #9d4edd;
            --success: #06d6a0;
            --warning: #ffd166;
            --danger: #ef476f;
            --dark: #0f172a;
            --light: #f8fafc;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Background animated blobs */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.4;
            animation: float 20s infinite ease-in-out;
            z-index: 0;
        }

        .blob-1 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            top: -100px;
            right: -100px;
            animation-delay: 0s;
        }

        .blob-2 {
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, #f093fb, #f5576c);
            bottom: -150px;
            left: -150px;
            animation-delay: 5s;
        }

        .blob-3 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: 10s;
            opacity: 0.2;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            33% {
                transform: translate(30px, -30px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }

        /* Particles container */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .particle {
            position: absolute;
            background: rgba(255,255,255,0.3);
            border-radius: 50%;
            pointer-events: none;
            animation: particleFloat 15s infinite linear;
        }

        @keyframes particleFloat {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) rotate(360deg);
                opacity: 0;
            }
        }

        /* Login Card */
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        .login-card {
            background: rgba(255,255,255,0.98);
            backdrop-filter: blur(10px);
            border-radius: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            overflow: hidden;
            max-width: 460px;
            width: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 35px 60px -15px rgba(0,0,0,0.3);
        }

        /* Header Card */
        .login-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            padding: 2rem;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: shine 8s infinite;
        }

        @keyframes shine {
            0% {
                transform: translate(-30%, -30%) rotate(0deg);
            }
            100% {
                transform: translate(30%, 30%) rotate(360deg);
            }
        }

        .login-icon {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2.5rem;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255,255,255,0.3);
        }

        .login-header h3 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            font-size: 0.85rem;
            opacity: 0.9;
            margin: 0;
        }

        /* Body Form */
        .login-body {
            padding: 2rem;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group-custom i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-size: 1.1rem;
            z-index: 2;
        }

        .input-group-custom input {
            width: 100%;
            padding: 0.9rem 1rem 0.9rem 2.8rem;
            border: 2px solid #e2e8f0;
            border-radius: 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #f8fafc;
            font-family: 'Inter', sans-serif;
        }

        .input-group-custom input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(67,97,238,0.1);
            background: white;
        }

        .input-group-custom input:hover {
            border-color: var(--primary-light);
        }

        /* Password toggle */
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #94a3b8;
            transition: color 0.2s;
            z-index: 2;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        /* Checkbox remember */
        .form-check {
            margin-bottom: 1.5rem;
        }

        .form-check-input {
            width: 1.1rem;
            height: 1.1rem;
            margin-top: 0.15rem;
            cursor: pointer;
            border: 2px solid #cbd5e1;
            transition: all 0.2s;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .form-check-label {
            font-size: 0.85rem;
            color: #475569;
            cursor: pointer;
        }

        /* Login Button */
        .btn-login {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 1rem;
            font-weight: 600;
            font-size: 1rem;
            color: white;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(67,97,238,0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Links */
        .login-links {
            text-align: center;
            margin-top: 1.5rem;
        }

        .login-links a {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.2s;
        }

        .login-links a:hover {
            color: var(--secondary);
            text-decoration: underline;
        }

        .divider {
            text-align: center;
            margin: 1.5rem 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 45%;
            height: 1px;
            background: #e2e8f0;
        }

        .divider::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            width: 45%;
            height: 1px;
            background: #e2e8f0;
        }

        .divider span {
            background: white;
            padding: 0 1rem;
            color: #94a3b8;
            font-size: 0.8rem;
        }

        /* Social Login */
        .social-login {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .social-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f5f9;
            color: #475569;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 1.2rem;
        }

        .social-btn:hover {
            transform: translateY(-3px);
        }

        .social-btn.google:hover {
            background: #db4437;
            color: white;
        }

        .social-btn.github:hover {
            background: #333;
            color: white;
        }

        .social-btn.facebook:hover {
            background: #1877f2;
            color: white;
        }

        /* Footer Card */
        .login-footer {
            background: #f8fafc;
            padding: 1rem;
            text-align: center;
            font-size: 0.75rem;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }

        /* Alert styling */
        .alert-custom {
            border-radius: 1rem;
            border: none;
            font-size: 0.85rem;
            padding: 0.75rem 1rem;
            margin-bottom: 1.5rem;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .login-body {
                padding: 1.5rem;
            }
            .login-header {
                padding: 1.5rem;
            }
            .login-icon {
                width: 60px;
                height: 60px;
                font-size: 2rem;
            }
        }

        /* Loading animation */
        .btn-loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-loading .btn-text {
            display: none;
        }

        .btn-loading .spinner {
            display: inline-block;
        }

        .spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Dark mode support untuk login (opsional) */
        @media (prefers-color-scheme: dark) {
            .login-card {
                background: rgba(30,41,59,0.98);
            }
            .input-group-custom input {
                background: #1e293b;
                border-color: #334155;
                color: #f1f5f9;
            }
            .input-group-custom input:focus {
                background: #1e293b;
            }
            .login-footer {
                background: #0f172a;
                border-top-color: #334155;
            }
            .divider::before,
            .divider::after {
                background: #334155;
            }
            .divider span {
                background: #1e293b;
                color: #94a3b8;
            }
            .social-btn {
                background: #1e293b;
                color: #cbd5e1;
            }
            .form-check-label {
                color: #cbd5e1;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background Blobs -->
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <!-- Particles -->
    <div class="particles" id="particles"></div>

    <div class="login-wrapper">
        <div class="login-card" data-aos="zoom-in" data-aos-duration="800">
            <div class="login-header">
                <div class="login-icon">
                    <i class="fas fa-mountain-sun"></i>
                </div>
                <h3>SPK Wisata Sumut</h3>
                <p>Sistem Pendukung Keputusan Wisata Sumatera Utara</p>
            </div>

            <div class="login-body">
                <!-- Alert Messages -->
                @if(session('error'))
                    <div class="alert alert-danger alert-custom d-flex align-items-center gap-2" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-custom d-flex align-items-center gap-2" role="alert">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form method="POST" action="#" id="loginForm">
                    @csrf

                    <div class="input-group-custom">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                               placeholder="Alamat Email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback" style="font-size: 0.75rem; margin-top: 0.25rem;">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="input-group-custom">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                               placeholder="Kata Sandi" required>
                        <span class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye-slash" id="toggleIcon"></i>
                        </span>
                        @error('password')
                            <div class="invalid-feedback" style="font-size: 0.75rem; margin-top: 0.25rem;">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-check d-flex justify-content-between align-items-center">
                        <div>
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Ingat Saya
                            </label>
                        </div>
                        <a href="#" style="font-size: 0.8rem;">Lupa Password?</a>
                    </div>

                    <button type="submit" class="btn-login" id="loginBtn">
                        <span class="btn-text">Masuk ke Dashboard</span>
                        <span class="spinner"></span>
                    </button>
                </form>

                <div class="divider">
                    <span>atau</span>
                </div>

                <div class="social-login">
                    <a href="#" class="social-btn google">
                        <i class="fab fa-google"></i>
                    </a>
                    <a href="#" class="social-btn github">
                        <i class="fab fa-github"></i>
                    </a>
                    <a href="#" class="social-btn facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </div>

                <div class="login-links">
                    <p>Belum punya akun? <a href="#">Daftar Sekarang</a></p>
                </div>
            </div>

            <div class="login-footer">
                <i class="fas fa-code me-1"></i> Sistem Pendukung Keputusan - Metode SAW
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true
        });

        // Create particles
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 50;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');

                const size = Math.random() * 6 + 2;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDuration = Math.random() * 10 + 8 + 's';
                particle.style.animationDelay = Math.random() * 10 + 's';
                particle.style.opacity = Math.random() * 0.5 + 0.2;

                particlesContainer.appendChild(particle);
            }
        }

        createParticles();

        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            }
        }

        // Form submit loading state
        const loginForm = document.getElementById('loginForm');
        const loginBtn = document.getElementById('loginBtn');

        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                if (loginForm.checkValidity()) {
                    loginBtn.classList.add('btn-loading');
                }
            });
        }

        // Demo credentials hint (untuk memudahkan testing)
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');

        // Optional: Auto-fill demo credentials (hapus jika tidak perlu)
        // emailInput.value = 'admin@spkwisata.com';
        // passwordInput.value = 'password';

        // Floating label effect
        const inputs = document.querySelectorAll('.input-group-custom input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateX(4px)';
            });
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateX(0)';
            });
        });

        // Add ripple effect to button
        const btn = document.querySelector('.btn-login');
        if (btn) {
            btn.addEventListener('click', function(e) {
                let ripple = document.createElement('span');
                ripple.classList.add('ripple');
                this.appendChild(ripple);

                let x = e.clientX - e.target.offsetLeft;
                let y = e.clientY - e.target.offsetTop;

                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        }

        // Style for ripple effect
        const style = document.createElement('style');
        style.textContent = `
            .btn-login {
                position: relative;
                overflow: hidden;
            }
            .ripple {
                position: absolute;
                border-radius: 50%;
                background: rgba(255,255,255,0.5);
                transform: scale(0);
                animation: ripple-animation 0.6s linear;
                pointer-events: none;
            }
            @keyframes ripple-animation {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>

    @stack('scripts')
</body>
</html>
