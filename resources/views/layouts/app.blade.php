<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Mahkota Gallery Watches</title>
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

        /* Sidebar Styling */
        .sidebar {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(251, 191, 36, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar-item {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .sidebar-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(to bottom, #fbbf24, #f59e0b);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .sidebar-item:hover::before,
        .sidebar-item.active::before {
            transform: scaleY(1);
        }

        .sidebar-item:hover {
            background: rgba(251, 191, 36, 0.1);
            transform: translateX(4px);
        }

        .sidebar-item.active {
            background: rgba(251, 191, 36, 0.15);
            color: #fbbf24;
        }

        /* Main Content */
        .main-content {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            min-height: 100vh;
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

            0%,
            100% {
                box-shadow: 0 0 20px rgba(251, 191, 36, 0.3);
            }

            50% {
                box-shadow: 0 0 30px rgba(251, 191, 36, 0.5);
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

        /* Mobile Menu */
        .mobile-menu {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .mobile-menu.open {
            transform: translateX(0);
        }

        /* Dropdown Animation */
        .dropdown-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .dropdown-content.open {
            max-height: 500px;
        }
    </style>
</head>

<body class="animated-bg">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar w-64 flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-700/50">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-br from-gray-800/50 to-black/80 flex items-center justify-center border border-yellow-400/20 logo-glow">
                        <span
                            class="text-xl font-bold bg-gradient-to-br from-yellow-300 to-yellow-500 bg-clip-text text-transparent">MG</span>
                    </div>
                    <div class="sidebar-text">
                        <h1 class="text-white font-bold text-lg">Mahkota Gallery</h1>
                        <p class="text-yellow-400 text-xs tracking-wider">WATCHES</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                    class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home w-5 text-center"></i>
                    <span class="sidebar-text ml-3">Dashboard</span>
                </a>

                @auth
                    @if (auth()->user()->role === 'admin')
                        <!-- Admin Only Section (Master Data)-->
                        <div class="pt-4">
                            <p class="sidebar-text px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Master Data</p>

                            <a href="{{ route('cabang.view') }}"
                                class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('cabang.*') ? 'active' : '' }}">
                                <i class="fas fa-building w-5 text-center"></i>
                                <span class="sidebar-text ml-3">Data Cabang</span>
                            </a>

                            <!-- Staff Management -->
                            <a href="{{ route('staff.view') }}"
                                class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('staff.*') ? 'active' : '' }}">
                                <i class="fas fa-users w-5 text-center"></i>
                                <span class="sidebar-text ml-3">Data Staff</span>
                            </a>

                            <a href="{{ route('jabatan.view') }}"
                                class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('jabatan.*') ? 'active' : '' }}">
                                <i class="fas fa-briefcase w-5 text-center"></i>
                                <span class="sidebar-text ml-3">Data Jabatan</span>
                            </a>
                        </div>
                        <!-- Admin Only Section (Pengajuan Karyawan)-->
                        <div class="pt-4">
                            <p class="sidebar-text px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Pengajuan Karyawan</p>
                            <a href="{{ route('kronologi.view') }}"
                                class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('kronologi.view') ? 'active' : '' }}">
                                <i class="fas fa-clock w-5 text-center"></i>
                                <span class="sidebar-text ml-3">Pengajuan Denda</span>
                            </a>

                            <a href="{{ route('pinjaman.view') }}"
                                class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('pinjaman.view') ? 'active' : '' }}">
                                <i class="fas fa-hand-holding-usd w-5 text-center"></i>
                                <span class="sidebar-text ml-3">Pengajuan Pinjaman</span>
                            </a>

                            <a href="{{ route('pengajuanizin.view') }}"
                                class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('pengajuanizin.view') ? 'active' : '' }}">
                                <i class="fas fa-calendar-check w-5 text-center"></i>
                                <span class="sidebar-text ml-3">Pengajuan Izin</span>
                            </a>

                            <a href="{{ route('pengajuandispensasi.view') }}"
                                class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('pengajuandispensasi.view') ? 'active' : '' }}">
                                <i class="fas fa-stopwatch w-5 text-center"></i>
                                <span class="sidebar-text ml-3">Pengajuan Dispensasi</span>
                            </a>
                        </div>

                        <!-- Admin Only Section (Penggajian)-->
                        <div class="pt-4">
                            <p class="sidebar-text px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Penggajian</p>
                            <!-- Absen Management -->
                            <a href="{{ route('absen.index') }}"
                                class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('absen.index') ? 'active' : '' }}">
                                <i class="fas fa-calendar-alt w-5 text-center"></i>
                                <span class="sidebar-text ml-3">Data Absen</span>
                            </a>

                            <a href="{{ route('slip.view') }}"
                                class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('slip.view') ? 'active' : '' }}">
                                <i class="fas fa-money-bill-wave w-5 text-center"></i>
                                <span class="sidebar-text ml-3">Gaji</span>
                            </a>

                            <a href="{{ route('slip.riwayat') }}"
                                class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('slip.riwayat') ? 'active' : '' }}">
                                <i class="fas fa-file-invoice-dollar w-5 text-center"></i>
                                <span class="sidebar-text ml-3">Riwayat Gaji All Staff</span>
                            </a>

                        </div>
                    @endif

                    {{-- Section Jadwal Off --}}
                    <div class="pt-4">
                        <p class="sidebar-text px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Jadwal Off Karyawan</p>

                        <a href="{{ route('jadwaloff.index') }}"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->is('jadwaloff.index') ? 'active' : '' }}">
                            <i class="fas fa-calendar-alt w-5 text-center"></i>
                            <span class="sidebar-text ml-3">Data Jadwal Off</span>
                        </a>
                    </div>


                    @if (auth()->user()->role === 'kepala')
                        <!-- Kepala Cabang Section -->
                        <div class="pt-4">
                            <p class="sidebar-text px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Kepala Cabang</p>

                            <a href="{{ route('kronologi.view') }}"
                                class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('kronologi.view') ? 'active' : '' }}">
                                <i class="fas fa-clock w-5 text-center"></i>
                                <span class="sidebar-text ml-3">Pengajuan Denda</span>
                            </a>

                            <a href="{{ route('pengajuanizin.view') }}"
                                class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('pengajuanizin.view') ? 'active' : '' }}">
                                <i class="fas fa-calendar-check w-5 text-center"></i>
                                <span class="sidebar-text ml-3">Pengajuan Izin</span>
                            </a>
                        </div>
                    @endif
                @endauth

                <!-- Personal Section -->
                <div class="pt-4">
                    <p class="sidebar-text px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                        Personal</p>

                    <a href="{{ route('absen.riwayat') }}"
                        class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('absen.riwayat') ? 'active' : '' }}">
                        <i class="fas fa-receipt w-5 text-center"></i>
                        <span class="sidebar-text ml-3">Riwayat Absen</span>
                    </a>

                    <a href="{{ route('slip.karyawan.riwayat') }}"
                        class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('slip.karyawan.riwayat') ? 'active' : '' }}">
                        <i class="fas fa-receipt w-5 text-center"></i>
                        <span class="sidebar-text ml-3">Riwayat Gaji</span>
                    </a>

                    <a href="{{ route('pengajuanizin.addView') }}"
                        class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('pengajuanizin.addView') ? 'active' : '' }}">
                        <i class="fas fa-plus-circle w-5 text-center"></i>
                        <span class="sidebar-text ml-3">Ajukan Izin</span>
                    </a>

                    <a href="{{ route('pengajuandispensasi.addView') }}"
                        class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('pengajuandispensasi.addView') ? 'active' : '' }}">
                        <i class="fas fa-hourglass-half w-5 text-center"></i>
                        <span class="sidebar-text ml-3">Ajukan Dispensasi</span>
                    </a>

                    <a href="{{ route('kronologi.addView') }}"
                        class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('kronologi.addView') ? 'active' : '' }}">
                        <i class="fas fa-plus-square w-5 text-center"></i>
                        <span class="sidebar-text ml-3">Ajukan Denda</span>
                    </a>

                    <a href="{{ route('pinjaman.addView') }}"
                        class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('pinjaman.addView') ? 'active' : '' }}">
                        <i class="fas fa-hand-holding-usd w-5 text-center"></i>
                        <span class="sidebar-text ml-3">Ajukan Pinjaman</span>
                    </a>

                </div>


                <div class="pt-4">
                    <p class="sidebar-text px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                        Riwayat</p>


                    <a href="{{ route('pengajuanizin.riwayat') }}"
                        class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('pengajuanizin.riwayat') ? 'active' : '' }}">
                        <i class="fas fa-history w-5 text-center"></i>
                        <span class="sidebar-text ml-3">Riwayat Izin</span>
                    </a>

                    <a href="{{ route('pengajuandispensasi.riwayat') }}"
                        class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('pengajuandispensasi.riwayat') ? 'active' : '' }}">
                        <i class="fas fa-archive w-5 text-center"></i>
                        <span class="sidebar-text ml-3">Riwayat Dispensasi</span>
                    </a>

                    <a href="{{ route('kronologi.riwayat') }}"
                        class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('kronologi.riwayat') ? 'active' : '' }}">
                        <i class="fas fa-file-alt w-5 text-center"></i>
                        <span class="sidebar-text ml-3">Riwayat Denda</span>
                    </a>

                    <a href="{{ route('pinjaman.riwayat') }}"
                        class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('pinjaman.riwayat') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice w-5 text-center"></i>
                        <span class="sidebar-text ml-3">Riwayat Pinjaman</span>
                    </a>

                </div>

                <div class="pt-4">
                    <p class="sidebar-text px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                        General</p>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="sidebar-item w-full flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-red-500/20 hover:text-red-400">
                            <i class="fas fa-sign-out-alt w-5 text-center"></i>
                            <span class="sidebar-text ml-3">Logout</span>
                        </button>
                    </form>
                </div>
            </nav>

            <!-- Sidebar Toggle Button -->
            <div class="p-4 border-t border-gray-700/50">
                <button id="sidebarToggle"
                    class="sidebar-item w-full flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700/30">
                    <i class="fas fa-chevron-left w-5 text-center transition-transform duration-300"
                        id="toggleIcon"></i>
                    <span class="sidebar-text ml-3">Collapse</span>
                </button>
            </div>
        </aside>

        <!-- Mobile Sidebar Overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="glass-card border-b border-gray-700/50 px-6 py-4">
                <div class="flex items-center justify-between">
                    <!-- Mobile Menu Button -->
                    <button id="mobileMenuBtn" class="lg:hidden text-white hover:text-yellow-400 transition-colors">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <!-- Page Title -->
                    <div class="flex-1 lg:flex-none">
                        <h1 class="text-2xl font-bold text-white">@yield('page-title', 'Dashboard')</h1>
                        <p class="text-gray-400 text-sm">@yield('page-description', 'Welcome to Mahkota Gallery Dashboard')</p>
                    </div>

                    <!-- User Menu -->
                    <div class="relative">
                        <button id="userMenuBtn"
                            class="flex items-center space-x-3 text-white hover:text-yellow-400 transition-colors">
                            <div
                                class="w-10 h-10 rounded-full bg-gradient-to-br from-yellow-400 to-amber-500 flex items-center justify-center">
                                <i class="fas fa-user text-black"></i>
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="font-medium">{{ Auth::user()->staff->nama ?? 'User' }}</p>
                                <p class="text-sm text-gray-400">{{ Auth::user()->email }}</p>
                            </div>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar -->
    <div id="mobileSidebar" class="mobile-menu fixed inset-y-0 left-0 z-50 w-64 sidebar lg:hidden">
        <!-- Same sidebar content as desktop -->
        <div class="p-6 border-b border-gray-700/50">
            <div class="flex items-center space-x-3">
                <div
                    class="w-12 h-12 rounded-full bg-gradient-to-br from-gray-800/50 to-black/80 flex items-center justify-center border border-yellow-400/20 logo-glow">
                    <span
                        class="text-xl font-bold bg-gradient-to-br from-yellow-300 to-yellow-500 bg-clip-text text-transparent">MG</span>
                </div>
                <div>
                    <h1 class="text-white font-bold text-lg">Mahkota Gallery</h1>
                    <p class="text-yellow-400 text-xs tracking-wider">WATCHES</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <!-- Same navigation as desktop -->
            <a href="{{ route('dashboard') }}"
                class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg">
                <i class="fas fa-home w-5 text-center"></i>
                <span class="ml-3">Dashboard</span>
            </a>
            <a href="{{ route('staff.view') }}"
                class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('staff.*') ? 'active' : '' }}">
                <i class="fas fa-users w-5 text-center"></i>
                <span class="ml-3">Data Staff</span>
            </a>

            @auth
                @if (auth()->user()->role === 'admin')
                    <!-- Admin Only Section (Master Data)-->
                    <div class="pt-4">
                        <p class="sidebar-text px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Master Data</p>

                        <a href="{{ route('cabang.view') }}"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('cabang.*') ? 'active' : '' }}">
                            <i class="fas fa-building w-5 text-center"></i>
                            <span class="sidebar-text ml-3">Data Cabang</span>
                        </a>

                        <!-- Staff Management -->
                        <a href="{{ route('staff.view') }}"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('staff.*') ? 'active' : '' }}">
                            <i class="fas fa-users w-5 text-center"></i>
                            <span class="sidebar-text ml-3">Data Staff</span>
                        </a>

                        <a href="{{ route('jabatan.view') }}"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('jabatan.*') ? 'active' : '' }}">
                            <i class="fas fa-briefcase w-5 text-center"></i>
                            <span class="sidebar-text ml-3">Data Jabatan</span>
                        </a>
                    </div>
                    <!-- Admin Only Section (Pengajuan Karyawan)-->
                    <div class="pt-4">
                        <p class="sidebar-text px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Pengajuan Karyawan</p>
                        <a href="{{ route('kronologi.view') }}"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('kronologi.view') ? 'active' : '' }}">
                            <i class="fas fa-clock w-5 text-center"></i>
                            <span class="sidebar-text ml-3">Pengajuan Denda</span>
                        </a>

                        <a href="{{ route('pinjaman.view') }}"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('pinjaman.view') ? 'active' : '' }}">
                            <i class="fas fa-hand-holding-usd w-5 text-center"></i>
                            <span class="sidebar-text ml-3">Pengajuan Pinjaman</span>
                        </a>

                        <a href="{{ route('pengajuanizin.view') }}"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('pengajuanizin.view') ? 'active' : '' }}">
                            <i class="fas fa-calendar-check w-5 text-center"></i>
                            <span class="sidebar-text ml-3">Pengajuan Izin</span>
                        </a>

                        <a href="{{ route('pengajuandispensasi.view') }}"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('pengajuandispensasi.view') ? 'active' : '' }}">
                            <i class="fas fa-stopwatch w-5 text-center"></i>
                            <span class="sidebar-text ml-3">Pengajuan Dispensasi</span>
                        </a>
                    </div>

                    <!-- Admin Only Section (Penggajian)-->
                    <div class="pt-4">
                        <p class="sidebar-text px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Penggajian</p>
                        <!-- Absen Management -->
                        <a href="{{ route('absen.index') }}"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('absen.index') ? 'active' : '' }}">
                            <i class="fas fa-calendar-alt w-5 text-center"></i>
                            <span class="sidebar-text ml-3">Data Absen</span>
                        </a>

                        <a href="{{ route('slip.view') }}"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('slip.view') ? 'active' : '' }}">
                            <i class="fas fa-money-bill-wave w-5 text-center"></i>
                            <span class="sidebar-text ml-3">Gaji</span>
                        </a>

                        <a href="{{ route('slip.riwayat') }}"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('slip.riwayat') ? 'active' : '' }}">
                            <i class="fas fa-file-invoice-dollar w-5 text-center"></i>
                            <span class="sidebar-text ml-3">Riwayat Gaji All Staff</span>
                        </a>

                    </div>
                @endif

                @if (auth()->user()->role === 'kepala')
                    <!-- Kepala Cabang Section -->
                    <div class="pt-4">
                        <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Kepala Cabang</p>

                        <a href="{{ route('kronologi.view') }}"
                            class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('kronologi.view') ? 'active' : '' }}">
                            <i class="fas fa-clock w-5 text-center"></i>
                            <span class="ml-3">Pengajuan Denda</span>
                        </a>
                    </div>
                @endif
            @endauth

            <!-- Personal Section -->
            <div class="pt-4">

                <a href="{{ route('absen.riwayat') }}"
                    class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('absen.riwayat') ? 'active' : '' }}">
                    <i class="fas fa-receipt w-5 text-center"></i>
                    <span class="ml-3">Riwayat Absen</span>
                </a>

                <a href="{{ route('slip.karyawan.riwayat') }}"
                    class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('slip.karyawan.riwayat') ? 'active' : '' }}">
                    <i class="fas fa-receipt w-5 text-center"></i>
                    <span class="ml-3">Riwayat Gaji</span>
                </a>

                <a href="{{ route('pengajuanizin.addView') }}"
                    class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('pengajuanizin.addView') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle w-5 text-center"></i>
                    <span class="ml-3">Ajukan Izin</span>
                </a>

                <a href="{{ route('kronologi.addView') }}"
                    class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('kronologi.addView') ? 'active' : '' }}">
                    <i class="fas fa-plus-square w-5 text-center"></i>
                    <span class="ml-3">Ajukan Denda</span>
                </a>

                <a href="{{ route('pinjaman.addView') }}"
                    class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('pinjaman.addView') ? 'active' : '' }}">
                    <i class="fas fa-hand-holding-usd w-5 text-center"></i>
                    <span class="ml-3">Ajukan Pinjaman</span>
                </a>

                <a href="{{ route('pengajuanizin.riwayat') }}"
                    class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('pengajuanizin.riwayat') ? 'active' : '' }}">
                    <i class="fas fa-history w-5 text-center"></i>
                    <span class="ml-3">Riwayat Izin</span>
                </a>

                <a href="{{ route('kronologi.riwayat') }}"
                    class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('kronologi.riwayat') ? 'active' : '' }}">
                    <i class="fas fa-file-alt w-5 text-center"></i>
                    <span class="ml-3">Riwayat Denda</span>
                </a>

                <a href="{{ route('pinjaman.riwayat') }}"
                    class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-lg {{ request()->routeIs('pinjaman.riwayat') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice w-5 text-center"></i>
                    <span class="ml-3">Riwayat Pinjaman</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="sidebar-item w-full flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-red-500/20 hover:text-red-400">
                        <i class="fas fa-sign-out-alt w-5 text-center"></i>
                        <span class="ml-3">Logout</span>
                    </button>
                </form>
            </div>
        </nav>
    </div>

    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const toggleIcon = document.getElementById('toggleIcon');
        const sidebarTexts = document.querySelectorAll('.sidebar-text');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');

            if (sidebar.classList.contains('collapsed')) {
                toggleIcon.style.transform = 'rotate(180deg)';
                sidebarTexts.forEach(text => text.style.display = 'none');
            } else {
                toggleIcon.style.transform = 'rotate(0deg)';
                sidebarTexts.forEach(text => text.style.display = 'block');
            }
        });

        // Mobile Menu
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        mobileMenuBtn.addEventListener('click', () => {
            mobileSidebar.classList.add('open');
            sidebarOverlay.classList.remove('hidden');
        });

        sidebarOverlay.addEventListener('click', () => {
            mobileSidebar.classList.remove('open');
            sidebarOverlay.classList.add('hidden');
        });

        // User Dropdown
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userDropdown = document.getElementById('userDropdown');

        userMenuBtn.addEventListener('click', () => {
            userDropdown.classList.toggle('hidden');
        });
    </script>
</body>

</html>
