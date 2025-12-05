<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Pastikan Auth di-import

class ModuleController extends Controller
{
    /**
     * Menampilkan daftar semua modul.
     */
    public function index()
    {
        // Halaman index tetap butuh login (karena ada filter level user)
        // Jika Anda ingin index publik juga, Anda perlu logika serupa di sini.
        // Untuk sekarang kita asumsikan index hanya untuk member.
        $modules = Module::orderBy('title')->get();

        return view('modules.index', [
            'modules' => $modules
        ]);
    }

    /**
     * [DIPERBARUI] Menampilkan detail satu modul.
     * Mengizinkan tamu akses Level 1, tapi menolak Level > 1.
     */
    public function show(Module $module)
    {
        // 1. Cek apakah User Login atau Tamu
        if (Auth::check()) {
            // --- LOGIKA USER LOGIN ---
            // User harus punya level cukup
            if (Auth::user()->level < $module->level_required) {
                return redirect()->route('modules.index')
                    ->with('error', "Level Anda (Lv. ".Auth::user()->level.") belum cukup untuk membuka modul ini. (Perlu Lv. {$module->level_required})");
            }
        } else {
            // --- LOGIKA TAMU (GUEST) ---
            // Tamu HANYA boleh akses Level 1
            if ($module->level_required > 1) {
                return redirect()->route('login')
                    ->with('status', 'Silakan login atau daftar untuk mengakses modul tingkat lanjut ini.');
            }
        }

        // Memuat relasi 'quiz'
        $module->load('quiz');

        return view('modules.show', [
            'module' => $module
        ]);
    }
}
