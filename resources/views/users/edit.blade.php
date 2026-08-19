<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nutzer bearbeiten
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        <form action="{{ route('users.update', $user) }}" method="POST"
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
            <div><label class="block mb-1">Name</label>
                <input name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded p-2">
            </div>
            <div><label class="block mb-1">E-Mail</label>
                <input name="email" type="email" autocomplete="off" value="{{ old('email', $user->email) }}" class="w-full border rounded p-2">
            </div>
            <div><label class="block mb-1">Passwort</label>
                <input name="password" type="password" autocomplete="new-password" class="w-full border rounded p-2">
            </div>
            <div><label class="block mb-1">Rolle</label>
                <select name="role" class="w-full border rounded p-2">
                    <option value="administrator" @selected($user->role === 'administrator')>Administrator</option>
                    <option value="spediteur" @selected($user->role === 'spediteur')>Spediteur</option>
                    <option value="kassenkraft" @selected($user->role === 'kassenkraft')>Kassenkraft</option>
                    <option value="lagermitarbeiter" @selected($user->role === 'lagermitarbeiter')>Lagermitarbeiter</option>
                    <option value="kunde" @selected($user->role === 'kunde')>Kunde</option>
                </select>
            </div>
            <button class="px-4 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">Bearbeiten</button>
        </form>
    </div>
</x-app-layout>


