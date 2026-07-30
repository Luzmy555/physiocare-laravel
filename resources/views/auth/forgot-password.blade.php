<x-layouts.auth :title="'Recuperar Contraseña - FisioCare Ayla'" :heading="'Recuperar Contraseña'" :subheading="'¿Olvidaste tu contraseña? Ingresa tu correo electrónico y te enviaremos un enlace para restablecerla.'">
    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <x-ui.input type="email" name="email" label="Correo Electrónico" :value="old('email')" required autofocus />

        <x-ui.button type="submit" class="w-full justify-center">Enviar Enlace de Recuperación</x-ui.button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        ¿Recordaste tu contraseña? <a href="{{ route('login') }}" class="font-semibold text-primary hover:text-accent-dark">Inicia sesión</a>
    </p>
</x-layouts.auth>
