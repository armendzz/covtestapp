<div>
    <div class="px-4 space-y-4 mt-8">

        {{-- Search box start --}}
        <form method="get">
            <div class="form-group row">
                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Testdaten</label>
                <div class="col-sm-10">
                    <input class="form-control form-control-lg" type="text" placeholder="Test suchen"
                        wire:model="term" />
                </div>
            </div>
        </form>
        {{-- Search box end --}}

        <hr>
        <div class="list">
            <div wire:loading>Searching Test...</div>
            <div wire:loading.remove>
                <!-- 
            notice that $term is available as a public 
            variable, even though it's not part of the 
            data array 
        -->
                @if ($term == '')
                    <!-- <div class="text-gray-500 text-sm">
                        Bitte mindesten 3 Buchstaben eingeben.
                    </div> -->
                @else
                    @if (isset($kunden))
                        @if ($kunden->isEmpty())
                            <div class="text-gray-500 text-sm">
                                Kein Kunde mit den eingegebenen Daten gefunden.
                            </div>
                        @else
                            {{-- List all kunden --}}
                            @foreach ($kunden as $kunde)
                                <div class="client bg-light mb-2">
                                    <div class="client-info">
                                        <h3 class="text-lg text-gray-900 text-bold">{{ $kunde->fn }}
                                            {{ $kunde->ln }}</h3>
                                        <div class="clients-buttons"> 

                                            {{-- Testen button --}}
                                            <a class="btn btn-primary mx-2 btn-md"
                                                href="/kunde/{{ $kunde->id }}">Testen
                                            </a>
                                            
                                            {{-- Daten bearbeiten button --}}
                                            <!-- <a
                                                class="btn btn-info mx-2 btn-md"
                                                href="/kunde/{{ $kunde->id }}/edit">Daten bearbeiten
                                            </a> -->
                                            
                                            {{-- Delete button --}}
                                            <form action="/kunde/{{ $kunde->id }}" method="post">@csrf
                                                @method('delete') <button type="submit"
                                                    class="btn btn-danger mx-2 btn-md"
                                                    href="/kunde/{{ $kunde->id }}">Löschen</button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    {{-- show more kunden daten --}}
                                    <p class="text-gray-500 text-sm">{{ $kunde->email }} | {{ $kunde->addresse }} |
                                        {{ $kunde->dob }} </p>
                                    <p class="text-gray-500"></p>

                                </div>
                            @endforeach
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
</div>
