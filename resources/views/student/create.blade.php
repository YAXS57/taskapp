<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengumpulan Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 700px;">
    
    <a href="{{ route('home') }}" class="btn btn-secondary mb-3">&larr; Kembali ke Menu Utama</a>

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">🎓 Pengumpulan Tugas (Mahasiswa)</h4>
        </div>
        <div class="card-body">
            
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('submissions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label class="fw-bold">Pilih Tugas</label>
                    <select name="assignment_id" id="assignmentSelect" class="form-select" required>
                        <option value="" selected disabled>--- Pilih Tugas ---</option>
                        @foreach($assignments as $task)
                            <option value="{{ $task->id }}" data-description="{{ $task->description }}">
                                {{ $task->title }} (Deadline: {{ \Carbon\Carbon::parse($task->deadline)->format('d M H:i') }})
                            </option>
                        @endforeach
                    </select>
                    @if($assignments->isEmpty())
                        <div class="form-text text-danger">Tidak ada tugas aktif saat ini.</div>
                    @endif
                </div>

                <div id="descriptionBox" class="alert alert-info d-none">
                    <strong>📝 Deskripsi Tugas:</strong><br>
                    <span id="descText" style="white-space: pre-wrap;"></span>
                </div>
                <div class="mb-3">
                    <label>Nama Mahasiswa</label>
                    <input type="text" name="student_name" class="form-control" required placeholder="Nama Lengkap">
                </div>

                <div class="mb-3">
                    <label>NIM</label>
                    <input type="text" name="nim" class="form-control" required placeholder="Nomor Induk Mahasiswa">
                </div>

                <div class="mb-3">
                    <label>File Tugas</label>
                    <input type="file" name="file" class="form-control" required>
                    <div class="form-text">Format file bebas (PDF, Word, Zip, dll). Maks 10MB.</div>
                </div>

                <button type="submit" class="btn btn-success w-100 fw-bold">Kirim Tugas</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Script untuk memunculkan deskripsi saat memilih tugas
    const assignmentSelect = document.getElementById('assignmentSelect');
    const descriptionBox = document.getElementById('descriptionBox');
    const descText = document.getElementById('descText');

    assignmentSelect.addEventListener('change', function() {
        // 1. Ambil opsi yang dipilih
        const selectedOption = this.options[this.selectedIndex];
        
        // 2. Ambil isi deskripsi dari atribut 'data-description'
        const description = selectedOption.getAttribute('data-description');

        // 3. Tampilkan di kotak biru
        if (description) {
            descText.textContent = description;
            descriptionBox.classList.remove('d-none'); // Hapus class hidden
        } else {
            descriptionBox.classList.add('d-none'); // Sembunyikan jika kosong
        }
    });
</script>

</body>
</html>