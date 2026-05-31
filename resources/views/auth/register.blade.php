<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="adminHMD authentication page">
    <title>Register | adminHMD</title>

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
            <a class="auth-brand" href="index.html"><span class="brand-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span><span><strong>adminHMD</strong><small>Create your adminHMD account.</small></span></a>
            <div class="auth-visual"><img src="../assets/images/png/dasher-ui-bootstrap-5.jpg" alt="adminHMD dashboard interface"></div>
            <form class="needs-validation" method="POST" action="{{ route('register') }}" novalidate>
                @csrf
                <div class="mb-4">
                    <p class="eyebrow mb-1">Secure Access</p>
                    <h1 class="h3 mb-1">Register</h1>
                    <p class="text-muted mb-0">Create your adminHMD account.</p>
                </div>
                <div class="mb-3">
                    <x-input-label class="form-label" for="name" :value="__('Name')" />
                    <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="invalid-feedback" />
                </div>

                <div class="mb-3">
                    <x-input-label class="form-label" for="email" :value="__('Email')" />
                    <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="invalid-feedback" />
                </div>

                <div class="mb-3">
                    <x-input-label class="form-label" for="password" :value="__('Password')" />
                    <x-text-input id="password" class="form-control"
                        type="password"
                        name="password"
                        required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="invalid-feedback" />
                </div>

                <div class="mb-3">
                    <x-input-label class="form-label" for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="form-control"
                        type="password"
                        name="password_confirmation"
                        required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="invalid-feedback" />
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="terms" required>
                    <label class="form-check-label" for="terms">I agree to the terms</label>
                    <div class="invalid-feedback">You must agree before continuing.</div>
                </div>
                <button class="btn btn-primary w-100" type="submit"><i class="bi bi-person-plus" aria-hidden="true"></i>{{ __('Register') }}</button>
            </form>

            <div class="auth-footer">Already have an account? <a href="{{ route('login') }}">Sign in</a></div>
        </section>
    </main>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>

</html>