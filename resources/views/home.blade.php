@vite(['resources/css/app.css', 'resources/js/app.js'])
@extends('layouts.app')
@section('content')
<div class="max-w-5xl mx-auto mt-10">
    <h1 class="text-4xl font-bold text-gray-800 mb-4">
        Bienvenido a Fisiocare
    </h1>

    <p class="text-lg text-gray-600">
        Esta será tu página de inicio completamente personalizada.
    </p>

</div>
@endsection
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FisioCare Ayla - Clínica de Fisioterapia</title>
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">>
</head>
<body>

    <!-- NAVBAR -->
    <header class="navbar">
        <div class="nav-content">
            <a href="/" class="logo">
                <div class="logo-box">FC</div>
                <span>
                    <strong>FisioCare Ayla</strong>
                    <small>Clínica de Fisioterapia</small>
                </span>
            </a>

            <ul class="nav-links">
                <li><a href="#hero">Inicio</a></li>
                <li><a href="#services">Servicios</a></li>
                <li><a href="#about">Sobre Nosotros</a></li>
                <li><a href="#testimonials">Testimonios</a></li>
                <li><a href="{{ route('citas.create') }}" class="btn btn-primary">Agendar Cita</a></li>
            </ul>

            <div class="nav-buttons">
                <a href="{{ route('login') }}" class="btn-login">Iniciar Sesión</a>
                <a href="{{ route('register') }}" class="btn-register">Registrarse</a>
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section id="hero" class="hero">
        <div class="container hero-content">
            <div class="hero-left">
                <h1 class="hero-title">Recupera tu Movilidad, Vive Sin Dolor</h1>
                <p class="hero-lead">Atención especializada en fisioterapia, rehabilitación y terapia manual. Profesionales certificados y planes personalizados para cada paciente.</p>

                <div class="hero-buttons">
                    <a href="{{ route('citas.create') }}" class="btn btn-primary">Agendar Cita</a>
                </div>
            </div>

            <div class="hero-right">
                <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=600&h=600&fit=crop" alt="Profesional de Fisioterapia">
            </div>
        </div>
    </section>

    <!-- ABOUT SECTION -->
    <section id="about" class="about">
        <div class="container about-content">
            <div class="about-text">
                <h2>Sobre Nosotros</h2>
                <p>FisioCare Ayla es una clínica moderna especializada en fisioterapia y rehabilitación, con profesionales certificados y equipamiento de última generación.</p>
                <p>Nuestro equipo se dedica a brindar atención personalizada, evaluación exhaustiva y tratamientos basados en evidencia científica.</p>

                <div class="about-highlights">
                    <div class="highlight-item">
                        <div class="highlight-icon">✓</div>
                        <div class="highlight-text">
                            <strong>Profesionales Certificados</strong>
                            <small>Equipo con amplia formación y experiencia</small>
                        </div>
                    </div>
                    <div class="highlight-item">
                        <div class="highlight-icon">✓</div>
                        <div class="highlight-text">
                            <strong>Equipamiento Moderno</strong>
                            <small>Tecnología de punta para mejor atención</small>
                        </div>
                    </div>
                    <div class="highlight-item">
                        <div class="highlight-icon">✓</div>
                        <div class="highlight-text">
                            <strong>Planes Personalizados</strong>
                            <small>Tratamiento adaptado a tus necesidades</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="about-img">
                <div class="geometric-frame">
                    <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=400&h=500&fit=crop" alt="Equipo de Fisioterapia">
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICES SECTION -->
    <section id="services" class="services">
        <div class="container">
            <div class="services-header">
                <h2 class="section-title">Nuestros Servicios Especializados</h2>
                <p class="section-subtitle">10 especialidades de fisioterapia para tu bienestar completo</p>
            </div>

            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">👶</div>
                    <h3>Fisioterapia Pediátrica</h3>
                    <p>Tratamientos especializados para niños con necesidades motoras y del desarrollo.</p>
                </div>

                <div class="service-card">
                    <div class="service-icon">👴</div>
                    <h3>Fisioterapia Geriátrica</h3>
                    <p>Movilidad, fortalecimiento y bienestar para adultos mayores.</p>
                </div>

                <div class="service-card">
                    <div class="service-icon">🫁</div>
                    <h3>Fisioterapia Respiratoria</h3>
                    <p>Técnicas para mejorar la función pulmonar y respiratoria.</p>
                </div>

                <div class="service-card">
                    <div class="service-icon">🦴</div>
                    <h3>Fisioterapia Traumatológica</h3>
                    <p>Recuperación de lesiones óseas, articulares y musculares.</p>
                </div>

                <div class="service-card">
                    <div class="service-icon">❤️</div>
                    <h3>Fisioterapia Cardiovascular</h3>
                    <p>Rehabilitación cardíaca y recuperación post-operatoria.</p>
                </div>

                <div class="service-card">
                    <div class="service-icon">🤲</div>
                    <h3>Fisioterapia Ocupacional</h3>
                    <p>Adaptación y rehabilitación para actividades de la vida diaria.</p>
                </div>

                <div class="service-card">
                    <div class="service-icon">🕊️</div>
                    <h3>Cuidados Paliativos</h3>
                    <p>Terapia complementaria para confort y calidad de vida.</p>
                </div>

                <div class="service-card">
                    <div class="service-icon">🏘️</div>
                    <h3>Fisioterapia Comunitaria</h3>
                    <p>Programas de prevención y promoción de salud en comunidades.</p>
                </div>

                <div class="service-card">
                    <div class="service-icon">⚽</div>
                    <h3>Fisioterapia Deportiva</h3>
                    <p>Tratamiento de lesiones deportivas y mejora del rendimiento.</p>
                </div>

                <div class="service-card">
                    <div class="service-icon">🧠</div>
                    <h3>Fisioterapia Neurológica</h3>
                    <p>Rehabilitación de trastornos neuromotores y neurológicos.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS SECTION -->
    <section id="testimonials" class="testimonials">
        <div class="container">
            <div class="services-header">
                <h2 class="section-title">Lo Que Dicen Nuestros Pacientes</h2>
                <p class="section-subtitle">Historias de recuperación y bienestar</p>
            </div>

            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="stars">★★★★★</div>
                    <p>"Después de un mes de tratamiento, mi dolor de espalda disminuyó significativamente. El equipo es muy profesional y atento."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">MC</div>
                        <div class="author-info">
                            <strong>María Consulta</strong>
                            <small>Paciente satisfecha</small>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="stars">★★★★★</div>
                    <p>"La terapia me ayudó a recuperarme de mi lesión deportiva mucho más rápido de lo que esperaba. ¡Recomendado!"</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">JG</div>
                        <div class="author-info">
                            <strong>Juan García</strong>
                            <small>Atleta profesional</small>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="stars">★★★★★</div>
                    <p>"Excelente atención al detalle. Los fisioterapeutas me explicaron cada paso del proceso. Muy satisfecho con los resultados."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">CR</div>
                        <div class="author-info">
                            <strong>Carlos Rodríguez</strong>
                            <small>Empresario jubilado</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ SECTION -->
    <section id="faq" class="faq">
        <div class="container faq-container">
            <div class="services-header">
                <h2 class="section-title">Preguntas Frecuentes</h2>
                <p class="section-subtitle">Resuelve tus dudas sobre nuestros servicios</p>
            </div>

            <div class="faq-items">
                <div class="faq-item">
                    <button class="faq-question">
                        ¿Cuántas sesiones necesitaré?
                        <span class="faq-toggle">+</span>
                    </button>
                    <div class="faq-answer">
                        El número de sesiones depende de tu condición específica. En la evaluación inicial determinamos un plan personalizado que puede variar entre 4-20 sesiones según la evaluación.
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question">
                        ¿Aceptan seguros médicos?
                        <span class="faq-toggle">+</span>
                    </button>
                    <div class="faq-answer">
                        Sí, trabajamos con la mayoría de seguros médicos del país. Te recomendamos verificar tu cobertura de fisioterapia directamente con tu aseguradora.
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question">
                        ¿Qué debo llevar en mi primera cita?
                        <span class="faq-toggle">+</span>
                    </button>
                    <div class="faq-answer">
                        Trae identificación, historial médico (si tienes), exámenes recientes relevantes, ropa cómoda y cualquier documentación de diagnóstico previo.
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question">
                        ¿Cuánto dura una sesión típica?
                        <span class="faq-toggle">+</span>
                    </button>
                    <div class="faq-answer">
                        Las sesiones de fisioterapia generalmente duran entre 45-60 minutos, incluyendo evaluación, tratamiento y ejercicios de rehabilitación.
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question">
                        ¿Hay horarios disponibles en fines de semana?
                        <span class="faq-toggle">+</span>
                    </button>
                    <div class="faq-answer">
                        Sí, tenemos disponibilidad limitada los sábados. Contáctanos directamente para verificar disponibilidad y reservar tu cita.
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question">
                        ¿Ofrecen terapia a domicilio?
                        <span class="faq-toggle">+</span>
                    </button>
                    <div class="faq-answer">
                        Sí, ofrecemos servicios de fisioterapia a domicilio para pacientes con movilidad limitada. Consulta disponibilidad y tarifas especiales.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container footer-content">
            <div class="footer-section">
                <h4>FisioCare Ayla</h4>
                <p>Clínica especializada en fisioterapia y rehabilitación con profesionales certificados y equipamiento moderno.</p>
                <div class="social-links">
                    <a href="#" class="social-link">f</a>
                    <a href="#" class="social-link">𝕏</a>
                    <a href="#" class="social-link">IG</a>
                    <a href="#" class="social-link">📺</a>
                </div>
            </div>

            <div class="footer-section">
                <h4>Navegación</h4>
                <div class="footer-links">
                    <a href="#hero">Inicio</a>
                    <a href="#services">Servicios</a>
                    <a href="#about">Sobre Nosotros</a>
                    <a href="#testimonials">Testimonios</a>
                    <a href="#faq">Preguntas Frecuentes</a>
                </div>
            </div>

            <div class="footer-section">
                <h4>Contacto</h4>
                <div class="footer-links">
                    <a href="tel:+18095550000">Tel: (809) 555-0000</a>
                    <a href="mailto:info@fisiocare.com">info@fisiocare.com</a>
                    <a href="#">Barahona, República Dominicana</a>
                </div>
            </div>

            <div class="footer-section">
                <h4>Legal</h4>
                <div class="footer-links">
                    <a href="#">Política de Privacidad</a>
                    <a href="#">Términos de Servicio</a>
                    <a href="#">Reserva de Citas</a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} FisioCare Ayla. Todos los derechos reservados. | Diseñado con dedicación a tu bienestar.</p>
        </div>
    </footer>

    <!-- FAQ INTERACTIVITY -->
    <script>
        document.querySelectorAll('.faq-question').forEach(button => {
            button.addEventListener('click', function() {
                const faqItem = this.parentElement;
                faqItem.classList.toggle('active');
            });
        });
    </script>

</body>
</html>
