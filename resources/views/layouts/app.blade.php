<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curso de Trading</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://vjs.zencdn.net/8.3.0/video-js.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"> -->


    <style>
        /* Body and general styling */
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <i class="bi bi-chat-dots-fill fs-4"></i>


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
                    <a href="{{ route('login') }}" class="btn btn-outline-success rounded-pill px-4 py-2 mx-2 shadow-sm">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-warning rounded-pill px-4 py-2 shadow-sm">Register</a>
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
 <!-- Botón flotante -->
 <!-- Botón flotante (reemplaza tu.ruta por #si quieres o elimínalo) -->
<a href="#" 
   class="floating-btn d-flex align-items-center justify-content-center"
   data-bs-toggle="modal"
   data-bs-target="#miModal">
    <i class="bi bi-chat-dots-fill fs-4"></i>
</a>

    <!-- Modal -->
<div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="miModalLabel">Título del Modal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        Aquí va el contenido de tu modal: texto, formularios, imágenes, lo que necesites.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://vjs.zencdn.net/8.3.0/video.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @livewireScripts

</body>
</html>
