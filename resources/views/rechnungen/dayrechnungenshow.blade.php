<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rechnung') }}
        </h2>
    </x-slot>

    <div class="container pb-5">
        <div class="card">
            {{-- <livewire:testen /> --}}
            <h3 class="text pl-3 mt-2">Rechnungen vom: {{ $date }}</h3>
            <h3 class="text pl-3 mt-2">
              
            </h3>
            <div class="card-body">
                @if ($rechnungen->isEmpty())
                    <div class="text-gray-500 text-sm">
                        Kein Test mit den eingegebenen Daten gefunden.
                    </div>
                @else
                <form action="/rechnungdownload" method="POST">
                    @csrf
                    <input type="hidden" name="date" value="{{ $date }}">
                    <button class="btn btn-success mb-2">Heruterladen Alles Rechnungen Vom {{ $date }}</button>
                </form>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Kunde/Kundin</th>
                                <th scope="col">Rechnung NR</th>
                                <th scope="col">Datum & Uhrzeit</th>
                              
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rechnungen as $rechnung)
                                <tr>
                                    <th scope="row">{{ $rechnung->test->fn }} {{ $rechnung->test->ln }} 
                                       
                                      
                                    </th>
                                    <td>{{ $rechnung->rechung_nr }}</td>
                                    <td>{{ $rechnung->created_at }}</td>
                                    
                                    <td style="text-align:right;">
                                        <div style="display: flex; float: right;">
                                     
                                            <a class="btn btn-primary mx-2 btn-md"
                                                href="/rechnung/{{ $rechnung->id }}">Rechnung
                                                ansehen</a>
                                        </div>
                                        <!-- Modal -->
                                     
            </div>
            </td>
            </tr>
            @endforeach
            </tbody>
            </table>
          
            @endif
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</x-app-layout>
