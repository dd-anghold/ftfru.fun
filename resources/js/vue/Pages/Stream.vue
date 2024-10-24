<script setup lang="jsx">
import navigation from '../Layout/nav.vue'

import OvenPlayerVue3 from "ovenplayer-vue3";
import { Head, usePage } from '@inertiajs/vue3';

const readyHandler = function (event) {
}
const errorHandler = function (event) {
}

const playerConfig = {
    autoStart: true,
    autoFallback: true,
    mute: false,
    sources: [
        {
            "type": "webrtc",
            "file": "ws://80.87.201.211:3333/app/" + usePage().props.streamid
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
