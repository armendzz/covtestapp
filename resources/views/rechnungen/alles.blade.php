<x-app-layout>
    <div class="pb-5 px-5 ">
        <div class="container pb-5">
            <div class="card">
                {{-- <livewire:testen /> --}}
                <h3 class="text pl-3 mt-2">Bitte Datum wahlen</h3>
                <div class="card-body">
                    <form action="/allesrechnungen" method="POST">
                        @csrf
                        <div class="mx-auto">
                            <div class="mx-auto mb-2">
                                <input type="date" name='date' id="dt" onchange="handler(event);">
                            </div>
                     
                        <button type="submit" class="btn btn-primary" id="rechungenansehen" disabled>Rechnungen Ansehen</button>
                        </div>
                    </form>
                    <hr>

                </div>
            </div>
        </div>
        <div>

            <script>
                function handler(e) {
                    document.getElementById('rechungenansehen').disabled = false;
                }
            </script>
        </div>
</x-app-layout>
