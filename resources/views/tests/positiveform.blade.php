
<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Neuer Kunde') }}
      </h2>
  </x-slot>
  @if(Session::has('info'))
  <p class="alert text-center alert-primary">{{ Session::get('info') }}</p>
  <h5 class="alert text-center alert-info"> Name: {{ $kunde->ln }}, {{$kunde->fn}} - Geb: {{ $kunde->dob }} - Anschrift: {{$kunde->addresse}} <a href="kundes/{{$kunde->id}}" class="btn btn-primary" >Testen</a> <a href="kundes/{{$kunde->id}}/edit" class="btn btn-info" >Kundendaten bearbeiten</a> </h5> 
  @endif
  <div class="container px-3 pb-5">
     <h3 class="mt-2 pt-2"> <strong> Gesundheitsamt Anmelden</strong></h3>
      <div class="card p-2">
      <form class="m-2" action="/positiveformprepare/{{$test[0]->id}}" method="POST" enctype="multipart/form-data">
          @csrf
          <h5 class="text-center mt-2 mb-3">Kunden Daten</h5>
            <div class="form-group row">
              <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Nachname *</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-lg" value="{{$test[0]->ln}}" name="nachname" placeholder="Mustermann" required>
              </div>
            </div>
          <div class="form-group row">
              <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Vorname *</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-lg" value="{{$test[0]->fn}}"  name="vorname" placeholder="Max" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Geburtstag *</label>
              <div class="col-sm-10">
                <input type="date" class="form-control form-control-lg" value="{{$test[0]->dob}}" name="birthday" required>
              </div>
            </div>
            <div class="form-group row">
                <label for="gender" class="col-sm-2 col-form-label col-form-label-lg">Geschlecht *</label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="mannlich"
                            value="1" required>
                        <label class="form-check-label" for="asd">Männlich</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="weiblich"
                            value="2" required>
                        <label class="form-check-label" for="asd">Weiblich</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="divers"
                            value="3" required>
                        <label class="form-check-label" for="asd">Divers</label>
                    </div>
                </div>
              </div>
            <div class="form-group row">
              <label for="strasse" class="col-sm-2 col-form-label col-form-label-lg">Anschrift *</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-lg" id="strasse" value="{{$test[0]->addresse}}" name="strasse" placeholder="Marktstr. 11" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-sm-2 col-form-label col-form-label-lg">E-Mail Adresse</label>
              <div class="col-sm-10">
                <input type="email" class="form-control form-control-lg" value="{{$test[0]->kunde->email}}" name="email" >
              </div>
            </div>
            <div class="form-group row">
              <label for="idnumber" class="col-sm-2 col-form-label col-form-label-lg">Tel.</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-lg" value="{{$test[0]->kunde->phone}}" autocomplete="autocomplete_off_hack_xfr4!k" name="phone" >
              </div>
            </div>
          <div class="form-group row">
              <label for="idnumber" class="col-sm-2 col-form-label col-form-label-lg">Personalausweis-Nr.</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-lg" autocomplete="autocomplete_off_hack_xfr4!k" name="idnumber" >
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
                        <input class="form-check-input" type="radio" name="gesundheitsamt" id="andre"
                            value="andre" required>
                        <label class="form-check-label" for="asd">Andre</label>
                    </div>
                </div>
              </div>
              <div class="other-data">
              <div class="form-group row">
                <label for="g-name" class="col-sm-2 col-form-label col-form-label-lg">Gesundheitsamt</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control form-control-lg" autocomplete="autocomplete_off_hack_xfr4!k" name="gname" >
                </div>
              </div>
              <div class="form-group row">
                <label
                  for="plz "
                  class="col-sm-2 col-form-label col-form-label-lg"
                  >PLZ *</label
                >
                <div class="col-md-3">
                  <input
                    type="text"
                    id="plz"
                    class="form-control form-control-lg"
                    name="gplz"
                    required
                  />
                </div>
                <label
                  for="city"
                  class="col-sm-2 col-form-label col-form-label-lg"
                  >Stadt *</label
                >
                <div class="col-md-5">
                  <input
                    type="text"
                    id="city"
                    class="form-control form-control-lg"
                    name="gcity"
                    required
                    
                  />
                </div>
              </div>
              <div class="form-group row">
                <label for="strasse" class="col-sm-2 col-form-label col-form-label-lg">Straße *</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control form-control-lg" id="strasse" name="gstrasse" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="g-tel" class="col-sm-2 col-form-label col-form-label-lg">Tel:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control form-control-lg" autocomplete="autocomplete_off_hack_xfr4!k" name="gtel" >
                </div>
              </div>
            </div>
            <div class="form-group row justify-content-center">
             <button type="submit" class="btn btn-lg btn-success py-3 px-5"> Gesundheitsamt Anmelden</button>
            </div>
        </form>
      </div>
  </div>
  
  </x-app-layout>
  