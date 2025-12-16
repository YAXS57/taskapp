<!DOCTYPE html>
<html>
<head>
    <title>Halaman Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
    <div class="container">
        <a href="/" class="btn btn-secondary mb-3">&larr; Kembali</a>
        
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4>Buat Tugas Baru</h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('dosen.store') }}" method="POST">
                    @csrf <div class="mb-3">
                        <label>ID Dosen / Chat ID Telegram</label>
                        <input type="text" name="lecturer_id" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Judul Tugas</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Tugas</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>