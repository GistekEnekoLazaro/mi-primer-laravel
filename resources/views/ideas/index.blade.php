<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 text-gray-900 dark:text-gray-100s space-x-8">
                    <a href="#" class="px-4 py-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">{{ __('Agregar') }}</a>
                    <a href="#" class="px-4 py-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">{{ __('Las Mejores') }}</a>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                @forelse($ideas as $idea)
                    <div class="p-6 flex space-x-2">
                        <x-bulb></x-bulb>
                        <div class="flex-1 pl-3">
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-gray-800 dark:text-gray-100">{{ $idea->user()->name }}</span>
                                    <small class="ml-2 text-sm text-gray-600 dark:text-gray-100">{{ $idea->created_at }}</small>
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
                                            <x-dropdown-link :href="$myroute='zzz'">
                                                {{ __('Ver') }}
                                            </x-dropdown-link>
                                            <x-dropdown-link :href="$myroute='zzz'">
                                                {{ __('Edit') }}
                                            </x-dropdown-link>
                                            <form method="POST" action="">
                                                @csrf
                                                @method('delete')
                                                <x-dropdown-link :href="$myroute='zzz'" onclick="event.preventDefault(); this.closest('form').submit();">
                                                    {{ __('Delete') }}
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                @endauth
                            </div>
                            <p class="mt-3 text-lg text-gray-900 dark:text-gray-100">{{ $idea->titulo }}</p>
                            <small class="text-sm text-gray-400 flex mt-3">
                                <svg width="16px" height="16px" viewBox="0 -0.5 21 21" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#ffffff" stroke="#ffffff" transform="rotate(0)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>like [#1385]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-259.000000, -760.000000)" fill="#ffffff"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M203,620 L207.200006,620 L207.200006,608 L203,608 L203,620 Z M223.924431,611.355 L222.100579,617.89 C221.799228,619.131 220.638976,620 219.302324,620 L209.300009,620 L209.300009,608.021 L211.104962,601.825 C211.274012,600.775 212.223214,600 213.339366,600 C214.587817,600 215.600019,600.964 215.600019,602.153 L215.600019,608 L221.126177,608 C222.97313,608 224.340232,609.641 223.924431,611.355 L223.924431,611.355 Z" id="like-[#1385]"> </path> </g> </g> </g> </g></svg>
                                <span class="ml-2">{{ $ideas->likes }}</span>
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