<div>
    <div class="container my-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header text-white text-center py-4" style="background-color: #2c3e50;">
                <h2 class="mb-0">Inicia tu camino hacia la libertad financiera</h2>
            </div>
            <div class="card-body p-5">
                <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label fs-5 fw-bold">Ingresa tu nombre o nick:</label>
                    <input type="text" class="form-control form-control-lg" wire:model="nick" placeholder="Tu nombre o nickname">
                    @error('nick')
                        <p class="text-danger mt-2 mb-2" style="font-size: .9rem;">
                            <i class="fa fa-exclamation-circle ms-2" aria-hidden="true"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-success btn-lg shadow-sm" wire:click="comenzar()">
                        <i class="fa fa-play-circle me-2"></i> Comenzar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            border-radius: 16px;
        }

        .card-header {
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
        }

        .card-body {
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            font-size: 1rem;
            padding: 12px 18px;
            border-radius: 8px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }

        .btn-success {
            transition: background-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #2ecc71;
        }

        .btn-success:focus {
            box-shadow: 0 0 0 0.25rem rgba(46, 204, 113, 0.5);
        }

        .text-danger {
            font-size: .875rem;
            margin-top: .5rem;
        }

        /* Add a little margin at the bottom for better spacing */
        .mb-4 {
            margin-bottom: 1.5rem;
        }
    </style>

</div>
