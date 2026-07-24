<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Mahasiswa dashboard">
  <title>Dashboard | Mahasiswa</title>

  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/vendors/bootstrap-icons/bootstrap-icons.css">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
  <div class="admin-shell">
    <div class="sidebar-backdrop" data-sidebar-close></div>

    @include('layouts.admin-sidebar', ['brandSubtitle' => 'Mahasiswa Panel'])

    <div class="admin-main">
      @include('layouts.admin-navbar')

      <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
          <div class="page-heading d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mt-3">
            <div class="page-heading-copy">
              <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
              <div>
                <p class="eyebrow mb-1">Selamat datang</p>
                <h1 class="h3 mb-1">Halo, {{ auth()->user()->name }}</h1>
                <p class="text-muted mb-0">Ini adalah dashboard mahasiswa Anda.</p>
              </div>
            </div>
          </div>

          @if (session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
          @endif

          <section class="row g-3 mt-3" aria-label="Dashboard ringkasan">
            <div class="col-12 col-sm-6 col-xl-3">
              <article class="metric-card metric-primary">
                <div class="metric-top">
                  <span class="metric-label">Tugas Akhir Saya</span>
                  <span class="metric-icon"><i class="bi bi-journal-text" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">{{ number_format($totalTugasAkhirSaya) }}</div>
                <div class="metric-meta">
                  <span class="text-success">Total entri</span>
                </div>
              </article>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
              <article class="metric-card metric-success">
                <div class="metric-top">
                  <span class="metric-label">Approved</span>
                  <span class="metric-icon"><i class="bi bi-check2-circle" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">{{ number_format($totalApproved) }}</div>
                <div class="metric-meta">
                  <span class="text-success">Sudah disetujui</span>
                </div>
              </article>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
              <article class="metric-card metric-danger">
                <div class="metric-top">
                  <span class="metric-label">Pending</span>
                  <span class="metric-icon"><i class="bi bi-hourglass-split" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">{{ number_format($totalPending) }}</div>
                <div class="metric-meta">
                  <span class="text-success">Menunggu verifikasi</span>
                </div>
              </article>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
              <article class="metric-card metric-warning">
                <div class="metric-top">
                  <span class="metric-label">Rejected</span>
                  <span class="metric-icon"><i class="bi bi-x-circle" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">{{ number_format($totalRejected) }}</div>
                <div class="metric-meta">
                  <span class="text-success">Ditolak admin</span>
                </div>
              </article>
            </div>
          </section>

          <section class="row g-3 mt-3">
            <div class="col-12 col-xl-12">
              <div class="panel">
                <div class="panel-header d-flex justify-content-between align-items-start gap-3">
                  <div>
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-journal-text" aria-hidden="true"></i><span>Daftar Tugas Akhir Saya</span></h2>
                    <p class="text-muted mb-0">Daftar tugas akhir milik Anda dengan pagination.</p>
                  </div>
                  <a class="btn btn-light btn-sm" href="{{ route('tugas_akhir.index') }}">Buka Semua</a>
                </div>

                <div class="table-responsive">
                  <table class="table table-hover align-middle">
                    <thead>
                      <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Tahun</th>
                        <th>Dibuat</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($recentTugasAkhirSaya as $tugas)
                        <tr>
                          <td>{{ $tugas->judul }}</td>
                          <td>{{ $tugas->category?->nama ?? '-' }}</td>
                          <td>
                            @if ($tugas->status === 'approved')
                              <span class="badge bg-success">Approved</span>
                            @elseif ($tugas->status === 'pending')
                              <span class="badge bg-warning text-dark">Pending</span>
                            @elseif ($tugas->status === 'rejected')
                              <span class="badge bg-danger">Rejected</span>
                            @else
                              <span class="badge bg-secondary">{{ $tugas->status ?? '-' }}</span>
                            @endif
                          </td>
                          <td>{{ $tugas->tahun_lulus }}</td>
                          <td>{{ $tugas->created_at?->format('d M Y') }}</td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="5" class="text-center">Belum ada tugas akhir.</td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>

                <div class="mt-3">
                  {{ $recentTugasAkhirSaya->links('pagination::bootstrap-5') }}
                </div>
              </div>
            </div>
          </section>
        </div>
      </main>
    </div>
  </div>

  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/main.js"></script>
</body>
</html>
