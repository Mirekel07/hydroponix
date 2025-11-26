<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🗓️ {{ __('Kalender Monitoring Tanaman') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="calendarApp(@js($events))">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Kolom Kiri: Kalender Custom -->
            <div class="lg:col-span-2">
                <!-- Header & Navigasi Bulan -->
                <div class="bg-green-600 overflow-hidden shadow-sm sm:rounded-t-lg p-6 text-white flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-semibold" x-text="monthNames[month] + ' ' + year"></h3>
                        <p class="text-green-100 mt-1 text-sm">
                            <span class="inline-block w-3 h-3 rounded-full bg-yellow-400 mr-1 border border-white/20"></span> Aktif
                            <span class="inline-block w-3 h-3 rounded-full bg-green-300 ml-2 mr-1 border border-white/20"></span> Mendatang
                        </p>
                    </div>
                    <div class="flex space-x-2">
                        <button @click="prevMonth()" class="p-2 hover:bg-green-700 rounded-full transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                        <button @click="nextMonth()" class="p-2 hover:bg-green-700 rounded-full transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                    </div>
                </div>

                <!-- Grid Kalender -->
                <div class="bg-white shadow-sm sm:rounded-b-lg p-6">
                    <!-- Nama Hari -->
                    <div class="grid grid-cols-7 mb-4 text-center">
                        <template x-for="day in dayNames">
                            <div class="text-gray-400 font-semibold text-sm py-2" x-text="day"></div>
                        </template>
                    </div>

                    <!-- Tanggal -->
                    <div class="grid grid-cols-7 gap-2">
                        <!-- Blank days (tanggal dari bulan sebelumnya) -->
                        <template x-for="blank in blankDays">
                            <div class="h-24 sm:h-28 border border-transparent"></div>
                        </template>

                        <!-- Tanggal Bulan Ini -->
                        <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                            <div @click="selectDate(date)"
                                 class="h-24 sm:h-28 border rounded-lg p-2 relative cursor-pointer transition hover:shadow-md flex flex-col justify-between"
                                 :class="{
                                    'border-green-500 ring-2 ring-green-200': isToday(date),
                                    'border-gray-100': !isToday(date),
                                    'bg-yellow-50 border-yellow-200': hasEvent(date) && getEvent(date).color === 'yellow',
                                    'bg-green-50 border-green-200': hasEvent(date) && getEvent(date).color === 'green'
                                 }">

                                <!-- Angka Tanggal -->
                                <span class="text-sm font-semibold"
                                      :class="{
                                        'text-green-700': isToday(date),
                                        'text-gray-700': !isToday(date),
                                        'text-yellow-800': hasEvent(date) && getEvent(date).color === 'yellow',
                                        'text-green-800': hasEvent(date) && getEvent(date).color === 'green'
                                      }" x-text="date"></span>

                                <!-- Indikator Event (Dot/Bar) -->
                                <template x-if="hasEvent(date)">
                                    <div class="mt-1">
                                        <div class="text-xs font-medium truncate px-1.5 py-0.5 rounded"
                                             :class="getEvent(date).color === 'yellow' ? 'bg-yellow-200 text-yellow-800' : 'bg-green-200 text-green-800'">
                                            <span x-text="getEvent(date).title_short"></span>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Sidebar Detail -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                    <div class="p-6 text-gray-900">
                        <h4 class="text-lg font-semibold mb-4" x-text="selectedEvent ? 'Detail Misi' : 'Misi Berjalan'"></h4>

                        <!-- Konten Dinamis Sidebar (Alpine.js) -->
                        <div x-show="selectedEvent">
                            <img :src="selectedEvent?.extendedProps?.image_url" class="w-full h-40 object-cover rounded-lg shadow-md mb-4" alt="Tanaman">
                            <h3 class="text-2xl font-bold text-green-600" x-text="selectedEvent?.extendedProps?.plant_name"></h3>

                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <span class="text-sm text-gray-500">Tahap <span x-text="selectedEvent?.extendedProps?.step_number"></span>:</span>
                                <h5 class="text-lg font-semibold" x-text="selectedEvent?.title"></h5>
                                <p class="text-sm text-gray-600 mt-1" x-text="selectedEvent?.extendedProps?.description"></p>
                            </div>

                            <div class="mt-4">
                                <p class="text-sm text-gray-500">Status:</p>
                                <div class="flex items-baseline space-x-2">
                                    <p class="text-xl font-bold"
                                       :class="selectedEvent?.color === 'yellow' ? 'text-yellow-600' : 'text-green-600'"
                                       x-text="selectedEvent?.color === 'yellow' ? 'Sedang Berjalan' : 'Misi Mendatang'">
                                    </p>
                                    <!-- Teks Sisa Hari Dinamis (Dari JS) -->
                                    <span class="text-sm font-medium text-gray-400" x-text="'(' + getDaysText(selectedEvent) + ')'"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Tampilan Default (Jika tidak ada event dipilih - Blade PHP) -->
                        <div x-show="!selectedEvent">
                            @if ($activePlants->isNotEmpty())
                                @php
                                    $default = $activePlants->first();

                                    // [PERUBAHAN] Hitung sisa detik secara presisi
                                    $exactSecondsRemaining = $default->mission_started_at->addDays($default->currentMission->duration_days)->timestamp - now()->timestamp;

                                    // Ubah ke hari dalam bentuk pecahan (float)
                                    $daysRemainingFloat = $exactSecondsRemaining / 86400;

                                    // [PERUBAHAN] Bulatkan ke bawah (floor)
                                    $daysRemaining = floor($daysRemainingFloat);

                                    // Pastikan tidak negatif jika sudah lewat
                                    $daysRemaining = max(0, $daysRemaining);
                                @endphp
                                <img src="{{ asset('storage/' . $default->plant->image_url) }}" class="w-full h-40 object-cover rounded-lg shadow-md mb-4">
                                <h3 class="text-2xl font-bold text-green-600">{{ $default->plant->name }}</h3>
                                <div class="mt-4 pt-4 border-t">
                                    <span class="text-sm text-gray-500">Tahap {{ $default->currentMission->step_number }}:</span>
                                    <h5 class="text-lg font-semibold">{{ $default->currentMission->title }}</h5>
                                    <p class="text-sm text-gray-600 mt-1">{{ $default->currentMission->description }}</p>
                                </div>
                                <div class="mt-4">
                                    <p class="text-sm text-gray-500">Status:</p>
                                    <div class="flex items-baseline space-x-2">
                                        <p class="text-xl font-bold text-yellow-600">Sedang Berjalan</p>
                                        <span class="text-sm font-medium text-gray-400">({{ $daysRemaining }} hari lagi)</span>
                                    </div>
                                </div>
                            @else
                                <div class="text-center p-4 border-2 border-dashed rounded-lg">
                                    <p class="text-gray-500">Tidak ada misi aktif.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Tombol Minimalis & Rapi -->
                        <a href="{{ route('user-plants.index') }}" class="block w-full text-center mt-6 px-6 py-2.5 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm font-medium hover:bg-green-100 hover:border-green-300 transition-colors shadow-sm">
                            Lihat Detail di Misi Saya
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js Script untuk Kalender -->
    <script>
        function calendarApp(eventsData) {
            return {
                month: new Date().getMonth(),
                year: new Date().getFullYear(),
                no_of_days: [],
                blankDays: [],
                days: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
                monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                dayNames: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                events: eventsData,
                selectedEvent: null,

                init() {
                    this.getNoOfDays();
                },

                isToday(date) {
                    const today = new Date();
                    const d = new Date(this.year, this.month, date);
                    return today.toDateString() === d.toDateString();
                },

                // Cek apakah tanggal memiliki event
                hasEvent(date) {
                    return this.getEvent(date) !== null;
                },

                // Ambil data event untuk tanggal tersebut
                getEvent(date) {
                    const dateString = new Date(this.year, this.month, date).toLocaleDateString('en-CA'); // Format YYYY-MM-DD

                    return this.events.find(e => {
                        return dateString >= e.date_start && dateString <= e.date_end;
                    }) || null;
                },

                // [PERUBAHAN] Fungsi baru untuk menghitung sisa hari dengan Math.floor
                getDaysText(event) {
                    if (!event) return '';
                    // Hapus reset jam agar perhitungan lebih presisi saat ini
                    const today = new Date();

                    if (event.color === 'yellow') {
                        // Untuk misi berjalan (hitung mundur ke akhir)
                        const endParts = event.date_end.split('-');
                        // Asumsikan deadline adalah akhir hari tersebut (23:59:59) untuk visualisasi
                        const endDate = new Date(endParts[0], endParts[1]-1, endParts[2], 23, 59, 59);

                        const diffTime = endDate - today;
                        // Gunakan Math.floor untuk membulatkan ke bawah
                        const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));

                        if (diffDays <= 0) return 'Hari Terakhir';
                        return diffDays + ' hari lagi';
                    } else {
                        // Untuk misi mendatang (hitung mundur ke mulai)
                        const startParts = event.date_start.split('-');
                        const startDate = new Date(startParts[0], startParts[1]-1, startParts[2]);

                        const diffTime = startDate - today;
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                        return 'Mulai dalam ' + diffDays + ' hari';
                    }
                },

                selectDate(date) {
                    const event = this.getEvent(date);
                    if (event) {
                        // Perbaiki judul pendek untuk tampilan
                        if(!event.title_short) {
                            let parts = event.title.split(': ');
                            event.title_short = parts.length > 1 ? parts[1] : event.title;
                        }
                        this.selectedEvent = event;
                    } else {
                        this.selectedEvent = null;
                    }
                },

                nextMonth() {
                    if (this.month == 11) {
                        this.month = 0;
                        this.year++;
                    } else {
                        this.month++;
                    }
                    this.getNoOfDays();
                    this.selectedEvent = null;
                },

                prevMonth() {
                    if (this.month == 0) {
                        this.month = 11;
                        this.year--;
                    } else {
                        this.month--;
                    }
                    this.getNoOfDays();
                    this.selectedEvent = null;
                },

                getNoOfDays() {
                    let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
                    let dayOfWeek = new Date(this.year, this.month).getDay();

                    let blankdaysArray = [];
                    for (var i = 1; i <= dayOfWeek; i++) {
                        blankdaysArray.push(i);
                    }

                    let daysArray = [];
                    for (var i = 1; i <= daysInMonth; i++) {
                        daysArray.push(i);
                    }

                    this.blankDays = blankdaysArray;
                    this.no_of_days = daysArray;
                }
            }
        }
    </script>
</x-app-layout>
