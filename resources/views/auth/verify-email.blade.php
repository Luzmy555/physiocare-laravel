<x-layouts.auth :title="'Verificar Correo - FisioCare Ayla'" :heading="'Verifica tu Correo'">
    <p class="mb-6 text-sm text-slate-600">
        ¡Gracias por registrarte! Antes de comenzar, ¿podrías verificar tu correo electrónico haciendo clic en el enlace que te enviamos? Si no recibiste el correo, con gusto te enviamos otro.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
            Se ha enviado un nuevo enlace de verificación al correo que registraste.
        </div>
    @endif

    <div class="flex items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-ui.button type="submit">Reenviar Correo de Verificación</x-ui.button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm font-medium text-slate-500 underline hover:text-ink">
                Cerrar Sesión
            </button>
        </form>
    </div>
</x-layouts.auth>
