@php $customer = \App\Models\Customer::where('user_id', auth()->id())->first();
@endphp

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Stammdaten
        </h2>
    </header>

    <form method="post" action="{{ route('profile.customer.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <div>
            <x-input-label for="street" value="Straße" />
            <x-text-input id="street" name="street" class="mt-1 block w-full" :value="old('street', $customer->street)"/>
        </div>
        <div>
            <x-input-label for="house_number" value="Hausnummer" />
            <x-text-input id="house_number" name="house_number" class="mt-1 block w-full" :value="old('house_number', $customer->house_number)"/>
        </div>
        <div>
            <x-input-label for="postal_code" value="PLZ" />
            <x-text-input id="postal_code" name="postal_code" class="mt-1 block w-full" :value="old('postal_code', $customer->postal_code)"/>
        </div>
        <div>
            <x-input-label for="city" value="Ort" />
            <x-text-input id="city" name="city" class="mt-1 block w-full" :value="old('city', $customer->city)"/>
        </div>
        <div class="flex items-cnter gap-4">
            <x-primary-button>Speichern</x-primary-button>
            @if (session('status') === 'customer-updated')
                <p class="text-sm text-gray-600">Gespeichert</p>
            @endif
        </div>

    </form>
</section>
