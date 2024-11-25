<script setup lang="jsx">
import { defineProps } from 'vue';

const props = defineProps({
    channel: {
        type: Object,
        required: true
    }
});

// Функция для добавления класса highlighted
const addHighlighted = (event) => {
    event.target.classList.add('highlighted');
};

// Функция для удаления класса highlighted
const removeHighlighted = (event) => {
    event.target.classList.remove('highlighted');
};
</script>
<template>
    <div class="channel">
        <div class="channel-name" @mouseover="addHighlighted($event)" @mouseleave="removeHighlighted($event)">{{
            channel.channel_name }}</div>
        <div v-if="Object.keys(channel.clients).length > 0" v-for="client in channel.clients" :key="client.nickname"
            class="user"
            :class="{ 'status--online': client.status === 'online', 'status--away': client.status === 'away' }"
            @mouseover="addHighlighted($event)" @mouseleave="removeHighlighted($event)">
            {{ client.nickname }} ({{ client.status }})
        </div>
        <div v-if="channel.subchannels.length" class="subchannel">
            <Channel v-for="subchannel in channel.subchannels" :key="subchannel.cid" :channel="subchannel" />
        </div>
    </div>
</template>

<style lang="scss">
.channel {
    font-size: 14px;
    font-weight: bold;
    padding: 2px;
    border-radius: 4px;
    margin: 0;

    cursor: pointer;

    .channel-name {
        padding: 10px 0 10px 10px;
        background: linear-gradient(to right, #202642, #2b2b3d);
        border-radius: 8px;
        display: inline-block;
        width: 100%;
    }
}

.subchannel {
    font-size: 14px;
    margin: 0 15px;
    border-radius: 4px;
    cursor: pointer;
}

.user {
    font-size: 14px;
    margin: 5px 15px;
    padding: 5px 8px;
    border-radius: 4px;
    cursor: pointer;
    background-color: #2b2b3d;

}

.highlighted {
    background: #4c4c6e !important;
    font-weight: bold !important;
}
</style>
