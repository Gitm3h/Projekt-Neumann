<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Passwort festlegen
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        <p class="mb-4 text-gray-600">Bitte legen Sie jetzt ein eigenes Passwort fest. </p>
        <form action="{{ route('password.force.update') }}" method="POST"
              class="bg-white p-6 rounded shadow space-y-4">

            @csrf
            @method('PUT')
            @if ($errors->any())
                <div class="rounded bg-red-100 p-3 text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label class="block mb-1">Neues Passwort</label>
                <input name="password" type="password" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1">Passwort wiederholen</label>
                <input name="password_confirmation" type="password" class="w-full border rounded p-2">
            </div>
            <button class="px-4 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">Passwort speichern</button>
        </form>
    </div>
</x-app-layout>

