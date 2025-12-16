<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Support\Facades\Storage;

class WebAssignmentController extends Controller
{
    // --- BAGIAN DOSEN ---

    public function createAssignment()
    {
        // Tampilkan form pembuatan tugas (file blade)
        return view('dosen');
    }

    public function storeAssignment(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'lecturer_id' => 'required'
        ]);

        Assignment::create($request->all());

        // Bedanya disini: Kita tidak return JSON, tapi "Redirect" kembali ke halaman form
        return redirect()->back()->with('success', 'Tugas berhasil dibuat!');
    }

    // --- BAGIAN MAHASISWA ---

    public function createSubmission()
    {
        // Ambil semua tugas untuk ditampilkan di Dropdown
        $assignments = Assignment::all();
        return view('mahasiswa', compact('assignments'));
    }

    public function storeSubmission(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required',
            'student_name' => 'required',
            'nim' => 'required',
            'file' => 'required|file|max:10240'
        ]);

        // Upload File (Logic sama seperti sebelumnya)
        // Jika pakai DO Spaces, ganti 'public' jadi 's3' dan pakai storePublicly
        $path = $request->file('file')->store('uploads', 'public'); 

        Submission::create([
            'assignment_id' => $request->assignment_id,
            'student_name' => $request->student_name,
            'nim' => $request->nim,
            'file_path' => $path
        ]);

        return redirect()->back()->with('success', 'Tugas berhasil dikumpulkan! Semangat!');
    }
}