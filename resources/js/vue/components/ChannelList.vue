<!-- resources/js/components/ChannelList.vue -->
<template>
    <div>
        <h2>Channels</h2>
        <ul>
            <li v-for="channel in channels" :key="channel.id">{{ channel.name }}</li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            channels: [],
        };
    },
    async created() {
        const response = await axios.get('/teamspeak/channels');
        this.channels = response.data;
        console.log(this.channel);
    },
};
</script>
