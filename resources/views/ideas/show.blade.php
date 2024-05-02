<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="pb-3 text-xl">{{ $idea->titulo }}</h1>
                    <p>{{ $idea->descripcion }}</p>
                    <form method="POST" action="{{ route('idea.like', $idea) }}">
                        @csrf
                        @method('put')
                        <div class="mt-4 space-x-8">
                            @if(!auth()->user()->iLikeIt($idea->id))
                                <x-primary-button>
                                    <x-likenegro></x-likenegro>
                                    &nbsp;&nbsp;
                                    Dar Like
                                </x-primary-button>
                            @else
                                <x-primary-button>
                                    <x-likenegroabajo></x-likenegroabajo>
                                    &nbsp;&nbsp;
                                    Quitar Like
                                </x-primary-button>
                            @endif
                            <a href="{{route('idea.index')}}" class="dark:text-gray-100">Atras</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
