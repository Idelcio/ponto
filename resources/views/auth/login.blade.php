<x-guest-layout>
    <div class="max-w-md w-full mx-auto px-6 py-8 bg-white shadow-md rounded-lg">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form id="login-form" method="POST" action="{{ route('login') }}" enctype="multipart/form-data">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Webcam Preview -->
            <div class="mt-6 text-center">
                <video id="video" autoplay playsinline class="mx-auto rounded shadow-md border" width="240"
                    height="180"></video>
                <canvas id="canvas" class="hidden"></canvas>
                <input type="hidden" name="foto" id="fotoBase64">
            </div>

            <!-- Localização -->
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-6">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button class="ml-3" id="login-button">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const fotoInput = document.getElementById('fotoBase64');
        const form = document.getElementById('login-form');
        const loginButton = document.getElementById('login-button');
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');

        // Ativa a câmera ao carregar
        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(error => {
                alert("Erro ao acessar a câmera: " + error.message);
            });

        // Captura a localização com Promessa
        function capturarLocalizacao() {
            return new Promise(resolve => {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(position => {
                        latitudeInput.value = position.coords.latitude;
                        longitudeInput.value = position.coords.longitude;
                        resolve();
                    }, error => {
                        console.warn("Erro ao obter localização: " + error.message);
                        resolve(); // Continua mesmo com erro
                    });
                } else {
                    console.warn("Geolocalização não suportada.");
                    resolve();
                }
            });
        }

        // Ao clicar no botão de login
        loginButton.addEventListener('click', async function(e) {
            e.preventDefault(); // Evita envio automático

            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            canvas.toBlob(async (blob) => {
                const reader = new FileReader();
                reader.onloadend = async () => {
                    fotoInput.value = reader.result;
                    await capturarLocalizacao(); // Espera localização
                    form.submit(); // Só envia depois que tudo estiver pronto
                };
                reader.readAsDataURL(blob);
            }, 'image/jpeg');
        });
    </script>
</x-guest-layout>
