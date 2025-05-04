<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curso de Trading</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://vjs.zencdn.net/8.3.0/video-js.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        header {
            background-color: #2C3E50;
            color: white;
            padding: 50px 0;
            text-align: center;
        }

        header h1 {
            font-size: 3rem;
            font-weight: 700;
        }

        footer {
            background-color: #34495E;
            color: white;
            padding: 20px 0;
            text-align: center;
            font-size: 1rem;
        }

        .main-container {
            padding: 40px 15px;
        }

        .cta-btn {
            background-color: #3498db;
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 500;
            text-transform: uppercase;
            transition: background-color 0.3s ease;
        }

        .cta-btn:hover {
            background-color: #2980b9;
        }

        .content-section {
            margin-top: 50px;
        }

        /* Cards and components styling */
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .card img {
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .card-body {
            padding: 20px;
            background-color: #fff;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .card-text {
            color: #555;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2C3E50;
            margin-bottom: 30px;
            text-align: center;
        }


        .floating-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background-color: #3498db;
            color: white;
            border-radius: 50%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-decoration: none;
            z-index: 1000;
            transition: background-color 0.3s ease;
        }

        .floating-btn:hover {
            background-color: #2980b9;
        }

        /* Centrar texto o ícono */
        .floating-btn i {
            pointer-events: none;
        }

        /* Estilos del Chat*/
        .modal-dialog {
            max-width: 700px;
        }

        .modal-content {
            border-radius: 16px;
            overflow: hidden;
        }

        .bg-gradient-primary {
            background: linear-gradient(90deg, #0062E6, #33AEFF);
        }

        .chat-body {
            max-height: 420px;
            overflow-y: auto;
            background-color: #f1f5f9;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .message {
            display: flex;
            align-items: flex-end;
            gap: 10px;
            animation: fadeIn 0.3s ease-in;
        }

        .message.sent {
            justify-content: flex-end;
        }

        .message.received {
            justify-content: flex-start;
        }

        .message-content {
            display: flex;
            align-items: center;
            max-width: 75%;
        }

        .text {
            padding: 12px 16px;
            border-radius: 20px;
            position: relative;
            font-size: 0.95rem;
            line-height: 1.4;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .message.sent .text {
            background-color: #007bff;
            color: white;
            border-bottom-right-radius: 4px;
        }

        .message.received .text {
            background-color: #e4e6eb;
            color: black;
            border-bottom-left-radius: 4px;
        }

        .time {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 4px;
            display: block;
            text-align: right;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .chat-input-area {
            background-color: #ffffff;
        }

        .chat-input-area input {
            border-radius: 20px;
            padding: 10px 15px;
        }

        .chat-input-area button {
            width: 44px;
            height: 44px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    @livewireStyles
</head>

<body>

    <body>
        <!-- Header Section -->
        <header class="d-flex justify-content-between align-items-center px-4 py-3 bg-dark text-white">
            <div>
                <h1>Qhatu</h1>
                <p>Aprende a invertir con éxito desde lo más básico hasta estrategias avanzadas.</p>
            </div>

            <!-- Botones de Login y Registro -->
            @if (Route::has('login'))
                <div>
                    @auth
                        <a href="{{ url('/') }}" class="btn btn-light rounded-pill px-4 py-2 shadow-sm">Inicio</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="btn btn-outline-success rounded-pill px-4 py-2 mx-2 shadow-sm">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="btn btn-outline-warning rounded-pill px-4 py-2 shadow-sm">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </header>

        <!-- Main Content -->
        <main class="main-container">
            <!-- Insert Content from Other Components -->
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer>
            <p>© 2025 Qhatu. Todos los derechos reservados.</p>
        </footer>

        <a href="#" class="floating-btn d-flex align-items-center justify-content-center" data-bs-toggle="modal"
            data-bs-target="#miModal">
            <i class="fas fa-robot"></i>
        </a>

        <!-- Modal Chat -->
        <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content shadow-lg border-0 rounded-4">

                    <!-- Header -->
                    <div class="modal-header bg-gradient-primary text-white rounded-top-4">
                        <h5 class="modal-title" id="miModalLabel"><i class="fas fa-comments me-2"></i>Atención al
                            Cliente</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Cerrar"></button>
                    </div>

                    <!-- Chat Body -->
                    <div class="modal-body p-0">
                        <div class="chat-body" id="chatMessages">

                            <!-- Mensaje recibido -->
                            <div class="message received">
                                <div class="message-content">
                                    <img src="https://via.placeholder.com/40x40?text=A" class="avatar" alt="Agente">
                                    <div class="text">
                                        <p>¡Hola! 👋 Soy Ana, tu asistente virtual. ¿En qué puedo ayudarte hoy?</p>
                                        <span class="time">09:15</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Mensaje enviado -->
                            <div class="message sent">
                                <div class="message-content">
                                    <div class="text">
                                        <p>Hola Ana, tengo dudas sobre mi último pedido.</p>
                                        <span class="time">09:16</span>
                                    </div>
                                    <img src="https://via.placeholder.com/40x40?text=Y" class="avatar" alt="Tú">
                                </div>
                            </div>

                            <!-- Mensaje recibido -->
                            <div class="message received">
                                <div class="message-content">
                                    <img src="https://via.placeholder.com/40x40?text=A" class="avatar" alt="Agente">
                                    <div class="text">
                                        <p>Con gusto te ayudo. ¿Podrías darme el número del pedido o el correo asociado?
                                        </p>
                                        <span class="time">09:17</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Mensaje enviado -->
                            <div class="message sent">
                                <div class="message-content">
                                    <div class="text">
                                        <p>Claro, es el #12589 y el correo es juan.perez@gmail.com</p>
                                        <span class="time">09:17</span>
                                    </div>
                                    <img src="https://via.placeholder.com/40x40?text=Y" class="avatar" alt="Tú">
                                </div>
                            </div>

                            <!-- Mensaje recibido -->
                            <div class="message received">
                                <div class="message-content">
                                    <img src="https://via.placeholder.com/40x40?text=A" class="avatar" alt="Agente">
                                    <div class="text">
                                        <p>Gracias Juan. Veo que tu pedido fue enviado ayer 🚚 y llegará entre hoy y
                                            mañana.</p>
                                        <span class="time">09:18</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Input -->
                    <div class="chat-input-area border-top d-flex align-items-center p-3">
                        <input type="text" class="form-control me-2" placeholder="Escribe tu mensaje...">
                        <button class="btn btn-primary rounded-circle" title="Enviar">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
        <script src="https://vjs.zencdn.net/8.3.0/video.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @livewireScripts

    </body>

</html>