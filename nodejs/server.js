const express = require("express");
var cors = require('cors')

// App setup
const PORT = 5000;
const app = express();
const server = app.listen(PORT, function () {
  console.log(`Listening on port ${PORT}`);
  console.log(`http://localhost:${PORT}`);
});

// Static files
app.use(express.static("public"));
app.use(cors())


// Socket setup
const io = require("socket.io")(server, {
  cors: {
    origin: "*",
    methods: ["GET", "POST"]
  }
});

var appServerId = '';
let warteForSign = false;
let sign = '';
let allData = {};

io.on('connection', (socket) => {

  socket.on('storeClientInfo', function (data) {
    appServerId = data.customId;

    if (appServerId == "111111") {
      if (allData.sign == undefined || allData.sign == '') {
        socket.emit('checkLoading', warteForSign);
      } else {
        socket.emit('signature', allData);
      }
    }
  });


  // get data from admin and send to client
  socket.on('data', (data) => {
    allData = {};
    if (appServerId == "111111") {
      warteForSign = data.loading;
    
      allData = data;
      socket.broadcast.emit('response', data);
    }
  });

  //get data from clent and send to admin
  socket.on('sign', (data) => {
    warteForSign = false;
    allData['sign'] = data;
   
    socket.broadcast.emit('signature', allData);

  });

});