<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ env('APP_NAME', 'Sistema de Ponto') }}</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png" />

    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}" />

    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />

    <style>
        body {
            background: linear-gradient(145deg, #e3f2fd, #ffffff);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .card-custom {
            max-width: 420px;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.05);
        }

        footer {
            text-align: center;
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: auto;
            padding: 1rem;
        }

        footer a {
            color: #0d6efd;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 576px) {
            .card-custom h1 {
                font-size: 1.5rem;
            }

            .card-custom p {
                font-size: 0.95rem;
            }

            .btn {
                width: 100%;
                font-size: 1rem;
            }
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center flex-column">

    <div class="container px-4 my-5">
        <div class="mx-auto card-custom bg-white text-center">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/images/favicon.png') }}" alt="Logo" class="mb-4" width="64"
                    height="64">
            </a>

            <h1 class="mb-3 text-primary">Sistema de Ponto Eletrônico</h1>
            <p class="text-muted mb-4">
                Registre seu ponto com segurança. Apenas administradores têm acesso aos relatórios.
            </p>

            <a href="{{ route('login') }}" class="btn btn-primary px-4">Registrar</a>
        </div>
    </div>

    <footer>
        Criado por <a href="https://forestdesenvolvimento.com.br" target="_blank">Forest Desenvolvimento</a>
    </footer>

</body>

</html>
