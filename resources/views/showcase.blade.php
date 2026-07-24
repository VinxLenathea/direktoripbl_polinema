<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Showcase Kategori | Direktori Tugas Akhir</title>

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
        <p class="text-uppercase text-warning fw-semibold mb-2">Showcase Kategori</p>
        <h1 class="display-5 fw-bold">Lihat semua kategori tugas akhir beserta jumlah proyek</h1>
        <p class="text-white-75 mx-auto" style="max-width: 700px;">Halaman ini menampilkan kategori tugas akhir secara lengkap dan jumlah proyek yang terhubung ke setiap kategori.</p>
      </div>
    </section>

    <section class="py-5">
      <div class="container">
        <div class="row g-4">
          @forelse($categories as $category)
            @php
              $name = strtolower($category->nama_kategori);
              if (str_contains($name, 'web') || str_contains($name, 'website') || str_contains($name, 'sistem')) {
                $icon = 'bi-folder';
              } elseif (str_contains($name, 'mobile') || str_contains($name, 'android') || str_contains($name, 'ios') || str_contains($name, 'aplikasi')) {
                $icon = 'bi-phone';
              } elseif (str_contains($name, 'iot') || str_contains($name, 'internet') || str_contains($name, 'embedded')) {
                $icon = 'bi-cpu';
              } elseif (str_contains($name, 'data') || str_contains($name, 'ai') || str_contains($name, 'analisis') || str_contains($name, 'machine learning')) {
                $icon = 'bi-bar-chart-line';
              } elseif (str_contains($name, 'cloud') || str_contains($name, 'server')) {
                $icon = 'bi-cloud';
              } else {
                $icon = 'bi-tags';
              }
            @endphp
            <div class="col-sm-6 col-lg-4">
              <div class="card category-card h-100 border-0 shadow-sm">
                <div class="card-body text-center px-4 py-5">
                  <div class="mb-4">
                    <i class="bi {{ $icon }} fs-1 text-primary"></i>
                  </div>
                  <h5 class="fw-bold">{{ $category->nama_kategori }}</h5>
                  <p class="text-muted mb-4">{{ $category->approved_projects_count }} Projects</p>
                  <a href="{{ route('showcase.category', ['kategori' => $category->slug]) }}" class="btn btn-sm px-4">View</a>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12">
              <div class="alert alert-secondary text-center mb-0">
                Belum ada kategori tugas akhir yang tersedia.
              </div>
            </div>
          @endforelse
        </div>

        <div class="mt-4 d-flex justify-content-center">
          {{ $categories->links('pagination::bootstrap-5') }}
        </div>
      </div>
    </section>
  </main>

 @include('layouts.footer')
</body>
</html>
