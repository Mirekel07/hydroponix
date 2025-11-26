<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Hidrophonix - Tanam Mudah & Menyenangkan</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="bg-gray-50 text-gray-900 font-sans antialiased">

        <!-- Navigation (Fixed & Transparan/Blur) -->
        <nav class="fixed w-full z-50 top-0 start-0 border-b border-gray-200 bg-white/90 backdrop-blur-md">
            <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between mx-auto p-4">
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <img src="{{ asset("img/logo.svg") }}" class="h-8" alt="Hidrophonix Logo">
                    <span class="self-center text-2xl font-bold whitespace-nowrap text-gray-900">Hidrophonix</span>
                </a>

                <!-- Menu Kanan -->
                <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                    @if (Route::has('login'))
                        <div class="flex gap-3">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 text-center transition duration-300">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 font-medium rounded-lg text-sm px-4 py-2 text-center border border-gray-200 transition duration-300">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 text-center transition duration-300">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </nav>

        <main class="w-full">

            <!-- Hero Section (Dengan Background Image & Overlay) -->
            <section class="relative bg-green-900 pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
                <!-- Background Image -->
                <div class="absolute inset-0">
                    <img src="https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?q=80&w=2064&auto=format&fit=crop" alt="Hydroponics Background" class="w-full h-full object-cover opacity-30">
                    <!-- Gradient Overlay untuk keterbacaan teks -->
                    <div class="absolute inset-0 bg-gradient-to-b from-green-900/60 to-green-800/90"></div>
                </div>

                <div class="relative max-w-7xl mx-auto px-6 lg:px-8 text-center">
                    <h1 class="text-4xl lg:text-6xl font-extrabold text-white tracking-tight mb-6">
                        Bertanam Cerdas <br class="hidden lg:block"> Bersama <span class="text-green-400">Hidrophonix</span>
                    </h1>
                    <p class="mt-4 text-lg lg:text-xl text-green-100 max-w-2xl mx-auto leading-relaxed">
                        Ubah ruang kosong di rumah Anda menjadi kebun hijau yang produktif. Kami memandu Anda dari benih hingga panen dengan teknologi modern.
                    </p>
                    <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-green-500 text-white font-bold rounded-full shadow-lg hover:bg-green-400 hover:scale-105 transition transform duration-300">
                            Mulai Sekarang Gratis
                        </a>
                    </div>
                </div>

                <!-- Dekorasi Gelombang Bawah -->
                <div class="absolute bottom-0 w-full">
                    <svg class="w-full h-12 lg:h-24 text-gray-50 fill-current" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
                        <path fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                    </svg>
                </div>
            </section>

            <!-- Section "Apa Itu Hidroponik?" (2 Kolom) -->
            <section class="py-16 lg:py-24 bg-gray-50">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <!-- Kolom Gambar -->
                        <div class="relative">
                            <div class="absolute -inset-4 bg-green-200 rounded-xl blur-lg opacity-50"></div>
                            <img src="https://images.unsplash.com/photo-1550989460-0adf9ea622e2?q=80&w=1974&auto=format&fit=crop" alt="Hydroponic Farm" class="relative rounded-xl shadow-2xl w-full h-auto object-cover transform hover:scale-[1.02] transition duration-500">
                        </div>
                        <!-- Kolom Teks -->
                        <div>
                            <h2 class="text-green-600 font-semibold tracking-wide uppercase text-sm mb-2">Mengenal Metode</h2>
                            <h3 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">Apa Itu Hidroponik?</h3>
                            <p class="text-lg text-gray-600 leading-relaxed mb-6">
                                Hidroponik adalah revolusi dalam bercocok tanam. Tanpa tanah, tanpa kotoran, hanya air yang kaya nutrisi dan sinar matahari.
                            </p>
                            <ul class="space-y-4">
                                <li class="flex items-start">
                                    <div class="flex-shrink-0 h-6 w-6 rounded-full bg-green-100 flex items-center justify-center mt-1">
                                        <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span class="ml-3 text-gray-600">Hemat air hingga 90% dibanding pertanian konvensional.</span>
                                </li>
                                <li class="flex items-start">
                                    <div class="flex-shrink-0 h-6 w-6 rounded-full bg-green-100 flex items-center justify-center mt-1">
                                        <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span class="ml-3 text-gray-600">Pertumbuhan tanaman lebih cepat dan hasil lebih bersih.</span>
                                </li>
                                <li class="flex items-start">
                                    <div class="flex-shrink-0 h-6 w-6 rounded-full bg-green-100 flex items-center justify-center mt-1">
                                        <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span class="ml-3 text-gray-600">Cocok untuk lahan sempit atau perkotaan (Urban Farming).</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section Fitur (Grid 3) -->
            <section id="features" class="py-16 lg:py-24 bg-white">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="text-center max-w-2xl mx-auto mb-16">
                        <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">Kenapa Memilih Hidrophonix?</h2>
                        <p class="mt-4 text-lg text-gray-600">Platform belajar all-in-one untuk kesuksesan panen Anda.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Fitur 1 -->
                        <div class="bg-gray-50 p-8 rounded-2xl border border-gray-100 hover:shadow-xl transition duration-300 text-center group">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-green-600 transition duration-300">
                                <svg class="h-8 w-8 text-green-600 group-hover:text-white transition duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h.01M15 12h.01M10.5 16.5h3m-6.364 3.545-.955-.955a2.25 2.25 0 0 1 0-3.182l2.121-2.121a2.25 2.25 0 0 1 3.182 0l.955.955a2.25 2.25 0 0 1 0 3.182l-2.121 2.121a2.25 2.25 0 0 1-3.182 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-4.5-4.5H9.75M15.75 12H18m-4.5 4.5h.01M12.75 18v-2.25" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Panduan Misi</h3>
                            <p class="text-gray-600">Sistem misi langkah demi langkah memastikan Anda tidak pernah bingung harus melakukan apa hari ini.</p>
                        </div>

                        <!-- Fitur 2 -->
                        <div class="bg-gray-50 p-8 rounded-2xl border border-gray-100 hover:shadow-xl transition duration-300 text-center group">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-green-600 transition duration-300">
                                <svg class="h-8 w-8 text-green-600 group-hover:text-white transition duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">E-Learning</h3>
                            <p class="text-gray-600">Akses modul pembelajaran lengkap dan uji pengetahuan Anda lewat kuis interaktif.</p>
                        </div>

                        <!-- Fitur 3 -->
                        <div class="bg-gray-50 p-8 rounded-2xl border border-gray-100 hover:shadow-xl transition duration-300 text-center group">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-green-600 transition duration-300">
                                <svg class="h-8 w-8 text-green-600 group-hover:text-white transition duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-6.75c-.621 0-1.125.504-1.125 1.125V18.75m9 0h-9" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 6.375a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm10.5 0a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-3.375 0a1.125 1.125 0 0 1-2.25 0c0-.621.504-1.125 1.125-1.125s1.125.504 1.125 1.125Z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Gamifikasi</h3>
                            <p class="text-gray-600">Naik level, kumpulkan poin, dan berkompetisi di papan peringkat global.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section Tanaman -->
            <section class="py-16 lg:py-24 bg-gray-50">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <h2 class="text-3xl font-bold text-center text-gray-900 mb-4">Pilihan Tanaman Populer</h2>
                    <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">Kami menyediakan panduan lengkap untuk berbagai jenis sayuran populer.</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach($plants as $plant)
                            <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden group">
                                <div class="relative h-48 overflow-hidden">
                                    <img src="{{ asset('storage/' . $plant->image_url) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" alt="{{ $plant->name }}">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end justify-center pb-4">
                                        <span class="text-white font-medium">Mulai Tanam</span>
                                    </div>
                                </div>
                                <div class="p-5 text-center">
                                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $plant->name }}</h3>
                                    <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $plant->description }}</p>
                                    <a href="{{ route('login') }}" class="inline-block w-full py-2 bg-green-50 text-green-700 font-semibold rounded-lg hover:bg-green-100 transition duration-200">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- Section Modul Preview -->
            <section class="py-16 lg:py-24 bg-white">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row justify-between items-end mb-10">
                        <div class="max-w-xl">
                            <h2 class="text-3xl font-bold text-gray-900">Modul Pembelajaran</h2>
                            <p class="mt-2 text-gray-600">Tingkatkan skill berkebun Anda dengan materi terstruktur.</p>
                        </div>
                        <a href="{{ route('login') }}" class="hidden md:inline-flex items-center font-semibold text-green-600 hover:text-green-700">
                            Lihat Semua Modul <span aria-hidden="true">→</span>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach($modules as $module)
                            <!-- [LOGIKA TOMBOL CERDAS] -->
                            <!-- Level 1: Bisa dibaca tamu. Level > 1: Harus login. -->
                            @php
                                $link = ($module->level_required == 1) ? route('modules.show', $module->slug) : route('login');
                                $text = ($module->level_required == 1) ? 'Mulai Baca' : 'Login untuk Akses';
                                $buttonClass = ($module->level_required == 1) ? 'text-green-600 hover:underline' : 'text-gray-400 hover:text-gray-600';
                                $iconLock = ($module->level_required > 1) ? '🔒' : '';
                            @endphp

                            <div class="bg-white p-6 rounded-2xl border border-gray-200 hover:border-green-500 transition duration-300 group cursor-pointer relative overflow-hidden">
                                <div class="absolute top-0 right-0 bg-green-600 text-white text-xs font-bold px-3 py-1 rounded-bl-lg">
                                    Lv. {{ $module->level_required }}
                                </div>
                                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center mb-4 text-blue-600 group-hover:bg-green-600 group-hover:text-white transition duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-green-600 transition">{{ $module->title }}</h3>
                                <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ strip_tags($module->description) }}</p>

                                <a href="{{ $link }}" class="text-sm font-medium {{ $buttonClass }}">
                                    {{ $text }} {{ $iconLock }}
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 text-center md:hidden">
                        <a href="{{ route('login') }}" class="inline-flex items-center font-semibold text-green-600 hover:text-green-700">
                            Lihat Semua Modul <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
            </section>

            <!-- CTA Akhir -->
            <section class="bg-green-900 py-16 lg:py-20 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/leaf.png')]"></div>
                <div class="relative max-w-7xl mx-auto px-6 lg:px-8 text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        Siap Panen Sendiri di Rumah?
                    </h2>
                    <p class="mx-auto mt-4 max-w-xl text-lg leading-8 text-green-100">
                        Bergabunglah dengan komunitas Hidrophonix sekarang dan rasakan kepuasan memakan hasil tanaman sendiri.
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a href="{{ route('register') }}" class="rounded-full bg-white px-8 py-3.5 text-sm font-semibold text-green-900 shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white transition duration-300">
                            Daftar Gratis
                        </a>
                    </div>
                </div>
            </section>

        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12 border-t border-gray-800">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <img src="{{ asset("img/logo.svg") }}" class="h-8 brightness-0 invert" alt="Logo">
                        <span class="text-xl font-bold">Hidrophonix</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Platform edukasi dan manajemen hidroponik untuk membantu Anda bertani di rumah dengan mudah dan menyenangkan.
                    </p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Masuk</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition">Daftar</a></li>
                        <li><a href="#" class="hover:text-white transition">Tentang Kami</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Hubungi Kami</h4>
                    <p class="text-gray-400 text-sm">support@hidrophonix.com</p>
                    <p class="text-gray-400 text-sm">Indonesia</p>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-6 lg:px-8 mt-12 pt-8 border-t border-gray-800 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} Hidrophonix. All rights reserved.
            </div>
        </footer>

    </body>
</html>
