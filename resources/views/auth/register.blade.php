<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Mahkota Gallery Watches</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Animated Background */
        .animated-bg {
            background: linear-gradient(-45deg, #0f0f0f, #1a1a1a, #2d1810, #1a1a1a);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating particles */
        .particle {
            position: absolute;
            background: rgba(251, 191, 36, 0.1);
            border-radius: 50%;
            pointer-events: none;
            animation: float 6s ease-in-out infinite;
        }

        .particle:nth-child(1) { width: 4px; height: 4px; top: 20%; left: 20%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 6px; height: 6px; top: 60%; left: 80%; animation-delay: 2s; }
        .particle:nth-child(3) { width: 3px; height: 3px; top: 80%; left: 40%; animation-delay: 4s; }
        .particle:nth-child(4) { width: 5px; height: 5px; top: 40%; left: 70%; animation-delay: 1s; }
        .particle:nth-child(5) { width: 4px; height: 4px; top: 70%; left: 10%; animation-delay: 3s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.3; }
            50% { transform: translateY(-20px) rotate(180deg); opacity: 0.8; }
        }

        /* Logo Animation */
        .logo-container {
            position: relative;
            animation: logoGlow 4s ease-in-out infinite;
        }

        @keyframes logoGlow {
            0%, 100% {
                box-shadow: 0 0 30px rgba(251, 191, 36, 0.3),
                           0 0 60px rgba(251, 191, 36, 0.1),
                           inset 0 0 30px rgba(251, 191, 36, 0.05);
            }
            50% {
                box-shadow: 0 0 50px rgba(251, 191, 36, 0.5),
                           0 0 100px rgba(251, 191, 36, 0.2),
                           inset 0 0 50px rgba(251, 191, 36, 0.1);
            }
        }

        /* Form Styling */
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.3);
        }

        .input-field {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-field:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #fbbf24;
            box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.1),
                       0 0 20px rgba(251, 191, 36, 0.2);
            transform: translateY(-2px);
        }

        .select-field {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .select-field:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #fbbf24;
            box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.1),
                       0 0 20px rgba(251, 191, 36, 0.2);
            transform: translateY(-2px);
        }

        .select-field option {
            background: #1f2937;
            color: white;
            padding: 10px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #d97706 100%);
            box-shadow: 0 10px 30px rgba(251, 191, 36, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(251, 191, 36, 0.4);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Text animations */
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        .fade-in-up:nth-child(1) { animation-delay: 0.1s; }
        .fade-in-up:nth-child(2) { animation-delay: 0.2s; }
        .fade-in-up:nth-child(3) { animation-delay: 0.3s; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .logo-container {
                width: 120px !important;
                height: 120px !important;
            }
        }

        /* Custom scrollbar */
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
<body class="animated-bg min-h-screen relative overflow-hidden">
    <!-- Floating Particles -->
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>

    <div class="min-h-screen flex">
        <!-- Left Side - Logo and Welcome -->
        <div class="hidden lg:flex lg:w-1/2 items-center justify-center p-12 relative">
            <!-- Decorative Elements -->
            <div class="absolute top-20 left-20 w-32 h-32 bg-gradient-to-br from-yellow-400/10 to-transparent rounded-full blur-xl"></div>
            <div class="absolute bottom-20 right-20 w-40 h-40 bg-gradient-to-br from-yellow-400/5 to-transparent rounded-full blur-2xl"></div>

            <div class="text-center space-y-8 relative z-10">
                <!-- Logo -->
                <div class="fade-in-up">
                    <div class="logo-container w-64 h-64 mx-auto rounded-full bg-gradient-to-br from-gray-800/50 via-gray-900/70 to-black/80 flex items-center justify-center border border-yellow-400/20">
                        <div class="text-center">
                            <div class="text-8xl font-bold bg-gradient-to-br from-yellow-300 via-yellow-400 to-amber-500 bg-clip-text text-transparent mb-4 drop-shadow-lg">
                                MG
                            </div>
                            <div class="text-yellow-400 text-base font-light tracking-[0.3em] uppercase">
                                MAHKOTA GALLERY
                            </div>
                            <div class="text-yellow-400/80 text-sm tracking-[0.4em] mt-2 uppercase">
                                WATCHES
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Welcome Text -->
                <div class="space-y-6 fade-in-up">
                    <h1 class="text-5xl font-bold bg-gradient-to-r from-white via-gray-100 to-gray-300 bg-clip-text text-transparent leading-tight">
                        Join Our<br>
                        <span class="text-yellow-400">Premium Community</span>
                    </h1>
                    <p class="text-yellow-400 text-xl font-light tracking-wider">
                        #YakinOri #AntiWorry
                    </p>
                    <div class="w-24 h-1 bg-gradient-to-r from-yellow-400 to-amber-500 mx-auto rounded-full"></div>
                </div>
            </div>
        </div>

        <!-- Right Side - Register Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 relative">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8 fade-in-up">
                    <div class="w-24 h-24 mx-auto rounded-full bg-gradient-to-br from-gray-800/50 to-black/80 flex items-center justify-center mb-4 border border-yellow-400/20 logo-container">
                        <div class="text-3xl font-bold bg-gradient-to-br from-yellow-300 to-yellow-500 bg-clip-text text-transparent">
                            MG
                        </div>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="glass-card rounded-2xl p-8 fade-in-up max-h-[90vh] overflow-y-auto">
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <h2 class="text-4xl font-bold bg-gradient-to-r from-yellow-300 via-yellow-400 to-amber-500 bg-clip-text text-transparent mb-3">
                            REGISTER
                        </h2>
                        <p class="text-gray-400 text-lg">Buat akun baru Anda</p>
                    </div>

                    <!-- Register Form -->
                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        <!-- Name -->
                        <div class="space-y-2">
                            <label for="name" class="text-gray-300 text-sm font-medium flex items-center">
                                <i class="fas fa-user mr-2 text-yellow-400"></i>
                                Nama Lengkap
                            </label>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="input-field w-full px-4 py-3 rounded-xl text-white placeholder-gray-400 focus:outline-none"
                                placeholder="Masukkan nama lengkap"
                                required
                                autofocus
                                autocomplete="name"
                            />
                            @error('name')
                                <p class="text-red-400 text-sm mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="text-gray-300 text-sm font-medium flex items-center">
                                <i class="fas fa-envelope mr-2 text-yellow-400"></i>
                                Email
                            </label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="input-field w-full px-4 py-3 rounded-xl text-white placeholder-gray-400 focus:outline-none"
                                placeholder="Masukkan email Anda"
                                required
                                autocomplete="username"
                            />
                            @error('email')
                                <p class="text-red-400 text-sm mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="space-y-2">
                            <label for="password" class="text-gray-300 text-sm font-medium flex items-center">
                                <i class="fas fa-lock mr-2 text-yellow-400"></i>
                                Password
                            </label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="input-field w-full px-4 py-3 rounded-xl text-white placeholder-gray-400 focus:outline-none"
                                placeholder="Masukkan password"
                                required
                                autocomplete="new-password"
                            />
                            @error('password')
                                <p class="text-red-400 text-sm mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-2">
                            <label for="password_confirmation" class="text-gray-300 text-sm font-medium flex items-center">
                                <i class="fas fa-lock mr-2 text-yellow-400"></i>
                                Konfirmasi Password
                            </label>
                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                class="input-field w-full px-4 py-3 rounded-xl text-white placeholder-gray-400 focus:outline-none"
                                placeholder="Konfirmasi password"
                                required
                                autocomplete="new-password"
                            />
                            @error('password_confirmation')
                                <p class="text-red-400 text-sm mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div class="space-y-2">
                            <label for="role" class="text-gray-300 text-sm font-medium flex items-center">
                                <i class="fas fa-user-tag mr-2 text-yellow-400"></i>
                                Role
                            </label>
                            <select
                                id="role"
                                name="role"
                                class="select-field w-full px-4 py-3 rounded-xl text-white focus:outline-none"
                                required
                            >
                                <option value="" class="text-gray-400">Pilih role Anda</option>
                                <option value="karyawan" {{ old('role') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                                <option value="kepala" {{ old('role') == 'kepala' ? 'selected' : '' }}>Kepala Cabang</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <p class="text-red-400 text-sm mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Register Button -->
                        <button type="submit" class="btn-primary w-full py-4 px-6 rounded-xl text-black font-semibold text-lg relative overflow-hidden mt-6">
                            <span class="relative z-10">Daftar</span>
                        </button>

                        <!-- Divider -->
                        <div class="relative my-6">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-700"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-transparent text-gray-500 uppercase tracking-wider">
                                    Atau daftar dengan
                                </span>
                            </div>
                        </div>

                        <!-- Google Register -->
                        <button type="button" class="btn-secondary w-full py-4 px-6 rounded-xl text-gray-900 font-semibold flex items-center justify-center space-x-3">
                            <svg class="w-5 h-5" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            <span>Google</span>
                        </button>

                        <!-- Terms and Privacy -->
                        <div class="text-center text-xs text-gray-500 mt-4">
                            Dengan mendaftar atau masuk, kamu menyetujui
                            <a href="#" class="text-yellow-400 hover:text-yellow-300 transition-colors">Syarat dan Ketentuan</a>
                            serta
                            <a href="#" class="text-yellow-400 hover:text-yellow-300 transition-colors">Kebijakan Privasi</a>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center pt-4">
                            <p class="text-gray-400">
                                Sudah punya akun?
                                <a href="{{ route('login') }}" class="text-yellow-400 hover:text-yellow-300 font-semibold transition-colors ml-1">
                                    Masuk
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
