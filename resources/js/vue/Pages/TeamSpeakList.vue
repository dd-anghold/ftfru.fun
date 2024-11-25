<script setup lang="jsx">
import Channel from '../Layout/Channel.vue';
import navigation from '../Layout/nav.vue';

import { Head } from '@inertiajs/vue3';
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

    <Head>
        <title>
            TS List
        </title>
    </Head>
    <section class="content">
        <main class="main-container main-container--fullheight bots-overview">
            <h1 class="overview__title">TeamSpeak Каналы и Пользователи</h1>
            <div class="bots">
                <div class="server-list">
                    <Channel v-for="channel in channels" :key="channel.cid" :channel="channel" />
                </div>
            </div>
        </main>
    </section>

    <navigation></navigation>
</template>

<style lang="scss">
.server-list {
    max-width: 100%;
    padding: 10px;
    *{
        text-align: center;

    }
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
