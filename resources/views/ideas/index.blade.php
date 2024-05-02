<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session()->has('message'))
                <div class="text-center bg-gray-100 rounded-md p-2">
                    <span class="text-indigo-600 text-xl font-semibold">{{ session('message') }}</span>
                </div>
            @endif
            <div class="overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 text-gray-900 dark:text-gray-100s space-x-8">
                    <a href="{{route('idea.create')}}" class="px-4 py-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">Crear</a>
                    <a href="#" class="px-4 py-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">Las mejores</a>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                @forelse($ideas as $idea)
                    <div class="p-6 flex space-x-2">
                        <x-bulb></x-bulb>
                        <div class="flex-1 pl-3">
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-gray-800 dark:text-gray-100">&nbsp;&nbsp;{{ $idea->user->name }}</span>
                                    <small class="ml-2 text-sm text-gray-600 dark:text-gray-100">{{ $idea->created_at->format('d/m/Y') }}</small>
                                    @unless($idea->created_at->eq($idea->updated_at))
                                        <small class="text-sm text-gray-400"> &middot; Editado</small>
                                    @endunless
                                </div>
                                @auth
                                    <x-dropdown>
                                        <x-slot name="trigger">
                                            <button>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>
                                        </x-slot>
                                        <x-slot name="content">
                                            <x-dropdown-link :href="route('idea.show', $idea)">
                                                Ver
                                            </x-dropdown-link>
                                            <x-dropdown-link :href="route('idea.edit', $idea)">
                                                Editar
                                            </x-dropdown-link>
                                            <form method="POST" action="{{ route('idea.delete', $idea) }}">
                                                @csrf
                                                @method('delete')
                                                <x-dropdown-link href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                                    Eliminar
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                @endauth
                            </div>
                            <p class="mt-3 text-lg text-gray-900 dark:text-gray-100">{{ $idea->titulo }}</p>
                            <small class="text-sm text-gray-400 flex mt-3">
                                <x-like></x-like>
                                <span class="ml-2">&nbsp;&nbsp;{{ $idea -> likes }}</span>
                            </small>
                        </div>
                    </div>
                @empty
                    <h2 class="text-xl text-white p-4">No hay ninguna idea publicada</h2>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>