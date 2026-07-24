<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Role</title>

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendors/bootstrap-icons/bootstrap-icons.css">
</head>

<body class="bg-light">

    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="card shadow p-5 text-center" style="width:450px;">

            @if (session('success'))
                <div class="alert alert-success mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <h2 class="mb-3">Pilih Role Login</h2>
            <p class="text-muted mb-4">
                Silakan pilih role terlebih dahulu sebelum login
            </p>

            <div class="d-grid gap-3">

                <a href="{{ route('login', ['role' => 'admin']) }}"
                   class="btn btn-primary btn-lg">
                    <i class="bi bi-person-workspace"></i>
                    Login sebagai Admin
                </a>

                <a href="{{ route('login', ['role' => 'mahasiswa']) }}"
                   class="btn btn-success btn-lg">
                    <i class="bi bi-mortarboard"></i>
                    Login sebagai Mahasiswa
                </a>

                <a href="{{ route('login', ['role' => 'dosen']) }}"
                   class="btn btn-info btn-lg">
                    <i class="bi bi-person-badge"></i>
                    Login sebagai Dosen
                </a>

            </div>

        </div>
    </div>
    </div>
</html>
