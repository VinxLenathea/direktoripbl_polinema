<section class="mb-4">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h2 class="h5 mb-1">Update Password</h2>
            <p class="text-muted mb-0">Ensure your account is using a long, random password to stay secure.</p>
        </div>
    </div>

    @if (session('status') === 'password-updated')
        <div class="alert alert-success">Saved.</div>
    @endif

    <form method="post" action="{{ route('password.update') }}" class="row g-3">
        @csrf
        @method('put')

        <div class="col-12 col-md-4">
            <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" autocomplete="current-password">
            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12 col-md-4">
            <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12 col-md-4">
            <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" autocomplete="new-password">
            @error('password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</section>
