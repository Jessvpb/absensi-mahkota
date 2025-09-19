<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahkota Gallery Watches - Premium Watch Collection</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Animated Background */
        .animated-bg {
            background: linear-gradient(-45deg, #0f0f0f, #1a1a1a, #2d1810, #1a1a1a);
            background-size: 400% 400%;
            animation: gradientShift 20s ease infinite;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Glass Card */
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.2);
        }

        /* Logo Animation */
        .logo-glow {
            animation: logoGlow 3s ease-in-out infinite;
        }

        @keyframes logoGlow {
            0%, 100% {
                box-shadow: 0 0 30px rgba(251, 191, 36, 0.4);
            }
            50% {
                box-shadow: 0 0 50px rgba(251, 191, 36, 0.7);
            }
        }

        /* Floating Animation */
        .float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        /* Fade In Animation */
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Slide In Animation */
        .slide-in-left {
            animation: slideInLeft 1s ease-out;
        }

        .slide-in-right {
            animation: slideInRight 1s ease-out;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Pulse Animation */
        .pulse-glow {
            animation: pulseGlow 2s ease-in-out infinite;
        }

        @keyframes pulseGlow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(251, 191, 36, 0.3);
            }
            50% {
                box-shadow: 0 0 40px rgba(251, 191, 36, 0.6);
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(31, 41, 55, 0.5);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(251, 191, 36, 0.3);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(251, 191, 36, 0.5);
        }
    </style>
</head>

<body class="animated-bg min-h-screen">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 glass-card border-b border-yellow-400/20">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-gray-800/50 to-black/80 flex items-center justify-center border border-yellow-400/20 logo-glow">
                        <span class="text-xl font-bold bg-gradient-to-br from-yellow-300 to-yellow-500 bg-clip-text text-transparent">MG</span>
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-lg">Mahkota Gallery</h1>
                        <p class="text-yellow-400 text-xs tracking-wider">WATCHES</p>
                    </div>
                </div>

                <!-- Auth Links -->
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 shadow-lg hover:shadow-yellow-500/25">
                                <i class="fas fa-tachometer-alt mr-2"></i>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 shadow-lg hover:shadow-yellow-500/25">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Masuk
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="min-h-screen flex items-center justify-center px-6 pt-20">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="text-center lg:text-left slide-in-left">
                    <div class="mb-6">
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-400/20 text-yellow-400 border border-yellow-400/30 mb-4">
                            <i class="fas fa-crown mr-2"></i>
                            Premium Watch Collection
                        </span>
                    </div>

                    <h1 class="text-5xl lg:text-7xl font-bold text-white mb-6 leading-tight">
                        <span class="bg-gradient-to-r from-yellow-300 to-amber-500 bg-clip-text text-transparent">Mahkota</span>
                        <br>
                        <span class="text-white">Gallery</span>
                    </h1>

                    <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                        Perusahaan jam tangan branded terpercaya dan terdepan di Indonesia.
                        Menghadirkan produk berkualitas tinggi dengan jaminan <span class="text-yellow-400 font-semibold">100% original</span>.
                    </p>

                    <!-- Taglines -->
                    <div class="flex flex-col sm:flex-row gap-4 mb-8">
                        <div class="flex items-center justify-center lg:justify-start">
                            <div class="p-3 bg-gradient-to-r from-green-400/20 to-emerald-500/20 rounded-xl border border-green-500/30 mr-3">
                                <i class="fas fa-shield-alt text-green-400"></i>
                            </div>
                            <div>
                                <p class="text-green-400 font-bold">#YakinOri</p>
                                <p class="text-gray-400 text-sm">100% Original</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-center lg:justify-start">
                            <div class="p-3 bg-gradient-to-r from-blue-400/20 to-cyan-500/20 rounded-xl border border-blue-500/30 mr-3">
                                <i class="fas fa-heart text-blue-400"></i>
                            </div>
                            <div>
                                <p class="text-blue-400 font-bold">#AntiWorry</p>
                                <p class="text-gray-400 text-sm">Layanan Terpercaya</p>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                   class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-bold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 shadow-lg hover:shadow-yellow-500/25 pulse-glow">
                                    <i class="fas fa-tachometer-alt mr-3"></i>
                                    Masuk ke Dashboard
                                </a>
                            {{-- @else
                                <a href="{{ route('login') }}"
                                   class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-bold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 shadow-lg hover:shadow-yellow-500/25 pulse-glow">
                                    <i class="fas fa-sign-in-alt mr-3"></i>
                                    Masuk Sekarang
                                </a> --}}
                            @endauth
                        @endif

                        <a href="#about"
                           class="inline-flex items-center justify-center px-8 py-4 bg-gray-800/50 text-white font-semibold rounded-xl hover:bg-gray-700/50 transition-all duration-300 border border-gray-600">
                            <i class="fas fa-info-circle mr-3"></i>
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>

                <!-- Right Content - Floating Watch -->
                <div class="flex justify-center lg:justify-end slide-in-right">
                    <div class="relative">
                        <div class="w-80 h-80 rounded-full bg-gradient-to-br from-yellow-400/20 to-amber-500/20 flex items-center justify-center border border-yellow-400/30 float">
                            <div class="w-64 h-64 rounded-full bg-gradient-to-br from-gray-800/50 to-black/80 flex items-center justify-center border border-yellow-400/20 logo-glow">
                                <i class="fas fa-clock text-8xl text-yellow-400"></i>
                            </div>
                        </div>

                        <!-- Floating Elements -->
                        <div class="absolute -top-4 -right-4 w-16 h-16 bg-gradient-to-r from-green-400/20 to-emerald-500/20 rounded-full flex items-center justify-center border border-green-500/30 float" style="animation-delay: -2s;">
                            <i class="fas fa-shield-alt text-green-400"></i>
                        </div>

                        <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-gradient-to-r from-blue-400/20 to-cyan-500/20 rounded-full flex items-center justify-center border border-blue-500/30 float" style="animation-delay: -4s;">
                            <i class="fas fa-heart text-blue-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 px-6">
        <div class="max-w-7xl mx-auto">
            <!-- Visi -->
            <div class="glass-card rounded-2xl p-8 mb-12 fade-in">
                <div class="text-center mb-8">
                    <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-500/20 text-blue-400 border border-blue-500/30 mb-4">
                        <i class="fas fa-eye mr-2"></i>
                        Visi Kami
                    </div>
                    <h2 class="text-4xl font-bold text-white mb-6">Visi Perusahaan</h2>
                </div>

                <div class="max-w-4xl mx-auto">
                    <p class="text-xl text-gray-300 leading-relaxed text-center">
                        Menjadi perusahaan jam tangan branded <span class="text-yellow-400 font-semibold">terpercaya dan terdepan di Indonesia</span>,
                        yang berkomitmen untuk menghadirkan produk berkualitas tinggi dengan jaminan <span class="text-green-400 font-semibold">100% original</span>,
                        harga kompetitif, pelayanan terbaik, serta pengalaman belanja yang <span class="text-blue-400 font-semibold">aman dan nyaman</span> bagi pelanggan.
                    </p>
                </div>
            </div>

            <!-- Misi -->
            <div class="glass-card rounded-2xl p-8 fade-in">
                <div class="text-center mb-8">
                    <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-purple-500/20 text-purple-400 border border-purple-500/30 mb-4">
                        <i class="fas fa-target mr-2"></i>
                        Misi Kami
                    </div>
                    <h2 class="text-4xl font-bold text-white mb-6">Misi Perusahaan</h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Misi 1 -->
                    <div class="bg-gradient-to-br from-green-500/10 to-green-600/10 border border-green-500/20 rounded-xl p-6 hover:from-green-500/20 hover:to-green-600/20 transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-shield-alt text-green-400"></i>
                            </div>
                            <h3 class="text-xl font-bold text-green-400">#YakinOri</h3>
                        </div>
                        <p class="text-gray-300 leading-relaxed">
                            Menjamin keaslian produk dengan garansi resmi yang memberikan rasa percaya dan kepuasan bagi pelanggan.
                        </p>
                    </div>

                    <!-- Misi 2 -->
                    <div class="bg-gradient-to-br from-blue-500/10 to-blue-600/10 border border-blue-500/20 rounded-xl p-6 hover:from-blue-500/20 hover:to-blue-600/20 transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-heart text-blue-400"></i>
                            </div>
                            <h3 class="text-xl font-bold text-blue-400">#AntiWorry</h3>
                        </div>
                        <p class="text-gray-300 leading-relaxed">
                            Memberikan rasa aman bagi pelanggan dengan adanya jaminan layanan after-sales yang berkualitas.
                        </p>
                    </div>

                    <!-- Misi 3 -->
                    <div class="bg-gradient-to-br from-purple-500/10 to-purple-600/10 border border-purple-500/20 rounded-xl p-6 hover:from-purple-500/20 hover:to-purple-600/20 transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-rocket text-purple-400"></i>
                            </div>
                            <h3 class="text-xl font-bold text-purple-400">Inovasi</h3>
                        </div>
                        <p class="text-gray-300 leading-relaxed">
                            Meningkatkan jangkauan bisnis dengan inovasi yang relevan dan mempertahankan pelayanan terbaik bagi pelanggan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12 fade-in">
                <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-400/20 text-yellow-400 border border-yellow-400/30 mb-4">
                    <i class="fas fa-star mr-2"></i>
                    Keunggulan Kami
                </div>
                <h2 class="text-4xl font-bold text-white mb-6">Mengapa Memilih Mahkota Gallery?</h2>
                <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                    Kami berkomitmen memberikan yang terbaik untuk setiap pelanggan dengan standar kualitas tertinggi
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="glass-card rounded-2xl p-6 text-center hover:scale-105 transition-all duration-300 fade-in">
                    <div class="w-16 h-16 bg-gradient-to-r from-yellow-400 to-amber-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-certificate text-2xl text-black"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">100% Original</h3>
                    <p class="text-gray-400">Semua produk dijamin keasliannya dengan sertifikat resmi</p>
                </div>

                <!-- Feature 2 -->
                <div class="glass-card rounded-2xl p-6 text-center hover:scale-105 transition-all duration-300 fade-in" style="animation-delay: 0.2s;">
                    <div class="w-16 h-16 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Layanan 24/7</h3>
                    <p class="text-gray-400">Customer service siap membantu Anda kapan saja</p>
                </div>

                <!-- Feature 3 -->
                <div class="glass-card rounded-2xl p-6 text-center hover:scale-105 transition-all duration-300 fade-in" style="animation-delay: 0.4s;">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-400 to-cyan-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shipping-fast text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Pengiriman Cepat</h3>
                    <p class="text-gray-400">Pengiriman aman dan cepat ke seluruh Indonesia</p>
                </div>

                <!-- Feature 4 -->
                <div class="glass-card rounded-2xl p-6 text-center hover:scale-105 transition-all duration-300 fade-in" style="animation-delay: 0.6s;">
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-400 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-tools text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">After Sales</h3>
                    <p class="text-gray-400">Layanan purna jual terbaik untuk kepuasan Anda</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="glass-card border-t border-yellow-400/20 py-8 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-3 mb-4 md:mb-0">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-800/50 to-black/80 flex items-center justify-center border border-yellow-400/20">
                        <span class="text-lg font-bold bg-gradient-to-br from-yellow-300 to-yellow-500 bg-clip-text text-transparent">MG</span>
                    </div>
                    <div>
                        <h1 class="text-white font-bold">Mahkota Gallery</h1>
                        <p class="text-yellow-400 text-xs tracking-wider">WATCHES</p>
                    </div>
                </div>

                <!-- Copyright -->
                <div class="text-center md:text-right">
                    <p class="text-gray-400 text-sm">
                        © {{ date('Y') }} Mahkota Gallery Watches. All rights reserved.
                    </p>
                    <p class="text-gray-500 text-xs mt-1">
                        #YakinOri #AntiWorry
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Smooth Scroll Script -->
    <script>
        // Smooth scroll for anchor links
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

        // Add scroll effect to navbar
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 100) {
                nav.style.background = 'rgba(0, 0, 0, 0.9)';
            } else {
                nav.style.background = 'rgba(255, 255, 255, 0.05)';
            }
        });
    </script>
</body>

</html>
