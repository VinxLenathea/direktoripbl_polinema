<aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
  <div class="sidebar-header">
    <a class="brand-mark" href="{{ auth()->user()?->role === 'mahasiswa' ? route('mahasiswa.dashboard') : route('dashboard') }}" aria-label="">
      <span class="brand-copy">
        <span class="brand-title">{{ auth()->user()?->role === 'mahasiswa' ? 'MAHASISWA' : 'ADMIN' }}</span>
        <span class="brand-subtitle">{{ $brandSubtitle ?? (auth()->user()?->role === 'mahasiswa' ? 'Mahasiswa Panel' : 'Admin Panel') }}</span>
      </span>
    </a>
  </div>

  <nav class="sidebar-nav">
    @if(auth()->user()?->role === 'mahasiswa')
      <a class="nav-link @if(request()->routeIs('mahasiswa.dashboard')) active @endif" href="{{ route('mahasiswa.dashboard') }}" @if(request()->routeIs('mahasiswa.dashboard')) aria-current="page" @endif>
        <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
        <span class="nav-text">Dashboard</span>
      </a>
    @else
      <a class="nav-link @if(request()->routeIs('dashboard')) active @endif" href="{{ route('dashboard') }}" @if(request()->routeIs('dashboard')) aria-current="page" @endif>
        <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
        <span class="nav-text">Dashboard</span>
      </a>
      <a class="nav-link @if(request()->routeIs('dashboard.mahasiswa.*')) active @endif" href="{{ route('dashboard.mahasiswa.index') }}" @if(request()->routeIs('dashboard.mahasiswa.*')) aria-current="page" @endif>
        <span class="nav-icon"><i class="bi bi-mortarboard" aria-hidden="true"></i></span>
        <span class="nav-text">Akun Mahasiswa</span>
      </a>
      <a class="nav-link @if(request()->routeIs('kategori.*')) active @endif" href="{{ route('kategori.index') }}" @if(request()->routeIs('kategori.*')) aria-current="page" @endif>
        <span class="nav-icon"><i class="bi bi-tag" aria-hidden="true"></i></span>
        <span class="nav-text">Kategori</span>
      </a>
    @endif

    <a class="nav-link @if(request()->routeIs('tugas_akhir.*')) active @endif" href="{{ route('tugas_akhir.index') }}" @if(request()->routeIs('tugas_akhir.*')) aria-current="page" @endif>
      <span class="nav-icon"><i class="bi bi-file-earmark-text" aria-hidden="true"></i></span>
      <span class="nav-text">Tugas Akhir</span>
    </a>

    <a class="nav-link @if(request()->routeIs('profile.*')) active @endif" href="{{ route('profile.edit') }}" @if(request()->routeIs('profile.*')) aria-current="page" @endif>
      <span class="nav-icon"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
      <span class="nav-text">Profile</span>
    </a>
  </nav>




  <div class="sidebar-footer">
    <span class="status-dot"></span>
    <span class="sidebar-footer-text">System running smoothly</span>
  </div>
</aside>
