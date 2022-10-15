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


io.on('connection', (socket) => {

  socket.on('storeClientInfo', function (data) {
  appServerId = data.customId;

  if(appServerId == "111111"){
    socket.emit('checkLoading', warteForSign); 
  }

});


  socket.on('data', (data) => {

    if(appServerId == "111111"){
      warteForSign = data.loading;
      socket.broadcast.emit('response', data); 
    }
    
        //sends the data to everyone except you.
   // socket.broadcast.emit('response', data); 
  //  console.log(data);
    //sends the data to everyone connected to the server
    // socket.emit("response", data)
  });
});