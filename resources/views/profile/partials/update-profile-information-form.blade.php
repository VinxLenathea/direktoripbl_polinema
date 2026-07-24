<div class="card p-4">
    <h4>Profile Information</h4>
    <p>Ubah data profil akun.</p>

    @if (session('status') == 'profile-updated')
        <div class="alert alert-success">
            Data berhasil disimpan.
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control"
                value="{{ old('name', $user->name) }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                value="{{ old('email', $user->email) }}">
        </div>

        <button type="submit" class="btn btn-primary">
            Simpan
        </button>
    </form>
</div>
