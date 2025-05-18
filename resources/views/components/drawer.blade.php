<div x-data="{ open: false, dropdownOpen: false }" class="sticky top-0 z-50 bg-white shadow px-4 py-2 flex justify-between items-center">

    <button @click="open = true"
        class="inline-flex items-center justify-center rounded-xl bg-white px-3 py-2 text-gray-700 transition hover:bg-gray-100 hover:text-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-300 cursor-pointer">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
    </button>

    <div class="relative">
        <button @click="dropdownOpen = !dropdownOpen"
            class="inline-flex items-center justify-center rounded-full w-10 h-10 bg-gray-100 text-gray-600 hover:text-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-300 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zm-9 12a6 6 0 0112 0v.75a.75.75 0 01-.75.75H7.5a.75.75 0 01-.75-.75V18z" />
            </svg>
        </button>

        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-cloak
            class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                Perfil
            </a>
            <form method="POST" action="{{ route('login.destroy') }}">
                @csrf
                <button type="submit"
                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 cursor-pointer">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>

    <div x-show="open" x-cloak x-transition.opacity @click="open = false" class="fixed inset-0 bg-black/40 z-40"></div>

    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed top-0 left-0 w-64 h-full bg-white shadow-lg z-50 overflow-y-auto">
        <nav class="p-4 space-y-1">
            <h2 class="text-lg font-bold text-gray-700 mb-4">Menú</h2>

            <a href="{{ route('home') }}"
                class="
                    flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                    {{ request()->routeIs('home') ? 'bg-gray-200 text-primary-700' : 'text-gray-700 hover:bg-gray-100' }}
                ">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 9.75L12 3l9 6.75v10.5a.75.75 0 01-.75.75h-5.25v-6.75H9v6.75H3.75a.75.75 0 01-.75-.75V9.75z" />
                </svg>
                <span>Home</span>
            </a>

            <a href="{{ route('encuesta.index') }}"
                class="
                    flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                    {{
                        request()->routeIs([
                            'encuesta.index',
                            'encuesta.create',
                            'encuesta.response',
                            'encuesta.edit',
                            'encuesta.view'
                        ])
                        ? 'bg-gray-200 text-primary-700'
                        : 'text-gray-700 hover:bg-gray-100'
                    }}
                "
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-6">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25M9 16.5v.75m3-3v3M15 12v5.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"
                    />
                </svg>
                <span>Encuestas</span>
            </a>

            <a
                href="{{ route('tipoEncuesta.index') }}"
                class="
                    flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                    {{
                        request()->routeIs('tipoEncuesta.index')
                        ? 'bg-gray-200 text-primary-700'
                        : 'text-gray-700 hover:bg-gray-100'
                    }}
                "
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-6">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z"
                    />
                </svg>
                <span>Tipo Encuesta</span>
            </a>

            <a
                href="{{ route('tipoCita.index') }}"
                class="
                    flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                    {{
                        request()->routeIs('tipoCita.index')
                        ? 'bg-gray-200 text-primary-700'
                        : 'text-gray-700 hover:bg-gray-100'
                    }}
                "
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
                        d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 6h.008v.008H6V6Z"
                    />
                </svg>
                <span>Tipo Cita</span>
            </a>

            <a href="{{ route('area.index') }}"
                class="
                    flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                    {{ request()->routeIs('area.index') ? 'bg-gray-200 text-primary-700' : 'text-gray-700 hover:bg-gray-100' }}
                ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>

                <span>Areas</span>
            </a>

            <!-- Nivel de Satisfacción -->
            <a href="{{ route('nivel_satisfaccion.index') }}" @click="open = false"
                class="
                    flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                    {{ request()->routeIs('nivel_satisfaccion.*')
                        ? 'bg-gray-200 text-primary-700'
                        : 'text-gray-700 hover:bg-gray-100' }}
                ">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <!-- un icono apropiado, por ejemplo un gráfico de barras -->
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M9 17V9m4 8V5m4 12v-4" />
                </svg>
                <span>Nivel Satisfacción</span>
            </a>

            <!-- Especialidades -->
            <a href="{{ route('especialidad.index') }}" @click="open = false"
                class="flex items-center px-3 py-2 rounded-lg text-sm font-medium
           {{ request()->routeIs('especialidad.*') ? 'bg-gray-200 text-primary-700' : 'text-gray-700 hover:bg-gray-100' }}">
                <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <!-- icono examples: clipboard list -->
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2
             0 00-2-2h-2M9 3h6a2 2 0 012 2v0a2 2 0 01-2 2H9a2 2 0
             01-2-2v0a2 2 0 012-2z" />
                </svg>
                <span>Especialidades</span>
            </a>
        </nav>
    </div>
</div>
