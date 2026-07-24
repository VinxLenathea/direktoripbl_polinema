<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Tugas Akhir">
  <title>Tugas Akhir</title>

  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/vendors/bootstrap-icons/bootstrap-icons.css">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <div class="admin-shell">
    <div class="sidebar-backdrop" data-sidebar-close></div>

    @include('layouts.admin-sidebar', ['brandSubtitle' => ' Daftar Tugas Akhir'])

    <div class="admin-main">
      @include('layouts.admin-navbar')

      <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
          <div class="page-heading">
            <div class="page-heading-copy">
              <span class="page-icon"><i class="bi bi-file-earmark-text" aria-hidden="true"></i></span>
              <div>
                <p class="eyebrow mb-1">Data</p>
                <h1 class="h3 mb-1">{{ auth()->user()->role === 'admin' ? 'Pengajuan upload Tugas Akhir' : 'Tugas Akhir' }}</h1>
                <p class="text-muted mb-0">{{ auth()->user()->role === 'admin' ? 'Kelola pengajuan mahasiswa dan verifikasi file laporan.' : 'Kelola judul, kategori, file laporan, link repository, dan keterkaitan mahasiswa.' }}</p>
              </div>
            </div>
          </div>

          @if (session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
          @endif
          @if (session('info'))
            <div class="alert alert-info mt-3">{{ session('info') }}</div>
          @endif
          @if ($errors->any())
            <div class="alert alert-danger mt-3">
              <ul class="mb-0">
                @foreach ($errors->all() as $err)
                  <li>{{ $err }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          @unless(auth()->user()->role === 'admin')
            <section class="panel mt-3">
              <div class="panel-header d-flex justify-content-between align-items-center">
                <div>
                  <h2 class="h5 mb-1 section-title"><i class="bi bi-file-earmark-plus" aria-hidden="true"></i><span>Tambah Tugas Akhir</span></h2>
                  <p class="text-muted mb-0">Klik tombol di kanan untuk membuka formulir pengajuan tugas akhir.</p>
                </div>
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#tugasAkhirModal">
                  <i class="bi bi-plus-circle"></i> Ajukan Tugas Akhir
                </button>
              </div>
            </section>

            <div class="modal fade" id="tugasAkhirModal" tabindex="-1" aria-labelledby="tugasAkhirModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                  <div class="modal-header border-0" style="background: linear-gradient(135deg, #2d296c 0%, #4a47a3 100%); color: white;">
                    <h5 class="modal-title" id="tugasAkhirModalLabel">Form Pengajuan upload Tugas Akhir</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form method="POST" action="{{ route('tugas_akhir.store') }}" enctype="multipart/form-data">
                      @csrf

                      <div class="row g-3">
                        <div class="col-12 col-md-6">
                          <label class="form-label">Judul</label>
                          <input name="judul" type="text" class="form-control" value="{{ old('judul') }}" required maxlength="255">
                        </div>

                        <div class="col-12 col-md-6">
                          <label class="form-label">Kategori</label>
                          <select name="kategori_id" class="form-select" required>
                            <option value="">-- pilih kategori --</option>
                            @foreach ($categories as $c)
                              <option value="{{ $c->id }}" @selected(old('kategori_id') == $c->id)>{{ $c->nama_kategori }}</option>
                            @endforeach
                          </select>
                        </div>

                        <div class="col-12">
                          <label class="form-label">Abstrak</label>
                          <textarea name="abstrak" class="form-control" rows="5" required>{{ old('abstrak') }}</textarea>
                        </div>

                        <div class="col-12 col-md-4">
                          <label class="form-label">Tahun Lulus</label>
                          <input name="tahun_lulus" type="number" class="form-control" value="{{ old('tahun_lulus') }}" required>
                        </div>

                        <div class="col-12 col-md-6">
                          <label class="form-label">File Laporan (PDF, max 2MB)</label>
                          <input name="file_laporan" type="file" class="form-control" accept="application/pdf" required>
                        </div>

                        <div class="col-12 col-md-6">
                          <label class="form-label">Surat Keterangan Administrasi (PDF, max 2MB)</label>
                          <input name="surat_administrasi" type="file" class="form-control" accept="application/pdf" required>
                        </div>

                        <div class="col-12 col-md-6">
                          <label class="form-label">Score Roaster TOEIC (PDF, max 2MB)</label>
                          <input name="score_toeic" type="file" class="form-control" accept="application/pdf" required>
                        </div>

                        <div class="col-12 col-md-6">
                          <label class="form-label">Sertikom (PDF, max 2MB)</label>
                          <input name="sertikom" type="file" class="form-control" accept="application/pdf" required>
                        </div>

                        <div class="col-12 col-md-6">
                          <label class="form-label">File SKKM (PDF, max 2MB)</label>
                          <input name="file_skkm" type="file" class="form-control" accept="application/pdf" required>
                        </div>

                        <div class="col-12 col-md-6">
                          <label class="form-label">Link Repository</label>
                          <input name="link_repository" type="url" class="form-control" value="{{ old('link_repository') }}" placeholder="https://..." required>
                        </div>

                        <div class="col-12 col-md-6">
                          <label class="form-label">Demo Video</label>
                          <input name="demo_video" type="url" class="form-control" value="{{ old('demo_video') }}" placeholder="https://..." required>
                        </div>
                      </div>

                      <div class="mt-4 d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit" style="background-color: #2d296c; border-color: #2d296c;">
                          <i class="bi bi-save" aria-hidden="true"></i> Kirim Pengajuan
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          @endunless

          <section class="panel mt-3">
            <div class="panel-header d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
              <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>{{ auth()->user()->role === 'admin' ? 'Daftar Pengajuan Tugas Akhir' : 'Daftar Tugas Akhir' }}</span></h2>
                <p class="text-muted mb-0">{{ auth()->user()->role === 'admin' ? 'Lihat semua pengajuan dan pilih setujui/tidak.' : 'Data yang tersimpan di database.' }}</p>
              </div>
            </div>

            <div class="panel-body border-bottom pb-3 mb-3">
              <form method="GET" action="{{ route('tugas_akhir.index') }}" class="row g-2 align-items-end">
                <div class="col-12 col-md-6 col-xl-5">
                  <label class="form-label">Cari judul / abstrak</label>
                  <input name="search" type="text" class="form-control" value="{{ old('search', $search ?? '') }}" placeholder="Masukkan kata kunci...">
                </div>
                <div class="col-12 col-md-3 col-xl-3">
                  <label class="form-label">Kategori</label>
                  <select name="kategori_id" class="form-select">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $c)
                      <option value="{{ $c->id }}" @selected((string) ($kategori_id ?? '') === (string) $c->id)>{{ $c->nama_kategori }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-12 col-md-3 col-xl-2">
                  <label class="form-label">Tahun Lulus</label>
                  <input name="tahun_lulus" type="number" class="form-control" value="{{ old('tahun_lulus', $tahun_lulus ?? '') }}" placeholder="2025">
                </div>
                <div class="col-12 col-md-12 col-xl-2 d-flex gap-2">
                  <button class="btn btn-primary w-100" type="submit"><i class="bi bi-search"></i> Filter</button>
                  <a class="btn btn-outline-secondary w-100" href="{{ route('tugas_akhir.index') }}">Reset</a>
                </div>
              </form>
            </div>

            <div class="table-responsive">
              <table class="table align-middle mb-0">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Tahun</th>
                    @if(auth()->user()->role === 'admin')
                      <th>Mahasiswa</th>
                    @endif
                    <th>Status</th>
                    <th>Repo / Demo</th>
                    <th>File</th>
                    <th class="text-end">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($data as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td class="fw-semibold">{{ $item->judul }}</td>
                      <td>{{ $item->category->nama_kategori ?? '-' }}</td>
                      <td>{{ $item->tahun_lulus }}</td>
                      @if(auth()->user()->role === 'admin')
                        <td>{{ $item->mahasiswa->map(fn($m) => optional($m->user)->name)->filter()->join(', ') ?: '-' }}</td>
                      @endif
                      <td>
                        @if($item->status === 'approved')
                          <span class="badge bg-success">Disetujui</span>
                        @elseif($item->status === 'pending')
                          <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($item->status === 'rejected')
                          <span class="badge bg-danger">Ditolak</span>
                        @else
                          <span class="badge bg-secondary">Belum lengkap</span>
                        @endif

                        @if($item->status === 'rejected' && $item->rejection_reason)
                          <div class="small text-danger mt-1">Catatan admin: {{ $item->rejection_reason }}</div>
                        @endif
                      </td>
                      <td>
                        @if ($item->link_repository)
                          <a href="{{ $item->link_repository }}" target="_blank">Repo</a>
                        @else
                          -
                        @endif
                        @if ($item->demo_video)
                          <span class="d-block"><a href="{{ $item->demo_video }}" target="_blank">Demo</a></span>
                        @endif
                      </td>
                      <td>
                        <div class="d-flex flex-column gap-1">
                          @if ($item->file_laporan)
                            <a href="{{ route('laporan.view', $item->id) }}" class="btn btn-light btn-sm">
                              <i class="bi bi-file-earmark-pdf me-1"></i> Lihat Laporan
                            </a>
                          @elseif ($item->pending_file)
                            <a class="btn btn-outline-secondary btn-sm" href="{{ asset('storage/'.$item->pending_file) }}" target="_blank">Lihat Pending Laporan</a>
                          @endif

                          @if ($item->surat_administrasi)
                            <a class="btn btn-outline-primary btn-sm" href="{{ asset('storage/'.$item->surat_administrasi) }}" target="_blank">Surat Administrasi</a>
                          @endif
                          @if ($item->score_toeic)
                            <a class="btn btn-outline-primary btn-sm" href="{{ asset('storage/'.$item->score_toeic) }}" target="_blank">Score TOEIC</a>
                          @endif
                          @if ($item->sertikom)
                            <a class="btn btn-outline-primary btn-sm" href="{{ asset('storage/'.$item->sertikom) }}" target="_blank">Sertikom</a>
                          @endif
                          @if ($item->file_skkm)
                            <a class="btn btn-outline-primary btn-sm" href="{{ asset('storage/'.$item->file_skkm) }}" target="_blank">SKKM</a>
                          @endif

                          @unless($item->file_laporan || $item->pending_file || $item->surat_administrasi || $item->score_toeic || $item->sertikom || $item->file_skkm)
                            <span class="text-muted">-</span>
                          @endunless
                        </div>
                      </td>
                      <td class="text-end">
                        @if(auth()->user()->role === 'admin')
                          <div class="d-flex justify-content-end gap-2 flex-wrap">
                            @if($item->status === 'pending' && $item->pending_file)
                              <form method="POST" action="{{ route('tugas_akhir.approve', $item->id) }}" style="display:inline-block">
                                @csrf
                                <button class="btn btn-success btn-sm" type="submit">
                                  <i class="bi bi-check2-circle" aria-hidden="true"></i> Setujui
                                </button>
                              </form>
                              <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $item->id }}">
                                <i class="bi bi-x-circle" aria-hidden="true"></i> Tolak
                              </button>
                            @else
                              <span class="text-muted small">-</span>
                            @endif
                          </div>
                        @elseif(auth()->user()->role === 'mahasiswa' && $item->mahasiswa->contains('user_id', auth()->id()) && in_array($item->status, ['pending', 'rejected', 'approved']))
                          <div class="d-flex justify-content-end gap-2 flex-wrap">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $item->id }}">
                              <i class="bi bi-pencil-square"></i> Edit
                            </button>
                          </div>
                        @else
                          <span class="text-muted">-</span>
                        @endif
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="9" class="text-muted">Belum ada data.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            @foreach ($data as $item)
              <div class="modal fade" id="editModal-{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                  <div class="modal-content border-0 shadow">
                    <div class="modal-header border-0" style="background: linear-gradient(135deg, #2d296c 0%, #4a47a3 100%); color: white;">
                      <h5 class="modal-title" id="editModalLabel-{{ $item->id }}">Edit Tugas Akhir</h5>
                      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form method="POST" action="{{ route('tugas_akhir.update', $item->id) }}" id="editForm-{{ $item->id }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                          <div class="col-12 col-md-6">
                            <label class="form-label">Judul</label>
                            <input name="judul" type="text" class="form-control" value="{{ old('judul', $item->judul) }}" required maxlength="255">
                          </div>

                          <div class="col-12 col-md-6">
                            <label class="form-label">Kategori</label>
                            <select name="kategori_id" class="form-select" required>
                              <option value="">-- pilih kategori --</option>
                              @foreach ($categories as $c)
                                <option value="{{ $c->id }}" @selected(old('kategori_id', $item->kategori_id) == $c->id)>{{ $c->nama_kategori }}</option>
                              @endforeach
                            </select>
                          </div>

                          <div class="col-12">
                            <label class="form-label">Abstrak</label>
                            <textarea name="abstrak" class="form-control" rows="5" required>{{ old('abstrak', $item->abstrak) }}</textarea>
                          </div>

                          <div class="col-12 col-md-4">
                            <label class="form-label">Tahun Lulus</label>
                            <input name="tahun_lulus" type="number" class="form-control" value="{{ old('tahun_lulus', $item->tahun_lulus) }}" required>
                          </div>

                          <div class="col-12 col-md-6">
                            <label class="form-label">File Laporan (PDF, max 2MB)</label>
                            @if($item->pending_file || $item->file_laporan)
                              <div class="mb-2 small text-muted">
                                File saat ini:
                                @if($item->pending_file)
                                  <a href="{{ asset('storage/'.$item->pending_file) }}" target="_blank">Pending laporan</a>
                                @elseif($item->file_laporan)
                                  <a href="{{ asset('storage/'.$item->file_laporan) }}" target="_blank">Laporan final</a>
                                @endif
                              </div>
                            @endif
                            <input name="file_laporan" type="file" class="form-control" accept="application/pdf">
                          </div>

                          <div class="col-12 col-md-6">
                            <label class="form-label">Surat Keterangan Administrasi (PDF, max 2MB)</label>
                            @if($item->surat_administrasi)
                              <div class="mb-2 small text-muted">
                                File saat ini: <a href="{{ asset('storage/'.$item->surat_administrasi) }}" target="_blank">Lihat</a>
                              </div>
                            @endif
                            <input name="surat_administrasi" type="file" class="form-control" accept="application/pdf">
                          </div>

                          <div class="col-12 col-md-6">
                            <label class="form-label">Score Roaster TOEIC (PDF, max 2MB)</label>
                            @if($item->score_toeic)
                              <div class="mb-2 small text-muted">
                                File saat ini: <a href="{{ asset('storage/'.$item->score_toeic) }}" target="_blank">Lihat</a>
                              </div>
                            @endif
                            <input name="score_toeic" type="file" class="form-control" accept="application/pdf">
                          </div>

                          <div class="col-12 col-md-6">
                            <label class="form-label">Sertikom (PDF, max 2MB)</label>
                            @if($item->sertikom)
                              <div class="mb-2 small text-muted">
                                File saat ini: <a href="{{ asset('storage/'.$item->sertikom) }}" target="_blank">Lihat</a>
                              </div>
                            @endif
                            <input name="sertikom" type="file" class="form-control" accept="application/pdf">
                          </div>

                          <div class="col-12 col-md-6">
                            <label class="form-label">File SKKM (PDF, max 2MB)</label>
                            @if($item->file_skkm)
                              <div class="mb-2 small text-muted">
                                File saat ini: <a href="{{ asset('storage/'.$item->file_skkm) }}" target="_blank">Lihat</a>
                              </div>
                            @endif
                            <input name="file_skkm" type="file" class="form-control" accept="application/pdf">
                          </div>

                          <div class="col-12 col-md-6">
                            <label class="form-label">Link Repository</label>
                            <input name="link_repository" type="url" class="form-control" value="{{ old('link_repository', $item->link_repository) }}" placeholder="https://...">
                          </div>

                          <div class="col-12 col-md-6">
                            <label class="form-label">Demo Video</label>
                            <input name="demo_video" type="url" class="form-control" value="{{ old('demo_video', $item->demo_video) }}" placeholder="https://...">
                          </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                          <button type="button" class="btn btn-primary" onclick="showConfirmAction('edit', {{ $item->id }})" style="background-color: #2d296c; border-color: #2d296c;">
                            <i class="bi bi-save" aria-hidden="true"></i> Simpan Perubahan
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal fade" id="rejectModal-{{ $item->id }}" tabindex="-1" aria-labelledby="rejectModalLabel-{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                  <div class="modal-content border-0 shadow">
                    <div class="modal-header border-0" style="background: linear-gradient(135deg, #2d296c 0%, #4a47a3 100%); color: white;">
                      <h5 class="modal-title" id="rejectModalLabel-{{ $item->id }}">Tolak Pengajuan Tugas Akhir</h5>
                      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form method="POST" action="{{ route('tugas_akhir.reject', $item->id) }}">
                        @csrf
                        <div class="mb-3">
                          <label class="form-label">Alasan Penolakan</label>
                          <textarea name="rejection_reason" class="form-control" rows="4" required>{{ old('rejection_reason') }}</textarea>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-danger" style="background-color: #c82333; border-color: #c82333;">Tolak Pengajuan</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach

            <div class="modal fade" id="confirmActionModal" tabindex="-1" aria-labelledby="confirmActionModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content border-0 shadow">
                  <div class="modal-header border-0" style="background: linear-gradient(135deg, #2d296c 0%, #4a47a3 100%); color: white;">
                    <h5 class="modal-title" id="confirmActionModalLabel">Konfirmasi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <p id="confirmActionMessage" class="mb-0">Apakah Anda yakin?</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="confirmActionButton" onclick="submitConfirmAction()" style="background-color: #2d296c; border-color: #2d296c;">Ya</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="mt-3">
              {{ $data->links('pagination::bootstrap-5') }}
            </div>
          </section>
        </div>
      </main>

      <footer class="admin-footer">
        <div class="container-fluid px-3 px-lg-4">
          <span>Copyright {{ date('Y') }} adminHMD.</span>
        </div>
      </footer>
    </div>
  </div>

  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/main.js"></script>
  <script>
    let pendingConfirmAction = null;

    function showConfirmAction(type, itemId) {
      const modal = document.getElementById('confirmActionModal');
      const message = document.getElementById('confirmActionMessage');
      const button = document.getElementById('confirmActionButton');

      pendingConfirmAction = { type, itemId };

      if (type === 'delete') {
        message.textContent = 'Apakah Anda yakin ingin menghapus tugas akhir ini?';
        button.textContent = 'Ya, Hapus';
      } else {
        message.textContent = 'Apakah Anda yakin ingin menyimpan perubahan ini?';
        button.textContent = 'Ya, Simpan';
      }

      new bootstrap.Modal(modal).show();
    }

    function submitConfirmAction() {
      if (!pendingConfirmAction) {
        return;
      }

      if (pendingConfirmAction.type === 'delete') {
        document.getElementById('deleteForm-' + pendingConfirmAction.itemId).submit();
      } else {
        document.getElementById('editForm-' + pendingConfirmAction.itemId).submit();
      }
    }
  </script>
  @if($errors->any() && auth()->user()->role !== 'admin')
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        var tugasAkhirModal = document.getElementById('tugasAkhirModal');
        if (tugasAkhirModal) {
          var modal = new bootstrap.Modal(tugasAkhirModal);
          modal.show();
        }
      });
    </script>
  @endif
</body>
</html>

