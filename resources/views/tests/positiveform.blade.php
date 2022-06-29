<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Neuer Kunde') }}
        </h2>
    </x-slot>
    @if (Session::has('info'))
        <p class="alert text-center alert-primary">{{ Session::get('info') }}</p>
        <h5 class="alert text-center alert-info"> Name: {{ $kunde->ln }}, {{ $kunde->fn }} - Geb:
            {{ $kunde->dob }} - Anschrift: {{ $kunde->addresse }} <a href="kundes/{{ $kunde->id }}"
                class="btn btn-primary">Testen</a> <a href="kundes/{{ $kunde->id }}/edit"
                class="btn btn-info">Kundendaten bearbeiten</a> </h5>
    @endif
    <div class="container px-3 pb-5">
        <h3 class="mt-2 pt-2"> <strong> Gesundheitsamt Anmelden</strong></h3>
        <div class="card p-2">
            <form class="m-2" action="/positiveformprepare/{{ $test[0]->id }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <h5 class="text-center mt-2 mb-3">Kunden Daten</h5>
                <div class="form-group row">
                    <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Nachname *</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-lg" value="{{ $test[0]->ln }}"
                            name="nachname" placeholder="Mustermann" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Vorname *</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-lg" value="{{ $test[0]->fn }}"
                            name="vorname" placeholder="Max" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Geburtstag *</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control form-control-lg" value="{{ $test[0]->dob }}"
                            name="birthday" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="gender" class="col-sm-2 col-form-label col-form-label-lg">Geschlecht *</label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="mannlich" value="2" required>
                            <label class="form-check-label" for="asd">Männlich</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="weiblich" value="1" required>
                            <label class="form-check-label" for="asd">Weiblich</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="divers" value="3" required>
                            <label class="form-check-label" for="asd">Divers</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="strasse" class="col-sm-2 col-form-label col-form-label-lg">Anschrift *</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-lg" id="strasse"
                            value="{{ $test[0]->addresse }}" name="strasse" placeholder="Marktstr. 11" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label col-form-label-lg">E-Mail Adresse</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control form-control-lg" value="{{ $test[0]->kunde->email }}"
                            name="email">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="idnumber" class="col-sm-2 col-form-label col-form-label-lg">Tel.</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-lg" value="{{ $test[0]->kunde->phone }}"
                            autocomplete="autocomplete_off_hack_xfr4!k" name="phone">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="idnumber" class="col-sm-2 col-form-label col-form-label-lg">Personalausweis-Nr.</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-lg"
                            autocomplete="autocomplete_off_hack_xfr4!k" name="idnumber">
                    </div>
                </div>
                <hr>
                <h5 class="text-center mb-2 mt-2">Gesundheitsamt Daten</h5>
                <div class="form-group row">
                    <label for="gesundheitsamt" class="col-sm-2 col-form-label col-form-label-lg">Gesundheitsamt</label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gesundheitsamt" id="oberhausen"
                                value="oberhausen" required>
                            <label class="form-check-label" for="asd">Oberhuasen</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gesundheitsamt" id="bottrop"
                                value="bottrop" required>
                            <label class="form-check-label" for="asd">Bottrop</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gesundheitsamt" id="duisburg"
                                value="duisburg" required>
                            <label class="form-check-label" for="asd">Duisburg</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gesundheitsamt" id="wesel" value="wesel"
                                required>
                            <label class="form-check-label" for="asd">Wesel</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gesundheitsamt" id="andre" value="andre"
                                required>
                            <label class="form-check-label" for="asd">Andere</label>
                        </div>
                    </div>
                </div>
                <div class="other-data">
                    <div class="form-group row">
                        <label for="g-name" class="col-sm-2 col-form-label col-form-label-lg">Gesundheitsamt</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control form-control-lg"
                                autocomplete="autocomplete_off_hack_xfr4!k" id="gname" name="gname" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="plz " class="col-sm-2 col-form-label col-form-label-lg">PLZ *</label>
                        <div class="col-md-3">
                            <input type="text" id="gplz" class="form-control form-control-lg" name="gplz" required  />
                        </div>
                        <label for="city" class="col-sm-2 col-form-label col-form-label-lg">Stadt *</label>
                        <div class="col-md-5">
                            <input type="text" id="gcity" class="form-control form-control-lg" name="gcity" required  />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="strasse" class="col-sm-2 col-form-label col-form-label-lg">Straße *</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control form-control-lg" id="gstrasse" name="gstrasse"
                                 required>
                        </div>
                    </div>
                    <div class="form-group row">
                      <label for="g-tel" class="col-sm-2 col-form-label col-form-label-lg">Tel: *</label>
                      <div class="col-sm-10">
                          <input type="text" class="form-control form-control-lg"
                              autocomplete="autocomplete_off_hack_xfr4!k" name="gtel" id="gtel" required>
                      </div>
                  </div>
                  <div class="form-group row">
                    <label for="g-tel" class="col-sm-2 col-form-label col-form-label-lg">Email: *</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-lg"
                            autocomplete="autocomplete_off_hack_xfr4!k" name="gemail" id="gemail" required>
                    </div>
                </div>
                </div>
                <div class="form-group row justify-content-center">
                    <button type="submit" class="btn btn-lg btn-success py-3 px-5"> Gesundheitsamt Anmelden</button>
                </div>
            </form>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script>
  $('input[type=radio][name=gesundheitsamt]').change(function() {

    if (this.value == 'oberhausen') {
      $("#gname").val('Gesundheitsamt Oberhausen');
      $("#gplz").val('46045');
      $("#gcity").val('Oberhausen');
      $("#gstrasse").val('Tannenbergstr. 11-13');
      $("#gtel").val('02088252570');
      $("#gemail").val('Infektionsmeldungen@oberhausen.de');
    }

    if (this.value == 'bottrop') {
      $("#gname").val('Gesundheitsamt Bottrop');
      $("#gplz").val('46236');
      $("#gcity").val('Bottrop');
      $("#gstrasse").val('Gladbeckerstr. 66');
      $("#gtel").val('02041705080');
      $("#gemail").val('infektionsschutz@bottrop.de');
    }

    if (this.value == 'duisburg') {
      $("#gname").val('Gesundheitsamt Duisburg');
      $("#gplz").val('47119');
      $("#gcity").val('Duisburg');
      $("#gstrasse").val('Ruhrorterstr. 195');
      $("#gtel").val('020394000');
      $("#gemail").val('gesundheitsaufsicht@stadt-Duisburg.de');
    }

    if (this.value == 'wesel') {
      $("#gname").val('Gesundheitsamt Kreis Wesel');
      $("#gplz").val('46483');
      $("#gcity").val('Wesel');
      $("#gstrasse").val('Jülicherstr. 6');
      $("#gtel").val('02812070');
      $("#gemail").val('pocmeldung@kreis-wesel.de');
    }


    if (this.value == 'andre') {
      $("#gname").val('');
      $("#gplz").val('');
      $("#gcity").val('');
      $("#gstrasse").val('');
      $("#gtel").val('');
      $("#gemail").val('');
    }

});
</script>
</x-app-layout>
