<div class="flex justify-center py-10 px-4">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Detalle de Bitácora #{{ $bitacora->id }}</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Información básica -->
                <div>
                    <p class="font-semibold">Acción:</p>
                    <p>
                        @switch($bitacora->tipoAccion)
                            @case(1) <span class="text-green-600">Creación</span> @break
                            @case(2) <span class="text-blue-600">Actualización</span> @break
                            @case(3) <span class="text-red-600">Eliminación</span> @break
                            @default <span>Desconocido</span>
                        @endswitch
                    </p>
                </div>

                <div>
                    <p class="font-semibold">ID Registro Afectado:</p>
                    <p>{{ $bitacora->idRegistro }}</p>
                </div>

                <div>
                    <p class="font-semibold">Usuario:</p>
                    <p>{{ $bitacora->usuario->name ?? 'N/A' }}</p>
                </div>

                <div>
                    <p class="font-semibold">Fecha:</p>
                    <p>{{ $bitacora->created_at->format('d/m/Y H:i:s') }}</p>
                </div>
            </div>

            <!-- Descripción en CSV -->
            <div class="mt-6">
                <p class="font-semibold mb-2">Detalles (CSV):</p>
                <div class="bg-gray-100 p-3 rounded overflow-x-auto">
                    <pre class="text-sm">{{ $bitacora->descripcion }}</pre>
                </div>
            </div>

            <!-- Botón para volver -->
            <div class="mt-6">
                <a 
                    href="{{ route('bitacora.index') }}" 
                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600"
                >
                    ← Volver al listado
                </a>
            </div>
        </div>
    </div>
</div>