@php use Carbon\Carbon; @endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Formations') }}
                </h2>
                @if (auth()->user() && auth()->user()->isAdmin())
                    <x-nav-link :href="route('formations.create')" class="ml-4 add_formation">
                        {{ __('Ajouter une formation') }}
                    </x-nav-link>
                @endif
            </div>
            <div>
                <form method="GET" action="{{ route('formations.index') }}" class="relative">
                    <input class="p-2 rounded border border-gray-900 w-full" type="text" name="search" placeholder="Rechercher..."
                           value="{{ request()->query('search') }}">
                    <button type="submit" class="absolute right-0 top-0 mt-search mr-2">
                        <img class="h-5" src="{{asset('/svg/search.svg')}}" alt="search icon">
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($formations as $formation)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg card">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="flex items-center">
                                <div>
                                    <p class="font-bold text-xl mb-2">{{$formation->name}}</p>
                                    <p>Début : {{ Carbon::parse($formation->start_date)->format('d/m/Y') }}</p>
                                    <p>Fin : {{ Carbon::parse($formation->end_date)->format('d/m/Y') }}</p>
                                </div>
                                @if (auth()->user() && auth()->user()->isAdmin())
                                    <div class="px-6 py-4 flex flex-col space-y-2 ml-4 icon-container">
                                        <form method="GET" action="{{route('formations.edit', $formation->id)}}">
                                            @csrf
                                            <button type="submit"><img class="svg" src="{{asset("/svg/edit.svg")}}"
                                                                       alt="edit button"></button>
                                        </form>
                                        <form method="POST" action="{{route('formations.destroy', $formation->id)}}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"><img class="svg" src="{{asset("/svg/delete.svg")}}"
                                                                       alt="delete button"></button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>

<link rel="stylesheet" href="{{asset('/css/main_formation.css')}}">
