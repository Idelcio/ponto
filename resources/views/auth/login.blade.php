<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form id="login-form" method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Foto da Câmera -->
        <div class="mt-6 text-center">
            <video id="video" autoplay class="mx-auto rounded shadow" width="240" height="180"></video>
            <canvas id="canvas" class="hidden"></canvas>
            <input type="hidden" name="foto" id="fotoBase64">
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3" id="login-button">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const fotoInput = document.getElementById('fotoBase64');
        const form = document.getElementById('login-form');
        const loginButton = document.getElementById('login-button');

        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(stream => {
                video.srcObject = stream;
            }).catch(error => {
                alert("Erro ao acessar a câmera: " + error.message);
            });

        loginButton.addEventListener('click', function(e) {
            e.preventDefault();

            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            canvas.toBlob(blob => {
                const reader = new FileReader();
                reader.onloadend = () => {
                    fotoInput.value = reader.result;
                    form.submit();
                };
                reader.readAsDataURL(blob);
            }, 'image/jpeg');
        });
    </script>
</x-guest-layout>
