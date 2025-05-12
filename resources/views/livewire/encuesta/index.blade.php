<div class="flex justify-center py-10 px-4">
    <div class="bg-white/90 backdrop-blur-md rounded-[36px] shadow ring-1 ring-slate-200/50 w-full max-w-[1100px] mx-auto px-10 py-12">

        <div class="sticky top-4 z-10 p-4 rounded-xl flex flex-wrap items-center gap-4 mb-4">
            @if (session()->has('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif
            
            <p class="text-4xl font-medium text-slate-900">Encuestas</p>

            <a 
                href="{{ route('encuesta.create') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition bg-gray-200 text-primary-700 hover:bg-gray-300"
            >
                <svg 
                    xmlns="http://www.w3.org/2000/svg" 
                    fill="none"
                    viewBox="0 0 24 24" 
                    stroke-width="1.5" 
                    stroke="currentColor" 
                    class="size-6"
                >
                    <path 
                        stroke-linecap="round" 
                        stroke-linejoin="round" 
                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" 
                    />
              </svg>              
                <span>Crear</span>
            </a>
        </div>

        <div class="mt-6 overflow-y-auto" style="max-height: 400px;">
            <ul class="divide-y divide-gray-200">
                @foreach($encuestas as $encuesta)
                    <li class="flex items-center justify-between py-4">
                        <div class="flex items-start space-x-4">

                            <x-avatar 
                                :label="substr($encuesta->tituloEncuesta, 0, 2)" 
                                size="md" 
                                class="bg-blue-100 text-blue-700" 
                            />

                            <div class="space-y-1">
                                <div class="flex items-baseline space-x-2">

                                    <x-mini-button 
                                        href="#" 
                                        rounded 
                                        flat 
                                        warning
                                    >
                                        <svg 
                                            xmlns="http://www.w3.org/2000/svg" 
                                            fill="none" 
                                            viewBox="0 0 24 24" 
                                            stroke-width="1.5" 
                                            stroke="currentColor" 
                                            class="size-4">
                                            <path 
                                                stroke-linecap="round" 
                                                stroke-linejoin="round" 
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" 
                                            />
                                        </svg>
                                    </x-mini-button>

                                    <p class="text-lg font-medium text-slate-900">
                                        {{ $encuesta->tituloEncuesta }} 
                                        <span class="text-sm text-gray-500">
                                            ({{ $encuesta->codigoEncuesta }})
                                        </span>
                                    </p>

                                    {{-- Fecha --}}
                                    <time class="text-sm text-gray-400">
                                        {{ optional($encuesta->created_at)->format('d M Y') }}
                                    </time>
                                </div>

                                <p class="text-sm text-gray-700">
                                    {{ $encuesta->descripcionEncuesta }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ $encuesta->area->nombreArea }}, 
                                    {{ $encuesta->tipoEncuesta->nombreTipoEncuesta }}, 
                                    {{ $encuesta->tipoCita->tipoCita }}
                                </p>

                                {{-- Estado --}}
                                @if($encuesta->estadoEncuesta)
                                    <x-badge flat green label="Activo" />
                                @else
                                    <x-badge flat red   label="Inactivo" />
                                @endif
                            </div>
                        </div>

                        <div class="flex space-x-2">
                            <x-mini-button 
                                href="#"
                                rounded 
                                flat 
                                green 
                                icon="eye" 
                                title="Ver encuesta" 
                            />

                            <x-mini-button 
                                href="#"
                                rounded 
                                flat 
                                blue
                            >
                                <svg 
                                    xmlns="http://www.w3.org/2000/svg" 
                                    fill="none" 
                                    viewBox="0 0 24 24" 
                                    stroke-width="1.5" 
                                    stroke="currentColor" 
                                    class="w-4 h-4">
                                <path 
                                    stroke-linecap="round" 
                                    stroke-linejoin="round" 
                                    d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 
                                        4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 
                                        1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 
                                        4.5a4.5 4.5 0 0 0 1.242 7.244" 
                                    />
                                </svg>
                            </x-mini-button>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div>
            {{ $encuestas->links() }}
        </div>
    </div>
</div>
