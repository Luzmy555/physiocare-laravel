<x-layouts.auth :title="'Restablecer Contraseña - FisioCare Ayla'" :heading="'Restablecer Contraseña'" :subheading="'Elige una nueva contraseña para tu cuenta.'">
    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <x-ui.input type="email" name="email" label="Correo Electrónico" :value="old('email', $request->email)" required autofocus autocomplete="username" />

        <x-ui.input type="password" name="password" label="Nueva Contraseña" required autocomplete="new-password" />

        <x-ui.input type="password" name="password_confirmation" label="Confirmar Contraseña" required autocomplete="new-password" />

        <x-ui.button type="submit" class="w-full justify-center">Restablecer Contraseña</x-ui.button>
    </form>
</x-layouts.auth>
