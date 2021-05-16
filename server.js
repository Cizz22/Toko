const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
const { Server } = require('socket.io');
const io = new Server(server, {
  cors: { origin: '*' }
});

function formatMessage (username, text) {
  return {
    username,
    text
  };
}

server.listen(3000, () => {
  console.log('Server run');
});

io.on('connection', socket => {
  console.log('connection');
  socket.emit('message', formatMessage('Admin', 'Belom selesai'));

  // listen for chat
  socket.on('chatmsg', (msg) => {
    io.emit('message', formatMessage('User', msg));
  });
});
