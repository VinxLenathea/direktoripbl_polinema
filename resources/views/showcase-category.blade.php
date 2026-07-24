<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Showcase {{ $kategori->nama_kategori }} | Direktori Tugas Akhir</title>

  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="welcome-page">
  <header class="py-4 welcome-header sticky-top bg-white shadow-sm" role="banner">
    <div class="container">
      <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
        <div class="d-flex align-items-center gap-3">
          <img src="{{ asset('assets/images/brand/logo/Logo-Politeknik-Negeri-Malang-Dianisa.com_.png') }}" alt="Politeknik Negeri Malang" width="52" height="52" class="brand-mark" />
          <div>
            <div class="fw-bold fs-6">Repository Tugas Akhir</div>
            <div class="text-muted small">Politeknik Negeri Malang PSDKU Pamekasan</div>
          </div>
        </div>

        <nav class="d-flex gap-3 align-items-center flex-wrap" role="navigation" aria-label="Main navigation">
          <a class="text-decoration-none text-muted fw-semibold" href="{{ url('/') }}">Home</a>
          <a class="text-decoration-none text-muted fw-semibold" href="{{ route('showcase') }}">Showcase</a>
          @auth
            <form method="POST" action="{{ route('logout') }}" class="m-0">
              @csrf
              <button type="submit" class="btn btn-primary btn-sm" style="background-color: #2d296c; border-color: #2d296c;">Logout</button>
            </form>
          @else
            <a class="btn btn-primary btn-sm" href="{{ route('login') }}" style="background-color: #2d296c; border-color: #2d296c;">Login</a>
          @endauth
        </nav>
      </div>
    </div>
  </header>

  <main role="main">
    <section class="showcase-hero py-5">
      <div class="container text-center py-5">
        <p class="text-uppercase text-warning fw-semibold mb-2">Kategori {{ $kategori->nama_kategori }}</p>
        <h1 class="display-5 fw-bold">Proyek {{ $kategori->nama_kategori }}</h1>
        <p class="text-white-75 mx-auto" style="max-width: 720px;">Berisi semua tugas akhir yang terdaftar di kategori ini dari database. Klik lihat detail untuk membuka informasi lengkap proyek.</p>
      </div>
    </section>

    <section class="py-5">
      <div class="container">
        <div class="row g-4">
          @forelse($projects as $project)
            <div class="col-sm-6 col-lg-4">
              <div class="card project-card h-100 border-0 shadow-sm position-relative">
                <span class="category-badge">{{ $kategori->nama_kategori }}</span>
                <div class="card-body pt-5">
                  <div class="mb-3">
                    <i class="bi bi-folder fs-1 text-primary"></i>
                  </div>
                  <h5 class="fw-bold">{{ $project->judul }}</h5>
                  <div class="text-secondary small mb-3">
                    <span class="me-3"><i class="bi bi-calendar3"></i> {{ $project->tahun_lulus }}/{{ date('Y', strtotime($project->created_at)) }}</span>
                    <span><i class="bi bi-people"></i> {{ $project->mahasiswa->map(fn($m) => $m->nim . ($m->user?->name || $m->name ? ' - ' . ($m->user?->name ?? $m->name) : ''))->join(', ') ?: '-' }}</span>
                  </div>
                  <p class="text-muted small">{{ \Illuminate\Support\Str::limit($project->abstrak, 120, '...') }}</p>
                  <a href="{{ route('showcase.project', ['kategori' => $kategori->slug, 'tugasAkhir' => $project->slug]) }}" class="btn btn-primary w-100 mt-3" style="background-color: #2d296c; border-color: #2d296c;">Lihat Detail</a>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12">
              <div class="alert alert-secondary text-center mb-0">
                Belum ada proyek yang tersedia untuk kategori ini.
              </div>
            </div>
          @endforelse
        </div>

        <div class="mt-4 d-flex justify-content-center">
          {{ $projects->links('pagination::bootstrap-5') }}
        </div>
      </div>
    </section>
  </main>

@include('layouts.footer')
</body>
</html>
