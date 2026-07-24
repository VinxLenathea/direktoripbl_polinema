<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Repository Tugas Akhir Mahasiswa</title>

  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <style>
    .welcome-page .btn:hover,
    .welcome-page .btn:focus {
      background-color: #f49220 !important;
      border-color: #f49220 !important;
      color: #ffffff !important;
    }
    .welcome-page .btn:active,
    .welcome-page .btn.active {
      background-color: #f49220 !important;
      border-color: #f49220 !important;
      color: #ffffff !important;
    }
    .welcome-page .btn:active:hover {
      background-color: #f49220 !important;
      border-color: #f49220 !important;
      color: #ffffff !important;
    }
  </style>

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
    <section class="py-5">
      <div class="container">
        <div class="hero-shell fade-up stagger-1">
          <div class="row g-4 align-items-start">
            <div class="col-lg-6">
              <h1 class="display-5 fw-bold">Tugas Akhir Manajemen Informatika</h1>
              <p class="lead text-secondary">Kumpulan data mahasiswa, progress proyek, dan hasil presentasi disajikan dengan jelas dalam tampilan yang tetap ringan dan mudah dijelajahi.</p>
              <div class="d-flex flex-column flex-sm-row gap-3 mt-4 mb-4">
                <a href="{{ route('showcase') }}" class="btn btn-primary btn-lg" style="background-color: #2d296c; border-color: #2d296c;">Lihat Showcase</a>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="hero-panel p-4 fade-up stagger-2 mt-lg-5 mt-4">
                <div class="row g-3">
                  <div class="col-6">
                    <div class="stat-card p-4 text-center fade-up stagger-2">
                      <div class="fs-3 fw-bold">{{ number_format($totalMahasiswa) }}</div>
                      <div class="text-secondary small">Mahasiswa</div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="stat-card p-4 text-center fade-up stagger-1">
                      <div class="fs-3 fw-bold">{{ number_format($totalProyek) }}</div>
                      <div class="text-secondary small">Proyek</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-5 bg-light" id="showcase">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="fw-bold">Kategori Tugas Akhir</h2>
            <p class="text-muted">
                Pilih kategori untuk melihat data
            </p>
        </div>

        <div class="row g-4 justify-content-center">
            @forelse($categories as $category)
                @php
                    $name = strtolower($category->nama_kategori);
                    if (str_contains($name, 'web') || str_contains($name, 'website') || str_contains($name, 'sistem')) {
                        $icon = 'bi-code-slash';
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
                <div class="col-md-3">
                    <div class="card category-card text-center h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <i class="bi {{ $icon }} fs-1"></i>
                            <h5 class="mt-3">{{ $category->nama_kategori }}</h5>
                            <p class="text-muted small">
                                Jelajahi berbagai karya dan inovasi tugas akhir mahasiswa dalam berbagai bidang teknologi.
                            </p>
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

        <!-- Tombol -->
        <div class="text-center mt-5">
            <a href="{{ url('/kategori') }}"
               class="btn btn-lg px-5"
               style="background-color:#2d296c; color:white;">
                Lihat Selengkapnya
            </a>
        </div>

    </div>
</section>
  </main>

  <footer class="py-5" style="background-color: #2d296c; color: white;">
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-4">
          <h5 class="fw-bold text-white">Direktori Tugas Akhir</h5>
          <p class="text-white-75">Media publikasi dan dokumentasi karya tugas akhir mahasiswa yang mendukung akses informasi, eksplorasi proyek, dan pengembangan inovasi akademik.</p>
        </div>

        <div class="col-6 col-md-2">
          <h6 class="fw-semibold text-white">Menu</h6>
          <ul class="list-unstyled">
            <li><a class="text-white-75 text-decoration-none" href="{{ url('/') }}">Home</a></li>
            <li><a class="text-white-75 text-decoration-none" href="#showcase">Showcase</a></li>
            <li>
              @auth
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-link text-white-75 text-decoration-none p-0">Logout</button>
                </form>
              @else
                <a class="text-white-75 text-decoration-none" href="{{ route('login') }}">Login</a>
              @endauth
            </li>
          </ul>
        </div>

        <div class="col-6 col-md-3">
          <h6 class="fw-semibold text-white">Kategori</h6>
          <ul class="list-unstyled">
            @foreach($categories->take(4) as $category)
              <li><span class="text-white-75">{{ $category->nama_kategori }}</span></li>
            @endforeach
          </ul>
        </div>

        <div class="col-md-3">
          <h6 class="fw-semibold text-white">Kontak</h6>
          <p class="text-white-75 small mb-1">Politeknik Negeri Malang PSDKU Pamekasan</p>
          <p class="text-white-75 small mb-0">Email: admin@polinema.ac.id</p>
        </div>
      </div>

      <div class="border-top mt-4 pt-3 text-center small" style="border-color: rgba(255,255,255,.15);">
        <span class="text-white-50">© {{ date('Y') }} Direktori Tugas Akhir - Politeknik Negeri Malang. Semua hak dilindungi.</span>
      </div>
    </div>
  </footer>
</body>
</html>

