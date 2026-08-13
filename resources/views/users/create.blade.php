<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Neuer Nutzer
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        <form action="{{ route('users.store') }}" method="POST"
              class="bg-white p-6 rounded shadow space-y-4">

            @csrf
            @if ($errors->any())
                <div class="rounded bg-red-100 p-3 text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div><label class="block mb-1">Name</label>
                <input name="name" value="{{ old('name') }}" class="w-full border rounded p-2">
            </div>
            <div><label class="block mb-1">E-Mail</label>
                <input name="email" type="email" value="{{ old('email') }}" class="w-full border rounded p-2">
            </div>
            <div><label class="block mb-1">Passwort</label>
                <input name="password" type="password" class="w-full border rounded p-2">
            </div>
            <div><label class="block mb-1">Rolle</label>
                <select name="role" class="w-full border rounded p-2">
                    <option value="administrator">Administrator</option>
                    <option value="spediteur">Spediteur</option>
                    <option value="kassenkraft">Kassenkraft</option>
                    <option value="lagermitarbeiter">Lagermitarbeiter</option>
                    <option value="kunde">Kunde</option>
                </select>
            </div>
            <button class="px-4 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">Anlegen</button>
        </form>
    </div>
</x-app-layout>

