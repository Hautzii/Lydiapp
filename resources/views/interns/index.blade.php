<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Stagiaires') }}
                </h2>
                @if (auth()->user() && auth()->user()->isAdmin())
                <x-nav-link :href="route('interns.create')" class="ml-4 add_intern">
                    {{ __('Ajouter un stagiaire') }}
                </x-nav-link>
                @endif
            </div>
            <div class="flex justify-end">
                @php
                    $favorites = request()->query('favorites', 0);
                    $newFavoritesValue = $favorites ? 0 : 1;
                    $icon = $favorites ? '/svg/heart_full.svg' : '/svg/heart.svg';
                @endphp
                @if (auth()->user() && auth()->user()->isAdmin())
                <a href="{{ route('interns.index', ['favorites' => $newFavoritesValue]) }}" class="btn btn-primary">
                    <img src="{{ asset($icon) }}" alt="favorites icon" class="svg-bar">
                </a>
                @endif
                <form method="GET" action="{{ route('interns.index') }}">
                    <input class="search-bar" type="text" name="search" placeholder="Rechercher..." value="{{ request()->query('search') }}">
                    <input type="hidden" name="favorites" value="{{ request()->query('favorites', 0) }}">
                    <button type="submit"></button>
                </form>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="containers">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach ($interns as $formationName => $internsGroup)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="font-bold text-xl mb-4">{{ $formationName }}</h3>
                        <div class="grid custom-grid-cols gap-4">
                            @foreach ($internsGroup as $intern)
                                <div class="card rounded overflow-hidden m-2">
                                    <div class="{{ auth()->user() && auth()->user()->isAdmin() ? 'flex justify-center mt-4' : 'flex justify-center mt-custom' }}">
                                        <img class="object-cover rounded-full"
                                            src="{{ asset('uploads/' . $intern->profile_picture) }}"
                                            alt="{{ $intern->first_name }}">
                                    </div>
                                    <div class="{{ auth()->user() && auth()->user()->isAdmin() ? 'px-6 py-4 mt-4 mt-custom' : 'px-6 py-4 mt-custom' }}">
                                        <h2 class="font-bold text-m mb-2">{{ $intern->last_name }}</h2>
                                        <h3 class="text-gray-700 text-s">{{ $intern->first_name }}</h3>
                                        <p class="text-gray-700 text-s">{{ $intern->phone_number }}</p>
                                        <p class="text-gray-700 text-s">{{ $intern->email }}</p>
                                        {{-- <p class="text-gray-700 text-s">{{ $intern->formation->name }}</p> --}}
                                    </div>
                                    <div class="px-6 py-4 flex justify-end space-x-2">
                                        @if (auth()->user() && auth()->user()->isAdmin())
                                        <form method="GET" action="{{ route('interns.edit', $intern->id) }}">
                                            @csrf
                                            <button type="submit"><img class="svg"
                                                    src="{{ asset('/svg/edit.svg') }}" alt="edit button"></button>
                                        </form>
                                        <form method="POST" action="{{ route('interns.destroy', $intern->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"><img class="svg"
                                                    src="{{ asset('/svg/delete.svg') }}" alt="delete button"></button>
                                        </form>
                                        @if (auth()->user()->favoriteInterns->contains($intern))
                                            <form method="POST" action="{{ route('interns.unfavorite', $intern) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"><img src="{{ asset('/svg/heart_full.svg') }}"
                                                        alt="unfavorite icon" class="svg"></button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('interns.favorite', $intern) }}">
                                                @csrf
                                                <button type="submit"><img src="{{ asset('/svg/heart.svg') }}"
                                                        alt="favorite icon" class="svg"></button>
                                            </form>
                                        @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>

<link rel="stylesheet" href="{{ asset('css/main_intern.css') }}">
