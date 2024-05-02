<x-app-layout>
    <style>
        @media (max-width: 700px) {
            #mensaje {
                width: 90%;
                margin: 0 auto;
            }
        }
    </style>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if(session()->has('message'))
                <div class="p-2 text-center bg-gray-100 rounded-md" id="mensaje">
                    <span class="text-xl font-semibold text-indigo-600">{{ session('message') }}</span>
                </div>
            @endif
            @if(session()->has('error'))
                <div class="p-2 text-center bg-gray-100 rounded-md" id="mensaje">
                    <span class="text-xl font-semibold text-indigo-600">{{ session('error') }}</span>
                </div>
            @endif
            <div class="mb-4 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-x-8 text-gray-900 dark:text-gray-100s">
                    <a href="{{route('idea.create')}}" class="px-4 py-4 text-sm font-semibold tracking-widest text-gray-700 uppercase bg-white border border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:border-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Crear</a>
                    <a href="#" class="px-4 py-4 text-sm font-semibold tracking-widest text-gray-700 uppercase bg-white border border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:border-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Las mejores</a>
                </div>
            </div>
            <div class="bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                @forelse($ideas as $idea)
                    <div class="flex p-6 space-x-2">
                        <x-bulb></x-bulb>
                        <div class="flex-1 pl-3">
                            <div class="flex items-center justify-between">
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
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>
                                        </x-slot>
                                        <x-slot name="content">
                                            <x-dropdown-link :href="route('idea.show', $idea)">
                                                Ver
                                            </x-dropdown-link>
                                            @can('update', $idea)
                                                <x-dropdown-link :href="route('idea.edit', $idea)">
                                                    Editar
                                                </x-dropdown-link>
                                            @endcan
                                            @can('delete', $idea)
                                                <form method="POST" action="{{ route('idea.delete', $idea) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <x-dropdown-link href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                                        Eliminar
                                                    </x-dropdown-link>
                                                </form>
                                            @endcan
                                        </x-slot>
                                    </x-dropdown>
                                @endauth
                            </div>
                            <p class="mt-3 text-lg text-gray-900 dark:text-gray-100">{{ $idea->titulo }}</p>
                            @can('like', $idea)
                                <form method="POST" action="{{ route('idea.likeIndex', $idea->id) }}">
                                    @csrf
                                    @method('put')
                                    <button>
                                    <small class="flex mt-3 text-sm text-gray-400">
                                        @if(auth()->user()->iLikeIt($idea->id))
                                        <x-like></x-like>
                                        <span class="ml-2">&nbsp;&nbsp;{{ $idea -> likes }}&nbsp;&nbsp;&nbsp;Te gusta</span>
                                        @else
                                        <x-like></x-like>
                                        <span class="ml-2">&nbsp;&nbsp;{{ $idea -> likes }}</span>
                                        @endif
                                    </small>
                                </form>
                            @endcan
                            @cannot('like', $idea)
                                <small class="flex mt-3 text-sm text-gray-400">
                                    <x-like></x-like>
                                    <span class="ml-2">&nbsp;&nbsp;{{ $idea -> likes }}</span>
                                </small>
                            @endcannot
                        </div>
                    </div>
                @empty
                    <h2 class="p-4 text-xl text-white">No hay ninguna idea publicada</h2>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
