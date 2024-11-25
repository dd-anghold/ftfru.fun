<script setup lang="jsx">
import navigation from '../Layout/nav.vue';
import { ref } from 'vue';
import OvenPlayerVue3 from 'ovenplayer-vue3';
import { Head, usePage } from '@inertiajs/vue3';

const username = 'root';
const password = '02092506dD';
const token = btoa(`${username}:${password}`);
const responseData = ref({});
const streamid = ref('');
const readyHandler = function (event) { }
const errorHandler = function (event) { }

const fetchData = () => {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'https://stream.ftfru.fun/api/default/apps/app/streams', false);
    xhr.setRequestHeader('Authorization', `Basic ${token}`);
    xhr.setRequestHeader('Accept', 'application/json');

    try {
        xhr.send();

        if (xhr.status !== 200) {
            throw new Error('HTTP error ' + xhr.status);
        }

        const data = JSON.parse(xhr.responseText);

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

        responseData.value = data.response;

        const pageStreamId = usePage().props.streamid.toLowerCase();
        for (const item of Object.values(responseData.value)) {

            if (typeof item === 'string' && item.toLowerCase() === pageStreamId) {
                streamid.value = item;
                break;
            }
        }

    } catch (error) {
        console.error('Error:', error);
    }
};

// Call fetchData when the component mounts or when needed
fetchData();

// Start of Selection
const playerConfig = {
    autoStart: true,
    autoFallback: true,
    mute: false,
    p2p: true, // Enable P2P to reduce server load
    sources: [
        {
            "type": "webrtc",
            "file": "wss:stream.ftfru.fun/app/" + streamid.value// Use the original streamid
        },
    ],
}
</script>

<template>

    <Head>
        <title>Стрим {{ $page.props.streamid }}</title>
    </Head>
    <section class="content">
        <main class="main-container main-container--fullheight bots-overview">
            <div class="ovenvediaplayer">
                <OvenPlayerVue3 ref="ovenplayer" :config="playerConfig" @ready="readyHandler" @error="errorHandler">
                </OvenPlayerVue3>
            </div>
        </main>
    </section>

    <navigation></navigation>
</template>
<style lang="css">
h1 {
    font-size: 2rem;
    margin-bottom: 1rem;
}

.ovenvediaplayer {
    width: 100%;
    height: 90%;

    font-size: 14px;
    font-family: "Source Sans Pro", "Helvetica Neue", Helvetica, Arial, sans-serif;
}
</style>
