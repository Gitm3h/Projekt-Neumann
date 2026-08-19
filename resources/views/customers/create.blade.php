<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Neuer Kunde
        </h2>
    </x-slot>
    <div class="sm:max-w-2xl mx-auto py-6 px-4">
        <form action="{{ route('customers.store') }}" method="POST"
              class="bg-white p-6 rounded shadow space-y-4">
            @csrf

            @if($errors->any())
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
            <div><label class="block mb-1">E-Mail (Portal-Login)</label>
                <input name="email" type="email" autocomplete="off" value="{{ old('email') }}" class="w-full border rounded p-2">
            </div>
            <div><label class="block mb-1">Passwort (Portal-Login)</label>
                <input name="password" type="password" autocomplete="new-password" class="w-full border rounded p-2">
            </div>



            <div><label class="block mb-1">Art</label>
                <select name="type" class="w-full border rounded p-2">
                    <option value="privat" @selected(old('type') === 'privat')>privat</option>
                    <option value="gewerblich" @selected(old('type') ==='gewerblich')>gewerblich</option>
                </select>

            </div>
            <div><label class="block mb-1">Straße</label>
                <input name="street" value="{{ old('street') }}" class="w-full border rounded p-2">
            </div>
            <div><label class="block mb-1">Hausnummer</label>
                <input name="house_number" value="{{ old('house_number') }}" class="w-full border rounded p-2">
            </div>
            <div><label class="block mb-1">PLZ</label>
                <input name="postal_code" value="{{ old('postal_code') }}" class="w-full border rounded p-2">
            </div>
            <div><label class="block mb-1">Ort</label>
                <input name="city" value="{{ old('city') }}" class="w-full border rounded p-2">
            </div>
            <div><label class="block mb-1">USt-IdNr. (nur gewerblich)</label>
                <input name="vat_id" value="{{ old('vat_id') }}" class="w-full border rounded p-2">
            </div>
            <button class="px-4 py-2 bg-teal-700 hover:bg-teal-800 transition text-white rounded">Anlegen</button>
        </form>
    </div>
</x-app-layout>
