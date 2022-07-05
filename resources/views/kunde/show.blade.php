<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Aktueller Test') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="card">

            {{-- Kudendaten bearbeiten button --}}
            <div class="card-header d-flex justify-content-between">
                <h4>Testdaten</h4> <a class="btn btn-secondary btn-md"
                    href="/kunde/{{ $kunde->id }}/edit">Testdaten bearbeiten</a>
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
                        <input type="hidden" name="price" id="pricedrucken" value="">
                        <button class="btn-primary btn" id="btndrucken" disabled>Testen & Drucken</button>
                    </form>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" onclick="kosten()"  name="kosten" value="free" id="free">
                            <label class="form-check-label text-lg text-success" for="free">Kostenlos</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" onclick="kosten()"  name="kosten" value="paid" id="paid">
                            <label class="form-check-label text-lg text-warning" for="paid">Kosten: 3€</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" onclick="kosten()"  name="kosten" value="10" id="10">
                            <label class="form-check-label text-lg text-danger" for="10">Kosten: 10€</label>
                        </div>
                      
                    </div>
                    {{-- Show "Testen & Email" button only if kunde has e-mail --}}
                    @if (isset($kunde->email))
                        <form action="/tests" method="post" enctype="multipart/form">
                            @csrf
                            <input type="hidden" name="kundeid" value="{{ $kunde->id }}">
                            <input type="hidden" name="digital" value="1">
                            <input type="hidden" name="price" id="priceemail" value="">
                            <button class="btn-info btn" id="btnemail" disabled>Testen & E-mail</button>
                        </form>
                    @endif
                    <script>
                        function kosten(){
                            let price = document.querySelector('input[name="kosten"]:checked').value;
			    document.getElementById('btndrucken').disabled = false;
                            
			   document.getElementById('pricedrucken').value = price;
                            
			    document.getElementById('btnemail').disabled = false;
			    
                            document.getElementById('priceemail').value = price;
                            
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
