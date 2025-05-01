<div>
    <div class="container mt-5">
        <!-- Tarjeta principal -->
        <div class="card p-4 shadow-lg rounded-3">
            <h2 class="text-center fw-bold text-primary">Resultados</h2>
            <h4 class="text-center mt-3 text-muted">Ranking de Usuarios</h4>
            
            <!-- Lista de Rankings -->
            <div class="list-group mt-3">
                @foreach($personas as $pers)
                <div class="list-group-item text-center d-flex justify-content-between align-items-center list-group-item-action rounded-3 mb-2" style="transition: transform 0.3s ease; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    <div><b>{{$pers->nick}}</b>: {{$pers->totalPuntos}} puntos</div>
                    <span class="badge bg-primary rounded-pill">{{$pers->totalPuntos}}</span>
                </div>
                @endforeach
            </div>
            
            <!-- Sección de Certificado -->
            <div class="mt-4 text-center">
                <h4 class="fw-bold text-success">Certificado de Finalización</h4>
                <p class="text-muted">¡Felicidades, <b>{{$person->nick}}</b>! Has completado el curso con éxito.</p>
                
                <!-- Botón para descargar certificado -->
                <button class="btn btn-lg btn-success px-4 py-3 rounded-pill shadow-sm" wire:click="generatePDF()" style="transition: transform 0.2s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    Descargar Certificado
                </button>
            </div>
        </div>
    </div>
    <!-- Añadir estilo personalizado -->
    <style>
        .list-group-item {
            border: none;
            padding: 15px 20px;
            background-color: #f8f9fa;
            font-size: 1.1rem;
            border-radius: 10px;
        }

        .list-group-item:hover {
            background-color: #e2e6ea;
            transform: scale(1.05);
        }

        .btn-success {
            transition: background-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        .badge {
            font-size: 1.1rem;
            padding: 10px 20px;
        }
    </style>
</div>


