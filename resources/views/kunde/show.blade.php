<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Aktueller Test') }}
        </h2>
    </x-slot>
    <div class="absolute w-full z-50 grund hidden" style="top: 300px;" id="grund3">
        <div class="bg-gray-100 border-2 border-black max-w-[1000px] mx-auto">
            <div class="font-bold bg-white text-xl text-center border-t border-r border-l rounded flex justify-between ">
                <div class="px-4 py-2">Bitte grund auswahlen</div>
                <div class="hover:tx-xl hover:cursor-pointer bg-red-600 hover:bg-red-400 px-3 py-2 text-white"
                    onclick="closeGrundAuswahl()">X</div>
            </div>
         
            <div class="form-check py-1 px-4 border border-gray-900">
                <input class="form-check-input" type="radio" onclick="kosten()" name="kosten" value="6"
                    id="6">
                <label class="form-check-label hover:cursor-pointer hover:font-bold ml-3 text-lg w-full text-black"
                    for="6">Veranstaltung in Innenräumen besuchen
                    </label>
            </div>
            <div class="form-check py-1 px-4 border border-gray-900">
                <input class="form-check-input" type="radio" onclick="kosten()" name="kosten" value="7"
                    id="7">
                <label class="form-check-label hover:cursor-pointer hover:font-bold ml-3 text-lg w-full text-black"
                    for="7">Kontakt zu ältere Personen/Risikopatienten </label>
            </div>
            <div class="form-check py-1 px-4 border border-gray-900">
                <input class="form-check-input" type="radio" onclick="kosten()" name="kosten" value="8"
                    id="8">
                <label class="form-check-label hover:cursor-pointer hover:font-bold ml-3 text-lg w-full text-black"
                    for="8">Kontakt zu Menschen mit Behinderung/Menschen mit
                    Vorerkrankungen </label>
            </div>
            <div class="form-check py-1 px-4 border border-gray-900">
                <input class="form-check-input" type="radio" onclick="kosten()" name="kosten" value="9"
                    id="9">
                <label class="form-check-label hover:cursor-pointer hover:font-bold ml-3 text-lg w-full text-black"
                    for="9">Corona-Warn-App Hinweis</label>
            </div>
            
        </div>


    </div>

    <div class="absolute w-full z-50 hidden grund" style="top: 250px;" id="grundkostenloss">
        <div class="bg-gray-100 border-2 border-black max-w-[1000px] mx-auto">
            <div class="font-bold bg-white text-xl text-center border-t border-r border-l rounded flex justify-between ">
                <div class="px-4 py-2">Bitte grund auswahlen</div>
                <div class="hover:tx-xl hover:cursor-pointer bg-red-600 hover:bg-red-400 px-3 py-2 text-white"
                    onclick="closeGrundAuswahl()">X</div>
            </div>
            <div class="form-check py-1 pl-4 border items-center">
                <input class="form-check-input" type="radio" onclick="kosten()" name="kosten" value="1"
                    id="1">
                <label class="form-check-label hover:cursor-pointer hover:font-bold ml-3 text-lg w-full text-black"
                    for="1">Kinder < 5</label>
            </div>
            <div class="form-check py-1 px-4 border border-gray-900">
                <input class="form-check-input" type="radio" onclick="kosten()" name="kosten" value="2"
                    id="2">
                <label class="form-check-label hover:cursor-pointer hover:font-bold ml-3 text-lg w-full text-black"
                    for="2">Schwangere Frauen / Personen, die sich aus medizinischen Gründen nicht impfen lassen können (Risikopatient)
                     </label>
            </div>
            <div class="form-check py-1 px-4 border border-gray-900">
                <input class="form-check-input" type="radio" onclick="kosten()" name="kosten" value="3"
                    id="3">
                <label class="form-check-label hover:cursor-pointer hover:font-bold ml-3 text-lg w-full text-black"
                    for="3">Impfstoff-Studie </label>
            </div>
            <div class="form-check py-1 px-4 border border-gray-900">
                <input class="form-check-input" type="radio" onclick="kosten()" name="kosten" value="4"
                    id="4">
                <label class="form-check-label hover:cursor-pointer hover:font-bold ml-3 text-lg w-full text-black"
                    for="4">Freitesten </label>
            </div>
            <div class="form-check py-1 px-4 border border-gray-900">
                <input class="form-check-input" type="radio" onclick="kosten()" name="kosten" value="5"
                    id="5">
                <label class="form-check-label hover:cursor-pointer hover:font-bold ml-3 text-lg w-full text-black"
                    for="5">Besucher/Behandelnde in KH, Pflegeeinrichtungen etc. </label>
            </div>
      
          
            <div class="form-check py-1 px-4 border border-gray-900">
                <input class="form-check-input" type="radio" onclick="kosten()" name="kosten" value="10"
                    id="10">
                <label class="form-check-label hover:cursor-pointer hover:font-bold ml-3 text-lg w-full text-black"
                    for="10">Leistungsberechtigte, die im Rahmen eines Persönli- chen Budgets nach dem
                    § 29 SGB IX Personen beschäf- tigen, sowie Personen, die bei Leistungsberechtigten im Rahmen eines
                    Persönlichen Budgets beschäftigt sind </label>
            </div>
            <div class="form-check py-1 px-4 border border-gray-900">
                <input class="form-check-input" type="radio" onclick="kosten()" name="kosten" value="11"
                    id="11">
                <label class="form-check-label hover:cursor-pointer hover:font-bold ml-3 text-lg w-full text-black"
                    for="11">Pflegende Angehörige </label>
            </div>
            <div class="form-check py-1 px-4 border border-gray-900">
                <input class="form-check-input" type="radio" onclick="kosten()" name="kosten" value="12"
                    id="12">
                <label class="form-check-label hover:cursor-pointer hover:font-bold ml-3 text-lg w-full text-black"
                    for="12">Haushaltsangehörige von nachweislich Infizierten </label>
            </div>
      
        </div>


    </div>
    <div class="container">
        <div class="card mb-6">

            {{-- Kudendaten bearbeiten button --}}
            <div class="card-header d-flex justify-content-between">
                <h4>Testdaten</h4> <a class="btn btn-secondary btn-md"
                    href="/kunde/{{ $kunde->id }}/edit">Testdaten bearbeiten</a>
            </div>

            {{-- show kunden daten --}}
            <div class="card-body">
                <ul class="client-info-list">
                    <li class="client-li">
                        <div class="client-att">Name: </div>
                        <div class="client-data">{{ $kunde->fn }} {{ $kunde->ln }} </div>
                    </li>
                    <li class="client-li">
                        <div class="client-att">Anschrift:</div>
                        <div class="client-data"> {{ $kunde->addresse }} </div>
                    </li>
                    <li class="client-li">
                        <div class="client-att">Geburtstag:</div>
                        <div class="client-data"> {{ $kunde->dob }} </div>
                    </li>
                    <li class="client-li">
                        <div class="client-att">E-Mail Adresse:</div>
                        <div class="client-data"> {{ $kunde->email }}</div>
                    </li>
                    <li class="client-li">
                        <div class="client-att">Tel:</div>
                        <div class="client-data"> {{ $kunde->phone }}</div>
                    </li>
                    <li class="client-li">
                        <div class="client-att">Personalausweis-Nr:</div>
                        <div class="client-data"> {{ $kunde->idnumber }} </div>
                    </li>
                    <li class="client-li">
                        <div class="client-att ">Notize:</div>
                        <textarea readonly class="form-control mt-2 mb-2 form-control-lg" name="notice" id="notice" cols="30" rows="10">{{ $kunde->notice }}</textarea>
                     
                    </li>
                </ul>

                {{-- <div class="w-full">
                    <select name="kosten" id="kosten">
                        <option value="0" disabled selected>Bitte Grund auswahlen</option>
                        <option value="1">Kinder unter 5 Jahren</option>
                        <option value="2">Personen, die sich aus medizinischen Gründen nicht impfen lassen können, unter anderem Schwangere im ersten Trimester</option>
                        <option value="3">Personen, die zum Zeitpunkt der Testung an klinischen Studien zur Wirksamkeit von Impfstoffen gegen das Coronavirus teilnehmen	</option>
                        <option value="4">Personen, bei denen ein Test zur Beendigung der Qua- rantäne erforderlich ist („Freitesten“)	</option>
                        <option value="5">Personen nach § 4 Abs. 1 Satz 1 Nr. 3 und 4 TestV (z.B. Besucher und Behandelte oder Bewohner in Pflege- heim, Krankenhaus, etc.)	</option>
                        <option value="6">Personen, die am Tag der Testung eine Veranstaltung in Innenräumen besuchen wollen	</option>
                        <option value="7">Personen, die am Tag der Testung Kontakt zu Personen haben werden, die ein hohes Risiko haben, schwer an Covid-19 zu erkranken (Menschen ab 60 Jahren).	</option>
                        <option value="8">Personen, die am Tag der Testung Kontakt zu Personen haben werden, die ein hohes Risiko haben, schwer an Covid-19 zu erkranken (Menschen mit Behinderung, Menschen mit Vorerkrankungen).	</option>
                        <option value="9">Personen, die durch die Corona-Warn-App einen Hin- weis auf ein erhöhtes Risiko erhalten haben („rote Ka- chel“)	</option>
                        <option value="10">Leistungsberechtigte, die im Rahmen eines Persönli- chen Budgets nach dem § 29 SGB IX Personen beschäf- tigen, sowie Personen, die bei Leistungsberechtigten im Rahmen eines Persönlichen Budgets beschäftigt sind	</option>
                        <option value="11">Pflegende Angehörige	</option>
                        <option value="12">Haushaltsangehörige von nachweislich Infizierten	</option>
                        <option value="13">Ohne Grund	</option>
                    </select>
                </div> --}}
                <div>
                    <div class="flex justify-center gap-3">
{{-- 


                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" onclick="kosten()"  name="kosten" value="free" id="free">
                            <label class="form-check-label text-lg text-success" for="free">Kostenlos</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" onclick="kosten()"  name="kosten" value="paid" id="paid">
                            <label class="form-check-label text-lg text-warning" for="paid">Kosten: 3€</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" onclick="kosten()"  name="kosten" value="10" id="10">
                            <label class="form-check-label text-lg text-danger" for="10">Kosten: 10€</label>
                        </div> --}}
                        <button class="btn-success btn" onclick="openKostenlossGrundAuswahl()">Grund
                            Auswahlen Kostenloss</button>
                            <button class="btn-warning btn" onclick="open3eGrundAuswahl()">Grund
                                Auswahlen 3E</button>
                                <button class="btn-danger btn" onclick="ohneGrund()">Ohne Grund 10E
                                    </button>
                    </div>
                </div>
                <hr>
                
                <div class="buttons mx-2 my-3">

                    {{-- Testen und drucken button --}}
                    <form action="/tests" method="post" enctype="multipart/form">
                        @csrf
                        <input type="hidden" name="kundeid" value="{{ $kunde->id }}">
                        <input type="hidden" name="digital" value="0">
                        <input type="hidden" name="price" id="pricedrucken" value="">
                        <button class="btn-primary btn" id="btndrucken" disabled>Testen & Drucken</button>
                    </form>
                  
                    {{-- Show "Testen & Email" button only if kunde has e-mail --}}
                    @if (isset($kunde->email))
                        <form action="/tests" method="post" enctype="multipart/form">
                            @csrf
                            <input type="hidden" name="kundeid" value="{{ $kunde->id }}">
                            <input type="hidden" name="digital" value="1">
                            <input type="hidden" name="price" id="priceemail" value="">
                            <button class="btn-info btn" id="btnemail" disabled>Testen & E-mail</button>
                        </form>
                    @endif
                </div>
                <hr>
                <div id="ausgewahlteGrundLabel" class="hidden">Ausgewalte Grund:</div>
                <div id="ausgewahlteGrund">

                </div>
                    <script>
                        function ohneGrund(){   

                            document.getElementById('btndrucken').disabled = false;

document.getElementById('pricedrucken').value = '13';



                           
                                grundText = 'Ohne Grund	'
                            
   
                                document.getElementById('ausgewahlteGrund').innerHTML = grundText;

                                
document.getElementById('btnemail').disabled = false;
document.getElementById('priceemail').value = '13';
                        }

                        function kosten() {
                            let price = document.querySelector('input[name="kosten"]:checked').value;
                            document.getElementById('btndrucken').disabled = false;

                            document.getElementById('pricedrucken').value = price;

                            
                           

                            const dialog = document.getElementById('grundkostenloss');
                            const dialog3 = document.getElementById('grund3');

                            dialog.classList.add("hidden");
                            dialog3.classList.add("hidden");
                            
                            
                            
                            document.getElementById('ausgewahlteGrundLabel').classList.remove('hidden')

                            let grundText = '';

                            if(price == 1){
                                grundText = 'Kinder unter 5 Jahren';
                            } 
                            if(price == 2){
                                grundText = 'Personen, die sich aus medizinischen Gründen nicht impfen lassen können, unter anderem Schwangere im ersten Trimester	'
                           
                            } 
                            if(price == 3){
                                grundText = 'Personen, die zum Zeitpunkt der Testung an klinischen Studien zur Wirksamkeit von Impfstoffen gegen das Coronavirus teilnehmen	'
                            }

                            if(price == 4){
                                grundText = 'Personen, bei denen ein Test zur Beendigung der Qua- rantäne erforderlich ist („Freitesten“)	'
                            }
                            
                            if(price == 5){
                                grundText = 'Personen nach § 4 Abs. 1 Satz 1 Nr. 3 und 4 TestV (z.B. Besucher und Behandelte oder Bewohner in Pflege- heim, Krankenhaus, etc.)	'
                            }

                            if(price == 6){
                                grundText = 'Personen, die am Tag der Testung eine Veranstaltung in Innenräumen besuchen wollen	' 
                            }
                            
                            if(price == 7){
                                grundText = 'Personen, die am Tag der Testung Kontakt zu Personen haben werden, die ein hohes Risiko haben, schwer an Covid-19 zu erkranken (Menschen ab 60 Jahren).	'
                            }

                            if(price == 8){
                                grundText = 'Personen, die am Tag der Testung Kontakt zu Personen haben werden, die ein hohes Risiko haben, schwer an Covid-19 zu erkranken (Menschen mit Behinderung, Menschen mit Vorerkrankungen).	'
                            }
                     
                            if(price == 9){
                                grundText = 'Personen, die durch die Corona-Warn-App einen Hin- weis auf ein erhöhtes Risiko erhalten haben („rote Ka- chel“)	'
                            }
                            
                            if(price == 10){
                                grundText = 'Leistungsberechtigte, die im Rahmen eines Persönli- chen Budgets nach dem § 29 SGB IX Personen beschäf- tigen, sowie Personen, die bei Leistungsberechtigten im Rahmen eines Persönlichen Budgets beschäftigt sind	'
                            }
                           
                            if(price == 11){
                                grundText = 'Pflegende Angehörige	'
                            }
                            
                            if(price == 12){
                                grundText = 'Haushaltsangehörige von nachweislich Infizierten	'
                            }
                            
                            if(price == 13){
                                grundText = 'Ohne Grund	'
                            }
   
                                document.getElementById('ausgewahlteGrund').innerHTML = grundText;

                                document.getElementById('btnemail').disabled = false;
                            document.getElementById('priceemail').value = price;
                        }


                        function openKostenlossGrundAuswahl() {
                            const dialog = document.getElementById('grundkostenloss');

                            dialog.classList.remove("hidden");
                        }

                        function open3eGrundAuswahl() {
                            const dialog = document.getElementById('grund3');

                            dialog.classList.remove("hidden");
                        }

                        function closeGrundAuswahl() {
                            const dialog = document.getElementById('grundkostenloss');
                            const dialog3 = document.getElementById('grund3');

                            dialog.classList.add("hidden");
                            dialog3.classList.add("hidden");
                        }

                        document.onkeydown = function(evt) {
                            evt = evt || window.event;
                            var isEscape = false;
                            if ("key" in evt) {
                                isEscape = (evt.key === "Escape" || evt.key === "Esc");
                            } else {
                                isEscape = (evt.keyCode === 27);
                            }
                            if (isEscape) {
                                const dialog = document.getElementById('grundkostenloss');
                                const dialog3 = document.getElementById('grund3');

                            dialog.classList.add("hidden");
                            dialog3.classList.add("hidden");
                            }
                        };
                    </script>
                
            </div>
        </div>
    </div>

</x-app-layout>
