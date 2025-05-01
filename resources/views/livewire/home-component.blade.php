<div>
    <!-- Barra superior con botones de login y registro -->
    <div class="d-flex justify-content-end p-3">
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/') }}" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-success rounded-pill px-4 py-2 mx-2 shadow-sm">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-outline-warning rounded-pill px-4 py-2 shadow-sm">Register</a>
                @endif
            @endauth
        @endif
    </div>
    
    <section class="content-section">
        <h2 class="section-title">¿Qué Aprenderás?</h2>
        <div class="container">
            <div class="row g-4">
                <div class="row g-4">
                    <div class="col-md-4">
                        <a href="/analisis">
                            <div class="card">
                                <img src="/media/analisisis tecnico.png" alt="Análisis Técnico">
                                <div class="card-body">
                                    <h5 class="card-title">Análisis Técnico</h5>
                                    <p class="card-text">Descubre cómo leer gráficos de mercado y detectar patrones de precios.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="/gestion">
                            <div class="card">
                                <img src="/media/estrategias avanzadas.png" alt="Gestión de Riesgos">
                                <div class="card-body">
                                    <h5 class="card-title">Gestión de Riesgos</h5>
                                    <p class="card-text">Aprende a proteger tu capital y minimizar las pérdidas en el mercado.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="/estrategia">
                            <div class="card">
                                <img src="/media/Gestion de riesgo.jpeg" alt="Estrategias Avanzadas">
                                <div class="card-body">
                                    <h5 class="card-title">Estrategias Avanzadas</h5>
                                    <p class="card-text">Domina técnicas de trading utilizadas por expertos en el mercado.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action Section -->
        <section class="text-center mt-5">
            <h2>¡Inscríbete Ahora y Comienza tu Camino hacia el Éxito!</h2>
            <a href="/person" class="cta-btn">Inscríbete Aquí</a>
        </section>
    </section>
</div>
