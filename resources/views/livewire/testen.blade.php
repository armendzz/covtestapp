<div>
    <div class="px-4 space-y-4 mt-8">
        <form method="get">
            <div class="form-group row">
                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Kundenname</label>
                <div class="col-sm-10">
                    <input class="form-control form-control-lg" type="text" placeholder="Test suchen"
                        wire:model="term" />
                </div>
            </div>
        </form>
        <hr>
        <div class="list">
            <div wire:loading>Suchen tests...</div>
            <div wire:loading.remove>
                @if ($term == '')
                    <div class="text-gray-500 text-sm">
                        Bitte mindesten 3 Buchstaben eingeben.
                    </div>
                @else
                    @if (isset($tests))
                        @if ($tests->isEmpty())
                            <div class="text-gray-500 text-sm">
                                Kein Test mit den eingegebenen Daten gefunden.
                            </div>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Kunde/Kundin</th>
                                        <th scope="col">Getestet durch</th>
                                        <th scope="col">Datum & Uhrzeit</th>
                                        <th scope="col">Ergebnis</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tests as $test)
                                        @if ($test->digital == 1 && !isset($test->ergebnis))
                                        @else
                                            <tr>
                                                <th scope="row">{{ $test->ln }}, {{ $test->fn }} <br>Geb:
                                                    {{ $test->dob }}</th>
                                                <td>@if(isset($test->user->name)){{ $test->user->name }}@endif</td>
                                                <td>{{ $test->created_at }}</td>
                                                <td>
                                                    @if ($test->ergebnis == 6)
                                                        <span class="text-success"><strong>Negativ</strong></span>
                                                    @endif
                                                    @if ($test->ergebnis == 7)
                                                        <span class="text-danger"><strong>Positiv</strong></span>
                                                    @endif
                                                    @if ($test->ergebnis == 8)
                                                        <span class="text-warning"><strong>Ungultig</strong></span>
                                                    @endif
                                                </td>
                                                <td style="text-align:right;">
                                                    <div style="display: flex; float: right;">
                                                        <form action="/tests/{{ $test->id }}" id="{{ $test->id }}"
                                                            method="post">@csrf
                                                            @method('delete')
                                                        </form>
                                                        <button type="submit" class="btn btn-danger mx-2 btn-md"> <span
                                                                data-toggle="modal" data-target="#modal{{ $test->id }}">
                                                                Löschen</span> </button>
                                                        <a class="btn btn-primary mx-2 btn-md"
                                                            href="/tests/{{ $test->id }}">Test
                                                            ansehen</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    @else
                        <div class="text-gray-500 text-sm">
                            Bitte mindesten 3 Buchstaben eingeben.
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
    <div class="px-4 mt-4">
        <div class="paginate">
        </div>
    </div>
</div>
