<x-layouts.auth :title="'Iniciar Sesión - FisioCare Ayla'" :heading="'Iniciar Sesión'" :subheading="'Accede a tu cuenta de FisioCare Ayla'">
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <x-ui.input type="email" name="email" label="Correo Electrónico" :value="old('email')" required autofocus />

        <x-ui.input type="password" name="password" label="Contraseña" required />

        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center gap-2 text-slate-600">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-primary focus:ring-primary" {{ old('remember') ? 'checked' : '' }}>
                Recuérdame
            </label>
            <a href="{{ route('password.request') }}" class="font-medium text-primary hover:text-accent-dark">¿Olvidaste tu contraseña?</a>
        </div>

        <x-ui.button type="submit" class="w-full justify-center">Iniciar Sesión</x-ui.button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        ¿No tienes cuenta? <a href="{{ route('register') }}" class="font-semibold text-primary hover:text-accent-dark">Regístrate aquí</a>
    </p>
</x-layouts.auth>
