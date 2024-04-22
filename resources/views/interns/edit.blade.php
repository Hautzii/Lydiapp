<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier Stagiaire') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('interns.update', $intern->id) }}" method="post" enctype="multipart/form-data" class="flex flex-col items-center">
                        @csrf
                        @method('PATCH')
                        <label for="profile_picture" class="self-start">Photo de profil :</label>
                        <img src="{{ asset('uploads/' . $intern->profile_picture) }}" alt="Current profile picture" class="mb-4">
                        <div class="flex items-center justify-center w-full mb-4">
                            <input type="file" id="profile_picture" name="profile_picture" class="text-center">
                        </div>
                        <label for="first_name" class="self-start">Prénom :</label>
                        <input type="text" id="first_name" name="first_name" value="{{$intern->first_name}}" class="mb-4 text-center rounded-sm interns">
                        <label for="last_name" class="self-start">Nom :</label>
                        <input type="text" id="last_name" name="last_name" value="{{$intern->last_name}}" class="mb-4 text-center rounded-sm interns">
                        <label for="phone_number" class="self-start">Numéro de téléphone :</label>
                        <input type="text" id="phone_number" name="phone_number" value="{{$intern->phone_number}}" class="mb-4 text-center rounded-sm interns">
                        <label for="email" class="self-start">Email :</label>
                        <input type="email" id="email" name="email" value="{{$intern->email}}" class="mb-4 text-center rounded-sm interns">
                        <label for="formation_id" class="self-start">Formation :</label>
                        <select id="formation_id" name="formation_id" class="mb-4 text-center rounded-sm">
                            @foreach ($formations as $formation)
                                <option value="{{ $formation->id }}">{{ $formation->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="submit_button">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<link rel="stylesheet" href="{{asset('/css/form.css')}}">
