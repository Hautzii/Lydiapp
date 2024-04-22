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
                    <form action="{{route('formations.update', $formation->id)}}" method="post" class="flex flex-col">
                        @csrf
                        @method('PATCH')
                        <label for="name">Nom :</label>
                        <input type="text" id="name" name="name" value="{{$formation->name}}">
                        <label for="start_date">Date de début :</label>
                        <input type="date" id="start_date" name="start_date" value="{{$formation->start_date}}">
                        <label for="end_date">Date de fin :</label>
                        <input type="date" id="end_date" name="end_date" value="{{$formation->end_date}}">
                        <button type="submit" class="submit_button">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<link rel="stylesheet" href="{{asset('/css/form.css')}}">
