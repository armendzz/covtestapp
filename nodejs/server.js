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


io.on('connection', (socket) => {
  console.log(`⚡: ${socket.id} user just connected`);
  socket.on('disconnect', () => {
    console.log('A user disconnected');
  });

  socket.on('message', (data) => {
        //sends the data to everyone except you.
    socket.broadcast.emit('response', data); 

    //sends the data to everyone connected to the server
    // socket.emit("response", data)
  });
});