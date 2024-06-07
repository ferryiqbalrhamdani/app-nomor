<div>
    <x-heading.auth>
        Sign In
    </x-heading.auth>
    <form wire:submit.prevent='loginAction'>
        @csrf
        <x-form.floating type="text" name="username">
            Username
        </x-form.floating>
        <x-form.floating type="password" name="password" showpassword="{{$showpassword}}">
            Password
        </x-form.floating>
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" wire:click='openPas()'>
                <label class="form-check-label" for="exampleCheck1">Tampilkan Password</label>
            </div>
        </div>
        <x-button.auth>
            Sign In
        </x-button.auth>
    </form>
    <p class="text-center mb-0"><a href="/lupa-password">Lupa Password?</a></p>
</div>