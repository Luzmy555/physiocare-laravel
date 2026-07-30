<x-layouts.auth :title="'Confirmar Contraseña - FisioCare Ayla'" :heading="'Confirmar Contraseña'" :subheading="'Esta es un área segura. Confirma tu contraseña antes de continuar.'">
    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <x-ui.input type="password" name="password" label="Contraseña" required autocomplete="current-password" autofocus />

        <x-ui.button type="submit" class="w-full justify-center">Confirmar</x-ui.button>
    </form>
</x-layouts.auth>
