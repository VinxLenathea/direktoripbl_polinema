<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="adminHMD authentication page">
    <title>Login | adminHMD</title>

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="auth-body">
    <button class="icon-button theme-toggle auth-theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme" title="Switch color theme">
        <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
    </button>
    <main class="auth-page">
        <section class="auth-card">
            <a class="auth-brand" href="index.html"><span class="brand-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span><span><strong>adminHMD</strong><small>Sign in to your admin workspace.</small></span></a>
            <div class="auth-visual"><img src="../assets/images/png/dasher-ui-bootstrap-5.jpg" alt="adminHMD dashboard interface"></div>
            <form class="needs-validation" method="POST" action="{{ route('login') }}" novalidate>
                @csrf
                <div class="mb-4">
                    <p class="eyebrow mb-1">Secure Access</p>
                    <h1 class="h3 mb-1">Login</h1>
                    <p class="text-muted mb-0">Sign in to your admin workspace.</p>
                </div>
                <div class="mb-3">
                    <x-input-label class="form-label" for="email" :value="__('Email')" />
                    <x-text-input class="form-control" id="email" type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="invalid-feedback" />
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <x-input-label class="form-label" for="password" :value="__('Password')" />
                        @if (Route::has('password.request'))
                        <a class="small fw-semibold" href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                        @endif
                    </div>
                    <x-text-input id="password" class="form-control"
                        type="password"
                        name="password"
                        required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="invalid-feedback" />
                </div>
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="remember-me" name="remember_me">
                    <label class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
                </div>
                <button class="btn btn-primary w-100" type="submit"><i class="bi bi-box-arrow-in-right" aria-hidden="true"></i>{{ __('Log in') }}</button>
            </form>

            <div class="auth-footer">New here? <a href="{{ route('register') }}">Create an account</a></div>
        </section>
    </main>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>

</html>