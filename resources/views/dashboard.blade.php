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
                    <div class="card col-md-4 m-3 new-card">
                        <a href="/kunde/create">
                            <div class="card-body dashboard-cards">
                                <h1 class="text-center">+</h1>
                                <h3 class="text-center">Neuer Test</h3>
                            </div>
                        </a>
                    </div>

                     {{-- In Wartezeit Card --}}
                    <div class="card col-md-4 m-3 inprogress-card">
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
                    <!-- <div class="card col-md-3 m-3 suchen-card">
                        <a href="/kunde">
                            <div class="card-body dashboard-cards">
                                <img src="https://img.icons8.com/ios-filled/50/000000/search--v4.png" />
                                <h3 class="text-center pt-3">Kunde suchen</h3>
                            </div>
                        </a>
                    </div> -->

                    {{-- Test suchen Card --}}
                  
                        <a href="/tests" class="suche-card col-md-4">
                            <div class="card-body dashboard-cards">
                                <svg style="h-8 w-8" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
                                </svg>
                                <h3 class="text-center pt-3">Test suchen</h3>
                            </div>
                        </a>
                  
                
                   
                        <a href="/stats" class="suche-card col-md-4">
                            <div class="card-body dashboard-cards">
                                <svg style="h-8 w-8" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M3,22V8H7V22H3M10,22V2H14V22H10M17,22V14H21V22H17Z" />
                                </svg>
                                <h3 class="text-center pt-3">Test Statistic</h3>
                            </div>
                        </a>
                   
                    
                        <a href="/rechnung" class="suche-card col-md-4">
                            <div class="card-body dashboard-cards">
                                <svg style="h-8 w-8" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M19.5 3.5L18 2L16.5 3.5L15 2L13.5 3.5L12 2L10.5 3.5L9 2L7.5 3.5L6 2L4.5 3.5L3 2V22L4.5 20.5L6 22L7.5 20.5L9 22L10.5 20.5L12 22L13.5 20.5L15 22L16.5 20.5L18 22L19.5 20.5L21 22V2L19.5 3.5M19 19H5V5H19V19M6 15H18V17H6M6 11H18V13H6M6 7H18V9H6V7Z" />
                                </svg>
                                <h3 class="text-center pt-3">Rechnung suchen</h3>
                            </div>
                        </a>
                  
                   
                        <a href="/allerechnungen" class="suche-card col-md-4">
                            <div class="card-body dashboard-cards">
                                <svg style="h-8 w-8" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M19.5 3.5L18 2L16.5 3.5L15 2L13.5 3.5L12 2L10.5 3.5L9 2L7.5 3.5L6 2L4.5 3.5L3 2V22L4.5 20.5L6 22L7.5 20.5L9 22L10.5 20.5L12 22L13.5 20.5L15 22L16.5 20.5L18 22L19.5 20.5L21 22V2L19.5 3.5M19 19H5V5H19V19M6 15H18V17H6M6 11H18V13H6M6 7H18V9H6V7Z" />
                                </svg>
                                <h3 class="text-center pt-3">Alle Rechnungen</h3>
                            </div>
                        </a>

                        <a href="/selbstauskunfte" class="suche-card col-md-4">
                            <div class="card-body dashboard-cards">
                                <svg style="h-8 w-8" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M19.5 3.5L18 2L16.5 3.5L15 2L13.5 3.5L12 2L10.5 3.5L9 2L7.5 3.5L6 2L4.5 3.5L3 2V22L4.5 20.5L6 22L7.5 20.5L9 22L10.5 20.5L12 22L13.5 20.5L15 22L16.5 20.5L18 22L19.5 20.5L21 22V2L19.5 3.5M19 19H5V5H19V19M6 15H18V17H6M6 11H18V13H6M6 7H18V9H6V7Z" />
                                </svg>
                                <h3 class="text-center pt-3">Alle Selbstauskunfte</h3>
                            </div>
                        </a>
                   

                </div>
                <hr>
                <div class="row justify-content-center">

                   
                </div>
                <div class="row justify-content-center">

                     {{-- Positive falle card --}}
                     <div class="card col-md-5 m-3 positive-card">
                        <a href="/positive">
                            <div class="card-body dashboard-cards">
                                <table class="mb-4">
                                    <tr>
                                      <th ></th>
                                      <th ></th>
                                   
                                    </tr>
                                    <tr class="border-b pb-2">
                                      <td class="pr-4 py-2 px-2">Kostenlos</td>
                                      <td class="px-2"> {{ $positivheutefree }}</td>
                                  
                                    </tr>
                                    <tr class="border-b pb-2">
                                      <td  class="pr-4 py-2 px-2">Kostenpflichtig 3E</td>
                                      <td class="px-2"> {{ $positivheutepaid }}</td>
                                    
                                    </tr>
                                    <tr class="border-b pb-2">
                                        <td class="pr-4 py-2 px-2">Kostenpflichtig 10E</td>
                                        <td class="px-2"> {{ $positivheutepaidten }}</td>
                                      
                                      </tr>
                                  </table>
                               
                                Positive Fälle
                            </div>
                        </a>
                    </div>


                       {{-- Today tests card --}}
                 
                    <div class="card col-md-5 m-3 stats-card text-white">
                        <a href="/stats" class="text-white ">
                            <div class="card-body dashboard-cards">
                                <table class="mb-4">
                                    <tr>
                                      <th></th>
                                      <th></th>
                                   
                                    </tr>
                                    <tr class="border-b pb-2">
                                      <td class="pr-4 py-2 px-2">Kostenlos</td>
                                      <td class="px-2"> {{ $testsheutefree }}</td>
                                  
                                    </tr>
                                    <tr class="border-b pb-2">
                                      <td  class="pr-4 py-2 px-2">Kostenpflichtig 3E</td>
                                      <td class="px-2">  {{ $testsheutepaid }}</td>
                                    
                                    </tr>
                                    <tr class="border-b pb-2">
                                        <td class="pr-4 py-2 px-2">Kostenpflichtig 10E</td>
                                        <td class="px-2"> {{ $testsheutepaidten }}</td>
                                      
                                      </tr>
                                      <tr class="border-b pb-2">
                                        <td class="pr-4 py-2 px-2"> <strong> Gesamt</strong></td>
                                        <td class="px-2"> {{$testhute}}</td>
                                      
                                      </tr>
                                  </table>
                               
                                  Tests Heute
                            </div>
                        </a>
                    </div>

                    {{-- This month tests card
                    <div class="card col-md-5 m-3 stats-card">
                       
                        <div class="card-body dashboard-cards">
                            <table class="mb-4">
                                <tr>
                                  <th></th>
                                  <th></th>
                               
                                </tr>
                                <tr class="border-b pb-2">
                                  <td class="pr-4 py-2 px-2">Kostenlos</td>
                                  <td class="px-2"> {{ $testsThisMonthfree }}</td>
                              
                                </tr>
                                <tr class="border-b pb-2">
                                  <td  class="pr-4 py-2 px-2">Kostenpflichtig 3E</td>
                                  <td class="px-2">  {{ $testsThisMonthpaid }}</td>
                                
                                </tr>
                                <tr class="border-b pb-2">
                                    <td class="pr-4 py-2 px-2">Kostenpflichtig 10E</td>
                                    <td class="px-2"> {{ $testsThisMonthpaidten }}</td>
                                  
                                  </tr>
                                  <tr class="border-b pb-2">
                                    <td class="pr-4 py-2 px-2"> <strong> Gesamt</strong></td>
                                    <td class="px-2"> {{$testsThisMonthfree + $testsThisMonthpaid + $testsThisMonthpaidten}}</td>
                                  
                                  </tr>
                              </table>
                           
                              Tests diesen Monat
                        </div>
                    
                </div> --}}
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
