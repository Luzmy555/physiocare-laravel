@php
    $navRol = Auth::user() && Auth::user()->rol ? Auth::user()->rol->nombre_rol : null;
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'FisioCare Ayla' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-inter text-ink antialiased">
    <div class="flex min-h-screen">
        <!-- SIDEBAR -->
        <aside class="fixed inset-y-0 left-0 z-30 hidden w-64 flex-col border-r border-slate-200 bg-white lg:flex">
            <div class="flex items-center gap-3 border-b border-slate-100 px-6 py-5">
                <img src="{{ asset('images/logo.jpg') }}" alt="FisioCare Ayla" class="h-10 w-10 rounded-lg object-cover">
                <div class="leading-tight">
                    <p class="font-poppins text-sm font-bold text-ink">FisioCare Ayla</p>
                    <p class="text-xs text-slate-400">Panel interno</p>
                </div>
            </div>

            <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
                @php
                    $navLink = function ($href, $icon, $text, $active = false) {
                        $base = 'flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition';
                        $state = $active
                            ? ' bg-primary/10 text-primary'
                            : ' text-slate-600 hover:bg-slate-50 hover:text-primary';
                        return "<a href=\"{$href}\" class=\"{$base}{$state}\"><i class=\"fa-solid {$icon} w-4 text-center\"></i><span>{$text}</span></a>";
                    };
                    $current = request()->route()?->getName();
                @endphp

                @if($navRol === 'admin')
                    {!! $navLink(route('dashboard'), 'fa-house', 'Panel', $current === 'dashboard') !!}
                    {!! $navLink(route('admin.usuarios.index'), 'fa-users', 'Usuarios', str_starts_with($current ?? '', 'admin.usuarios')) !!}
                    {!! $navLink(route('admin.medicos.index'), 'fa-user-doctor', 'Fisioterapeutas', str_starts_with($current ?? '', 'admin.medicos')) !!}
                    {!! $navLink(route('especialidades.index'), 'fa-hospital', 'Especialidades', str_starts_with($current ?? '', 'especialidades')) !!}
                    {!! $navLink(route('pacientes.index'), 'fa-user-injured', 'Pacientes', str_starts_with($current ?? '', 'pacientes')) !!}
                    {!! $navLink(route('historiales.index'), 'fa-notes-medical', 'Historiales', str_starts_with($current ?? '', 'historiales')) !!}
                    {!! $navLink(route('admin.citas.index'), 'fa-calendar-check', 'Citas', str_starts_with($current ?? '', 'admin.citas')) !!}
                    {!! $navLink(route('roles.index'), 'fa-user-shield', 'Roles', str_starts_with($current ?? '', 'roles')) !!}
                @elseif($navRol === 'fisioterapeuta' || $navRol === 'medico')
                    {!! $navLink(route('dashboard'), 'fa-house', 'Inicio', $current === 'dashboard') !!}
                    {!! $navLink(route('medico.mis-citas'), 'fa-calendar-days', 'Mis Citas', str_starts_with($current ?? '', 'medico.mis-citas')) !!}
                    {!! $navLink(route('medico.mis-pacientes'), 'fa-clipboard-list', 'Historiales Clínicos', str_starts_with($current ?? '', 'medico.mis-pacientes')) !!}
                    {!! $navLink(route('medico.mi-horario'), 'fa-clock', 'Mi Horario', str_starts_with($current ?? '', 'medico.mi-horario')) !!}
                @else
                    {!! $navLink(route('dashboard'), 'fa-house', 'Inicio', $current === 'dashboard') !!}
                    {!! $navLink(route('citas.publicas.create'), 'fa-calendar-plus', 'Agendar Cita', false) !!}
                @endif
            </nav>

            <div class="space-y-1 border-t border-slate-100 px-3 py-4">
                {!! $navLink(route('profile.edit'), 'fa-user', 'Mi Perfil', str_starts_with($current ?? '', 'profile')) !!}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left text-sm font-medium text-red-500 transition hover:bg-red-50">
                        <i class="fa-solid fa-right-from-bracket w-4 text-center"></i>
                        <span>Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- MOBILE TOPBAR -->
        <header class="fixed inset-x-0 top-0 z-20 flex items-center justify-between border-b border-slate-200 bg-white px-4 py-3 lg:hidden">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/logo.jpg') }}" alt="FisioCare Ayla" class="h-8 w-8 rounded-lg object-cover">
                <span class="font-poppins text-sm font-bold text-ink">FisioCare Ayla</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="flex h-9 w-9 items-center justify-center rounded-full bg-primary/10 text-sm font-bold text-primary">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </a>
        </header>

        <!-- MAIN -->
        <main class="min-h-screen flex-1 px-4 py-6 pt-20 lg:ml-64 lg:px-8 lg:py-8 lg:pt-8">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
