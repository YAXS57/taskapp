<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\Assignment;
use Illuminate\Support\Facades\Storage;
use Telegram\Bot\Laravel\Facades\Telegram; // <--- WAJIB ADA INI AGAR BISA KIRIM PESAN

class SubmissionController extends Controller
{
    // MENAMPILKAN FORM MAHASISWA
    public function create()
    {
        // Ambil hanya tugas yang belum expired (Deadline > Sekarang)
        // Pastikan Timezone sudah Asia/Jakarta agar akurat
        $assignments = Assignment::where('deadline', '>', now())->get();
        return view('student.create', compact('assignments'));
    }
public function download($id)
    {
        // 1. Cari data submission di database
        $submission = Submission::findOrFail($id);

        // 2. Cek apakah file fisik benar-benar ada di penyimpanan?
        // Kita menggunakan disk 'public' karena saat upload kita pakai store('...', 'public')
        if (!Storage::disk('public')->exists($submission->file_path)) {
            return back()->with('error', 'Maaf, file fisik tidak ditemukan di server.');
        }

        // 3. Paksa Download
        return Storage::disk('public')->download($submission->file_path);
    }
    // MENYIMPAN TUGAS & KIRIM NOTIFIKASI
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'assignment_id' => 'required',
            'student_name' => 'required',
            'nim' => 'required',
            'file' => 'required|file|max:10240' // Max 10MB
        ]);


        // 2. Upload File
        $path = $request->file('file')->store('uploads', 'public');

        // 3. Simpan ke Database
        $submission = Submission::create([
            'assignment_id' => $request->assignment_id,
            'student_name' => $request->student_name,
            'nim' => $request->nim,
            'file_path' => $path
        ]);

        // =======================================================
        // 4. LOGIKA NOTIFIKASI TELEGRAM (BARU DITAMBAHKAN)
        // =======================================================
        try {
            // Cari data Tugas untuk mendapatkan ID Telegram Dosen
            $assignment = Assignment::find($request->assignment_id);

            if ($assignment && $assignment->lecturer_id) {
                $chatIdDosen = $assignment->lecturer_id;
                
                // Susun Pesan
                $pesan = "📩 *TUGAS BARU DITERIMA!*\n\n" .
                         "👤 *Nama:* " . $request->student_name . "\n" .
                         "🆔 *NIM:* " . $request->nim . "\n" .
                         "📚 *Tugas:* " . $assignment->title . "\n" .
                         "⏰ *Waktu:* " . now()->format('d M Y, H:i') . "\n\n" .
                         "✅ _Silakan cek aplikasi untuk mengunduh file._";

                // Kirim Pesan
                Telegram::sendMessage([
                    'chat_id' => $chatIdDosen,
                    'text' => $pesan,
                    'parse_mode' => 'Markdown'
                ]);
            }
        } catch (\Exception $e) {
            // Jika Telegram error (misal koneksi putus), biarkan saja.
            // Jangan sampai mahasiswa gagal upload cuma gara-gara notif error.
            \Log::error("Gagal kirim notif Telegram: " . $e->getMessage());
        }

        // 5. Kembali ke Halaman Form dengan Pesan Sukses
        return redirect()->route('student.create')->with('success', '✅ Tugas berhasil dikirim! Dosen telah dinotifikasi.');
    }
}