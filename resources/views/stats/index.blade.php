<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rechnung suchen') }}
        </h2>
    </x-slot>
   
    <div class="container pb-5">
        <div >
          
            <div class="m-3">
                @if($error != '')
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                    <span class="font-medium">Error!</span> {{ $error }}
                  </div>
                  @endif
            <div class="mt-16 flex items-center">
     
         
                <div>
                <form action="/stats" method="GET">
                    <label for="from" class="text-2xl mx-2">Von: </label>
                    <input class="rounded" id="from" type="date" name="fromDate">
                    <label  for="to" class="text-2xl ml-6 mx-2">Bis: </label>
                    <input class="rounded" id="to" type="date" name="toDate">
                    @csrf
                    <button type="submit" href="" class="px-2 py-1 bg-blue-600 text-white rounded text-2xl mx-6 my-auto hover:bg-blue-500">Filter</button>

                </form>
                
            </div>
            <a href="/stats" class="px-2 py-1 bg-green-600 text-white rounded text-2xl mx-6 my-auto hover:bg-green-500">Reset</a>
                
            </div>
            @if($error == '')
                <div>
                   <div class="text-xl my-4"> Test Statistik von  <span class="font-bold">{{ $from }}</span> bis <span class="font-bold"> {{ $to }}</span> </div>
                    <table class="mb-4">
                        <tr>
                            <th class="border-2 border-gray-900 px-1 text-xl">ID</th>
                            <th class="border-2 border-gray-900 px-2 text-xl">Testanspruch</th>
                            <th class="border-2 border-gray-900 px-2 text-xl">Price</th>
                            <th class="border-2 border-gray-900 px-2 text-xl">Zahl</th>

                        </tr>
                        <tr class="border border-black pb-2 text-green-800 font-bold">
                            <td class="border-2 border-gray-400 border-l-2 border-l-black px-2 py-1">1</td>
                            <td class="border-2 border-gray-400 px-2 py-1" >Kinder unter 5 Jahren </td>
                            <td class="border-2 border-gray-400 px-2 py-1 text-center"> Konstenloss </td>
                            <td class="border-2 border-gray-400 px-2 py-1 text-center border-r-black" > {{ $grund1 }}</td>

                        </tr>
                        <tr class="border-b pb-2 text-green-800 font-bold">
                            <td class="border-2 border-gray-400 border-l-2 border-l-black px-2 py-1">2</td>
                            <td class="border-2 border-gray-400 px-2 py-1" >Personen, die sich aus medizinischen Gründen nicht
                                impfen lassen können, unter anderem Schwangere im
                                ersten Trimester</td>
                            <td class="border-2 border-gray-400 px-2 py-1 text-center">Konstenloss</td>
                                <td class="border-2 border-gray-400 px-2 py-1 text-center border-r-black" > {{ $grund2 }}</td>

                        </tr>
                        <tr class="border-b pb-2 text-green-800 font-bold">
                            <td class="border-2 border-gray-400 border-l-2 border-l-black px-2 py-1">3</td>
                            <td class="border-2 border-gray-400 px-2 py-1" >Personen, die zum Zeitpunkt der Testung an klinischen
                                Studien zur Wirksamkeit von Impfstoffen gegen das
                                Coronavirus teilnehmen</td>
                            <td class="border-2 border-gray-400 px-2 py-1 text-center">Konstenloss</td>
                                <td class="border-2 border-gray-400 px-2 py-1 text-center border-r-black" > {{ $grund3 }}</td>

                        </tr>
                        <tr class="border-b pb-2 text-green-800 font-bold">
                            <td class="border-2 border-gray-400 border-l-2 border-l-black px-2 py-1">4</td>
                            <td class="border-2 border-gray-400 px-2 py-1" >Personen, bei denen ein Test zur Beendigung der Qua-
                                rantäne erforderlich ist („Freitesten“)</td>
                            <td class="border-2 border-gray-400 px-2 py-1 text-center">Konstenloss</td>
                                <td class="border-2 border-gray-400 px-2 py-1 text-center border-r-black" > {{ $grund4 }}</td>

                        </tr>
                        <tr class="border-b pb-2 text-green-800 font-bold">
                            <td class="border-2 border-gray-400 border-l-2 border-l-black px-2 py-1">5</td>
                            <td class="border-2 border-gray-400 px-2 py-1" >Personen nach § 4 Abs. 1 Satz 1 Nr. 3 und 4 TestV (z.B.

                                Besucher und Behandelte oder Bewohner in Pflege-
                                heim, Krankenhaus, etc.)</td>
                            <td class="border-2 border-gray-400 px-2 py-1 text-center">Konstenloss</td>
                                <td class="border-2 border-gray-400 px-2 py-1 text-center border-r-black" > {{ $grund5 }}</td>

                        </tr>

                        <tr class="border-b pb-2 text-yellow-500 font-bold">
                            <td class="border-2 border-gray-400 border-l-2 border-l-black px-2 py-1">6</td>
                            <td class="border-2 border-gray-400 px-2 py-1" >Personen, die am Tag der Testung eine Veranstaltung in
                                Innenräumen besuchen wollen</td>
                            <td class="border-2 border-gray-400 px-2 py-1 text-center">3E</td>
                                <td class="border-2 border-gray-400 px-2 py-1 text-center border-r-black" > {{ $grund6 }}</td>

                        </tr>
                        <tr class="border-b pb-2 text-yellow-500 font-bold">
                            <td class="border-2 border-gray-400 border-l-2 border-l-black px-2 py-1">7</td>
                            <td class="border-2 border-gray-400 px-2 py-1" >Personen, die am Tag der Testung Kontakt zu Personen
                                haben werden, die ein hohes Risiko haben, schwer an
                                Covid-19 zu erkranken (Menschen ab 60 Jahren).</td>
                            <td class="border-2 border-gray-400 px-2 py-1 text-center">3E</td>
                                <td class="border-2 border-gray-400 px-2 py-1 text-center border-r-black" > {{ $grund7 }}</td>

                        </tr>
                        <tr class="border-b pb-2 text-yellow-500 font-bold">
                            <td class="border-2 border-gray-400 border-l-2 border-l-black px-2 py-1">8</td>
                            <td class="border-2 border-gray-400 px-2 py-1" >Personen, die am Tag der Testung Kontakt zu Personen
                                haben werden, die ein hohes Risiko haben, schwer an
                                Covid-19 zu erkranken (Menschen mit Behinderung,
                                Menschen mit Vorerkrankungen).</td>
                            <td class="border-2 border-gray-400 px-2 py-1 text-center">3E</td>
                                <td class="border-2 border-gray-400 px-2 py-1 text-center border-r-black" > {{ $grund8 }}</td>

                        </tr>
                        <tr class="border-b pb-2 text-yellow-500 font-bold">
                            <td class="border-2 border-gray-400 border-l-2 border-l-black px-2 py-1">9</td>
                            <td class="border-2 border-gray-400 px-2 py-1" >Personen, die durch die Corona-Warn-App einen Hin-
                                weis auf ein erhöhtes Risiko erhalten haben („rote Ka-
                                chel“)</td>
                            <td class="border-2 border-gray-400 px-2 py-1 text-center">3E</td>
                                <td class="border-2 border-gray-400 px-2 py-1 text-center border-r-black" > {{ $grund9 }}</td>

                        </tr>
                        <tr class="border-b pb-2 text-green-800 font-bold">
                            <td class="border-2 border-gray-400 border-l-2 border-l-black px-2 py-1">10</td>
                            <td class="border-2 border-gray-400 px-2 py-1" >Leistungsberechtigte, die im Rahmen eines Persönli-
                                chen Budgets nach dem § 29 SGB IX Personen beschäf-
                                tigen, sowie Personen, die bei Leistungsberechtigten im
                                
                                Rahmen eines Persönlichen Budgets beschäftigt sind</td>
                            <td class="border-2 border-gray-400 px-2 py-1 text-center">Konstenloss</td>
                                <td class="border-2 border-gray-400 px-2 py-1 text-center border-r-black" > {{ $grund10 }}</td>

                        </tr>
                        <tr class="border-b pb-2 text-green-800 font-bold">
                            <td class="border-2 border-gray-400 border-l-2 border-l-black px-2 py-1">11</td>
                            <td class="border-2 border-gray-400 px-2 py-1" >Pflegende Angehörige</td>
                            <td class="border-2 border-gray-400 px-2 py-1 text-center">Konstenloss</td>
                            <td class="border-2 border-gray-400 px-2 py-1 text-center border-r-black" > {{ $grund11 }}</td>

                        </tr>
                        <tr class="border-b pb-2 text-green-800 font-bold">
                            <td class="border-2 border-gray-400 border-l-2 border-l-black px-2 py-1">12</td>
                            <td class="border-2 border-gray-400 px-2 py-1" >Haushaltsangehörige von nachweislich Infizierten</td>
                            <td class="border-2 border-gray-400 px-2 py-1 text-center">Konstenloss</td>
                            <td class="border-2 border-gray-400 px-2 py-1 text-center border-r-black" > {{ $grund12 }}</td>

                        </tr>
                        <tr class="border pb-2 text-red-500 font-bold">
                            <td class="border-t-2 border-r-2 border-l-2 border-gray-400 border-l-black px-2 py-1">13</td>
                            <td class="border-t-2 border-r-2 border-l-2 border-gray-400 px-2 py-1" >Ohne Grund</td>
                            <td class="border-t-2 border-r-2 border-l-2 border-gray-400 px-2 py-1 text-center">10E</td>
                            <td class="border-t-2 border-r-2 border-l-2 border-gray-400 px-2 py-1 text-center border-r-black" > {{ $grund13 }}</td>

                        </tr>
                        <tr class="border-t-2 border-black">
                            <td class="border-b-2 border-l-2 border-gray-900 px-2 py-1 text-xl"></td>
                            <td class="border-b-2 border-gray-900 px-2 py-1 text-xl" > <strong> Gesamt</strong></td>
                           
                          
                            <td class="border-b-2 border-gray-900 px-2 py-1 text-xl"></td>
                            <td class="border-2 border-gray-900 px-2 py-1 font-bold text-xl">{{ $total }}</td>
                        </tr>
                    </table>

           
                </div>
                <!-- <div class="card col-md-5 m-3 stats-card">
                       
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
                    </div> -->
                @endif
            
            </div>


        </div>
    </div>

</x-app-layout>
