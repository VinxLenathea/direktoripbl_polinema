<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
<div class="admin-shell">

    <div class="sidebar-backdrop" data-sidebar-close></div>

    @include('layouts.admin-sidebar', ['brandSubtitle' => 'profile'])

    <div class="admin-main">

        @include('layouts.admin-navbar')

        <main class="dashboard-content">
            <div class="container-fluid px-3 px-lg-4 py-4">

                <div class="page-heading d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <h1>Hai, {{ auth()->user()->name }}</h1>
                        <p>Kelola profil akun Anda.</p>
                    </div>
                </div>

                {{-- PROFILE --}}
                <div class="card p-4 mb-4">
                    <h4>Profile Information</h4>

                    @if(session('status') == 'profile-updated')
                        <div class="alert alert-success">
                            Data berhasil disimpan.
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </form>
                </div>

                {{-- PASSWORD --}}
                <div class="card p-4 mb-4">
                    <h4>Ubah Password</h4>

                    @if(session('status') == 'password-updated')
                        <div class="alert alert-success">
                            Password berhasil diubah.
                        </div>
                    @endif

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label>Password Lama</label>
                            <input type="password" name="current_password" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Password Baru</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-success">
                            Update Password
                        </button>
                    </form>
                </div>

                {{-- DELETE ACCOUNT --}}
                <div class="card p-4">
                    <h4>Hapus Akun</h4>
                    <p class="text-muted"> Akun yang dihapus tidak dapat dikembalikan. </p>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        Hapus Akun
                    </button>
                </div>

                <!-- Modal Delete -->
                <div class="modal fade" id="deleteModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Hapus Akun</h5>
                                <button type="button" class="btn-close"data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ route('profile.destroy') }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="mb-3">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                    <button type="submit"class="btn btn-danger"> Ya, Hapus Akun </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </main>

    </div>
</div>

<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/main.js"></script>

</body>
</html>
