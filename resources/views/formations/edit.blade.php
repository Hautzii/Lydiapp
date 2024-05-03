<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier Formation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{route('formations.update', $formation->id)}}" method="post" class="flex flex-col items-center">
                        @csrf
                        @method('PATCH')
                        <label for="name" class="self-start text-center w-full">Nom :</label>
                        <input type="text" id="name" name="name" class="mb-4 mt-2 text-center rounded w-72 border p-2 border-gray-900" value="{{$formation->name}}">
                        <label for="start_date" class="self-start text-center w-full">Date de début :</label>
                        <input type="date" id="start_date" name="start_date" class="mb-4 mt-2 text-center rounded border p-2 border-gray-900" value="{{$formation->start_date}}">
                        <label for="end_date" class="self-start text-center w-full">Date de fin :</label>
                        <input type="date" id="end_date" name="end_date" class="mb-4 mt-2 text-center rounded border p-2 border-gray-900" value="{{$formation->end_date}}">
                        <button type="submit" class="bg-button px-4 py-2 rounded text-lg w-24 mt-4">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
