<script setup lang="jsx">
import navigation from '../Layout/nav.vue'

import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount } from 'vue';

const username = 'root';
const password = '02092506dD';
const token = btoa(`${username}:${password}`);
const responseData = ref({}); // Initialize as an empty object
const Check = ref(false);
// Function to fetch data
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
        responseData.value = data.response || {}; // Ensure it's an object
        Check.value = true;
    } catch (error) {
        console.error('Error:', error);
    }
};


// Fetch data on component mount
onMounted(() => {
    fetchData(); // Initial fetch
    const intervalId = setInterval(fetchData, 5000);

    // Clear interval on component unmount
    onBeforeUnmount(() => {
        clearInterval(intervalId);
    });
});
</script>


<template>

    <Head>
        <title>Активность стримов</title>
    </Head>
    <section class="content">
        <main class="main-container main-container--fullheight bots-overview">
            <h1 class="overview__title">Активность стримов</h1>
            <div class="Streams" v-if="Check">
                <template v-if="Object.keys(responseData).length === 0">
                    <i><h1 class="overview__title">Стримов нет</h1></i>
                </template>
                <template v-else-if="Object.keys(responseData).length > 0">
                    <template v-for="id in responseData">
                        <Link :href="route('stream', id)">{{ id }}</Link>
                    </template>
                </template>
            </div>
        </main>
    </section>

    <navigation></navigation>
</template>


<style lang="css">
.Streams {
    display: grid;
    grid-gap: 1em;
    grid-template-columns: repeat(auto-fill, minmax(275px, 1fr));
    min-height: 0;

    font-size: 14px;
    font-family: "Source Sans Pro", "Helvetica Neue", Helvetica, Arial, sans-serif;

    a {
        text-decoration: none;
    }

    .stream_list {
        background: #222;
        border-radius: 0 0 4px 4px;
        padding: .5em;
        transition: border .3s;
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
