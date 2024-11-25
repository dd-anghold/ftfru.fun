<script setup lang="jsx">
import navigation from '../Layout/nav.vue';

import { ref, onMounted, onBeforeUnmount } from 'vue';
import { usePage, Head, Link } from '@inertiajs/vue3';

// Определяем реактивные свойства
const playerData = ref([]);
const responseData = ref({});
const usersAndChannels = ref([]); // Данные о пользователях и каналах

// Для авторизации
const username = 'root';
const password = '02092506dD';
const token = btoa(`${username}:${password}`);

// Функция для получения данных игроков
const fetchPlayerData = async () => {
    try {
        const response = await fetch(`https://ftfru.fun/steam-api/ISteamUser/GetPlayerSummaries/v0002/?key=5775462EC5EBC648147BAD6A9809D128&steamids=${usePage().props.playerData}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('HTTP error ' + response.status);
        }
        const data = await response.json();
        playerData.value = data.response.players;

        // Сортируем players по steamid
        const steamIdsOrder = usePage().props.playerData.split(',');
        playerData.value.sort((a, b) => {
            const indexA = steamIdsOrder.indexOf(a.steamid);
            const indexB = steamIdsOrder.indexOf(b.steamid);
            return indexA - indexB;
        });

        // Обновляем данные для playerData, включая streamId и teamspeakId
        let streamIds = usePage().props.streamIds.map(id => id.toLowerCase());
        let teamspeakid = usePage().props.teamspeakid;

        playerData.value = playerData.value.map((player, index) => ({
            ...player,
            streamid: streamIds[index] || player.steamid,
            teamspeakid: teamspeakid[index] || null,
        }));
    } catch (error) {
        console.error('Error fetching player data:', error);
    }
};

// Функция для получения данных о стримах через WebSocket
const fetchData = async () => {
    try {
        const response = await fetch('https://stream.ftfru.fun/api/default/apps/app/streams', {
            method: 'GET',
            headers: {
                'Authorization': `Basic ${token}`,
                'Accept': 'application/json'
            },
            mode: 'cors' // Explicitly set CORS mode
        });

        // Check if the response is successful
        if (!response.ok) {
            throw new Error('HTTP error ' + response.status);
        }

        const data = await response.json(); // Parse the JSON response

        // Convert all string values in data.response to lowercase
        const convertToLowercase = (obj) => {
            if (typeof obj === 'string') {
                return obj.toLowerCase();
            } else if (Array.isArray(obj)) {
                return obj.map(convertToLowercase);
            } else if (obj && typeof obj === 'object') {
                return Object.keys(obj).reduce((acc, key) => {
                    acc[key] = convertToLowercase(obj[key]);
                    return acc;
                }, {});
            }
            return obj;
        };

        responseData.value = convertToLowercase(data.response || {});
    } catch (error) {
        console.error('Error:', error);
    }
};
// Функция для получения данных о пользователях и каналах
const fetchUsersAndChannels = async () => {
    try {
        const response = await fetch('https://ftfru.fun/teamspeak/users-with-channels', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('HTTP error ' + response.status);
        }

        const data = await response.json();
        usersAndChannels.value = data; // Сохраняем данные о пользователях и их каналах
    } catch (error) {
        console.error('Error fetching users and channels:', error);
    }
};

// Запросы и интервалы обновления данных
onMounted(() => {
    fetchPlayerData(); // Первоначальная загрузка данных игроков
    fetchData(); // Первоначальная загрузка данных стримов
    fetchUsersAndChannels(); // Первоначальная загрузка данных пользователей и каналов

    const playerDataInterval = setInterval(fetchPlayerData, 7500);
    const streamDataInterval = setInterval(fetchData, 7500);
    const usersAndChannelsInterval = setInterval(fetchUsersAndChannels, 7500);

    // Очистка интервалов перед размонтированием компонента
    onBeforeUnmount(() => {
        clearInterval(playerDataInterval);
        clearInterval(streamDataInterval);
        clearInterval(usersAndChannelsInterval);
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

const getStatusTextEngStatus = (status) => {
    switch (status) {
        case 0: return 'Offline';
        case 1: return 'Online';
        case 2: return 'Busy';
        case 3: return 'Away';
        case 4: return 'Do-not-disturb';
        case 5: return 'Looking-for-trade';
        case 6: return 'Looking-for-game';
        default: return 'Unknown status';
    }
};
</script>


<template>

    <Head>
        <title>Activity</title>
    </Head>
    <section class="content">
        <main class="main-container">
            <h1 class="overview__title">Activity</h1>
            <div class="bots">
                <template v-for="player, index in playerData" :key="player.steamid">
                    <!-- Добавляем key для элементов -->
                    <div class="bot" :class="`status--${getStatusTextEngStatus(player.personastate).toLowerCase()}`">
                        <a :href="'https://steamcommunity.com/profiles/' + player.steamid" target="_blank">
                            <img :src="player.avatarfull" class="bot__avatar has-tooltip" data-original-title="null">
                        </a>
                        <div class="bot__status">
                            <span class="bot__status-property bot__status-property--name has-tooltip">
                                <a :href="'https://steamcommunity.com/profiles/' + player.steamid" target="_blank">
                                    {{ player.personaname }}
                                </a>
                            </span>
                            <span class="bot__status-property bot__status-property--text">
                                <template v-if="!player.gameextrainfo">
                                    {{ getStatusTextEng(player.personastate) }}
                                </template>
                                <template v-else-if="player.gameextrainfo">
                                    Play in {{ player.gameextrainfo }}
                                </template>
                            </span>
                            <span class="bot__status-property bot__status-property--text">
                                <template v-if="usersAndChannels[player.teamspeakid]">
                                    Sits in the channel {{ usersAndChannels[player.teamspeakid] }}
                                </template>
                                <template v-else-if="!usersAndChannels[player.teamspeakid]">
                                    Offline in TS
                                </template>
                            </span>
                        </div>
                        <div class="stream_action">
                            <template v-if="Object.values(responseData).includes(player.steamid)">
                                <Link :href="route('stream', player.steamid)">
                                <i class="fa-solid fa-play"></i>
                                </Link>
                            </template>
                            <template v-else-if="Object.values(responseData).includes(player.streamid)">
                                <Link :href="'/streams/' + player.streamid">
                                <i class="fa-solid fa-play"></i>
                                </Link>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </main>
    </section>

    <navigation></navigation>
</template>

<style lang="scss">
.bots {
    display: grid;
    grid-gap: 1em;
    grid-template-columns: repeat(auto-fill, minmax(275px, 1fr));
    min-height: 0;

    font-size: 14px;
    font-family: "Source Sans Pro", "Helvetica Neue", Helvetica, Arial, sans-serif;

    a {
        text-decoration: none;
        box-sizing: border-box;
    }

    .stream_action {
        align-items: center;
        display: flex;
        grid-area: buttons;
        justify-content: space-around;
        font-size: 2em;
    }

    .bot {
        background: #222;
        border-radius: 0 0 4px 4px;
        display: grid;
        grid-template-areas: "avatar meta buttons";
        grid-template-columns: min-content 1fr;
        padding: .5em;
        transition: border .3s;
        height: 54px;
        box-sizing: border-box;
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

            a:hover {
                color: #66C0F4;
                text-decoration: none;
                cursor: pointer;
            }
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

/* Красный */
.status--offline {
    border-top: 3px solid #f44336;

    .stream_action i:hover {
        color: #f44336;
    }
}

/* Зеленый */
.status--online {
    border-top: 3px solid #4caf50;

    .stream_action i:hover {
        color: #4caf50;
    }
}

/* Оранжевый */
.status--do-not-disturb {
    border-top: 3px solid #ff9800;

    .stream_action i:hover {
        color: #ff9800;
    }
}

/* Синий */
.status--away {
    border-top: 3px solid #2196f3;

    .stream_action i:hover {
        color: #2196f3;
    }
}

/* Серый */
.status--snooze {
    border-top: 3px solid #9e9e9e;

    .stream_action i:hover {
        color: #9e9e9e;
    }
}

/* Пурпурный */
.status--looking-to-trade {
    border-top: 3px solid #673ab7;

    .stream_action i:hover {
        color: #673ab7;
    }
}

/* Тёмно-синий */
.status--looking-to-play {
    border-top: 3px solid #3f51b5;

    .stream_action i:hover {
        color: #3f51b5;
    }
}
</style>
