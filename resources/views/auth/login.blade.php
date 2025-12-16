<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">

<div class="card shadow-sm" style="width: 400px;">
    <div class="card-header bg-primary text-white text-center">
        <h4>🔒 Login Dosen</h4>
    </div>
    <div class="card-body">
        
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukan admin" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukan admin" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </form>
        
        <div class="mt-3 text-center">
            <a href="{{ route('home') }}" class="text-decoration-none">&larr; Kembali ke Menu Utama</a>
        </div>
    </div>
</div>

</body>
</html>