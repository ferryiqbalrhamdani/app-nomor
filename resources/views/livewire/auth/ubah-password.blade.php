<div>
    <div class="d-flex align-items-center justify-content-center mb-3">
        <a href="index.html" class="">
            <h3 class="text-primary">App Nomor</h3>
        </a>
    </div>
    <p class="mb-3 ">
        Masukkan password baru anda
    </p>

    <form wire:submit.prevent='ubah'>
        @csrf
        <x-form.floating type="password" name="password" showpassword="{{$showpassword}}">
            Password
        </x-form.floating>
        <x-form.floating type="password" name="confirmPassword" showpassword="{{$showpassword}}">
            Confirm Password
        </x-form.floating>
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" wire:click='openPas()'>
                <label class="form-check-label" for="exampleCheck1">Tampilkan Password</label>
            </div>
        </div>
        <x-button.auth>
            Kirim
        </x-button.auth>
    </form>
    <p class="text-center mb-0"><a href="/login">Kembali</a></p>
</div>