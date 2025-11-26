<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Katalog Tanaman') }}
        </h2>
    </x-slot>

    <!--
      x-data scope untuk Search & Modal
    -->
    <div x-data="{
            search: '',
            showModal: false,
            targetPlantName: '',
            targetActionUrl: ''
         }">

        <!-- HERO SECTION / HEADING CARD (Layout Baru: Side-by-Side) -->
        <div class="max-w-7xl mx-auto mt-14 px-4 sm:px-6 lg:px-8 pt-8">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-10 border border-gray-100 relative">
                <!-- Dekorasi Pattern Halus -->
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-green-50 rounded-full opacity-50 blur-3xl pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-64 h-64 bg-blue-50 rounded-full opacity-50 blur-3xl pointer-events-none"></div>

                <div class="relative z-10 px-8 py-10">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                        <!-- Bagian Teks (Kiri) -->
                        <div class="md:w-1/2 text-left">
                            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-3 tracking-tight">
                                Mulai Kebun <span class="text-green-600">Hidroponikmu</span>
                            </h1>
                            <p class="text-gray-500 text-lg leading-relaxed">
                                Temukan tanaman favorit, ikuti panduan misi, dan nikmati hasil panen segar langsung dari rumah Anda.
                            </p>
                        </div>

                        <!-- Bagian Search Bar (Kanan) -->
                        <div class="md:w-1/2 w-full max-w-md">
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-green-600 transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text"
                                       x-model="search"
                                       class="block w-full pl-12 pr-4 py-3.5 border border-gray-200 rounded-xl leading-5 bg-gray-50 text-gray-900 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-transparent sm:text-sm transition-all duration-300 shadow-sm hover:shadow-md"
                                       placeholder="Cari tanaman (misal: Bayam)...">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="pb-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Notifikasi -->
                @if (session('error'))
                    <div class="mb-8 bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm flex items-start" role="alert">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-bold text-red-700">Oops!</p>
                            <p class="text-sm text-red-600">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <!-- BAGIAN TANAMAN AKTIF (Tetap Tampil di Atas) -->
                @if ($activePlants->isNotEmpty())
                    <div class="mb-12">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold text-gray-800 flex items-center">
                                <span class="bg-green-100 text-green-700 p-2 rounded-lg mr-3 shadow-sm">🌿</span>
                                Sedang Anda Tanam
                            </h3>
                            <a href="{{ route('user-plants.index') }}" class="text-sm font-medium text-green-600 hover:text-green-800 hover:underline">Lihat Detail &rarr;</a>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            @foreach($activePlants as $activePlant)
                                <div class="bg-white border border-green-100 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col sm:flex-row group">
                                    <div class="sm:w-48 h-48 sm:h-auto relative flex-shrink-0">
                                        <img src="{{ asset('storage/' . $activePlant->plant->image_url) }}" alt="{{ $activePlant->plant->name }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                                        <div class="absolute top-3 left-3">
                                            <span class="bg-white/90 backdrop-blur text-green-700 text-xs font-bold px-2.5 py-1 rounded-md shadow-sm flex items-center gap-1">
                                                <span class="relative flex h-2 w-2">
                                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                                </span>
                                                Aktif
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-6 flex flex-col justify-center flex-1">
                                        <h2 class="text-2xl font-bold text-gray-800 group-hover:text-green-700 transition-colors">{{ $activePlant->plant->name }}</h2>
                                        <div class="mt-3 space-y-2 mb-4">
                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                                                Misi: <span class="font-semibold ml-1 text-gray-800">{{ $activePlant->currentMission->title }}</span>
                                            </div>
                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                Umur: <span class="font-semibold ml-1 text-gray-800">{{ $activePlant->plant_age }} hari</span>
                                            </div>
                                        </div>
                                        <a href="{{ route('user-plants.index') }}" class="mt-auto inline-flex justify-center items-center px-4 py-2.5 bg-green-600 text-white text-sm font-medium rounded-xl hover:bg-green-700 transition-all shadow-sm hover:shadow group-hover:translate-x-1">
                                            Lanjutkan Misi
                                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- BAGIAN KATALOG TANAMAN -->
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-800 flex items-center">
                        <span class="bg-blue-100 text-blue-700 p-2 rounded-lg mr-3 shadow-sm">📚</span>
                        Katalog Tanaman
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse ($allPlants as $plant)
                        <!-- Kartu Tanaman dengan Filter Alpine.js -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full group overflow-hidden"
                             x-show="search === '' || '{{ strtolower($plant->name) }}'.includes(search.toLowerCase())"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100">

                            <div class="relative h-56 overflow-hidden">
                                <img src="{{ asset('storage/' . $plant->image_url) }}" alt="{{ $plant->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-60"></div>
                                @if($activePlantIds->contains($plant->id))
                                    <div class="absolute top-3 right-3">
                                        <span class="bg-green-500/90 backdrop-blur text-white text-xs font-bold px-2.5 py-1.5 rounded-lg shadow-sm border border-green-400 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                            Sedang Ditanam
                                        </span>
                                    </div>
                                @endif
                                <div class="absolute bottom-4 left-4 right-4 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                                    <h4 class="font-bold text-xl text-white shadow-black drop-shadow-md">{{ $plant->name }}</h4>
                                </div>
                            </div>

                            <div class="p-5 flex flex-col flex-grow bg-white relative z-10">
                                <p class="text-sm text-gray-600 mb-6 line-clamp-3 flex-grow leading-relaxed">
                                    {{ $plant->description }}
                                </p>

                                <div class="mt-auto pt-4 border-t border-gray-100">
                                    @if($activePlantIds->contains($plant->id))
                                        <button class="w-full py-2.5 px-4 bg-green-50 text-green-700 font-medium rounded-xl text-sm border border-green-200 cursor-default flex items-center justify-center gap-2">
                                            <span>Sudah di Kebun</span>
                                        </button>
                                    @else
                                        <!--
                                            Tombol ini memicu Modal Alpine.js
                                            Kita set nama tanaman dan URL aksi form
                                        -->
                                        <button @click="
                                            showModal = true;
                                            targetPlantName = '{{ $plant->name }}';
                                            targetActionUrl = '{{ route('user-plants.store', $plant->id) }}';
                                        "
                                        class="w-full py-2.5 px-4 bg-white text-green-700 font-bold rounded-xl text-sm border-2 border-green-600 hover:bg-green-600 hover:text-white transition-all duration-200 shadow-sm hover:shadow-md flex items-center justify-center gap-2 group-hover:bg-green-600 group-hover:text-white">
                                            <svg class="w-4 h-4 transition-transform group-hover:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                            Mulai Tanam
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-16 bg-white rounded-2xl border-2 border-dashed border-gray-200">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Belum ada tanaman</h3>
                            <p class="mt-1 text-gray-500">Admin belum menambahkan data tanaman.</p>
                        </div>
                    @endforelse

                    <!-- Pesan jika hasil pencarian kosong (Alpine) -->
                    <div x-show="search !== '' && $el.parentElement.querySelectorAll('[x-show^=\'search\']').length === 0" style="display: none;" class="col-span-full text-center py-16 bg-white rounded-2xl border-2 border-dashed border-gray-200">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Tidak ditemukan</h3>
                        <p class="mt-1 text-gray-500">Tidak ada tanaman yang cocok dengan pencarian Anda.</p>
                        <button @click="search = ''" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Reset Pencarian
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <!-- MODAL KONFIRMASI (Alpine.js) -->
        <div x-show="showModal"
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto"
             aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <!-- Backdrop -->
            <div x-show="showModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm transition-opacity"
                 @click="showModal = false"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <!-- Modal Panel -->
                <div x-show="showModal"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100">

                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-full bg-blue-50 sm:mx-0 sm:h-12 sm:w-12 mb-4 sm:mb-0">
                                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25" />
                                </svg>
                            </div>
                            <div class="text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <h3 class="text-xl font-bold leading-6 text-gray-900" id="modal-title">Rekomendasi Belajar 📖</h3>
                                <div class="mt-3">
                                    <p class="text-sm text-gray-600">
                                        Anda akan mulai menanam <span class="font-bold text-green-600 text-base" x-text="targetPlantName"></span>.
                                    </p>
                                    <div class="mt-4 p-4 bg-blue-50 rounded-xl border border-blue-100">
                                        <p class="text-xs text-blue-700 font-medium flex items-start text-left">
                                            <svg class="w-4 h-4 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                            Tips Pro: Membaca modul panduan terlebih dahulu dapat meningkatkan keberhasilan panen hingga 80%!
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-100">
                        <!-- Tombol Kanan: Lanjutkan (Submit Form) -->
                        <form :action="targetActionUrl" method="POST" class="inline-block w-full sm:w-auto sm:ml-3">
                            @csrf
                            <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-green-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-green-500 hover:shadow-md transition-all sm:w-auto">
                                Lanjutkan Menanam
                            </button>
                        </form>

                        <!-- Tombol Kiri: Ke Modul -->
                        <a href="{{ route('modules.index') }}" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-bold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 hover:text-green-700 transition-all sm:mt-0 sm:w-auto">
                            Baca Modul Dulu
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
