<template>
    <div>
        <ChannelList />
        <VoiceChat />
    </div>
</template>

<script>
import ChannelList from '../components/ChannelList.vue';
import VoiceChat from '../components/VoiceChat.vue';

export default {
    components: {
        ChannelList,
        VoiceChat,
    },
};
</script>
