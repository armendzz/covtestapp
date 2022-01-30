<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Aktueller Kunde') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="card">

            {{-- Kudendaten bearbeiten button --}}
            <div class="card-header d-flex justify-content-between">
                <h4>Kundendaten</h4> <a class="btn btn-secondary btn-md"
                    href="/kunde/{{ $kunde->id }}/edit">Kundendaten bearbeiten</a>
            </div>

            {{-- show kunden daten --}}
            <div class="card-body">
                <ul class="client-info-list">
                    <li class="client-li">
                        <div class="client-att">Name: </div>
                        <div class="client-data">{{ $kunde->fn }} {{ $kunde->ln }} </div>
                    </li>
                    <li class="client-li">
                        <div class="client-att">Anschrift:</div>
                        <div class="client-data"> {{ $kunde->addresse }} </div>
                    </li>
                    <li class="client-li">
                        <div class="client-att">Geburtstag:</div>
                        <div class="client-data"> {{ $kunde->dob }} </div>
                    </li>
                    <li class="client-li">
                        <div class="client-att">E-Mail Adresse:</div>
                        <div class="client-data"> {{ $kunde->email }}</div>
                    </li>
                    <li class="client-li">
                        <div class="client-att">Tel:</div>
                        <div class="client-data"> {{ $kunde->phone }}</div>
                    </li>
                    <li class="client-li">
                        <div class="client-att">Personalausweis-Nr:</div>
                        <div class="client-data"> {{ $kunde->idnumber }} </div>
                    </li>
                </ul>

                <div class="buttons mx-2 my-3">

                    {{--  Testen und drucken button--}}
                    <form action="/tests" method="post" enctype="multipart/form">
                        @csrf
                        <input type="hidden" name="kundeid" value="{{ $kunde->id }}">
                        <input type="hidden" name="digital" value="0">
                        <button class="btn-primary btn">Testen & Drucken</button>
                    </form>

                    {{-- Show "Testen & Email" button only if kunde has e-mail --}}
                    @if (isset($kunde->email))
                        <form action="/tests" method="post" enctype="multipart/form">
                            @csrf
                            <input type="hidden" name="kundeid" value="{{ $kunde->id }}">
                            <input type="hidden" name="digital" value="1">
                            <button class="btn-info btn">Testen & E-mail</button>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
