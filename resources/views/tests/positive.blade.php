<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Test suchen') }}
        </h2>
    </x-slot>
    <div class="container pb-5">
        <div class="card">
            <div class="text-center mt-1"><strong>Info:</strong> GH = Gesundheitsamt, KD = Kunde</div>
            <div class="card-body">
                @if ($positiveheute->isEmpty())
                    <div class="text-gray-500 text-sm">
                        Kein Test mit den eingegebenen Daten gefunden.
                    </div>
                @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Kunde/Kundin</th>
                                <th scope="col">Getestet durch</th>
                                <th scope="col">Kunde <br> Angemelded</th>
                                <th scope="col">Gesundheitsamt <br> Angemeldet</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($positiveheute as $test)
                                @if (isset($test->kunde))
                                    @if ($test->digital == 1 && !isset($test->ergebnis))
                                    @else
                                        <tr>
                                            <th scope="row">{{ $test->ln }},
                                                {{ $test->fn }} <br>Geb:
                                                {{ $test->dob }}
                                            </th>
                                            <td>{{ $test->user->name }}</td>
                                            <td>  @if ($test->kundeinformieren == 1)
                                                <span class="text-success"><strong>JA</strong></span>
                                            @endif
                                            @if ($test->kundeinformieren == 0)
                                                <span class="text-danger"><strong>Nein</strong></span>
                                            @endif</td>
                                            <td>
                                                @if ($test->ghaanmeldung == 1)
                                                    <span class="text-success"><strong>JA</strong></span>
                                                @endif
                                                @if ($test->ghaanmeldung == 0)
                                                    <span class="text-danger"><strong>Nein</strong></span>
                                                @endif
                                            </td>
                                            <td style="text-align:right;">
                                                <div style="display: flex; float: right;">
                                                    <form action="/tests/{{ $test->id }}" id="{{ $test->id }}"
                                                        method="post">@csrf @method('delete')
                                                    </form>
                                                    <button type="submit" class="btn btn-danger mx-2 btn-md"> <span
                                                            data-toggle="modal" data-target="#modal{{ $test->id }}">
                                                            Löschen</span> </button>
                                                    <a class="btn btn-primary mx-2 btn-md"
                                                        href="/tests/{{ $test->id }}">Test ansehen</a>
                                                    <a class="btn btn-success mx-2 btn-md"
                                                        href="/positiveform/{{ $test->id }}">GH
                                                        Anmelden</a>
                                                        <form action="/infomailpositiv/{{ $test->id }}" 
                                                            method="post">@csrf 
                                                            <button type="submit" class="btn btn-warning mx-2 btn-md"
                                                        >KD
                                                        Anmelden</button>
                                                        </form>
                                                        
                                                </div>
                                                <!-- Modal -->
                                                <div class="modal fade" id="modal{{ $test->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalCenterTitle"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">
                                                                    Löschen Bestätigung</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h6>Sie wollen das Test<span class="text-danger">
                                                                        Löschen </span>.</h6>
                                                                <h4> Sind Sie sicher?</h4>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Nein</button>

                                                                <button class="btn btn-danger" data-dismiss="modal"
                                                                    onclick="event.preventDefault();document.getElementById('{{ $test->id }}').submit();">Ja,
                                                                    sicher</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
            </div>
            </td>
            </tr>
            @endif
            @endif
            @endforeach
            </tbody>
            </table>

            @endif
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

</x-app-layout>
