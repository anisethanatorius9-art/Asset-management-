<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asset Management System</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|space-grotesk:400,500,600,700" rel="stylesheet" />
    <style>
        :root {
            --bg: #0d1117;
            --bg-secondary: #161b22;
            --fg: #e6edf3;
            --muted: #8b949e;
            --accent: #00d4aa;
            --accent-secondary: #0ea5e9;
            --card: rgba(22, 27, 34, 0.8);
            --border: rgba(139, 148, 158, 0.2);
            --radius: 16px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Instrument Sans', system-ui, sans-serif;
            background: var(--bg);
            color: var(--fg);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Animated Grid Background */
        .bg-grid {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(0, 212, 170, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 212, 170, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            z-index: 0;
            animation: gridMove 20s linear infinite;
        }

        @keyframes gridMove {
            0% {
                transform: translate(0, 0);
            }

            100% {
                transform: translate(60px, 60px);
            }
        }

        /* Floating Orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
            animation: orbFloat 15s ease-in-out infinite;
        }

        .orb-1 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(0, 212, 170, 0.15) 0%, transparent 70%);
            top: -100px;
            right: -100px;
        }

        .orb-2 {
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.1) 0%, transparent 70%);
            bottom: 20%;
            left: -100px;
            animation-delay: -5s;
        }

        .orb-3 {
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(168, 85, 247, 0.1) 0%, transparent 70%);
            top: 50%;
            right: 10%;
            animation-delay: -10s;
        }

        @keyframes orbFloat {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(30px, -30px) scale(1.05);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.95);
            }
        }

        /* Content */
        .content {
            position: relative;
            z-index: 1;
        }

        /* Navigation */
        nav {
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(10px);
            background: rgba(13, 17, 23, 0.8);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--accent), var(--accent-secondary));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: iconPulse 3s ease-in-out infinite;
        }

        @keyframes iconPulse {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(0, 212, 170, 0.3);
            }

            50% {
                box-shadow: 0 0 40px rgba(0, 212, 170, 0.5);
            }
        }

        .logo-text {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 24px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--accent), var(--accent-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav-link {
            color: var(--muted);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--fg);
            background: rgba(0, 212, 170, 0.1);
        }

        .btn {
            padding: 10px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            font-family: inherit;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent), var(--accent-secondary));
            color: var(--bg);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 212, 170, 0.3);
        }

        .btn-secondary {
            background: var(--card);
            color: var(--fg);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: rgba(0, 212, 170, 0.1);
            border-color: var(--accent);
        }

        /* Hero Section */
        .hero {
            padding: 80px 40px;
            text-align: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(0, 212, 170, 0.1);
            border: 1px solid rgba(0, 212, 170, 0.2);
            padding: 8px 20px;
            border-radius: 50px;
            margin-bottom: 40px;
            animation: fadeInUp 0.8s ease-out;
        }

        .badge-dot {
            width: 8px;
            height: 8px;
            background: var(--accent);
            border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(1.2);
            }
        }

        .hero-badge span {
            color: var(--accent);
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .hero-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(48px, 8vw, 80px);
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 24px;
            opacity: 0;
            animation: fadeInUp 0.8s ease-out 0.2s forwards;
        }

        .hero-title span {
            background: linear-gradient(135deg, var(--fg) 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 20px;
            color: var(--muted);
            max-width: 600px;
            margin: 0 auto 48px;
            line-height: 1.6;
            opacity: 0;
            animation: fadeInUp 0.8s ease-out 0.4s forwards;
        }

        .hero-actions {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
            opacity: 0;
            animation: fadeInUp 0.8s ease-out 0.6s forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Stats Section */
        .stats-section {
            padding: 0 40px 80px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .stat-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 32px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            opacity: 0;
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .stat-card:nth-child(1) {
            animation-delay: 0.2s;
        }

        .stat-card:nth-child(2) {
            animation-delay: 0.4s;
        }

        .stat-card:nth-child(3) {
            animation-delay: 0.6s;
        }

        .stat-card:nth-child(4) {
            animation-delay: 0.8s;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            border-color: rgba(0, 212, 170, 0.3);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .stat-1 .stat-icon {
            background: rgba(0, 212, 170, 0.15);
            color: var(--accent);
        }

        .stat-2 .stat-icon {
            background: rgba(14, 165, 233, 0.15);
            color: var(--accent-secondary);
        }

        .stat-3 .stat-icon {
            background: rgba(168, 85, 247, 0.15);
            color: #a855f7;
        }

        .stat-4 .stat-icon {
            background: rgba(34, 197, 94, 0.15);
            color: #22c55e;
        }

        .stat-value {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .stat-label {
            color: var(--muted);
            font-size: 14px;
            font-weight: 500;
        }

        /* Features Section */
        .features-section {
            padding: 0 40px 100px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 64px;
        }

        .section-label {
            color: var(--accent);
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 16px;
            display: block;
        }

        .section-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(32px, 5vw, 48px);
            font-weight: 700;
            margin-bottom: 16px;
        }

        .section-desc {
            color: var(--muted);
            font-size: 18px;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .feature-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 32px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            opacity: 0;
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .feature-card:nth-child(1) {
            animation-delay: 0.2s;
        }

        .feature-card:nth-child(2) {
            animation-delay: 0.4s;
        }

        .feature-card:nth-child(3) {
            animation-delay: 0.6s;
        }

        .feature-card:nth-child(4) {
            animation-delay: 0.8s;
        }

        .feature-card:nth-child(5) {
            animation-delay: 1s;
        }

        .feature-card:nth-child(6) {
            animation-delay: 1.2s;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            border-color: rgba(0, 212, 170, 0.3);
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            background: linear-gradient(135deg, rgba(0, 212, 170, 0.15), rgba(14, 165, 233, 0.15));
        }

        .feature-icon svg {
            width: 28px;
            height: 28px;
            color: var(--accent);
        }

        .feature-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .feature-desc {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        /* Footer */
        footer {
            padding: 40px;
            border-top: 1px solid var(--border);
            text-align: center;
            background: rgba(13, 17, 23, 0.8);
            backdrop-filter: blur(10px);
        }

        .footer-text {
            color: var(--muted);
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            nav {
                padding: 16px 20px;
                flex-wrap: wrap;
                gap: 16px;
            }

            .hero {
                padding: 60px 20px;
            }

            .hero-title {
                font-size: 40px;
            }

            .hero-subtitle {
                font-size: 16px;
            }

            .stats-section,
            .features-section {
                padding: 0 20px 60px;
            }

            .stats-grid,
            .features-grid {
                grid-template-columns: 1fr;
            }

            .nav-links {
                width: 100%;
                justify-content: center;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>

<body>
    <div class="bg-grid"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="content">
        <nav>
            <div class="logo">
                <div class="logo-icon">
                    <img src="{{ asset('images/logo.png') }}" alt="Asset Management Logo" style="width: 28px; height: 28px; object-fit: contain;" />
                </div>
                <span class="logo-text">Asset Management</span>
            </div>
            <div class="nav-links">
                @if (Route::has('login'))
                @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                @else
                <a href="{{ route('login') }}" class="nav-link">Login</a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                @endif
                @endauth
                @endif
            </div>
        </nav>

        <section class="hero">
            <div class="hero-badge">
                <span class="badge-dot"></span>
                <span>Asset Management System v2.0</span>
            </div>
            <h1 class="hero-title">
                Powerful Asset<br>
                <span>Management</span><br>
                Simplified
            </h1>
            <p class="hero-subtitle">
                Track, manage, and optimize your assets with precision. From inventory to lifecycle management,
                everything you need in one powerful platform built for modern businesses.
            </p>
            <div class="hero-actions">
                <a href="{{ route('login') }}" class="btn btn-primary">Get Started</a>
                <a href="#features" class="btn btn-secondary">Learn More</a>
            </div>
        </section>

        <section class="stats-section">
            <div class="stats-grid">
                <div class="stat-card stat-1">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                        </svg>
                    </div>
                    <div class="stat-value">{{ number_format(\App\Models\Asset::count()) }}</div>
                    <div class="stat-label">Total Assets</div>
                </div>
                <div class="stat-card stat-2">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                            <path d="M3 9h18M9 3v18" />
                        </svg>
                    </div>
                    <div class="stat-value">{{ number_format(\App\Models\Category::count()) }}</div>
                    <div class="stat-label">Categories</div>
                </div>
                <div class="stat-card stat-3">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </div>
                    <div class="stat-value">{{ number_format(\App\Models\Location::count()) }}</div>
                    <div class="stat-label">Locations</div>
                </div>
                <div class="stat-card stat-4">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                        </svg>
                    </div>
                    <div class="stat-value">{{ \App\Helpers\Helper::formatNumber(\App\Models\Asset::sum('purchase_price')) }}</div>
                    <div class="stat-label">Total Value</div>
                </div>
            </div>
        </section>

        <section id="features" class="features-section">
            <div class="section-header">
                <span class="section-label">Features</span>
                <h2 class="section-title">Everything You Need to Manage Assets</h2>
                <p class="section-desc">
                    Comprehensive tools for tracking, organizing, and maintaining your assets throughout their lifecycle.
                </p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                        </svg>
                    </div>
                    <h3 class="feature-title">Asset Tracking</h3>
                    <p class="feature-desc">Complete lifecycle management from acquisition to disposal. Track location, condition, and maintenance history.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                            <path d="M3 9h18M9 3v18" />
                        </svg>
                    </div>
                    <h3 class="feature-title">Category Management</h3>
                    <p class="feature-desc">Organize assets into flexible categories with custom attributes and hierarchical support.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </div>
                    <h3 class="feature-title">Location Tracking</h3>
                    <p class="feature-desc">Multi-level location hierarchy from buildings to shelves. Track asset movement and assignments.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                    </div>
                    <h3 class="feature-title">Document Management</h3>
                    <p class="feature-desc">Attach invoices, manuals, and warranties. Centralize all asset-related documentation.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                        </svg>
                    </div>
                    <h3 class="feature-title">Maintenance Alerts</h3>
                    <p class="feature-desc">Automated reminders for scheduled maintenance, inspections, and renewals.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="20" x2="18" y2="10" />
                            <line x1="12" y1="20" x2="12" y2="4" />
                            <line x1="6" y1="20" x2="6" y2="14" />
                        </svg>
                    </div>
                    <h3 class="feature-title">Reports & Analytics</h3>
                    <p class="feature-desc">Generate comprehensive reports on asset utilization, depreciation, and costs.</p>
                </div>
            </div>
        </section>

        <footer>
            <p class="footer-text">© 2026 AMS - Asset Management System. All rights reserved.</p>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            // Scroll reveal for elements without animation
            const reveals = document.querySelectorAll('.stat-card, .feature-card');

            if (!prefersReducedMotion) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry, index) => {
                        if (entry.isIntersecting) {
                            setTimeout(() => {
                                entry.target.style.transform = 'translateY(-8px)';
                                entry.target.style.opacity = '1';
                            }, index * 50);
                        }
                    });
                }, {
                    threshold: 0.1
                });

                reveals.forEach(card => observer.observe(card));
            }
        });
    </script>
</body>

</html>
