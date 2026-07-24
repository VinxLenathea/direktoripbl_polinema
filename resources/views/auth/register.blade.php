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
    <main class="auth-page">
        <section class="auth-card">
            <div class="text-center mb-4">
                <img src="{{ asset('assets/images/brand/logo/Logo-Politeknik-Negeri-Malang-Dianisa.com_.png') }}" alt="Politeknik Negeri Malang" class="auth-logo" style="width: 90px; height: auto;" />
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                @php
                    $selectedRole = old('role') ?? request('role');
                @endphp

                <div class="mb-4">
                    <h1 class="h3 mb-1">Register</h1>
                    <p class="text-muted mb-0">Create your account.</p>

                    @if(empty($selectedRole))
                        <div class="mt-3 text-center">
                            <div class="small text-muted mb-2">Pilih role saat register:</div>
                            <div class="d-flex gap-2 justify-content-center">
                                <a class="btn btn-light btn-sm" href="{{ route('register') }}?role=admin">Admin</a>
                                <a class="btn btn-light btn-sm" href="{{ route('register') }}?role=mahasiswa">Mahasiswa</a>
                            </div>
                        </div>
                        @error('role')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    @else
                        <div class="alert alert-primary mt-3" role="alert">
                            Register sebagai: <strong>{{ ucfirst($selectedRole) }}</strong>
                        </div>
                        <input type="hidden" name="role" value="{{ $selectedRole }}">
                        @error('role')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    @endif
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

                @if($selectedRole === 'mahasiswa')
                    <div class="mb-3">
                        <x-input-label class="form-label" for="nim" value="NIM" />
                        <x-text-input id="nim" class="form-control" type="text" name="nim" :value="old('nim')" required autocomplete="off" />
                        <x-input-error :messages="$errors->get('nim')" class="invalid-feedback" />
                    </div>
                    <div class="mb-3">
                        <x-input-label class="form-label" for="jurusan" value="Jurusan" />
                        <x-text-input id="jurusan" class="form-control" type="text" name="jurusan" :value="old('jurusan')" required />
                        <x-input-error :messages="$errors->get('jurusan')" class="invalid-feedback" />
                    </div>
                    <div class="mb-3">
                        <x-input-label class="form-label" for="prodi" value="Prodi" />
                        <x-text-input id="prodi" class="form-control" type="text" name="prodi" :value="old('prodi')" required />
                        <x-input-error :messages="$errors->get('prodi')" class="invalid-feedback" />
                    </div>
                @endif

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
