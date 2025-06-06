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

    <!-- Boton chat -->
    <a wire:click="abrirModal()" class="floating-btn d-flex align-items-center justify-content-center"
        style="background-color: {{ $this->notificaciones > 0 ? 'red' : 'blue' }} !important; position: fixed; bottom: 20px; right: 20px;" 
        data-bs-toggle="modal" data-bs-target="#miModal">
        
        <i class="fas fa-robot"></i>

        @if($this->notificaciones > 0)
            <span class="notification-badge">{{ $this->notificaciones }}</span>
        @endif
    </a>


    

    <!-- Modal Chat -->
    <div wire:ignore.self class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
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
                        @foreach($historial as $mess)
                            @if($mess->bot)
                                <!-- Mensaje recibido -->
                                <div class="message received">
                                    <div class="message-content">
                                        <img src="/bot.gif" class="avatar" alt="Agente">
                                        <div class="text">
                                            <p>{{ $mess->mensaje }}</p>
                                            <span class="time">{{ $mess->created_at }}</span>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Mensaje enviado -->
                                <div class="message sent">
                                    <div class="message-content">
                                        <div class="text">
                                            <p>{{ $mess->mensaje }}</p>
                                            <span class="time text-white">{{ $mess->created_at }}</span>
                                        </div>
                                        <img src="/tu.png" class="avatar" alt="Tú">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Input -->
                <div class="chat-input-area border-top d-flex align-items-center p-3">
                    <input 
                        type="text" 
                        class="form-control me-2" 
                        placeholder="Escribe tu mensaje..." 
                        wire:model="message" 
                        wire:keydown.enter="enviarMensaje"
                        wire:loading.attr="disabled"
                        wire:target="enviarMensaje"
                    >

                    <button 
                        class="btn btn-primary rounded-circle" 
                        wire:click="enviarMensaje" 
                        title="Enviar" 
                        wire:loading.attr="disabled"
                        wire:target="enviarMensaje"
                    >
                        <span wire:loading.remove wire:target="enviarMensaje">
                            <i class="fas fa-paper-plane"></i>
                        </span>
                        <span wire:loading wire:target="enviarMensaje">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>
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
        window.addEventListener('scrollToBottom', event => {
            console.log('entra dom');
            var chatMessages = document.getElementById("chatMessages");
            chatMessages.scrollTop = chatMessages.scrollHeight;
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

        .floating-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            font-size: 24px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: red !important;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s ease-in-out;
            z-index: 9999; /* Asegura que no lo tapen otros elementos */
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: yellow;
            color: black;
            font-weight: bold;
            padding: 5px 10px;
            font-size: 14px;
            border-radius: 50%;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);
        }

    </style>
</div>