<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Models\UserPlant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlantController extends Controller
{
    /**
     * Menampilkan daftar semua tanaman & tanaman aktif pengguna.
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil semua tanaman yang tersedia di sistem (untuk Katalog)
        $allPlants = Plant::orderBy('name')->get();

        // 2. Ambil SEMUA tanaman yang sedang aktif ditanam oleh user (untuk bagian 'Sedang Anda Tanam')
        $activePlants = UserPlant::where('user_id', $user->id)
                                ->where('status', 'active')
                                ->with(['plant', 'currentMission']) // Eager load relasi agar efisien
                                ->get();

        // 3. Dapatkan list ID tanaman yang sedang aktif
        // Ini digunakan di view untuk mengecek apakah tombol "Mulai Tanam" harus dinonaktifkan
        $activePlantIds = $activePlants->pluck('plant_id');

        return view('plants.index', [
            'allPlants' => $allPlants,
            'activePlants' => $activePlants,
            'activePlantIds' => $activePlantIds
        ]);
    }

    /**
     * Menampilkan detail satu tanaman dan daftar misinya.
     */
    public function show(Plant $plant)
    {
        // Muat relasi misi untuk tanaman ini, diurutkan berdasarkan langkah
        $plant->load(['missions' => function ($query) {
            $query->orderBy('step_number', 'asc');
        }]);

        return view('plants.show', ['plant' => $plant]);
    }
}
