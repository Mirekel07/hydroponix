<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📚 {{ __('Modul Pembelajaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Kartu Hero Sesuai Tema -->
            <div class="bg-green-600 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-white flex items-center space-x-4">
                    <!-- Ikon Buku -->
                    <svg class="h-12 w-12 text-green-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25" />
                    </svg>
                    <div>
                        <h3 class="text-2xl font-semibold">Katalog Modul</h3>
                        <p class="text-green-100 mt-1">
                            Level Anda saat ini: <span class="font-bold">Level {{ Auth::user()->level }}</span>. Terus belajar untuk membuka modul baru!
                        </p>
                    </div>
                </div>
            </div>

            <!-- Notifikasi -->
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            @if (session('info'))
                <div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('info') }}</span>
                </div>
            @endif

            <!-- Container Utama dengan Alpine.js untuk Filter & Search -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" x-data="{ selectedLevel: 'all', searchQuery: '' }">
                <div class="p-6 text-gray-900">

                    @php
                        $userLevel = Auth::user()->level;
                        // Ambil level-level yang unik dari koleksi modul untuk membuat tombol filter
                        $availableLevels = $modules->pluck('level_required')->unique()->sort();
                    @endphp

                    <!-- [BARU] Toolbar Filter & Search -->
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6 pb-4 border-b border-gray-100">

                        <!-- Bagian Kiri: Filter Tombol -->
                        <div class="flex flex-wrap gap-2 items-center w-full md:w-auto">
                            <span class="text-sm font-medium text-gray-500 mr-2">Filter Level:</span>

                            <!-- Tombol Semua -->
                            <button @click="selectedLevel = 'all'"
                                    :class="selectedLevel === 'all' ? 'bg-green-600 text-white border-green-600' : 'bg-white text-gray-600 border-gray-300 hover:border-green-500 hover:text-green-600'"
                                    class="px-4 py-1.5 rounded-full text-sm font-semibold border transition-all duration-200 shadow-sm">
                                Semua
                            </button>

                            <!-- Tombol Level Dinamis -->
                            @foreach($availableLevels as $level)
                                <button @click="selectedLevel = {{ $level }}"
                                        :class="selectedLevel === {{ $level }} ? 'bg-green-600 text-white border-green-600' : 'bg-white text-gray-600 border-gray-300 hover:border-green-500 hover:text-green-600'"
                                        class="px-4 py-1.5 rounded-full text-sm font-semibold border transition-all duration-200 shadow-sm">
                                    Level {{ $level }}
                                </button>
                            @endforeach
                        </div>

                        <!-- Bagian Kanan: Search Bar -->
                        <div class="relative w-full md:w-64">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="text"
                                   x-model="searchQuery"
                                   class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-green-500 focus:border-green-500"
                                   placeholder="Cari judul modul...">
                        </div>
                    </div>

                    <!-- Grid Modul -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @forelse ($modules as $module)
                            <!-- Wrapper Kartu dengan Logika Filter Gabungan (Level + Search) -->
                            <div x-show="(selectedLevel === 'all' || selectedLevel === {{ $module->level_required }}) && '{{ strtolower($module->title) }}'.includes(searchQuery.toLowerCase())"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform scale-95"
                                 x-transition:enter-end="opacity-100 transform scale-100"
                                 class="flex flex-col h-full">

                                @if ($userLevel >= $module->level_required)
                                    <!-- 1. TAMPILAN MODUL TERBUKA -->
                                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm flex flex-col justify-between transition-all hover:shadow-md h-full">
                                        <div class="p-5">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-xs font-semibold bg-green-100 text-green-800 px-3 py-1 rounded-full">
                                                    Lv. {{ $module->level_required }}
                                                </span>
                                                <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                            </div>
                                            <h4 class="font-bold text-lg text-gray-900">{{ $module->title }}</h4>
                                            <p class="text-sm text-gray-600 mt-1 line-clamp-3">
                                                {{ Str::limit($module->description, 100) }}
                                            </p>
                                        </div>
                                        <div class="px-5 pb-5 mt-auto">
                                            <a href="{{ route('modules.show', $module->slug) }}" class="inline-block w-full text-center px-4 py-2 bg-green-600 text-white rounded-md text-sm font-semibold hover:bg-green-700 shadow-sm transition-colors">
                                                Mulai Baca
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <!-- 2. TAMPILAN MODUL TERKUNCI -->
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg shadow-sm flex flex-col justify-between opacity-80 h-full">
                                        <div class="p-5">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-xs font-semibold bg-gray-200 text-gray-700 px-3 py-1 rounded-full">
                                                    Lv. {{ $module->level_required }}
                                                </span>
                                                <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 0 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                                </svg>
                                            </div>
                                            <h4 class="font-bold text-lg text-gray-500">{{ $module->title }}</h4>
                                            <p class="text-sm text-gray-500 mt-1">
                                                Selesaikan kuis lain untuk mencapai level {{ $module->level_required }} dan membuka modul ini.
                                            </p>
                                        </div>
                                        <div class="px-5 pb-5 mt-auto">
                                            <span class="inline-block w-full text-center px-4 py-2 bg-gray-200 text-gray-400 rounded-md text-sm font-medium cursor-not-allowed border border-gray-300">
                                                🔒 Terkunci
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-gray-500 col-span-3 text-center py-10">Belum ada modul yang tersedia.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
