<!-- resources/js/components/VoiceChat.vue -->
<template>
    <div>
        <button @click="connectToVoice">Connect to Voice</button>
        <audio ref="audio" autoplay></audio>
    </div>
</template>

<script>
import SimplePeer from 'simple-peer';

export default {
    data() {
        return {
            peer: null,
        };
    },
    methods: {
        connectToVoice() {
            const ws = new WebSocket('ws://localhost:3000');
            this.peer = new SimplePeer({ initiator: true, trickle: false });

            this.peer.on('signal', data => {
                ws.send(JSON.stringify({ type: 'offer', offer: data }));
            });

            ws.onmessage = async (event) => {
                const data = JSON.parse(event.data);

                if (data.type === 'answer') {
                    this.peer.signal(data.answer);
                } else if (data.type === 'candidate') {
                    await this.peer.addIceCandidate(data.candidate);
                }
            };

            this.peer.on('stream', stream => {
                this.$refs.audio.srcObject = stream;
            });
        },
    },
};
</script>
