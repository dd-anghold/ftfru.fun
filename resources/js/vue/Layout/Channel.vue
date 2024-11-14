<template>
    <li>
        <!-- Display the channel name -->
        <div class="channel">
            <strong>{{ channel.channel_name }}</strong>
        </div>

        <!-- Display online users in the channel -->
        <ul class="users">
            <li v-for="client in channel.clients" :key="client.nickname" :class="{'status--online': client.status === 'online', 'status--away': client.status === 'away'}">
                {{ client.nickname }} ({{ client.status }})
            </li>
        </ul>

        <!-- Display subchannels recursively -->
        <ul v-if="channel.subchannels.length" class="subchannels">
            <Channel v-for="subchannel in channel.subchannels" :key="subchannel.cid" :channel="subchannel" />
        </ul>
    </li>
</template>

<script setup lang="jsx">
import { defineProps } from 'vue';

const props = defineProps({
    channel: {
        type: Object,
        required: true
    }
});
</script>

<style lang="scss">
.channel {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 0.5em;
}

.users {
    list-style-type: none;
    padding-left: 1em;
}

.subchannels {
    list-style-type: none;
    padding-left: 1.5em;
}
</style>
