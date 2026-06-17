@props(['activeTab' => 'ciudades', 'departamentos' => [], 'municipios' => [], 'actividades' => []])

<div class="container-fluid px-3 px-md-4 mb-4">
        
        <!-- Actividades Tab Pane -->
        <div class="tab-pane fade {{ $activeTab === 'actividades' ? 'show active' : '' }}" 
             id="actividades-pane" 
             role="tabpanel" 
             aria-labelledby="actividades-tab" 
             tabindex="0">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-hiking me-2"></i>
                        Actividades en Parques
                    </h5>
                </div>
                <div class="card-body p-3 p-sm-4">
                    <div class="row g-2 g-sm-3">
                        @forelse($actividades as $actividad)
                            <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                                <div class="card border-0 shadow-sm h-100 text-center cursor-pointer" 
                                     data-bs-toggle="modal" 
                                     data-bs-target="#modalActividad{{ $actividad->ID_ACTIVIDAD }}">
                                    <div class="card-body p-2 p-sm-3">
                                        <div class="bg-info bg-opacity-10 rounded-circle p-2 p-sm-3 d-inline-block mb-2 mb-sm-3">
                                            <i class="fas fa-hiking text-info fs-5 fs-sm-4"></i>
                                        </div>
                                        <h6 class="card-title fw-bold mb-1 mb-sm-2 small fs-sm-6">{{ Str::limit($actividad->NOMBRE_ACTIVIDAD_EN_PARQUE, 20) }}</h6>
                                        <p class="text-muted small mb-0 d-none d-sm-block">
                                            <i class="fas fa-hiking me-1"></i>
                                            Actividad
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal para Actividades -->
                            <div class="modal fade"
                                 id="modalActividad{{ $actividad->ID_ACTIVIDAD }}"
                                 tabindex="-1"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable mx-3">
                                    <div class="modal-content">
                                        <div class="modal-header bg-info text-white">
                                            <h5 class="modal-title h6">
                                                <i class="fas fa-hiking me-2"></i>
                                                {{ $actividad->NOMBRE_ACTIVIDAD_EN_PARQUE }}
                                            </h5>
                                            <button type="button"
                                                    class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body py-3">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <p class="text-muted small mb-2">
                                                        <i class="fas fa-tag me-1"></i>
                                                        <strong>Actividad:</strong> {{ $actividad->NOMBRE_ACTIVIDAD_EN_PARQUE }}
                                                    </p>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <p class="text-muted small mb-2">
                                                        <i class="fas fa-map-pin me-1"></i>
                                                        <strong>ID Localidad:</strong> {{ $actividad->ID_LOCALITITES }}
                                                    </p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="mt-3">
                                                <h6 class="text-info fw-bold mb-2">Descripción</h6>
                                                <p class="mb-0">{{ $actividad->DESCRIPCION ?? 'No hay descripción disponible para esta actividad.' }}</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button"
                                                    class="btn btn-secondary btn-sm"
                                                    data-bs-dismiss="modal">
                                                Cerrar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <div class="col-12">
                                <div class="alert alert-info text-center">
                                    No hay actividades disponibles.
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </ul>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth transitions for tab switching
    const tabButtons = document.querySelectorAll('#mainTabs .nav-link');
    tabButtons.forEach(button => {
        button.addEventListener('shown.bs.tab', function (e) {
            // Smooth scroll to tab content
            const tabContent = document.querySelector(e.target.getAttribute('data-bs-target'));
            if (tabContent) {
                tabContent.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
});
</script>
