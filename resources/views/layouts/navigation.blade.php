<nav x-data="{ open: false, openUserView: false }" class="bg-white border-b border-gray-100 fixed top-0 w-full z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::check() ? route('dashboard') : url('/') }}" class="flex items-center gap-2">
                        <img src="{{ asset("img/logo.svg") }}" class="block h-9 w-auto" alt="Hidrophonix Logo" />
                        <!-- [PERUBAHAN] Menambahkan teks Hidrophonix di sebelah logo -->
                        <span class="font-bold text-xl text-gray-800 tracking-tight">Hidrophonix</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @php
                        $activeClasses = 'inline-flex items-center px-1 pt-1 border-b-2 border-green-600 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-green-700 transition duration-150 ease-in-out';
                        $inactiveClasses = 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';

                        $subActiveClasses = 'inline-flex items-center px-1 pt-1 border-b-2 border-green-500 text-sm font-medium text-green-600';
                        $subInactiveClasses = 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700';
                    @endphp

                    <!-- Cek Auth Dulu -->
                    @auth
                        @if (Auth::user()->isAdmin())
                            <!-- === TAMPILAN UNTUK ADMIN === -->
                            <a href="{{ route('admin.adminDashboard') }}" class="{{ request()->routeIs('admin.adminDashboard') ? $activeClasses : $inactiveClasses }}">
                                Admin Panel
                            </a>
                            <a href="{{ route('admin.modules.index') }}" class="{{ request()->routeIs(['admin.modules.index', 'admin.modules.create', 'admin.modules.edit']) ? $activeClasses : $inactiveClasses }}">
                                Kelola Modul
                            </a>
                            <a href="{{ route('admin.plants.index') }}" class="{{ request()->routeIs(['admin.plants.*']) ? $activeClasses : $inactiveClasses }}">
                                Kelola Tanaman
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.index') ? $activeClasses : $inactiveClasses }}">
                                Kelola User
                            </a>

                            <!-- Tombol Toggle "Lihat Situs" -->
                            <button
                                @click="openUserView = !openUserView"
                                :class="openUserView ? '{{ $activeClasses }}' : '{{ $inactiveClasses }}'"
                                class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none">
                                <span>Lihat Situs (User)</span>
                                <svg class="fill-current h-4 w-4 ms-1 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" :class="{'rotate-180': openUserView}">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                        @else
                            <!-- === TAMPILAN UNTUK USER BIASA === -->
                            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? $activeClasses : $inactiveClasses }}">
                                {{ __('Dashboard') }}
                            </a>
                            <a href="{{ route('plants.index') }}" class="{{ request()->routeIs(['plants.index', 'plants.show']) ? $activeClasses : $inactiveClasses }}">
                                {{ __('Plants') }}
                            </a>
                            <a href="{{ route('user-plants.index') }}" class="{{ request()->routeIs('user-plants.index') ? $activeClasses : $inactiveClasses }}">
                                {{ __('My Plant') }}
                            </a>
                            <a href="{{ route('modules.index') }}" class="{{ request()->routeIs(['modules.index', 'modules.show', 'quiz.result', 'quiz.show']) ? $activeClasses : $inactiveClasses }}">
                                {{ __('Modul') }}
                            </a>
                            <a href="{{ route('calendar.index') }}" class="{{ request()->routeIs('calendar.index') ? $activeClasses : $inactiveClasses }}">
                                {{ __('Calendar') }}
                            </a>
                        @endif
                    @else
                        <!-- === TAMPILAN UNTUK TAMU (GUEST) === -->
                        <!-- [PERUBAHAN] Tidak ada link navigasi lain selain logo -->
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown & Mobile Menu Button -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <!-- Dropdown Profil untuk User Login -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <img class="h-8 w-8 rounded-full object-cover me-2" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=D1FAE5&color=065F46&size=32" alt="{{ Auth::user()->name }}">
                                <div class="text-left">
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-gray-400">
                                        @if(Auth::user()->isAdmin())
                                            <span class="font-semibold text-green-600">Admin</span>
                                        @else
                                            Level {{ Auth::user()->level }}
                                        @endif
                                    </div>
                                </div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <!-- Tombol Login/Register untuk Tamu -->
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-green-600 font-medium">Log in</a>
                        <a href="{{ route('register') }}" class="text-sm bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">Register</a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- [BARU] Sub-Navigasi (Anak Navigation) untuk Admin melihat view User -->
    @auth
        <div x-show="openUserView && {{ Auth::user()->isAdmin() ? 'true' : 'false' }}"
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="opacity-0 transform -translate-y-3"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-3"
             style="display: none;"
             class="bg-gray-50 border-b border-gray-200 shadow-inner pt-16"> <!-- Added pt-16 due to fixed nav -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-start h-12 space-x-8">
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? $subActiveClasses : $subInactiveClasses }} h-full">
                        {{ __('Dashboard') }}
                    </a>
                    <a href="{{ route('plants.index') }}" class="{{ request()->routeIs(['plants.index', 'plants.show']) ? $subActiveClasses : $subInactiveClasses }} h-full">
                        {{ __('Plants') }}
                    </a>
                    <a href="{{ route('user-plants.index') }}" class="{{ request()->routeIs('user-plants.index') ? $subActiveClasses : $subInactiveClasses }} h-full">
                        {{ __('My Plant') }}
                    </a>
                    <a href="{{ route('modules.index') }}" class="{{ request()->routeIs(['modules.index', 'modules.show', 'quiz.result', 'quiz.show']) ? $subActiveClasses : $subInactiveClasses }} h-full">
                        {{ __('Modul') }}
                    </a>
                    <a href="{{ route('calendar.index') }}" class="{{ request()->routeIs('calendar.index') ? $subActiveClasses : $subInactiveClasses }} h-full">
                        {{ __('Calendar') }}
                    </a>
                </div>
            </div>
        </div>
    @endauth

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-b border-gray-200 fixed top-16 w-full z-40 overflow-y-auto max-h-[calc(100vh-4rem)]">
        <div class="pt-2 pb-3 space-y-1">
            @php
                $activeMobile = 'block w-full ps-3 pe-4 py-2 border-l-4 border-green-600 text-start text-base font-medium text-green-700 bg-green-50 focus:outline-none focus:text-green-800 focus:bg-green-100 focus:border-green-700 transition duration-150 ease-in-out';
                $inactiveMobile = 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out';
            @endphp

            @auth
                @if (Auth::user()->isAdmin())
                    <!-- Mobile Admin -->
                    <a href="{{ route('admin.adminDashboard') }}" class="{{ request()->routeIs('admin.adminDashboard') ? $activeMobile : $inactiveMobile }}">Admin Panel</a>
                    <a href="{{ route('admin.modules.index') }}" class="{{ request()->routeIs('admin.modules.*') ? $activeMobile : $inactiveMobile }}">Kelola Modul</a>
                    <a href="{{ route('admin.plants.index') }}" class="{{ request()->routeIs('admin.plants.*') ? $activeMobile : $inactiveMobile }}">Kelola Tanaman</a>
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.index') ? $activeMobile : $inactiveMobile }}">Kelola User</a>

                    <!-- Mobile Submenu "Lihat Situs" -->
                    <div x-data="{ openUserMenu: false }" class="border-t border-gray-200 pt-2 mt-2">
                        <button @click="openUserMenu = !openUserMenu" class="{{ $inactiveMobile }} w-full flex justify-between items-center">
                            Lihat Situs (User)
                            <svg class="h-5 w-5 transition-transform" :class="{'rotate-180': openUserMenu}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="openUserMenu" x-transition class="ps-4 border-l-4 border-gray-200 ml-4 mt-1 space-y-1">
                            <a href="{{ route('dashboard') }}" class="{{ $inactiveMobile }}">Dashboard</a>
                            <a href="{{ route('plants.index') }}" class="{{ $inactiveMobile }}">Plants</a>
                            <a href="{{ route('user-plants.index') }}" class="{{ $inactiveMobile }}">My Plant</a>
                            <a href="{{ route('modules.index') }}" class="{{ $inactiveMobile }}">Modul</a>
                            <a href="{{ route('calendar.index') }}" class="{{ $inactiveMobile }}">Calendar</a>
                        </div>
                    </div>
                @else
                    <!-- Mobile User Biasa -->
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? $activeMobile : $inactiveMobile }}">Dashboard</a>
                    <a href="{{ route('plants.index') }}" class="{{ request()->routeIs(['plants.index', 'plants.show']) ? $activeMobile : $inactiveMobile }}">Plants</a>
                    <a href="{{ route('user-plants.index') }}" class="{{ request()->routeIs('user-plants.index') ? $activeMobile : $inactiveMobile }}">My Plant</a>
                    <a href="{{ route('modules.index') }}" class="{{ request()->routeIs(['modules.index', 'modules.show']) ? $activeMobile : $inactiveMobile }}">Modul</a>
                    <a href="{{ route('calendar.index') }}" class="{{ request()->routeIs('calendar.index') ? $activeMobile : $inactiveMobile }}">Calendar</a>
                @endif
            @else
                <!-- Mobile Tamu -->
                <!-- [PERUBAHAN] Hanya Login & Register di menu mobile untuk tamu -->
                <a href="{{ route('login') }}" class="{{ $inactiveMobile }}">Log in</a>
                <a href="{{ route('register') }}" class="{{ $inactiveMobile }}">Register</a>
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">
                        {{ Auth::user()->name }}
                        @if(Auth::user()->isAdmin())
                            <span class="font-semibold text-green-600">(Admin)</span>
                        @else
                            (Level {{ Auth::user()->level }})
                        @endif
                    </div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="{{ $inactiveMobile }}">
                        {{ __('Profile') }}
                    </a>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" class="{{ $inactiveMobile }}"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
