<div>

    <h5 class="mb-4"><b>{{ $levelsCompleted->name }}</b>: <i>{{ $levelsCompleted->description }}</i></h5>
    <br>
    <h5>Hola, <b>{{$person->nick}}</b></h5>
    <br>
    <div id="bloque-video">
        <div style="display: flex; flex-direction: column; align-items: center; text-align: center;">
            <video id="miVideo" class="video-js" controls width="600">
                <source src="{{$levelsCompleted->link}}" type="video/mp4">
                Tu navegador no soporta videos HTML5.
            </video>
            <br>
            <button id="preguntas" class="btn btn-danger"   wire:click="seeQuestion()">Ver Preguntas</button>
        </div>
    </div>

    @if($validacionNivel !== '')
    <div class="alert alert-danger d-flex align-items-center p-4 shadow-sm rounded-3" role="alert">

        <div>
            <strong>¡Atención!</strong> {{$validacionNivel}}
        </div>
    </div>
    @endif

    @if($verPreguntas)
    <div class="container mt-5">

        @foreach($levelsCompleted->questions as $key => $lev)
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold">{{ $key+1 }}. {{ $lev->question }}</h6>
                <div class="list-group">
                    @foreach ($lev->options as $keyOption => $option)
                        <button class="list-group-item list-group-item-action @if($option->id == $respuestas[$lev->id]['option']) bg-success text-white @else bg-light @endif border-0 rounded-3 my-2" wire:click="chooseOption({{ $levelsCompleted->id }},{{ $lev->id }},{{ $option->id }})">
                            <b>{{ $keyOption+1 }}.</b> {{ $option->name }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach

        <div class="text-center mt-4">
            <button class="btn btn-primary btn-lg px-5 py-3" wire:click="sendQuestion()">Enviar Respuesta</button>
        </div>
    </div>
    @endif
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
                    <h5 class="modal-title" id="miModalLabel"><i class="fas fa-magic me-2"></i>IA Chat</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Cerrar"></button>
                </div>

                <!-- Chat Body -->
                <div class="modal-body p-0">
                    <div class="chat-body" id="chatMessages">

                        <!-- Mensaje recibido -->
                        <div class="message received">
                            <div class="message-content">
                                <img src="/bot.gif" class="avatar" alt="Agente">
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
                                    <span class="time text-white">09:16</span>
                                </div>
                                <img src="tu.png" class="avatar" alt="Tú">
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

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            advertenciaInicio();
            cargarVideo();
        });

        window.addEventListener('cargarVideo', event => {
            console.log('respuesta desde bk');
            //cargarVideo();
            //location.reload();
        });

        function advertenciaInicio(){
            Swal.fire({
                title: '¡Atención!',
                text: 'Para pasar al siguiente nivel, debes responder correctamente al menos 4 de 5 preguntas.',
                icon: 'info', // Puede ser 'success', 'error', 'warning', 'info', etc.
                timer: '4000', // Tiempo de la alerta (en milisegundos)
                //showConfirmButton: true, // Puedes quitar esto si no quieres el botón de confirmación
            });
        } 



        function cargarVideo() {
            if (typeof videojs !== "undefined" && document.getElementById("miVideo")) {
                var player = videojs('miVideo');
                const botonPreguntas = document.getElementById("preguntas");

                player.on("ended", function () {
                    botonPreguntas.removeAttribute("disabled");
                    botonPreguntas.classList.add("habilitado");
                });
            }
        }

        window.addEventListener('show-swal-alert', event => {
            Swal.fire({
                title: event.detail[0].title,
                text: event.detail[0].text,
                icon: event.detail[0].icon, // Puede ser 'success', 'error', 'warning', 'info', etc.
                timer: event.detail[0].timer, // Tiempo de la alerta (en milisegundos)
                showConfirmButton: true, // Puedes quitar esto si no quieres el botón de confirmación
            });
            setTimeout(() => { // Pequeño delay para asegurar que el DOM ya se actualizó
                location.reload();
            }, 4000);
        });
    </script>

    <style>
        .card {
            border-radius: 12px;
        }

        .list-group-item-action {
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .list-group-item-action:hover {
            transform: scale(1.05);
            background-color: #f8f9fa;
        }

        .list-group-item-action:active {
            transform: scale(0.98);
            background-color: #e9ecef;
        }

        .badge {
            font-size: 0.8rem;
            padding: 5px 10px;
        }

        .btn-primary {
            font-size: 1.1rem;
            padding: 12px 30px;
            border-radius: 30px;
        }
    </style>
</div>