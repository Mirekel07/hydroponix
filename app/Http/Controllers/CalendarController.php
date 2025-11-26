<?php

namespace App\Http\Controllers;

use App\Models\UserPlant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CalendarController extends Controller
{
    /**
     * Menampilkan halaman utama kalender.
     * Data events dikirim langsung ke view untuk Alpine.js.
     */
    public function index()
    {
        // 1. Ambil semua tanaman aktif
        $activePlants = UserPlant::where('user_id', Auth::id())
            ->where('status', 'active')
            ->with(['plant.missions', 'currentMission'])
            ->get();

        // 2. Generate events di server-side agar siap pakai di view
        $events = $this->generateEventsData($activePlants);

        return view('calendar.index', [
            'activePlants' => $activePlants,
            'events' => $events, // Kirim data events langsung
        ]);
    }

    /**
     * API untuk mengambil data event (jika diperlukan untuk navigasi bulan via AJAX nanti)
     */
    public function getEvents(Request $request)
    {
        $activePlants = UserPlant::where('user_id', Auth::id())
            ->where('status', 'active')
            ->with(['plant.missions', 'currentMission'])
            ->get();

        $events = $this->generateEventsData($activePlants);

        return response()->json($events);
    }

    /**
     * Helper function untuk mengolah logika tanggal misi
     */
    private function generateEventsData($activePlants)
    {
        $events = [];

        foreach ($activePlants as $activePlant) {
            $currentMission = $activePlant->currentMission;
            $startDate = $activePlant->mission_started_at;

            // --- A. Misi SEDANG BERJALAN (Kuning) ---
            $events[] = [
                'id' => 'current-' . $activePlant->id,
                'title' => "{$activePlant->plant->name}: {$currentMission->title}",
                'date_start' => $startDate->format('Y-m-d'), // Format standar Y-m-d
                'date_end'   => $startDate->copy()->addDays($currentMission->duration_days)->subDay()->format('Y-m-d'), // Kurangi 1 hari agar pas di visual
                'color' => 'yellow', // Class indikator warna
                'extendedProps' => [
                    'step_number' => $currentMission->step_number,
                    'description' => $currentMission->description,
                    'plant_name'  => $activePlant->plant->name,
                    'image_url'   => Storage::url($activePlant->plant->image_url),
                    'is_active'   => true,
                ]
            ];

            // --- B. Misi MENDATANG (Hijau) ---
            $futureMissions = $activePlant->plant->missions
                ->where('step_number', '>', $currentMission->step_number)
                ->sortBy('step_number');

            $cumulativeDate = $startDate->copy()->addDays($currentMission->duration_days);

            foreach ($futureMissions as $mission) {
                $events[] = [
                    'id' => 'future-' . $activePlant->id . '-' . $mission->id,
                    'title' => "{$activePlant->plant->name}: {$mission->title}",
                    'date_start' => $cumulativeDate->format('Y-m-d'),
                    'date_end'   => $cumulativeDate->copy()->addDays($mission->duration_days)->subDay()->format('Y-m-d'),
                    'color' => 'green', // Class indikator warna
                    'extendedProps' => [
                        'step_number' => $mission->step_number,
                        'description' => $mission->description,
                        'plant_name'  => $activePlant->plant->name,
                        'image_url'   => Storage::url($activePlant->plant->image_url),
                        'is_active'   => false,
                    ]
                ];
                $cumulativeDate->addDays($mission->duration_days);
            }
        }

        return $events;
    }
}
