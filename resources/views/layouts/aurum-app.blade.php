<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="نُسَاه - تجربة صحية فاخرة">
    <title>@yield('title') | نُسَاه</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo.ico') }}">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    
    <!-- Custom Aurum Styles -->
    <style>
        :root {
            --aurum-gold: #D4AF37;
            --aurum-gold-light: #F7DC6F;
            --aurum-gold-dark: #B8860B;
            --aurum-black: #0A0A0A;
            --aurum-charcoal: #1A1A1A;
            --aurum-cream: #F5F5DC;
            --aurum-white: #FFFFFF;
            --aurum-gray: #8B7355;
            --aurum-gradient: linear-gradient(135deg, #D4AF37 0%, #B8860B 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: var(--aurum-white);
            color: var(--aurum-charcoal);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .aurum-font {
            font-family: 'Playfair Display', serif;
        }

        /* Header Styles */
        .aurum-header {
            background: rgba(10, 10, 10, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--aurum-gold);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .aurum-header.scrolled {
            background: rgba(10, 10, 10, 0.98);
            box-shadow: 0 4px 20px rgba(212, 175, 55, 0.1);
        }

        .aurum-logo {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--aurum-gold);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .aurum-logo:hover {
            color: var(--aurum-gold-light);
            text-shadow: 0 0 10px var(--aurum-gold);
        }

        .aurum-nav .nav-link {
            color: var(--aurum-white);
            font-weight: 500;
            padding: 1rem 1.5rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .aurum-nav .nav-link:hover,
        .aurum-nav .nav-link.active {
            color: var(--aurum-gold);
        }

        .aurum-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--aurum-gradient);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .aurum-nav .nav-link:hover::after,
        .aurum-nav .nav-link.active::after {
            width: 80%;
        }

        /* Hero Section */
        .aurum-hero {
            background: linear-gradient(135deg, var(--aurum-black) 0%, var(--aurum-charcoal) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .aurum-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="%23D4AF3710" points="0,0 1000,300 1000,1000 0,700"/></svg>');
            background-size: cover;
        }

        .aurum-hero-content {
            position: relative;
            z-index: 2;
        }

        .aurum-hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--aurum-gold);
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .aurum-hero-subtitle {
            font-size: 1.5rem;
            color: var(--aurum-cream);
            margin-bottom: 2rem;
            font-weight: 300;
        }

        /* Buttons */
        .aurum-btn {
            display: inline-block;
            padding: 1rem 2.5rem;
            font-weight: 600;
            text-decoration: none;
            border-radius: 50px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .aurum-btn-primary {
            background: var(--aurum-gradient);
            color: var(--aurum-black);
            border: none;
        }

        .aurum-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.3);
            color: var(--aurum-black);
        }

        .aurum-btn-secondary {
            background: transparent;
            color: var(--aurum-gold);
            border: 2px solid var(--aurum-gold);
        }

        .aurum-btn-secondary:hover {
            background: var(--aurum-gold);
            color: var(--aurum-black);
            transform: translateY(-2px);
        }

        /* Cards */
        .aurum-card {
            background: var(--aurum-white);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(212, 175, 55, 0.1);
        }

        .aurum-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(212, 175, 55, 0.2);
            border-color: var(--aurum-gold);
        }

        .aurum-card-icon {
            width: 80px;
            height: 80px;
            background: var(--aurum-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 2rem;
            color: var(--aurum-black);
        }

        /* Sections */
        .aurum-section {
            padding: 5rem 0;
            position: relative;
        }

        .aurum-section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: var(--aurum-gold);
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }

        .aurum-section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            width: 80px;
            height: 3px;
            background: var(--aurum-gradient);
            transform: translateX(-50%);
        }

        /* Footer */
        .aurum-footer {
            background: var(--aurum-black);
            color: var(--aurum-cream);
            padding: 3rem 0 1rem;
            border-top: 3px solid var(--aurum-gold);
        }

        /* Animations */
        @keyframes aurumGlow {
            0%, 100% { box-shadow: 0 0 5px var(--aurum-gold); }
            50% { box-shadow: 0 0 20px var(--aurum-gold), 0 0 30px var(--aurum-gold); }
        }

        .aurum-glow {
            animation: aurumGlow 2s ease-in-out infinite;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .aurum-hero-title {
                font-size: 2.5rem;
            }
            
            .aurum-hero-subtitle {
                font-size: 1.2rem;
            }
            
            .aurum-section {
                padding: 3rem 0;
            }
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--aurum-charcoal);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--aurum-gradient);
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="aurum-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <a class="aurum-logo" href="{{ url('/') }}">
                    <img src="{{ asset('logo.png') }}" alt="نُسَاه" style="height: 50px; margin-left: 10px;">
                    نُسَاه
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#aurumNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="aurumNav">
                    <ul class="navbar-nav me-auto aurum-nav">
                        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">الرئيسية</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('doctorsall') }}">الأطباء</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('clinic') }}">العيادات</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('inbody') }}">أجهزة InBody</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('articals') }}">مقالات</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('diet') }}">الحمية الغذائية</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">اتصل بنا</a></li>
                    </ul>
                    <div class="d-flex">
                        <a href="{{ route('login/home') }}" class="aurum-btn aurum-btn-primary">تسجيل دخول</a>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="aurum-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <h5 class="aurum-font" style="color: var(--aurum-gold);">نُسَاه</h5>
                    <p>تجربة صحية فاخرة تلبي أعلى معايير الجودة والتميز</p>
                </div>
                <div class="col-lg-4">
                    <h6 style="color: var(--aurum-gold);">روابط سريعة</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('clinic') }}" style="color: var(--aurum-cream); text-decoration: none;">العيادات</a></li>
                        <li><a href="{{ route('inbody') }}" style="color: var(--aurum-cream); text-decoration: none;">أجهزة InBody</a></li>
                        <li><a href="{{ route('articals') }}" style="color: var(--aurum-cream); text-decoration: none;">المقالات</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6 style="color: var(--aurum-gold);">تواصل معنا</h6>
                    <p>ليبيا - طرابلس</p>
                    <p>هاتف: +218 91 234 5678</p>
                </div>
            </div>
            <hr style="border-color: var(--aurum-gold);">
            <div class="text-center">
                <p>&copy; 2024 نُسَاه. جميع الحقوق محفوظة</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true
        });

        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.aurum-header');
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
