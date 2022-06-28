<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Neuer Test') }}
        </h2>
    </x-slot>

    {{-- If Kunde exist show message --}}
    @if (Session::has('info'))
        <p class="alert text-center alert-primary">{{ Session::get('info') }}</p>
        <h5 class="alert text-center alert-info"> Name: {{ $kunde->ln }}, {{ $kunde->fn }} - Geb:
            {{ $kunde->dob }} - Anschrift: {{ $kunde->addresse }} <a href="clients/{{ $kunde->id }}"
                class="btn btn-primary">Testen</a> <a href="clients/{{ $kunde->id }}/edit"
                class="btn btn-info">Testdaten bearbeiten</a> </h5>
    @endif

    <div class="container px-3 pb-5">

        {{-- Live Search --}}
        <div class="card mb-4">
            <livewire:kunden/> 
        </div>

        {{-- Show input errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h3 class="mt-2 pt-2"> <strong> Neuer Test</strong></h3>
        <div class="card p-2">
            <form class="m-2" action="/kunde" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nachname input --}}
                <div class="form-group row">
                    <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Nachname *</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-lg" name="ln" placeholder="Mustermann"
                            required>
                    </div>
                </div>

                {{-- Vorname input --}}
                <div class="form-group row">
                    <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Vorname *</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-lg" name="fn" placeholder="Max" required>
                    </div>
                </div>

                {{-- Geburtstag input --}}
                <div class="form-group row">
                    <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Geburtstag *</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control form-control-lg" name="dob" required>
                    </div>
                </div>

                {{-- PLZ + City input --}}
                <div class="form-group row">
                    <label for="plz " class="col-sm-2 col-form-label col-form-label-lg">PLZ *</label>
                    <div class="col-md-3">
                        <input type="text" id="plz" class="form-control form-control-lg" placeholder="46045" required />
                    </div>

                    {{-- City input is disabled, will autofill from API after user has input PLZ --}}
                    <label for="city" class="col-sm-2 col-form-label col-form-label-lg">Stadt *</label>
                    <div class="col-md-5">
                        <input type="text" id="city" class="form-control form-control-lg" placeholder="Berlin" required
                            disabled />
                    </div>
                </div>

                {{-- Street input --}}
                <div class="form-group row">
                    <label for="strasse" class="col-sm-2 col-form-label col-form-label-lg">Straße *</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-lg" id="strasse" name="strasse"
                            placeholder="Marktstr. 11" required>
                    </div>
                </div>

                {{-- E-Mail Adresse input --}}
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label col-form-label-lg">E-Mail Adresse</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control form-control-lg" name="email"
                            placeholder="maxmustermann@gmail.com">
                    </div>
                </div>

                {{-- Phone input --}}
                <div class="form-group row">
                    <label for="idnumber" class="col-sm-2 col-form-label col-form-label-lg">Tel.</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-lg"
                            autocomplete="autocomplete_off_hack_xfr4!k" name="phone" placeholder="015222444333">
                    </div>
                </div>

                {{-- Personalausweis input --}}
                <div class="form-group row">
                    <label for="idnumber" class="col-sm-2 col-form-label col-form-label-lg">Personalausweis-Nr.</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-lg"
                            autocomplete="autocomplete_off_hack_xfr4!k" name="idnumber" placeholder="YK12345">
                    </div>
                </div>

                {{-- Complete Address hidden input. This input will autofill from Javascript --}}
                <input type="hidden" id="anschrift" name="addresse" value="">

                {{-- Submit input --}}
                <div class="form-group row justify-content-center">
                    <button type="submit" class="btn btn-lg btn-primary py-3 px-5"> + Test speichern</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Importing Jquery & Axios --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script>
        $('#plz').on('input', function() {
            $('#city').val('');

            //if user has input more than 3 chars then send request to API
            if ($('#plz').val().length > 3) {
                let plz = $('#plz').val();
                axios
                    .get(
                        'https://public.opendatasoft.com/api/records/1.0/search/?dataset=georef-germany-postleitzahl&q=' +
                        plz + '&facet=plz_name')
                    .then(function(res) {

                        // autofill city input and add is-invalid class if there is no result
                        if (res.data.nhits > 0) {
                            $('#city').val(res.data.records[0].fields.plz_name)
                            $('#plz').removeClass("is-invalid");
                            $('#city').removeClass("is-invalid");
                            $('#plz').addClass("is-valid");
                            $('#city').addClass("is-valid");
                        } else {
                            $('#plz').addClass("is-invalid");
                            $('#city').addClass("is-invalid");
                            $('#city').removeClass("is-valid");
                        }
                    })
            }
        });

        // Autofill hidden addresse input after geting result from API and street input  
        let anschrift = '';
        $('#strasse').keyup(function() {
            anschrift = $('#strasse').val() + ', ' + $('#plz').val() + ' ' + $('#city').val()
            $('#anschrift').val(anschrift)
        })
        $('#plz').keyup(function() {
            anschrift = $('#strasse').val() + ', ' + $('#plz').val() + ' ' + $('#city').val()
            $('#anschrift').val(anschrift)
        })
    </script>
</x-app-layout>
