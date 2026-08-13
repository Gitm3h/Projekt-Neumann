<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Kundenportal
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4">
        @if (session('status'))
            <p class="mb-3 text-teal-700">{{ session('status') }}</p>
        @endif

        <table class="w-full bg-white rounded shadow">
            <thead>
            <tr class="text-left border-b">
                <th class="p-3">Artikel</th>
                <th class="p-3">Bestand</th>
                <th class="p-3">Reservieren</th>
            </tr>
            </thead>
            <tbody>
            @foreach($articles as $article)
                <tr class="border-b">
                    <td class="p-3">{{$article->name}}</td>
                    <td class="p-3">{{ $article->stocks->sum('quantity') }}</td>
                    <td class="p-3">
                        <form action="{{ route('portal.reserve') }}" method="POST"
                              class="flex gap-2">
                            @csrf
                            <input type="hidden" name="article_id" value="{{ $article->id }}">
                            <input name="quantity" type="number" min="1" value="1"
                            class="w-20 border rounded p-1">
                            <button class="px-3 py-1 bg-teal-700 text-white rounded">OK</button>
                        </form>
                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
