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
                    <form action="{{ route('interns.store') }}" method="post" enctype="multipart/form-data" class="flex flex-col items-center">
                        @csrf
                        <label for="profile_picture" class="self-start text-center w-full">Photo de profil :</label>
                        <input type="file" id="profile_picture" name="profile_picture" class="text-center mb-4">
                        <label for="first_name" class="self-start text-center w-full">Prénom :</label>
                        <input type="text" id="first_name" name="first_name" class="text-capitalize mb-4 mt-2 py-1 text-center rounded w-72 border p-2 border-gray-900">
                        <label for="last_name" class="self-start text-center w-full">Nom :</label>
                        <input type="text" id="last_name" name="last_name" class="text-uppercase mb-4 mt-2 py-1 text-center rounded w-72 border p-2 border-gray-900">
                        <label for="phone_number" class="self-start text-center w-full">Numéro de téléphone :</label>
                        <input type="text" id="phone_number" name="phone_number" class="mb-4 mt-2 py-1 text-center rounded w-72 border p-2 border-gray-900">
                        <label for="email" class="self-start text-center w-full">Email :</label>
                        <input type="email" id="email" name="email" class="mb-4 mt-2 py-1 text-center rounded w-72 border p-2 border-gray-900">
                        <label for="formation_id" class="self-start text-center w-full">Formation :</label>
                        <select id="formation_id" name="formation_id" class="mb-4 mt-2 py-1 px-2 text-center rounded border p-2 border-gray-900">
                            <option value="0">Choisir une formation...</option>
                            @foreach ($formations as $formation)
                                <option value="{{ $formation->id }}">{{ $formation->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-button px-4 py-2 rounded p-2 text-lg w-24 mt-4">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
