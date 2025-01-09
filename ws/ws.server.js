const express = require('express');
const WebSocket = require('ws');

const app = express();
const port = 3000;

const wss = new WebSocket.Server({ noServer: true });

let connections = [];

wss.on('connection', (ws) => {
    connections.push(ws);

    ws.on('message', (message) => {
        console.log('Mensagem recebida: ', message);
    });

    ws.on('close', () => {
        connections = connections.filter(conn => conn !== ws);
    });
});

app.post('/message', express.json(), (req, res) => {
    const { message } = req.body;

    connections.forEach(ws => {
        ws.send(message);
    });

    res.send({ message: 'Mensagem enviada a todos os clientes.' });
});

const server = app.listen(port, () => {
    console.log(`API REST rodando em http://localhost:${port}`);
});

server.on('upgrade', (request, socket, head) => {
    wss.handleUpgrade(request, socket, head, (ws) => {
        wss.emit('connection', ws, request);
    });
});
