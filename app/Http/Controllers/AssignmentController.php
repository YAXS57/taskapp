<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use Telegram\Bot\Laravel\Facades\Telegram; 

class AssignmentController extends Controller
{
    // TAMPILKAN HALAMAN UTAMA
public function index()
    {
        // 1. Ambil semua data urut terbaru
        $assignments = Assignment::orderBy('created_at', 'desc')->get();

        // 2. Ambil waktu sekarang (Asia/Jakarta)
        $now = now(); 

        // 3. Filter Tugas Aktif (Deadline MASIH di masa depan)
        // gt() artinya "Greater Than" (Lebih besar dari)
        $activeTasks = $assignments->filter(function ($t) use ($now) {
            return $t->deadline->gt($now); 
        });
        
        // 4. Filter Riwayat (Deadline SUDAH lewat atau sama dengan sekarang)
        // lte() artinya "Less Than or Equal" (Kurang dari atau sama dengan)
        $historyTasks = $assignments->filter(function ($t) use ($now) {
            return $t->deadline->lte($now);
        });

        return view('assignments.index', compact('activeTasks', 'historyTasks'));
    }

    // SIMPAN TUGAS BARU
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'lecturer_id' => 'required',
            'deadline' => 'required|date'
        ]);

        $assignment = Assignment::create($request->all());

        // Kirim Telegram (Opsional, copy paste logika try-catch telegram Anda di sini)
        // ... kode telegram ...

        return redirect()->route('assignments.index')->with('success', '✅ Tugas berhasil dibuat!');
    }

    // UPDATE TUGAS
    public function update(Request $request, $id)
    {
        $assignment = Assignment::findOrFail($id);
        
        $request->validate([
            'title' => 'required',
            'deadline' => 'required|date',
            // ... validasi lain
        ]);

        $assignment->update($request->all());

        return redirect()->route('assignments.index')->with('success', '✅ Tugas berhasil diperbarui!');
    }

    // HAPUS TUGAS
    public function destroy($id)
    {
        Assignment::findOrFail($id)->delete();
        return redirect()->route('assignments.index')->with('success', '🗑 Tugas berhasil dihapus.');
    }

    // LIHAT PENGUMPULAN (Tampilkan View Khusus)
    public function showSubmissions($id)
    {
        $assignment = Assignment::with('submissions')->findOrFail($id);
        return view('assignments.submissions', compact('assignment'));
    }
}