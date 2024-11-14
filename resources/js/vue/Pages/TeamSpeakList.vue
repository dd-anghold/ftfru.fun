<script setup lang="jsx">
import Channel from '../Layout/Channel.vue';
import navigation from '../Layout/nav.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const channels = ref([]);

// Функция для получения данных о каналах и пользователях
const fetchChannelsAndUsers = async () => {
    try {
        const response = await axios.get(route('getChannelsAndUsers')); // API для получения каналов и пользователей
        channels.value = response.data; // Иерархическая структура каналов с подканалами и пользователями
    } catch (error) {
        console.error("Ошибка получения данных:", error);
    }
};

// Автоматический вызов функции при монтировании и периодическое обновление каждые 5 секунд
onMounted(() => {
    fetchChannelsAndUsers();
    setInterval(fetchChannelsAndUsers, 5000);
});

</script>

<template>
    <section class="content">
        <main class="main-container main-container--fullheight bots-overview">
            <h1 class="overview__title">TeamSpeak Каналы и Пользователи</h1>
            <div class="bots">
                <Channel v-for="channel in channels" :key="channel.cid" :channel="channel" />
            </div>
        </main>
    </section>

    <navigation></navigation>
</template>

<style lang="scss">
.bots {
    min-height: 0;
    font-size: 14px;
    font-family: "Source Sans Pro", "Helvetica Neue", Helvetica, Arial, sans-serif;
}

.status--online {
    border-top: 3px solid #4caf50;
}

.status--away {
    border-top: 3px solid #2196f3;
}

.status--busy {
    border-top: 3px solid #ff9800;
}

.status--offline {
    border-top: 3px solid #f44336;
}
</style>
