<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Document</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
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
<body>
    <div id="datainfo" class="w-full text-xl hidden">
        <h1 class="text-2xl text-center mt-5">DatenInfo</h1>
        <div id="dateninfo" class="w-full lg:w-3/5 mx-auto border shadow rouded mt-4">
            <div class="flex w-full p-2 border-b">
                <div class="min-w-[150px]">Nachname:</div>
                <div id="ln"></div>
            </div>
            <div class="flex w-full p-2 border-b">
                <div class="min-w-[150px]">Vorname:</div>
                <div id="fn"></div>
            </div>
            <div class="flex w-full p-2 border-b">
                <div class="min-w-[150px]">Geb:</div>
                <div id="dob"></div>
            </div>
            <div class="flex w-full p-2 border-b">
                <div class="min-w-[150px]">Grund:</div>
                <div id="grund"></div>
            </div>
            <div class="flex w-full p-2 border-b">
                <div class="wrapper w-full">

                    <canvas id="signature-pad" class="signature-pad mx-auto" width=400 height=200></canvas>
                  </div>

            </div>
            <div class="flex justify-between">

                <button id="clear" class="text-2xl bg-orange-400 text-white m-2 p-2 rounded hover:bg-orange-600">Korektur</button>
                <button id="save" class="text-2xl bg-green-600 text-white m-2 p-2 rounded hover:bg-green-800">Bestätigen</button>
              </div>
        </div>
    </div>

    <div id="ads" class="">
    <h1 class="text-2xl text-center mt-5">TestZentrum TZT Essen</h1>
        <div class="w-full lg:w-3/5 mx-auto border shadow rouded mt-4">

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

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
        </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.js"
        integrity="sha512-q/dWJ3kcmjBLU4Qc47E4A9kTB4m3wuTY7vkFJDTZKjTs8jhyGQnaUrxa0Ytd0ssMZhbNua9hE+E7Qv1j+DyZwA=="
        crossorigin="anonymous"></script>
    <script>
        const socket = io.connect('http://127.0.0.1:5522');


        socket.on('response', (data) => {

            if(data.loading){
                document.getElementById('datainfo').classList.remove("hidden");
            document.getElementById('ads').classList.add("hidden");
            document.getElementById('fn').innerHTML = data.fn;
            document.getElementById('ln').innerHTML = data.ln;
            document.getElementById('dob').innerHTML = data.dob;
            document.getElementById('grund').innerHTML = data.grund;
            } else {
                document.getElementById('datainfo').classList.add("hidden");
            document.getElementById('ads').classList.remove("hidden");
            document.getElementById('fn').innerHTML = '';
            document.getElementById('ln').innerHTML = '';
            document.getElementById('dob').innerHTML = '';
            document.getElementById('grund').innerHTML = '';
            canvas.clear();
            }
        });


        saveButton.addEventListener('click', function (event) {

           // const link = document.createElement('a');
            //   link.download = 'download.png';
            //   link.href = canvas.toDataURL();
            //   link.click();
            const img = canvas.toDataURL();

            socket.emit('sign', img);
            canvas.clear();
            document.getElementById('datainfo').classList.add("hidden");
            document.getElementById('ads').classList.remove("hidden");
            document.getElementById('fn').innerHTML = '';
            document.getElementById('ln').innerHTML = '';
            document.getElementById('dob').innerHTML = '';
            document.getElementById('grund').innerHTML = '';
            });




    </script>
</body>

</html>
