<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $tugasAkhir->judul }} | Showcase {{ $kategori->nama_kategori }}</title>

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
          <a class="text-decoration-none text-muted fw-semibold" href="{{ route('showcase') }}">Showcase</a>
          <a class="text-decoration-none text-muted fw-semibold" href="{{ url('/') }}">Home</a>
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
    <section class="project-header py-5">
      <div class="container">
        <div class="row align-items-center gy-4">
          <div class="col-lg-8">
            <span class="badge bg-white text-dark mb-3">{{ $kategori->nama_kategori }}</span>
            <h1 class="display-5 fw-bold">{{ $tugasAkhir->judul }}</h1>
            <p class="text-white-75 mb-3">{{ $tugasAkhir->tahun_lulus }} • {{ $tugasAkhir->mahasiswa->map(fn($m) => $m->nim . ($m->user?->name || $m->name ? ' - ' . ($m->user?->name ?? $m->name) : ''))->join(', ') ?: 'Mahasiswa belum tersedia' }}</p>
           <div class="d-flex flex-wrap gap-2">
                @if($tugasAkhir->link_repository)
                    <a href="{{ $tugasAkhir->link_repository }}" target="_blank" class="btn btn-primary btn-sm">
                        <i class="bi bi-github me-1"></i>Lihat Repository</a>
                @endif
                @if($tugasAkhir->file_laporan)
                    <a href="{{ route('laporan.view', $tugasAkhir->id) }}" class="btn btn-light btn-sm">
                        <i class="bi bi-file-earmark-pdf me-1"></i>
                        Lihat Laporan
                    </a>
                @endif

            </div>
          </div>
          <div class="col-lg-4 text-lg-end">
            <a href="{{ route('showcase.category', ['kategori' => $kategori->slug]) }}" class="btn btn-outline-light">Kembali ke {{ $kategori->nama_kategori }}</a>
          </div>
        </div>
      </div>
    </section>

    <section class="py-5">
     <div class="row g-4">

    <!-- Deskripsi -->
    <div class="col-lg-6">
        <div class="card detail-card h-100">
            <div class="card-body p-4">
                <h3 class="h5 mb-3">Deskripsi</h3>
                <p class="text-secondary mb-0"> {{ $tugasAkhir->abstrak }}</p>
            </div>
        </div>
    </div>

    <!-- Video Demo -->
    <div class="col-lg-6">
        <div class="card detail-card h-100">
            <div class="card-body p-4">
                <h3 class="h5 mb-3">Video Demo</h3>

                @if($tugasAkhir->demo_video)
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/{{ preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([A-Za-z0-9_-]+)/', $tugasAkhir->demo_video, $m) ? $m[1] : '' }}" allowfullscreen>
                        </iframe>
                    </div>
                @else
                    <div class="text-muted">
                        Belum ada video demo.
                    </div>
                @endif

            </div>
        </div>
    </div>

</div>
    </section>
  </main>

  @include('layouts.footer')
</body>
</html>
