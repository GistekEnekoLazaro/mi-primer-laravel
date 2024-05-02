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
            @if(session()->has('error'))
            <div class="row">
                <div class="p-2 text-center bg-gray-100 rounded-md col-10" id="mensaje">
                    <span class="text-xl font-semibold text-indigo-600">{{ session('error') }}</span>
                </div>
            </div>
            @endif
            <div class="mt-4 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="pb-3 text-xl">{{ $idea->titulo }}</h1>
                    <p>{{ $idea->descripcion }}</p>
                    @can('like', $idea)
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
                                    <x-secondary-button>
                                        <x-likeabajo></x-likeabajo>
                                        &nbsp;&nbsp;
                                        Quitar Like
                                    </x-secondary-button>
                                @endif
                                <a href="{{route('idea.index')}}" class="dark:text-gray-100">Atras</a>
                            </div>
                        </form>
                    @endcan
                    @cannot('like', $idea)
                        <div class="mt-4"><a href="{{route('idea.index')}}" class="dark:text-gray-100">Atras</a></div>
                    @endcannot
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
