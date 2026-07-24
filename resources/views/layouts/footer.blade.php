

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
            <li><a class="text-white-75 text-decoration-none" href="{{ route('login') }}">Login</a></li>
          </ul>
        </div>

        <div class="col-6 col-md-3">
          <h6 class="fw-semibold text-white">Kategori</h6>
          <ul class="list-unstyled">
            @foreach(($categories ?? collect())->take(4) as $category)
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


