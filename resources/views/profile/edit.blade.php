<x-layouts.internal :title="'Mi Perfil - FisioCare Ayla'">
    <x-ui.page-header title="Mi Perfil" subtitle="Gestiona tu información personal y de seguridad" />

    @if (session('status') === 'profile-updated')
        <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            <i class="fa-solid fa-check"></i> Perfil actualizado correctamente
        </div>
    @endif

    <div class="mx-auto max-w-2xl space-y-6">
        <x-ui.card>
            @include('profile.partials.update-profile-information-form')
        </x-ui.card>

        <x-ui.card>
            @include('profile.partials.update-password-form')
        </x-ui.card>

        <x-ui.card class="border-red-200">
            @include('profile.partials.delete-user-form')
        </x-ui.card>
    </div>
</x-layouts.internal>
