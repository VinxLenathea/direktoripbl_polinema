<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="adminHMD authentication page">
    <title>Login</title>

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="auth-body">

    <main class="auth-page">
        <section class="auth-card">
            <div class="text-center mb-4">
                <img src="{{ asset('assets/images/brand/logo/Logo-Politeknik-Negeri-Malang-Dianisa.com_.png') }}" alt="Politeknik Negeri Malang" class="auth-logo" style="width: 90px; height: auto;" />
            </div>

            @if(session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form class="needs-validation" method="POST" action="{{ route('login') }}" novalidate>
                @csrf

                <div class="mb-4">
                    <h1 class="h3 mb-1">Login</h1>
                </div>
                <div class="mb-3">
                    <x-input-label class="form-label" for="email" :value="__('Email')" />
                    <x-text-input class="form-control" id="email" type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="invalid-feedback" />
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <x-input-label class="form-label" for="password" :value="__('Password')" />

                    </div>
                    <div class="position-relative">
                        <x-text-input id="password" class="form-control"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
                        <button type="button" class="btn btn-sm position-absolute"
                            style="right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; padding: 0;"
                            id="togglePassword" title="Tampilkan/Sembunyikan Password">
                            <i class="bi bi-eye" id="passwordIcon"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="invalid-feedback" />
                </div>
                <button class="btn btn-primary w-100" type="submit"><i class="bi bi-box-arrow-in-right" aria-hidden="true"></i>{{ __('Log in') }}</button>
            </form>

            <div class="auth-footer">Masuk menggunakan akun Anda.</div>

        </section>
    </main>

  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/main.js"></script>

  <script>
    document.getElementById('togglePassword').addEventListener('click', function(e) {
      e.preventDefault();
      const passwordInput = document.getElementById('password');
      const passwordIcon = document.getElementById('passwordIcon');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.classList.remove('bi-eye');
        passwordIcon.classList.add('bi-eye-slash');
      } else {
        passwordInput.type = 'password';
        passwordIcon.classList.remove('bi-eye-slash');
        passwordIcon.classList.add('bi-eye');
      }
    });
  </script>

</body>

</html>
