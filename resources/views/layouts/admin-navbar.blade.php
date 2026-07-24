<nav class="navbar admin-navbar navbar-expand bg-white">
  <div class="container-fluid px-3 px-lg-4">
    <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar" aria-expanded="true" aria-label="Toggle sidebar">
      <span></span>
      <span></span>
      <span></span>
    </button>

    <div class="navbar-actions ms-auto">
       <div class="dropdown d-flex align-items-center gap-2">
        <div class="d-none d-sm-block text-end">
          <div class="fw-semibold">{{ auth()->user()->name }}</div>
          <div class="text-muted small">{{ ucfirst(auth()->user()->role) }}</div>
        </div>
        <button class="icon-button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Open account menu">
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
              @csrf
              <button type="submit" class="dropdown-item">Sign out</button>
            </form>
          </li>
        </ul>
      </div>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
      </form>
    </div>
  </div>
</nav>
