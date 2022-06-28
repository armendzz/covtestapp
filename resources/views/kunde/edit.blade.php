<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Testdaten bearbeiten') }}
        </h2>
    </x-slot>

    {{-- Show message if kunden daten are succsessfully updated --}}
    @if (Session::has('success'))
        <p class="alert text-center {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('success') }} -
            <a href="/kunde/{{ $kunde->id }}">Klicken Sie hier, um den Client mit neuen Daten zu Testen</a> </p>
    @endif


    <div class="container">

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

        <div class="card p-2">
            <form class="m-2" action="/kunde/{{ $kunde->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Nachname input --}}
                <div class="form-group row">
                    <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Nachname *</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-lg" value="{{ $kunde->ln }}"
                            autocomplete="autocomplete_off_hack_xfr4!k" name="ln" placeholder="Mustermann" required>
                    </div>
                </div>

                {{-- Vorname input --}}
                <div class="form-group row">
                    <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Vorname *</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-lg" value="{{ $kunde->fn }}"
                            autocomplete="autocomplete_off_hack_xfr4!k" name="fn" placeholder="Max" required>
                    </div>
                </div>

                {{-- Geburtstag input --}}
                <div class="form-group row">
                    <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Geburtstag *</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control form-control-lg" value="{{ $kunde->dob }}" name="dob"
                            required>
                    </div>
                </div>

                {{-- Addresse input --}}
                <div class="form-group row">
                    <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Anschrift *</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-lg" value="{{ $kunde->addresse }}"
                            autocomplete="autocomplete_off_hack_xfr4!k" name="addresse"
                            placeholder="Marktstr. 11, 46045 Oberhausen" required>
                    </div>
                </div>

                {{-- Email input --}}
                <div class="form-group row">
                    <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">E- Mail
                        Adresse</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control form-control-lg" value="{{ $kunde->email }}"
                            name="email" placeholder="maxmustermann@gmail.com">
                    </div>
                </div>

                {{-- Phone input --}}
                <div class="form-group row">
                    <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Tel.</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-lg" value="{{ $kunde->phone }}"
                            name="phone" placeholder="123456">
                    </div>
                </div>

                {{-- Personalausweis input --}}
                <div class="form-group row">
                    <label for="colFormLabelLg"
                        class="col-sm-2 col-form-label col-form-label-lg">Personalausweis-Nr.</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-lg" value="{{ $kunde->idnumber }}"
                            autocomplete="autocomplete_off_hack_xfr4!k" name="idnumber" placeholder="YK12345">
                    </div>
                </div>

                {{-- submit button --}}
                <div class="form-group row justify-content-center">
                    <button type="submit" class="btn btn-lg btn-info py-3 px-5"> Daten aktualisieren</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
