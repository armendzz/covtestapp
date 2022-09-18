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
  position: relative;
  width: 400px;
  height: 200px;
  -moz-user-select: none;
  -webkit-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
img {
  position: absolute;
  left: 0;
  top: 0;
}

.signature-pad {
  position: absolute;
  left: 0;
  top: 0;
  width:400px;
  height:200px;
}
</style>
<body>
    <div class="w-full text-xl">
        <h1 class="text-2xl text-center mt-5">DatenInfo</h1>
        <div id="dateninfo" class="w-3/5 mx-auto border shadow rouded mt-4">
            <div class="flex w-full p-2 border-b">
                <div class="w-1/5">Nachname:</div>
                <div>Armend</div>
            </div>
            <div class="flex w-full p-2 border-b">
                <div class="w-1/5">Vorname:</div>
                <div>Armend</div>
            </div>
            <div class="flex w-full p-2 border-b">
                <div class="w-1/5">Geb:</div>
                <div>12.09.1992</div>
            </div>
            <div class="flex w-full p-2 border-b">
                <div class="w-1/5">Grund:</div>
                <div>freitesten</div>
            </div>
            <div class="flex w-full p-2 border-b">
                <div class="wrapper">
                    
                    <canvas id="signature-pad" class="signature-pad" width=400 height=200></canvas>
                  </div>
               
            </div>
            <div>
                <button id="save">Save</button>
                <button id="clear">Clear</button>
              </div>
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

saveButton.addEventListener('click', function (event) {
    console.log(canvas.toDataURL());
  const link = document.createElement('a');
  link.download = 'download.png';
  link.href = canvas.toDataURL();
  link.click();
 
});

cancelButton.addEventListener('click', function (event) {
    canvas.clear();
});
        </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.js"
        integrity="sha512-q/dWJ3kcmjBLU4Qc47E4A9kTB4m3wuTY7vkFJDTZKjTs8jhyGQnaUrxa0Ytd0ssMZhbNua9hE+E7Qv1j+DyZwA=="
        crossorigin="anonymous"></script>
    <script>
        const socket = io.connect('http://localhost:5000');
        socket.on('response', (data) => {
            notify.textContent = data;
        });
    </script>
</body>

</html>
