<x-layouts.internal :title="'Mi Horario - FisioCare Ayla'">
    <x-ui.card padding="p-0">
        <div class="flex flex-col items-center justify-between gap-4 border-b border-slate-100 px-6 py-4 md:flex-row">
            <div>
                <h1 class="text-xl font-bold text-ink">Agenda Semanal: {{ auth()->user()->name }}</h1>
                <p class="text-sm text-slate-500">{{ now()->startOfWeek()->format('d M') }} - {{ now()->endOfWeek()->format('d M, Y') }}</p>
            </div>

            <button onclick="window.print()" class="print:hidden flex items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-ink hover:bg-slate-100">
                <i class="fa-solid fa-print"></i> Imprimir Agenda
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-fixed border-collapse">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="w-20 border-b border-slate-200 p-2 text-xs font-bold uppercase text-ink">Hora</th>
                        @foreach(['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'] as $diaLabel)
                            <th class="border-b border-l border-slate-200 p-2 text-sm font-bold text-ink">{{ $diaLabel }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                        $horas = ['08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00'];
                        $diasEspanol = ['lunes','martes','miercoles','jueves','viernes','sabado','domingo'];
                    @endphp

                    @foreach($horas as $hora)
                        <tr>
                            <td class="border-r border-slate-100 p-2 text-center">
                                <span class="text-[11px] font-bold text-ink">{{ $hora }}</span>
                            </td>

                            @foreach($diasEspanol as $index => $dia)
                                @php
                                    $horario = $horariosPorDia[$dia]->firstWhere('hora_inicio', $hora);
                                    $colores = ['bg-blue-50 text-blue-700', 'bg-pink-50 text-pink-700', 'bg-purple-50 text-purple-700', 'bg-green-50 text-green-700', 'bg-amber-50 text-amber-700'];
                                    $colorActual = $colores[$index % count($colores)];
                                @endphp
                                <td class="h-16 border-l border-slate-100 p-1">
                                    @if($horario && $horario->disponible)
                                        <div class="{{ $colorActual }} flex h-full w-full flex-col justify-center rounded border border-current/10 p-2 text-center">
                                            <span class="block text-[10px] font-bold uppercase leading-tight">Disponible</span>
                                            <span class="text-[11px] font-black leading-tight">
                                                {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }}
                                            </span>
                                        </div>
                                    @else
                                        <div class="h-full w-full"></div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-ui.card>

    <style>
        @media print {
            body { padding: 0; }
        }
    </style>
</x-layouts.internal>
