<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengumpulan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>📥 Pengumpulan: {{ $assignment->title }}</h3>
        <a href="{{ route('assignments.index') }}" class="btn btn-secondary">&larr; Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="bg-success text-white">
                    <tr>
                        <th>No</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>Waktu Kirim</th>
                        <th>File</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assignment->submissions as $index => $sub)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-bold">{{ $sub->student_name }}</td>
                        <td>{{ $sub->nim }}</td>
                        <td>{{ $sub->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            <a href="{{ route('submissions.download', $sub->id) }}" class="btn btn-sm btn-success text-white">
    ⬇ Download
</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center p-5 text-muted">Belum ada mahasiswa yang mengumpulkan tugas ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>