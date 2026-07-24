<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Kelola Kategori">
  <title>Kategori</title>
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
              <span class="page-icon"><i class="bi bi-tag" aria-hidden="true"></i></span>
              <div>
                <p class="eyebrow mb-1">Admin</p>
                <h1 class="h3 mb-1">Kelola Kategori</h1>
                <p class="text-muted mb-0">Tambah, edit, atau hapus kategori tugas akhir.</p>
              </div>
            </div>
          </div>

          @if (session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
          @endif

          <section class="row g-3 mt-3" aria-label="Kelola kategori">
            <div class="col-12 col-xl-12">
              <div class="panel">
                <div class="panel-header d-flex justify-content-between align-items-start gap-3">
                  <div>
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-list-ul" aria-hidden="true"></i><span>Daftar Kategori</span></h2>
                    <p class="text-muted mb-0">Total: <strong>{{ $kategoris->total() }}</strong> kategori</p>
                  </div>
                  <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#createKategoriModal">
                    <i class="bi bi-plus-circle"></i> Tambah Kategori
                  </button>
                </div>

                <div class="table-responsive">
                  <table class="table table-hover align-middle">
                    <thead>
                      <tr>
                        <th>Nama Kategori</th>
                        <th>Dibuat</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($kategoris as $kategori)
                        <tr>
                          <td>{{ $kategori->nama_kategori }}</td>
                          <td>{{ $kategori->created_at?->format('d M Y') ?? '-' }}</td>
                          <td class="text-center">
                            <button class="btn btn-sm btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#editKategoriModal{{ $kategori->id }}" title="Edit" style="background-color: #fff3cd; color: #8a6d3b; border-color: #ffeeba;">
                              <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" type="button" title="Hapus" onclick="showKategoriConfirm({{ $kategori->id }})">
                              <i class="bi bi-trash"></i>
                            </button>
                            <form method="POST" action="{{ route('kategori.destroy', $kategori->id) }}" id="deleteKategoriForm{{ $kategori->id }}" style="display:none;">
                              @csrf
                              @method('DELETE')
                            </form>
                          </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editKategoriModal{{ $kategori->id }}" tabindex="-1" aria-labelledby="editKategoriModalLabel{{ $kategori->id }}" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                              <div class="modal-header border-0" style="background: linear-gradient(135deg, #2d296c 0%, #4a47a3 100%); color: white;">
                                <h5 class="modal-title" id="editKategoriModalLabel{{ $kategori->id }}">Edit Kategori</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form method="POST" action="{{ route('kategori.update', $kategori->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                  <div class="mb-3">
                                    <label for="nama_kategori{{ $kategori->id }}" class="form-label">Nama Kategori</label>
                                    <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" id="nama_kategori{{ $kategori->id }}" name="nama_kategori" value="{{ $kategori->nama_kategori }}" required>
                                    @error('nama_kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                  <button type="submit" class="btn btn-primary" style="background-color: #2d296c; border-color: #2d296c;">Perbarui</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      @empty
                        <tr>
                          <td colspan="3" class="text-center">Belum ada kategori.</td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>

                <!-- Pagination -->
                @if ($kategoris->hasPages())
                  <div class="d-flex justify-content-center mt-3">
                    {{ $kategoris->links('pagination::bootstrap-5') }}
                  </div>
                @endif
              </div>
            </div>
          </section>

          <!-- Create Modal -->
          <div class="modal fade" id="createKategoriModal" tabindex="-1" aria-labelledby="createKategoriModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content border-0 shadow">
                <div class="modal-header border-0" style="background: linear-gradient(135deg, #2d296c 0%, #4a47a3 100%); color: white;">
                  <h5 class="modal-title" id="createKategoriModalLabel">Tambah Kategori</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('kategori.store') }}">
                  @csrf
                  <div class="modal-body">
                    <div class="mb-3">
                      <label for="nama_kategori" class="form-label">Nama Kategori</label>
                      <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori') }}" required>
                      @error('nama_kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" style="background-color: #2d296c; border-color: #2d296c;">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/main.js"></script>
  <div class="modal fade" id="confirmKategoriDeleteModal" tabindex="-1" aria-labelledby="confirmKategoriDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow">
        <div class="modal-header border-0" style="background: linear-gradient(135deg, #2d296c 0%, #4a47a3 100%); color: white;">
          <h5 class="modal-title" id="confirmKategoriDeleteModalLabel">Konfirmasi Hapus</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="mb-0">Apakah Anda yakin ingin menghapus kategori ini?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-danger" onclick="submitKategoriDelete()">Ya, Hapus</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    let pendingKategoriDeleteId = null;

    function showKategoriConfirm(id) {
      pendingKategoriDeleteId = id;
      const modal = new bootstrap.Modal(document.getElementById('confirmKategoriDeleteModal'));
      modal.show();
    }

    function submitKategoriDelete() {
      if (!pendingKategoriDeleteId) return;
      document.getElementById('deleteKategoriForm' + pendingKategoriDeleteId).submit();
    }
  </script>
</body>
</html>
