<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>
    <div class="container pb-5">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">

                    {{-- Neue Kunde Card --}}
                    <div class="card col-md-3 m-3 new-card">
                        <a href="/kunde/create">
                            <div class="card-body dashboard-cards">
                                <h1 class="text-center">+</h1>
                                <h3 class="text-center">Neuer Kunde</h3>
                            </div>
                        </a>
                    </div>

                     {{-- In Wartezeit Card --}}
                    <div class="card col-md-3 m-3 inprogress-card">
                        <a href="/inwartezeit">
                            <div class="card-body dashboard-cards">
                                <h1 class="text-center">
                                    {{count($inwartezeit)}}
                                </h1>
                                <h5 class="text-center">Test(s) in Wartezeit...</h5>
                            </div>
                        </a>
                    </div>
                </div>
                <hr>
                <div class="row justify-content-center">

                    {{-- Kunde suchen Card --}}
                    <div class="card col-md-3 m-3 suchen-card">
                        <a href="/kunde">
                            <div class="card-body dashboard-cards">
                                <img src="https://img.icons8.com/ios-filled/50/000000/search--v4.png" />
                                <h3 class="text-center pt-3">Kunde suchen</h3>
                            </div>
                        </a>
                    </div>

                    {{-- Test suchen Card --}}
                    <div class="card col-md-3 m-3 suchen-card">
                        <a href="/tests">
                            <div class="card-body dashboard-cards">
                                <img src="https://img.icons8.com/ios-filled/50/000000/search--v4.png" />
                                <h3 class="text-center pt-3">Test suchen</h3>
                            </div>
                        </a>
                    </div>

                </div>
                <hr>
                <div class="row justify-content-center">

                    {{-- Positive falle card --}}
                    <div class="card col-md-3 m-3 positive-card">
                        <a href="/positive">
                            <div class="card-body dashboard-cards">
                                <h1 class="text-center">{{$positivheute}}</h1>
                                Positive Fälle
                            </div>
                        </a>
                    </div>

                    {{-- Today tests card --}}
                    <div class="card col-md-3 m-3 stats-card">
                        <div class="card-body dashboard-cards">
                            <h1 class="text-center">{{$testhute}}</h1>
                            Heute durchgeführte Tests
                        </div>
                    </div>

                    {{-- This month tests card --}}
                    <div class="card col-md-3 m-3 stats-card">
                        <div class="card-body dashboard-cards">
                            <h1 class="text-center">{{$thismonth}}</h1>
                            Diesen Monat durchgeführte Tests
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
