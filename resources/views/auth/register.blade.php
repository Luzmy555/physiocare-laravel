<x-layouts.auth :title="'Registrarse - FisioCare Ayla'" :heading="'Crear Cuenta'" :subheading="'Regístrate en FisioCare Ayla'">
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <x-ui.input type="text" name="name" label="Nombre Completo" :value="old('name')" required autofocus />

        <x-ui.input type="email" name="email" label="Correo Electrónico" :value="old('email')" required />

        <x-ui.input type="password" name="password" label="Contraseña" required />

        <x-ui.input type="password" name="password_confirmation" label="Confirmar Contraseña" required />

        <x-ui.button type="submit" class="w-full justify-center">Registrarse</x-ui.button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="font-semibold text-primary hover:text-accent-dark">Inicia sesión aquí</a>
    </p>
</x-layouts.auth>
