<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Dosen - Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white shadow-sm rounded">
    <h4 class="m-0 text-primary">👨‍🏫 Panel Kontrol Dosen</h4>
    
    <div>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary me-2">
            🏠 Menu Utama
        </a>

        <a href="{{ route('logout') }}" class="btn btn-danger">
            🚪 Logout
        </a>
    </div>
</div>

<div class="container mt-5">
    <div class="alert alert-warning">
    <strong>🔍 Cek Waktu Sistem:</strong><br>
    Waktu Server Laravel: <strong>{{ now()->format('Y-m-d H:i:s') }}</strong> <br>
    Zona Waktu: <strong>{{ config('app.timezone') }}</strong>
</div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Buat Tugas Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('assignments.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label>ID Dosen (Telegram Chat ID)</label>
                            <input type="number" name="lecturer_id" class="form-control" required placeholder="Contoh: 5298808777">
                        </div>

                        <div class="mb-3">
                            <label>Judul Tugas</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Deadline</label>
                            <input type="datetime-local" name="deadline" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-info text-white w-100 fw-bold">Simpan Tugas</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="text-primary mb-0">⚡ Tugas Aktif</h5>
                    <a href="{{ route('assignments.index') }}" class="btn btn-sm btn-outline-primary">🔄 Refresh</a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Judul</th>
                                <th>Deadline</th>
                                <th class="text-center" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activeTasks as $task)
                            <tr>
                                <td class="fw-bold">{{ $task->title }}</td>
                                <td class="text-danger">
                                    {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y, H:i') }}
                                </td>
                                <td class="text-center">
                                    <button type="button" 
                                            class="btn btn-sm btn-warning"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal"
                                            data-id="{{ $task->id }}"
                                            data-title="{{ $task->title }}"
                                            data-desc="{{ $task->description }}"
                                            data-lecturer="{{ $task->lecturer_id }}"
                                            data-deadline="{{ $task->deadline }}">
                                        ✏️
                                    </button>

                                    <a href="{{ route('assignments.submissions', $task->id) }}" class="btn btn-sm btn-info text-white">👁</a>

                                    <form action="{{ route('assignments.destroy', $task->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">🗑</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted p-4">Tidak ada tugas aktif.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="text-secondary mb-0">📂 Riwayat Tugas</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($historyTasks as $task)
                            <tr style="opacity: 0.7">
                                <td>{{ $task->title }}</td>
                                <td><span class="badge bg-secondary">Selesai</span></td>
                                <td class="text-center">
                                    <a href="{{ route('assignments.submissions', $task->id) }}" class="btn btn-sm btn-info text-white">👁</a>
                                    <form action="{{ route('assignments.destroy', $task->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">🗑</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted p-4">Riwayat kosong.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT') 
                
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">✏️ Edit Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Judul</label>
                        <input type="text" name="title" id="editTitle" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label>Deadline</label>
                        <input type="datetime-local" name="deadline" id="editDeadline" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>ID Dosen</label>
                        <input type="number" name="lecturer_id" id="editLecturer" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="description" id="editDesc" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editModal = document.getElementById('editModal');
        
        if (editModal) {
            editModal.addEventListener('show.bs.modal', function (event) {
                // 1. Ambil tombol yang diklik
                var button = event.relatedTarget;
                
                // 2. Ambil data dari atribut tombol
                var id = button.getAttribute('data-id');
                var title = button.getAttribute('data-title');
                var desc = button.getAttribute('data-desc');
                var lecturer = button.getAttribute('data-lecturer');
                var deadline = button.getAttribute('data-deadline');

                // 3. Isi Formulir
                document.getElementById('editTitle').value = title;
                document.getElementById('editDesc').value = desc;
                document.getElementById('editLecturer').value = lecturer;

                // 4. Perbaikan Format Tanggal (Spasi -> T)
                if (deadline) {
                    var formattedDate = deadline.replace(' ', 'T').substring(0, 16);
                    document.getElementById('editDeadline').value = formattedDate;
                }

                // 5. Ubah URL Action Form
                var form = document.getElementById('editForm');
                form.action = '/assignments/' + id;
            });
        }
    });
</script>

</body>
</html>