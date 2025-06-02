<x-app-layout>
    <div class="container mx-auto text-center py-10">
        <h2 class="text-2xl font-bold mb-6">Captura de Foto para Registro de Ponto</h2>

        <video id="video" autoplay class="mx-auto rounded shadow" width="320" height="240"></video>
        <canvas id="canvas" class="hidden"></canvas>

        <form id="ponto-form" method="POST" action="{{ route('registrar.ponto') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="foto" id="fotoBase64">
            <button type="submit" class="mt-4 px-6 py-2 bg-green-600 text-white rounded shadow">Registrar
                Ponto</button>
        </form>
    </div>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const form = document.getElementById('ponto-form');
        const fotoInput = document.getElementById('fotoBase64');

        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(stream => {
                video.srcObject = stream;

                // Espera um pouco, tira a foto e envia
                setTimeout(() => {
                    const context = canvas.getContext('2d');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);

                    canvas.toBlob(blob => {
                        const file = new File([blob], "registro.jpg", {
                            type: "image/jpeg"
                        });

                        // Converte para base64
                        const reader = new FileReader();
                        reader.onloadend = () => {
                            fotoInput.value = reader.result;
                            form.submit();
                        };
                        reader.readAsDataURL(file);
                    }, "image/jpeg");
                }, 3000); // tira a foto após 3 segundos
            })
            .catch(error => {
                alert("Erro ao acessar a câmera: " + error.message);
            });
    </script>
</x-app-layout>
