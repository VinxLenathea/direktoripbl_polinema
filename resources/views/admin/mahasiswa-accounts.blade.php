<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Kelola Akun Mahasiswa">
  <title>Akun Mahasiswa</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/vendors/bootstrap-icons/bootstrap-icons.css">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
  <div class="admin-shell">
    <div class="sidebar-backdrop" data-sidebar-close></div>

    @include('layouts.admin-sidebar', ['brandSubtitle' => 'Admin Panel'])

    <div class="admin-main">
      @include('layouts.admin-navbar')

      <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
          <div class="page-heading d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mt-3">
            <div class="page-heading-copy">
              <span class="page-icon"><i class="bi bi-mortarboard" aria-hidden="true"></i></span>
              <div>
                <p class="eyebrow mb-1">Admin</p>
                <h1 class="h3 mb-1">Akun Mahasiswa</h1>
                <p class="text-muted mb-0">Kelola akun mahasiswa tanpa menampilkan password di tabel.</p>
              </div>
            </div>
          </div>

          <section class="row g-3 mt-3" aria-label="Kelola akun mahasiswa">
            <div class="col-12 col-xl-12">
              <div class="panel">
                <div class="panel-header d-flex justify-content-between align-items-start gap-3">
                  <div>
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-people" aria-hidden="true"></i><span>Daftar Akun Mahasiswa</span></h2>
                    <p class="text-muted mb-0">Kelola akun mahasiswa yang sudah dibuat.</p>
                  </div>
                  <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#createMahasiswaModal">
                    <i class="bi bi-person-plus"></i> Buat Akun Mahasiswa
                  </button>
                </div>

                <div class="table-responsive">
                  <table class="table table-hover align-middle">
                    <thead>
                      <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>NIM</th>
                        <th>Jurusan</th>
                        <th>Prodi</th>
                        <th>Angkatan</th>
                        <th>Dibuat</th>
                        <th class="text-end">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($mahasiswaUsers as $mahasiswa)
                        <tr>
                          <td>{{ $mahasiswa->name }}</td>
                          <td>{{ $mahasiswa->email }}</td>
                          <td>{{ $mahasiswa->mahasiswa?->nim ?? '-' }}</td>
                          <td>{{ $mahasiswa->mahasiswa?->jurusan ?? '-' }}</td>
                          <td>{{ $mahasiswa->mahasiswa?->prodi ?? '-' }}</td>
                          <td>{{ $mahasiswa->mahasiswa?->angkatan ?? '-' }}</td>
                          <td>{{ $mahasiswa->created_at->format('d M Y') }}</td>
                          <td class="text-end">
                            <div class="d-flex justify-content-end gap-2 flex-wrap">
                              <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editMahasiswaModal-{{ $mahasiswa->id }}">
                                <i class="bi bi-pencil-square"></i> Edit
                              </button>
                              <form method="POST" action="{{ route('dashboard.mahasiswa.destroy', $mahasiswa->id) }}" onsubmit="return confirm('Hapus akun mahasiswa ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                  <i class="bi bi-trash"></i> Hapus
                                </button>
                              </form>
                            </div>
                          </td>
                        </tr>

                        <div class="modal fade" id="editMahasiswaModal-{{ $mahasiswa->id }}" tabindex="-1" aria-labelledby="editMahasiswaModalLabel-{{ $mahasiswa->id }}" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="editMahasiswaModalLabel-{{ $mahasiswa->id }}">Edit Akun Mahasiswa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form method="POST" action="{{ route('dashboard.mahasiswa.update', $mahasiswa->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                  <div class="mb-3">
                                    <label for="name-{{ $mahasiswa->id }}" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="name-{{ $mahasiswa->id }}" name="name" value="{{ old('name', $mahasiswa->name) }}" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="email-{{ $mahasiswa->id }}" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email-{{ $mahasiswa->id }}" name="email" value="{{ old('email', $mahasiswa->email) }}" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="nim-{{ $mahasiswa->id }}" class="form-label">NIM</label>
                                    <input type="text" class="form-control" id="nim-{{ $mahasiswa->id }}" name="nim" value="{{ old('nim', $mahasiswa->mahasiswa?->nim) }}" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="jurusan-{{ $mahasiswa->id }}" class="form-label">Jurusan</label>
                                    <input type="text" class="form-control" id="jurusan-{{ $mahasiswa->id }}" name="jurusan" value="{{ old('jurusan', $mahasiswa->mahasiswa?->jurusan) }}" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="prodi-{{ $mahasiswa->id }}" class="form-label">Prodi</label>
                                    <input type="text" class="form-control" id="prodi-{{ $mahasiswa->id }}" name="prodi" value="{{ old('prodi', $mahasiswa->mahasiswa?->prodi) }}" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="angkatan-{{ $mahasiswa->id }}" class="form-label">Angkatan</label>
                                    <input type="number" class="form-control" id="angkatan-{{ $mahasiswa->id }}" name="angkatan" value="{{ old('angkatan', $mahasiswa->mahasiswa?->angkatan) }}" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="password-{{ $mahasiswa->id }}" class="form-label">Password Baru</label>
                                    <input type="password" class="form-control" id="password-{{ $mahasiswa->id }}" name="password" placeholder="Kosongkan jika tidak ganti">
                                  </div>
                                  <div class="mb-3">
                                    <label for="password_confirmation-{{ $mahasiswa->id }}" class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" id="password_confirmation-{{ $mahasiswa->id }}" name="password_confirmation" placeholder="Kosongkan jika tidak ganti">
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                  <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      @empty
                        <tr>
                          <td colspan="8" class="text-center">Belum ada akun mahasiswa.</td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </section>

          <div class="modal fade" id="createMahasiswaModal" tabindex="-1" aria-labelledby="createMahasiswaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="createMahasiswaModalLabel">Buat Akun Mahasiswa</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('dashboard.mahasiswa.store') }}">
                  @csrf
                  <div class="modal-body">
                    <div class="mb-3">
                      <label for="name" class="form-label">Nama</label>
                      <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                      @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                      <label for="email" class="form-label">Email</label>
                      <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                      @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                      <label for="nim" class="form-label">NIM</label>
                      <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim') }}" required>
                      @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                      <label for="jurusan" class="form-label">Jurusan</label>
                      <input type="text" class="form-control @error('jurusan') is-invalid @enderror" id="jurusan" name="jurusan" value="{{ old('jurusan') }}" required>
                      @error('jurusan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                      <label for="prodi" class="form-label">Prodi</label>
                      <input type="text" class="form-control @error('prodi') is-invalid @enderror" id="prodi" name="prodi" value="{{ old('prodi') }}" required>
                      @error('prodi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                      <label for="angkatan" class="form-label">Angkatan</label>
                      <input type="number" class="form-control @error('angkatan') is-invalid @enderror" id="angkatan" name="angkatan" value="{{ old('angkatan') }}" required>
                      @error('angkatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                      @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                      <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                      <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required>
                      @error('password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  @if (session('modal_status'))
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header {{ session('modal_status') === 'success' ? 'border-success' : 'border-danger' }}">
            <h5 class="modal-title" id="statusModalLabel">{{ session('modal_title') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p class="mb-0">{{ session('modal_message') }}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
  @endif

  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/main.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const statusModalElement = document.getElementById('statusModal');
      const createModalElement = document.getElementById('createMahasiswaModal');

      if (statusModalElement) {
        const statusModal = new bootstrap.Modal(statusModalElement);
        statusModal.show();
      }

      if (createModalElement && {{ session('modal_status') === 'error' ? 'true' : 'false' }}) {
        const createModal = bootstrap.Modal.getOrCreateInstance(createModalElement);
        createModal.show();
      }
    });
  </script>
</body>
</html>
