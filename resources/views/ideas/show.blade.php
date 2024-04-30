<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-xl pb-3">{{ $idea->titulo }}</h1>
                    <p>{{ $idea->descripcion }}</p>
                    <form method="POST" action="">
                        @csrf
                        @method('put')
                        <div class="mt-4 space-x-8">
                            <x-primary-button>
                                <x-likenegro></x-likenegro>
                                &nbsp;&nbsp;
                                Dar/Quitar Like
                            </x-primary-button>
                            <a href="{{route('idea.index')}}" class="dark:text-gray-100">Atras</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>