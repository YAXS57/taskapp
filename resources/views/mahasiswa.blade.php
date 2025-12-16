<!DOCTYPE html>
<html>
<head>
    <title>Halaman Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
    <div class="container">
        <a href="/" class="btn btn-secondary mb-3">&larr; Kembali</a>

        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h4>Pengumpulan Tugas</h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('mahasiswa.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf 
                    
                    <div class="mb-3">
                        <label>Pilih Tugas</label>
                        <select name="assignment_id" class="form-select" required>
                            <option value="">-- Pilih Tugas --</option>
                            @foreach($assignments as $tugas)
                                <option value="{{ $tugas->id }}">{{ $tugas->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Nama Mahasiswa</label>
                        <input type="text" name="student_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>NIM</label>
                        <input type="text" name="nim" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>File Tugas</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success">Kirim Tugas</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>