<!DOCTYPE html>
<html lang="en">

<head class="min-h-[100dvh]">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0"
        name="viewport">
    <meta content="ie=edge"
        http-equiv="X-UA-Compatible">
    <title>Document</title>
    <link href="https://fonts.bunny.net"
        rel="preconnect">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Scripts -->
</head>
@php
    $arr = explode(',', $invoice->client->address);
    // dump($invoice);
@endphp

<body class="min-h-[100dvh] p-6 mb-2 space-y-4">
    <header class="flex w-full h-44 justify-between items-center">
        <div class="h-full flex flex-col justify-center gap-2 pl-1">
            <div>
                <h2 class="font-semibold">Popa Ionut</h2>
            </div>
            <div>
                <p>Hofstraat 17, 2480 Dessel </p>
                <p>Tel: 0032467864650 </p>
                <p>Email: info@ipwerken.be</p>
            </div>
        </div>
        <div class="font-semibold flex flex-col justify-center gap-3 h-full items-end">
            <p>BTW nr: BE 1011.068.711</p>
            <p>Iban: BE17 9734 9549 4121</p>
        </div>
        <div class="h-1/2 flex items-center justify-start">
            {{-- <img src="/images/logo.svg" class="h-4/5" alt="logo"> --}}
            @php $logo = public_path('/images/logo.svg'); @endphp
            {{-- @inlinedImage($logo) --}}
            <img alt="logo"
                src="{{ URL::asset('/images/logo.svg') }}"
                width="176">
        </div>
    </header>
    <section class="w-full flex h-28 items-center justify-end pr-6">
        <div class="flex w-1/3 justify-center gap-2">
            <span class="font-semibold">Aan:</span>
            <div class="w-full">
                <p>{{ $invoice->client->name }}</p>
                @if ($invoice->client->add_btw)
                    <p>BTW nr: {{ $invoice->client->btw_number }}</p>
                @endif
                @foreach ($arr as $item)
                    <p>{{ $item }}</p>
                @endforeach
            </div>
    </section>
    <main class="min-h-48">
        <div class="w-full h-full flex flex-col px-1 items-start">
            <h1 class="w-full font-semibold text-2xl text-end pr-14 italic">Factuur</h1>
            <div
                class="w-full h-1/6 flex items-center justify-center text-center leading-none font-semibold border-2 border-black divide-x-1 divide-black">
                <div class="w-3/10 h-full flex flex-col justify-center items-center p-5"><span
                        class="block">Factuurnummer</span> {{ $invoice->id }}</div>
                <div class="w-3/10 h-full flex flex-col justify-center items-center p-5"><span
                        class="block">Factuurdatum</span> {{ $invoice->created_at->format('d/m/Y') }}</div>
                <div class="w-3/10 h-full flex flex-col justify-center items-center p-5"><span
                        class="block">Vervaldatum</span>
                    {{ $invoice->expired_at }}</div>
            </div>
            <p class="w-full h-1/12 border-x-2 border-black px-1 text-sm font-semibold">Locatie werken: @if (!$invoice->client->btw_number)
                    {{ $invoice->client->address }}
                @endif
            </p>
            <div class="w-full h-5/6 flex">
                <table class="w-full h-full table-fixed">
                    <thead class="w-full h-14 border-b-2 text-left text-sm border-x-2 border-t-2 border-black">
                        <tr>
                            <th class="w-2/12 pl-1 border-r-2 border-black">Datum</th>
                            <th class="w-4/12 pl-1 border-r-2 border-black">Omschrijving</th>
                            <th class="w-1/12 pl-1 border-r-2 border-black">Aantal</th>
                            <th class="w-2/12 pl-1 border-r-2 border-black">Prijs</th>
                            <th class="w-1/12 pl-1 border-r-2 border-black">Excl. btw</th>
                            <th class="w-2/12 pl-1 text-center"
                                colspan="2">BTW % / €</th>
                        </tr>
                    </thead>
                    <tbody class="w-full min-h-[300px]">
                        @foreach ($invoice->data as $item)
                            <tr class="w-full divide-x-1 divide-black max-h-20 h-10 border-x-2 border-black">
                                <td class="px-3">{{ Carbon\Carbon::create($item['date'])->format('d/m/Y') }}</td>
                                <td class="px-3">{{ $item['service_materials'] }}</td>
                                <td class="px-3">{{ $item['quantity'] }}</td>
                                <td class="px-3">{{ $item['price'] }}</td>
                                <td class="px-3">{{ $item['price'] * $item['quantity'] }}</td>
                                <td class="px-3">21%</td>
                                <td class="px-3"></td>
                            </tr>
                        @endforeach
                        <tr
                            class="{{ count($invoice->data) > 8 ? 'w-full border-b-2 divide-x-1 divide-black border-black border-x-2' : 'w-full h-24 divide-x-1 divide-black border-black border-x-2 border-b-2' }}">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class=" border-2 border-black text-right px-3">Total:</td>
                            <td class=" border-2 border-black pl-2">€260</td>
                            <td class=" border-2 border-black text-center text-xs pl-1"
                                colspan="2">
                                @if ($invoice->client->add_btw)
                                    BTW medecontractant
                                @endif
                            </td>
                        </tr>
                        <tr class="">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="border-2 border-black text-right px-3">Te betalen:</td>
                            <td class="border-2 border-black text-center bg-green-100 font-semibold"
                                colspan="3">
                                €260
                            </td>
                        </tr>
                        <tr>
                            <td class="font-semibold text-xs"
                                colspan='6'>Opmerkingen & Voorwaarden</td>
                        </tr>
                        @if ($invoice->client->add_btw)
                            <tr>
                                <td class="font-semibold text-xs"
                                    colspan='6'>Btw medecontractant waar je totaal van de btw berekend</td>
                            </tr>
                        @endif
                        <tr>
                            <td class="text-xs"
                                colspan='6'>Wij verzoeken u vriendelijk het bedrag binnen 30 dagen over te maken op
                                het
                                rekeningnummer BE17 9734
                                9549
                                4121 onder vermelding van het factuurnummer. Op alle diensten zijn onze algemene
                                voorwaarden van
                                toepassing.
                                Deze kan u vinden op de achterzijde.</td>
                        </tr>
                        {{-- <td class="font-semibold">Btw medecontractant waar je totaal van de btw berekend</td>
                        <td>Wij verzoeken u vriendelijk het bedrag binnen 30 dagen over te maken op het
                            rekeningnummer BE17 9734
                            9549
                            4121 onder vermelding van het factuurnummer. Op alle diensten zijn onze algemene
                            voorwaarden van
                            toepassing.
                            Deze kan u vinden op de achterzijde.</td> --}}
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>

</html>
