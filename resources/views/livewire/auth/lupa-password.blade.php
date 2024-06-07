<div>
    <div class="d-flex align-items-center justify-content-center mb-3">
        <a href="index.html" class="">
            <h3 class="text-primary">App Nomor</h3>
        </a>
    </div>
    <p class="mb-3 ">
        Masukkan username anda
    </p>

    <form wire:submit.prevent='lupaPassword'>
        @csrf
        <x-form.floating type="text" name="username">
            Username
        </x-form.floating>
        <x-button.auth>
            Kirim
        </x-button.auth>
    </form>
    <p class="text-center mb-0"><a href="/login">Kembali</a></p>
</div>