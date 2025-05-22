<div class="flex justify-center py-10 px-4">
    <!-- Encuestas Totales -->
    <x-card title="Encuestas Totales" icon="document-text" class="hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div class="text-3xl font-bold text-primary-600">{{ $totalSurveys }}</div>
            <x-badge positive label="Total" />
        </div>
        <x-slot name="footer">
            <x-button
                icon="information-circle" 
                wire:click="$emit('openModal', 'dashboard.metrics-detail', {{ json_encode(['metric' => 'totalSurveys']) }})"
                class="text-gray-400 hover:text-primary-500"
                xs
            />
        </x-slot>
    </x-card>

    <!-- Respuestas -->
    <x-card title="Respuestas" icon="check-circle" class="hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div class="text-3xl font-bold text-green-600">{{ $totalResponses }}</div>
            <x-badge green label="Recibidas" />
        </div>
        <x-slot name="footer">
            <x-button
                icon="information-circle" 
                wire:click="$emit('openModal', 'dashboard.metrics-detail', {{ json_encode(['metric' => 'totalResponses']) }})"
                class="text-gray-400 hover:text-green-500"
                xs
            />
        </x-slot>
    </x-card>

    <!-- Tasa de Respuesta -->
    <x-card title="Tasa de Respuesta" icon="trending-up" class="hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div class="text-3xl font-bold text-purple-600">{{ $responseRate }}%</div>
            <x-badge purple label="Participación" />
        </div>
        <x-slot name="footer">
            <x-button
                icon="information-circle" 
                wire:click="$emit('openModal', 'dashboard.metrics-detail', {{ json_encode(['metric' => 'responseRate']) }})"
                class="text-gray-400 hover:text-purple-500"
                xs
            />
        </x-slot>
    </x-card>

    <!-- Facilitadores Activos -->
    <x-card title="Facilitadores Activos" icon="users" class="hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div class="text-3xl font-bold text-yellow-600">{{ $activeFacilitators }}</div>
            <x-badge yellow label="Activos" />
        </div>
        <x-slot name="footer">
            <x-button
                icon="information-circle" 
                wire:click="$emit('openModal', 'dashboard.metrics-detail', {{ json_encode(['metric' => 'activeFacilitators']) }})"
                class="text-gray-400 hover:text-yellow-500"
                xs
            />
        </x-slot>
    </x-card>

    <!-- Satisfacción Promedio -->
    <x-card title="Satisfacción" icon="emoji-happy" class="hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div class="text-3xl font-bold text-red-600">{{ $satisfactionRate }}/5</div>
            <x-badge red label="Promedio" />
        </div>
        <x-slot name="footer">
            <x-button 
                icon="information-circle" 
                wire:click="$emit('openModal', 'dashboard.metrics-detail', {{ json_encode(['metric' => 'satisfactionRate']) }})"
                class="text-gray-400 hover:text-red-500"
                xs
            />
        </x-slot>
    </x-card>
</div>