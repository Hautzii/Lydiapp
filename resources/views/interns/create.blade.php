<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter un stagiaire') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('interns.store') }}" method="post" enctype="multipart/form-data" class="flex flex-col">
                        @csrf
                        <label for="profile_picture">Photo de profil :</label>
                        <input type="file" id="profile_picture" name="profile_picture">
                        <label for="first_name">Prénom :</label>
                        <input type="text" id="first_name" name="first_name">
                        <label for="last_name">Nom :</label>
                        <input type="text" id="last_name" name="last_name">
                        <label for="phone_number">Numéro de téléphone :</label>
                        <input type="text" id="phone_number" name="phone_number">
                        <label for="email">Email :</label>
                        <input type="email" id="email" name="email">
                        <label for="formation_id">Formation :</label>
                        <select id="formation_id" name="formation_id">
                            <option value="0">Choisir une formation...</option>
                            @foreach ($formations as $formation)
                                <option value="{{ $formation->id }}">{{ $formation->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<link rel="stylesheet" href="{{asset('/css/create_intern.css')}}">
