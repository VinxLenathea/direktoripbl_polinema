<section class="mb-4">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h2 class="h5 mb-1">Delete Account</h2>
            <p class="text-muted mb-0">Once your account is deleted, all of its resources and data will be permanently deleted. Please download any data you wish to keep before continuing.</p>
        </div>
    </div>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm-user-deletion-modal">
        Delete Account
    </button>

    <div class="modal fade" id="confirm-user-deletion-modal" tabindex="-1" aria-labelledby="confirmUserDeletionLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmUserDeletionLabel">{{ __('Delete Account') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}</p>
            <form method="post" action="{{ route('profile.destroy') }}" id="delete-account-form">
                @csrf
                @method('delete')
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" form="delete-account-form" class="btn btn-danger">Delete Account</button>
          </div>
        </div>
      </div>
    </div>
</section>
