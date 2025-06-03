<x-guest-layout>
    <div class="container mx-auto max-w-md bg-white shadow-md rounded px-6 py-8 text-center">


        <form id="ponto-form" method="POST" action="{{ route('registrar.ponto') }}" enctype="multipart/form-data">
            @csrf

            <!-- Email -->
            <div class="mb-4 text-left">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" required
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
            </div>

            <!-- Senha -->
            <div class="mb-6 text-left">
                <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                <input type="password" name="password" id="password" required
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
            </div>

            <!-- Vídeo e Captura -->
            <div class="mb-4">
                <video id="video" autoplay playsinline class="mx-auto rounded shadow border" width="280"
                    height="200"></video>
                <canvas id="canvas" class="hidden"></canvas>
            </div>

            <!-- Campos ocultos -->
            <input type="hidden" name="foto" id="fotoBase64">
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <!-- Botão -->
            <button type="submit"
                class="mt-4 px-6 py-2 bg-green-600 text-white rounded shadow hover:bg-green-700 transition">
                Registrar Ponto
            </button>
        </form>
    </div>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const form = document.getElementById('ponto-form');
        const fotoInput = document.getElementById('fotoBase64');
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');

        // Ativa a câmera
        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(error => {
                alert("Erro ao acessar a câmera: " + error.message);
            });

        // Captura geolocalização (retorna Promise)
        function capturarLocalizacao() {
            return new Promise(resolve => {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        position => {
                            latitudeInput.value = position.coords.latitude;
                            longitudeInput.value = position.coords.longitude;
                            resolve();
                        },
                        error => {
                            console.warn("Erro ao obter localização: " + error.message);
                            resolve(); // continua mesmo com erro
                        }
                    );
                } else {
                    console.warn("Geolocalização não suportada.");
                    resolve();
                }
            });
        }

        // Captura a foto e envia
        form.addEventListener('submit', async (e) => {
            e.preventDefault(); // impede envio direto

            await capturarLocalizacao();

            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            canvas.toBlob(blob => {
                const reader = new FileReader();
                reader.onloadend = () => {
                    fotoInput.value = reader.result;
                    form.submit(); // envia só depois de tudo pronto
                };
                reader.readAsDataURL(blob);
            }, 'image/jpeg');
        });
    </script>
    </x-app-layout>
