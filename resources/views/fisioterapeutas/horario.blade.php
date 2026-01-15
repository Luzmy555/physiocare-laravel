@extends('layouts.app', ['showNavbar' => false])

@section('content')
<div class="min-h-screen bg-gray-100 py-6 px-2">
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">

        <div class="px-6 py-4 border-b border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-xl font-bold text-black">Agenda Semanal: {{ auth()->user()->name }}</h1>
                <p class="text-sm text-gray-600">{{ now()->startOfWeek()->format('d M') }} - {{ now()->endOfWeek()->format('d M, Y') }}</p>
            </div>

            <button onclick="window.print()"
                class="flex items-center px-4 py-2 bg-gray-100 border border-gray-300 text-black text-sm font-bold rounded hover:bg-gray-200 transition-all shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                IMPRIMIR AGENDA
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse table-fixed">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="w-20 p-2 text-xs font-bold text-black uppercase border-b border-gray-200">Hora</th>
                        @foreach(['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'] as $diaLabel)
                            <th class="p-2 text-sm font-bold text-black border-b border-l border-gray-200">{{ $diaLabel }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        $horas = ['08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00'];
                        $diasEspanol = ['lunes','martes','miercoles','jueves','viernes','sabado','domingo'];
                    @endphp

                    @foreach($horas as $hora)
                        <tr>
                            <td class="p-2 text-center border-r border-gray-100">
                                <span class="text-[11px] font-bold text-black">{{ $hora }}</span>
                            </td>

                            @foreach($diasEspanol as $index => $dia)
                                @php
                                    $horario = $horariosPorDia[$dia]->firstWhere('hora_inicio', $hora);
                                    // Colores pasteles suaves como en tu imagen de referencia
                                    $colores = ['bg-blue-50 text-blue-700', 'bg-pink-50 text-pink-700', 'bg-purple-50 text-purple-700', 'bg-green-50 text-green-700', 'bg-yellow-50 text-yellow-700'];
                                    $colorActual = $colores[$index % count($colores)];
                                @endphp
                                <td class="p-1 border-l border-gray-100 h-16">
                                    @if($horario && $horario->disponible)
                                        <div class="{{ $colorActual }} h-full w-full p-2 rounded text-center flex flex-col justify-center border border-current border-opacity-10">
                                            <span class="text-[10px] font-bold block uppercase leading-tight">Disponible</span>
                                            <span class="text-[11px] font-black text-black leading-tight">
                                                {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }}
                                            </span>
                                        </div>
                                    @else
                                        <div class="h-full w-full bg-transparent"></div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {
        .bg-gray-100 { background-color: white !important; }
        button { display: none !important; }
        .shadow-md { shadow: none !important; }
        body { padding: 0; }
    }
     /* Forzar texto negro SOLO en esta vista */
    .min-h-screen,
    .min-h-screen * {
        color: #000 !important;
    }

    @media print {
        .bg-gray-100 { background-color: white !important; }
        button { display: none !important; }
        .shadow-md { box-shadow: none !important; }
        body { padding: 0; }
    }
</style>
@endsection
