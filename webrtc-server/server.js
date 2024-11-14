// webrtc-server/server.js
const WebSocket = require('ws');
const { RTCPeerConnection } = require('wrtc');

const wss = new WebSocket.Server({ port: 3000 });

wss.on('connection', ws => {
    const peer = new RTCPeerConnection();

    ws.on('message', async message => {
        const data = JSON.parse(message);

        if (data.type === 'offer') {
            await peer.setRemoteDescription(data.offer);
            const answer = await peer.createAnswer();
            await peer.setLocalDescription(answer);
            ws.send(JSON.stringify({ type: 'answer', answer }));
        } else if (data.type === 'candidate') {
            peer.addIceCandidate(data.candidate);
        }
    });

    peer.onicecandidate = event => {
        if (event.candidate) {
            ws.send(JSON.stringify({ type: 'candidate', candidate: event.candidate }));
        }
    };
});
