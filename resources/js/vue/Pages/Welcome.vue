<script setup lang="jsx">
import navigation from '../Layout/nav.vue'

import { ref, onMounted, onBeforeUnmount } from 'vue';
import { usePage, Head } from '@inertiajs/vue3';

// Определяем реактивное свойство playerData
const playerData = ref([]);

// Функция для получения данных игрока
const fetchPlayerData = async () => {
    try {
        const response = await fetch(`https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=39EA90A863FC233C9868C29FF3591B68&steamids=${usePage().props.playerData}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            },
        });

        // Проверяем, успешен ли ответ
        if (!response.ok) {
            throw new Error('HTTP error ' + response.status);
        }
        const data = await response.json(); // Преобразуем ответ в JSON
        playerData.value = data.response.players; // Сохраняем данные игроков в реактивное свойство

        // Сортируем players по порядку steamid из usePage().props.playerData
        const steamIdsOrder = usePage().props.playerData.split(','); // Преобразуем строку в массив
        playerData.value.sort((a, b) => {
            const indexA = steamIdsOrder.indexOf(a.steamid);
            const indexB = steamIdsOrder.indexOf(b.steamid);
            return indexA - indexB; // Сравниваем индексы для сортировки
        });

    } catch (error) {
        console.error('Error:', error);
    }
};

// Получаем данные игрока при монтировании компонента
onMounted(() => {
    fetchPlayerData(); // Первоначальная загрузка данных
    const intervalId = setInterval(fetchPlayerData, 5000);

    onBeforeUnmount(() => {
        clearInterval(intervalId);
    });
});

// Функции для получения статуса
const getStatusText = (status) => {
    switch (status) {
        case 0: return 'Офлайн';
        case 1: return 'В сети';
        case 2: return 'Занят';
        case 3: return 'Отошел';
        case 4: return 'Не беспокоить';
        case 5: return 'Ищет обмен';
        case 6: return 'Ищет игру';
        default: return 'Неизвестный статус';
    }
};

const getStatusTextEng = (status) => {
    switch (status) {
        case 0: return 'Offline';
        case 1: return 'Online';
        case 2: return 'Busy';
        case 3: return 'Away';
        case 4: return 'Do not disturb';
        case 5: return 'Looking for trade';
        case 6: return 'Looking for game';
        default: return 'Unknown status';
    }
};

</script>

<template>

    <Head>
        <title>Актив стима</title>
    </Head>
    <section class="content">
        <main class="main-container main-container--fullheight bots-overview">
            <h1>Активность стима</h1>
            <div class="bots">
                <template v-for="player in playerData" :key="player.steamid"> <!-- Добавляем key для элементов -->
                    <a :href="'https://steamcommunity.com/profiles/' + player.steamid" target="_blank">
                        <div class="bot" :class="`status--${getStatusTextEng(player.personastate).toLowerCase()}`">
                            <img :src="player.avatarfull" class="bot__avatar has-tooltip" data-original-title="null">
                            <div class="bot__status">
                                <span class="bot__status-property bot__status-property--name has-tooltip">
                                    {{ player.personaname }}
                                </span>
                                <span class="bot__status-property bot__status-property--text">
                                    <template v-if="player.gameextrainfo">
                                        Play in {{ player.gameextrainfo }}
                                    </template>
                                    <template v-else>
                                        {{ getStatusText(player.personastate) }}
                                    </template>
                                </span>
                            </div>
                        </div>
                    </a>
                </template>
            </div>
        </main>
    </section>

    <navigation></navigation>
</template>

<style lang="scss">
/* Ваши стили остаются без изменений */
h1 {
    font-size: 2rem;
    margin-bottom: 1rem;
}

.bots {
    display: grid;
    grid-gap: 1em;
    grid-template-columns: repeat(auto-fill, minmax(275px, 1fr));
    min-height: 0;

    font-size: 14px;
    font-family: "Source Sans Pro", "Helvetica Neue", Helvetica, Arial, sans-serif;

    a {
        text-decoration: none;
    }

    .bot {
        background: #222;
        border-radius: 0 0 4px 4px;
        display: grid;
        grid-template-areas: "avatar meta";
        grid-template-columns: min-content 1fr;
        padding: .5em;
        transition: border .3s;
    }

    .bot__avatar {
        cursor: pointer;
        display: block;
        height: 2.25em;
        margin-right: .5em;
        max-width: 2.25em;
        width: auto;
    }

    .bot__status {
        cursor: pointer;
        display: flex;
        flex-direction: column;
        overflow: hidden;

        .bot__status-property {
            display: inline-block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .bot__status-property--name {
            font-weight: 600;
        }

        .bot__status-property--text {
            font-size: .8em;
            font-style: italic;
        }
    }
}

.status--offline {
    border-top: 3px solid #f44336;
}

/* Красный */
.status--online {
    border-top: 3px solid #4caf50;
}

/* Зеленый */
.status--busy {
    border-top: 3px solid #ff9800;
}

/* Оранжевый */
.status--away {
    border-top: 3px solid #2196f3;
}

/* Синий */
.status--snooze {
    border-top: 3px solid #9e9e9e;
}

/* Серый */
.status--looking-to-trade {
    border-top: 3px solid #673ab7;
}

/* Пурпурный */
.status--looking-to-play {
    border-top: 3px solid #3f51b5;
}

/* Тёмно-синий */
</style>
