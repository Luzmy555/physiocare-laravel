<header class="navbar">
    <div class="nav-content">
    <!-- LOGO (izquierda) -->
        <a href="{{ url('/') }}" class="logo">
            <img src="{{ asset('images/logo.jpg') }}" alt="FisioCare Ayla Logo" class="logo-img">
            <div class="logo-text">
                <strong>FisioCare Ayla</strong>
                <small>Clínica de Fisioterapia</small>
            </div>
        </a>



        <!-- BOTONES DERECHA -->
        <div class="nav-buttons">
            @guest
                <a href="{{ route('login') }}" class="btn-login">Iniciar Sesión</a>
                <a href="{{ route('register') }}" class="btn-register">Registrarse</a>
            @else
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="btn-register">Cerrar sesión</button>
                </form>
            @endguest
        </div>
    </div>
</header>


