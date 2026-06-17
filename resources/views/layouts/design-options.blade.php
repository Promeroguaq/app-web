<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opciones de Diseño - Turismo App</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .design-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .design-option {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .design-option:hover {
            transform: translateY(-5px);
        }
        
        .design-preview {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            background: #f8f9fa;
        }
        
        /* Opción 1: Dashboard Moderno */
        .modern-dashboard {
            background: #2c3e50;
            color: white;
        }
        
        .modern-sidebar {
            background: #34495e;
            width: 250px;
            height: 400px;
            float: left;
            padding: 20px;
        }
        
        .modern-content {
            margin-left: 270px;
            background: white;
            color: #333;
            padding: 20px;
            height: 400px;
            border-radius: 8px;
        }
        
        /* Opción 2: Minimalista Claro */
        .minimal-light {
            background: #ffffff;
            border: 1px solid #e9ecef;
        }
        
        .minimal-sidebar {
            background: #f8f9fa;
            width: 200px;
            height: 400px;
            float: left;
            padding: 15px;
            border-right: 1px solid #e9ecef;
        }
        
        .minimal-content {
            margin-left: 220px;
            background: white;
            padding: 20px;
            height: 400px;
        }
        
        /* Opción 3: Corporativo Azul */
        .corporate-blue {
            background: #1e3a8a;
            color: white;
        }
        
        .corporate-sidebar {
            background: #1e40af;
            width: 280px;
            height: 400px;
            float: left;
            padding: 25px;
        }
        
        .corporate-content {
            margin-left: 300px;
            background: white;
            color: #333;
            padding: 25px;
            height: 400px;
            border-radius: 8px;
        }
        
        /* Opción 4: Turístico Verde */
        .tourism-green {
            background: #0f2d1a;
            color: white;
        }
        
        .tourism-sidebar {
            background: #14532d;
            width: 260px;
            height: 400px;
            float: left;
            padding: 20px;
        }
        
        .tourism-content {
            margin-left: 280px;
            background: white;
            color: #333;
            padding: 20px;
            height: 400px;
            border-radius: 8px;
        }
        
        .btn-apply {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .btn-apply:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    <div class="design-container">
        <div class="text-center mb-5">
            <h1 style="color: white; font-size: 2.5rem; margin-bottom: 10px;">🎨 Opciones de Diseño para Turismo App</h1>
            <p style="color: rgba(255,255,255,0.9); font-size: 1.1rem;">Elige el diseño que más te guste y lo aplicaré a todo el proyecto</p>
        </div>
        
        <!-- Opción 1: Dashboard Moderno -->
        <div class="design-option">
            <h3 style="color: #2c3e50; margin-bottom: 15px;">🎯 Opción 1: Dashboard Moderno</h3>
            <p style="color: #666; margin-bottom: 20px;">Diseño oscuro con sidebar elegante, perfecto para administración y datos.</p>
            
            <div class="design-preview">
                <div class="modern-dashboard clearfix">
                    <div class="modern-sidebar">
                        <h5>🌴 TurismoApp</h5>
                        <hr style="border-color: rgba(255,255,255,0.2);">
                        <div style="font-size: 0.9rem;">
                            <div style="padding: 8px 0;">🏠 Inicio</div>
                            <div style="padding: 8px 0;">🗺️ Destinos</div>
                            <div style="padding: 8px 0;">🏨 Alojamiento</div>
                            <div style="padding: 8px 0;">🍽️ Gastronomía</div>
                        </div>
                    </div>
                    <div class="modern-content">
                        <h4>Panel de Control</h4>
                        <p>Bienvenido al sistema de turismo</p>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div style="background: #3498db; color: white; padding: 15px; border-radius: 8px; text-align: center;">
                                    <div style="font-size: 1.5rem; font-weight: bold;">156</div>
                                    <div style="font-size: 0.8rem;">Destinos</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div style="background: #2ecc71; color: white; padding: 15px; border-radius: 8px; text-align: center;">
                                    <div style="font-size: 1.5rem; font-weight: bold;">89</div>
                                    <div style="font-size: 0.8rem;">Hoteles</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <button class="btn-apply" onclick="applyDesign('modern')">Aplicar este diseño</button>
        </div>
        
        <!-- Opción 2: Minimalista Claro -->
        <div class="design-option">
            <h3 style="color: #2c3e50; margin-bottom: 15px;">✨ Opción 2: Minimalista Claro</h3>
            <p style="color: #666; margin-bottom: 20px;">Diseño limpio y ligero, ideal para experiencia de usuario fluida.</p>
            
            <div class="design-preview">
                <div class="minimal-light clearfix">
                    <div class="minimal-sidebar">
                        <h6 style="color: #333;">🌴 Turismo</h6>
                        <hr style="border-color: #e9ecef;">
                        <div style="font-size: 0.85rem; color: #666;">
                            <div style="padding: 6px 0;">Home</div>
                            <div style="padding: 6px 0;">Places</div>
                            <div style="padding: 6px 0;">Hotels</div>
                            <div style="padding: 6px 0;">Food</div>
                        </div>
                    </div>
                    <div class="minimal-content">
                        <h5 style="color: #333; font-weight: 300;">Explore Colombia</h5>
                        <p style="color: #666;">Descubre amazing lugares</p>
                        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-top: 20px;">
                            <h6 style="color: #333;">Featured Destinations</h6>
                            <div style="display: flex; gap: 10px; margin-top: 10px;">
                                <div style="background: white; padding: 10px; border-radius: 5px; flex: 1; text-align: center;">
                                    🏖️ Beach
                                </div>
                                <div style="background: white; padding: 10px; border-radius: 5px; flex: 1; text-align: center;">
                                    🏔️ Mountain
                                </div>
                                <div style="background: white; padding: 10px; border-radius: 5px; flex: 1; text-align: center;">
                                    🌿 Nature
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <button class="btn-apply" onclick="applyDesign('minimal')">Aplicar este diseño</button>
        </div>
        
        <!-- Opción 3: Corporativo Azul -->
        <div class="design-option">
            <h3 style="color: #2c3e50; margin-bottom: 15px;">💼 Opción 3: Corporativo Azul</h3>
            <p style="color: #666; margin-bottom: 20px;">Diseño profesional con colores corporativos, perfecto para empresas.</p>
            
            <div class="design-preview">
                <div class="corporate-blue clearfix">
                    <div class="corporate-sidebar">
                        <h5>🏢 TurismoCorp</h5>
                        <hr style="border-color: rgba(255,255,255,0.2);">
                        <div style="font-size: 0.9rem;">
                            <div style="padding: 10px 0; background: rgba(255,255,255,0.1); border-radius: 5px;">📊 Dashboard</div>
                            <div style="padding: 10px 0;">📍 Destinations</div>
                            <div style="padding: 10px 0;">🏨 Lodging</div>
                            <div style="padding: 10px 0;">🍽️ Dining</div>
                            <div style="padding: 10px 0;">📅 Events</div>
                        </div>
                    </div>
                    <div class="corporate-content">
                        <h4 style="color: #1e3a8a;">Executive Dashboard</h4>
                        <p style="color: #666;">Business Intelligence Platform</p>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-top: 20px;">
                            <div style="background: #eff6ff; padding: 15px; border-radius: 8px; text-align: center; border-left: 4px solid #3b82f6;">
                                <div style="font-size: 1.2rem; font-weight: bold; color: #1e3a8a;">2.5M</div>
                                <div style="font-size: 0.75rem; color: #666;">Visitors</div>
                            </div>
                            <div style="background: #f0fdf4; padding: 15px; border-radius: 8px; text-align: center; border-left: 4px solid #22c55e;">
                                <div style="font-size: 1.2rem; font-weight: bold; color: #1e3a8a;">89%</div>
                                <div style="font-size: 0.75rem; color: #666;">Satisfaction</div>
                            </div>
                            <div style="background: #fefce8; padding: 15px; border-radius: 8px; text-align: center; border-left: 4px solid #eab308;">
                                <div style="font-size: 1.2rem; font-weight: bold; color: #1e3a8a;">156</div>
                                <div style="font-size: 0.75rem; color: #666;">Locations</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <button class="btn-apply" onclick="applyDesign('corporate')">Aplicar este diseño</button>
        </div>
        
        <!-- Opción 4: Turístico Verde -->
        <div class="design-option">
            <h3 style="color: #2c3e50; margin-bottom: 15px;">🌿 Opción 4: Turístico Verde (Actual)</h3>
            <p style="color: #666; margin-bottom: 20px;">Diseño con colores naturales, perfecto para turismo y naturaleza.</p>
            
            <div class="design-preview">
                <div class="tourism-green clearfix">
                    <div class="tourism-sidebar">
                        <h5>🌴 TurismoApp</h5>
                        <hr style="border-color: rgba(255,255,255,0.2);">
                        <div style="font-size: 0.9rem;">
                            <div style="padding: 12px 0;">🏠 Inicio</div>
                            <div style="padding: 12px 0;">🗺️ Destinos</div>
                            <div style="padding: 12px 0;">🏨 Alojamiento</div>
                            <div style="padding: 12px 0;">🍽️ Gastronomía</div>
                            <div style="padding: 12px 0;">🎯 Actividades</div>
                            <div style="padding: 12px 0;">🎉 Eventos</div>
                            <div style="padding: 12px 0;">🏖️ Playas</div>
                        </div>
                    </div>
                    <div class="tourism-content">
                        <h4 style="color: #0f2d1a;">Descubre Colombia</h4>
                        <p style="color: #666;">Turismo, aventura y cultura</p>
                        <div style="background: #f0fdf4; padding: 20px; border-radius: 8px; margin-top: 20px; border-left: 4px solid #22c55e;">
                            <h6 style="color: #0f2d1a;">Destinos Populares</h6>
                            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-top: 15px;">
                                <div style="background: white; padding: 10px; border-radius: 5px; text-align: center;">
                                    🏰 Cartagena
                                </div>
                                <div style="background: white; padding: 10px; border-radius: 5px; text-align: center;">
                                    🌆 Medellín
                                </div>
                                <div style="background: white; padding: 10px; border-radius: 5px; text-align: center;">
                                    🏖️ Santa Marta
                                </div>
                                <div style="background: white; padding: 10px; border-radius: 5px; text-align: center;">
                                    ☕ Eje Cafetero
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <button class="btn-apply" onclick="applyDesign('tourism')">Aplicar este diseño</button>
        </div>
    </div>
    
    <script>
        function applyDesign(designType) {
            // Aquí implementaremos la lógica para aplicar el diseño
            alert('Voy a aplicar el diseño ' + designType + ' a todo el proyecto. Esto tomará unos minutos...');
            
            // Enviar al servidor para aplicar el diseño
            fetch('/apply-design/' + designType, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/';
                } else {
                    alert('Error al aplicar el diseño: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al aplicar el diseño. Por favor, inténtalo de nuevo.');
            });
        }
    </script>
</body>
</html>
