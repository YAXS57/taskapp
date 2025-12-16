<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GridCloud Task App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex flex-column justify-content-center align-items-center min-vh-100">
    
    <h2 class="mb-5 text-secondary fw-bold">Selamat Datang!</h2>

    <div class="row w-100 justify-content-center">
        
        <div class="col-md-5 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm border-primary text-center p-4">
                <div class="card-body d-flex flex-column align-items-center">
                    <div class="display-1 mb-3">👨‍🏫</div>
                    <h3 class="text-primary mb-3">Dosen</h3>
                    <p class="text-muted">Halaman Terbatas untuk Dosen.</p>
                    <a href="{{ route('assignments.index') }}" class="btn btn-primary btn-lg w-100 mt-auto">
                        Masuk Dosen 🔒
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-5 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm border-success text-center p-4">
                <div class="card-body d-flex flex-column align-items-center">
                    <div class="display-1 mb-3">🎓</div>
                    <h3 class="text-success mb-3">Mahasiswa</h3>
                    <p class="text-muted">Halaman Terbuka untuk Mahasiswa.</p>
                    <a href="{{ route('student.create') }}" class="btn btn-success btn-lg w-100 mt-auto">
                        Masuk Mahasiswa
                    </a>
                </div>
            </div>
        </div>

    </div>

    <footer class="mt-5 text-muted small">
        &copy; AAA GridCloud Project - Laravel Edition
    </footer>

</div>

</body>
</html>