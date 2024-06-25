<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tests in Wartezeit') }}
        </h2>
    </x-slot>
    <style>
        .wrapper {

      -moz-user-select: none;
      -webkit-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    .signature-pad {
      width:400px;
      height:200px;
      border: 1px solid black;
    }
    </style>
    <div class="container py-5">
        <div class="card">

            <div class="card-body">
                @if ($tests->isEmpty())
                    <div class="text-gray-500 text-sm">
                       Keine Tests in Wartezeit.
                    </div>
                @else

                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Test-Nr</th>
                        <th scope="col">Kunde/Kundin</th>
                        <th scope="col">Wartezeit</th>
                        <th scope="col"></th>
                        <th scope="col">Ergebnis</th>
                        <th scope="col" style="text-align:right;"></th>
                      </tr>
                    </thead>
                    <tbody>


                    @foreach ($tests as $test)

                    <tr>
                        <th scope="row">{{ $test->test_nr }}</th>
                        <td> {{ $test->ln }}, {{ $test->fn }}   <p class="text-gray-500 text-sm">{{ $test->created_at }}<strong> </strong></p> </td>
                        <td>
                            @php($today = time())
                            @php($expiretime = strtotime($test->created_at . '+ 15 minute'))

                            @if ($today >= $expiretime)
                                Ergebnis erhalten
                            @else
                                <span class="text-info time hidden" id="{{ $test->test_nr + $test->test_nr + $test->test_nr}}">
                                    {{ $expiretime - $today }} </span>

                                    <span class="text-info " id="{{ $test->test_nr}}">
                                        </span>

                            @endif


                        </td>
                        <td>


                                <form action="/tests/{{ $test->id }}"
                                    method="post">@csrf @method('delete')
                                       <button type="submit" class="btn btn-outline-danger">Abbrechen</button>
                                   </form>

                        </td>
                            <form action="/test-ergebnis/{{ $test->id }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="kundeid" value="{{ $test->kunde->id }}">
                            <input class="signinput" type="hidden" name="sign" value="">
                            <td>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="ergebnis" id="{{$test->id . 'positiv'}}"
                                    value="7" required data-toggle="modal" data-target="#exampleModalCenter">

                                <label class="form-check-label text-danger" for="{{$test->id . 'positiv'}}">Positiv</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="ergebnis" id="{{$test->id . 'negativ'}}"
                                    value="6" required>
                                <label class="form-check-label text-success" for="{{$test->id . 'negativ'}}">Negativ</label>
                            </div>

                        </td>
                            <td style="text-align:right;">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                   sign
                                  </button>

                            @if($test->digital == 1)
                            <button type="submit" class="btn btn-info btn-md">
                                E-mail senden & - drucken
                            </button>
                            @else
                            <button id="testdrucken" type="submit" disabled class="btn btn-primary btn-md">
                                Test Drucken
                            </button>
                            @endif

                            </td>
                        </form>

                      </tr>

                    @endforeach
                </tbody>
            </table>
            <!-- Button trigger modal -->
            {{ $tests->links() }}

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div id="datainfo" class="w-full text-xl">
                <div id="dateninfo" class="w-full  mx-auto border shadow rouded mt-4">
                    <div class="flex w-full p-2 border-b">
                        <div class="wrapper w-full">
                            <canvas id="signature-pad" class="signature-pad mx-auto" width=400 height=200></canvas>
                          </div>
                    </div>
                    <div class="flex justify-between">


                      </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button id="clear" class="text-2xl bg-orange-400 text-white m-2 p-2 rounded hover:bg-orange-600">Korektur</button>
            <button id="save" class="text-2xl bg-green-600 text-white m-2 p-2 rounded hover:bg-green-800" data-dismiss="modal">Bestätigen</button>
        </div>
      </div>
    </div>
  </div>
                    <script>
                        // Countdown simulator
                        let clients = document.getElementsByClassName("time");
                        let interval = setInterval(function() {
                            for (i = 0; i < clients.length; i++) {

                                let countdown = clients[i].textContent - 1;
                                if (countdown <= 0) {

                                    clients[i].innerHTML = 'Ergebnis erhalten'
                                    clearInterval(interval)
                                } else {
                                    clients[i].innerHTML = countdown
                                    let minutes = Math.floor(countdown / 60);
                                    let seconds = countdown % 60;
                                    let span = document.getElementById(clients[i].id/3)

                                    if(minutes <= 9) {
                                        minutes = '0' + minutes

                                    }
                                    if(seconds <= 9){
                                            seconds = '0' + seconds
                                        }

                                    span.innerHTML = minutes  + ':' + seconds
                                    if(minutes == 0 && seconds == 1) span.innerHTML ='Ergebnis erhalten'
                                }
                            }
                        }, 1000);
                    </script>

                    <div class="paginate">

                    </div>

                @endif

            </div>
        </div>

    </div>


    </div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Positive Bestätigung</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <h6>Sie haben das Testergebnis als <span class="text-danger"> POSITIV </span> ausgewählt.</h6>
            <h4> Sind Sie sicher?</h4>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary"  onclick="confirmation()" data-dismiss="modal">Nein</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Ja, sicher</button>
        </div>
      </div>
    </div>
  </div>



<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>



  <script>
    function confirmation() {
        let input = document.getElementById('positiv');
       input.checked = false;


    }

</script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>
    var canvas = new SignaturePad(document.getElementById('signature-pad'), {
   backgroundColor: 'rgba(255, 255, 255, 0)',
   penColor: 'rgb(0, 0, 0)'
 });
 var saveButton = document.getElementById('save');
 var cancelButton = document.getElementById('clear');


 cancelButton.addEventListener('click', function (event) {
     canvas.clear();
 });


 var saveButton = document.getElementById('save');

 saveButton.addEventListener('click', function (event) {

// const link = document.createElement('a');
 //   link.download = 'download.png';
 //   link.href = canvas.toDataURL();
 //   link.click();
 const img = canvas.toDataURL();

 canvas.clear();

 const inputs = document.querySelectorAll('.signinput');

inputs.forEach((input, index) => {
    input.value = img;

})
document.getElementById('testdrucken').disabled = false;

 });


         </script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.js"
         integrity="sha512-q/dWJ3kcmjBLU4Qc47E4A9kTB4m3wuTY7vkFJDTZKjTs8jhyGQnaUrxa0Ytd0ssMZhbNua9hE+E7Qv1j+DyZwA=="
         crossorigin="anonymous"></script>


</x-app-layout>
