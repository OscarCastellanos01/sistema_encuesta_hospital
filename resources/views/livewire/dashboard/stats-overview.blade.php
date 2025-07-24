<div class="flex justify-center py-10 px-4">
    <div
        class="bg-white/90 backdrop-blur-md rounded-[36px] shadow ring-1 ring-slate-200/50 w-full max-w-[1100px] mx-auto px-10 py-12 space-y-8">
        <h2 class="text-xl font-bold">Estadística de Encuestas</h2>
        <x-card title="Encuestas Totales" icon="document-text" class="hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div class="text-3xl font-bold text-primary-600">{{ $totalSurveys }}</div>
                <x-badge label="Total" />
            </div>
            <x-slot name="footer">
            
            </x-slot>
        </x-card>

        <!-- Respuestas -->
        <x-card title="Respuestas" icon="check-circle" class="hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div class="text-3xl font-bold text-primary-600">{{ $totalResponses }}</div>
                <x-badge label="Recibidas" />
            </div>
            <x-slot name="footer">
                
            </x-slot>
        </x-card>


        <!-- Facilitadores Activos -->
        <x-card title="Facilitadores Activos" icon="users" class="hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div class="text-3xl font-bold text-primary-600">{{ $activeFacilitators }}</div>
                <x-badge label="Activos" />
            </div>
            <x-slot name="footer">
               
            </x-slot>
        </x-card>

        <!-- Satisfacción Promedio -->
        <x-card title="Satisfacción" icon="emoji-happy" class="hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div class="text-3xl font-bold text-primary-600">{{ $satisfactionRate }}/100</div>
                <x-badge label="Promedio" />
            </div>
            <x-slot name="footer">
               
            </x-slot>
        </x-card>
    </div>
</div>
