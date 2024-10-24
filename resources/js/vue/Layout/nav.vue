<script setup lang="jsx">
import { Link } from '@inertiajs/vue3';


</script>
<template>
    <nav class="side-navigation">
        <div class="navigation-category">
            <div class="navigation-category__title"><span>Control</span></div>
            <Link :href="route('index')"
                class="navigation-link router-link-exact-active navigation-link--active navigation-link--default"
                data-inertia="true">
            <span class="navigation-link__icon">
                <i class="fa-brands fa-steam"></i>
            </span>
            <span class="navigation-link__name">Steam</span>
            </Link>
            <Link :href="route('streams')"
                class="navigation-link router-link-exact-active navigation-link--active navigation-link--default"
                data-inertia="true">
            <span class="navigation-link__icon">
                <i class="fa-solid fa-video"></i>
            </span>
            <span class="navigation-link__name">Stream</span>
            </Link>
            <a href="https://admin.ftfru.fun"
                class="navigation-link router-link-exact-active navigation-link--active navigation-link--default"
                data-inertia="true">
                <span class="navigation-link__icon">
                    <i class="fa-solid fa-user-tie"></i>
                </span>
                <span class="navigation-link__name">Admin</span>
            </a>
        </div>
    </nav>
</template>
<style lang="css">
.side-navigation {
    background: #222d32;
    bottom: 0;
    display: flex;
    flex-direction: column;
    left: 0;
    overflow: hidden;
    position: fixed;
    top: 0;
    transition: ease-in-out width 0.3s;
    z-index: 1001;
}

.navigation-category__title {
    align-items: center;
    background: rgba(0, 0, 0, 0.4);
    display: flex;
    font-size: 0.9em;
    padding: 0.75em 1em;
    text-transform: uppercase;
}

.navigation-link.navigation-link--default {
    padding: 0.95em 1.25em;
}

.navigation-link {
    align-items: center;
    border-left: 3px solid rgba(0, 0, 0, 0);
    box-sizing: border-box;
    cursor: pointer;
    display: flex;
    text-decoration: none;
    transition: background 0.2s;
    white-space: nowrap;
    width: 100%;
}

.navigation-link__icon>i {
    height: 1em;
    margin-right: 0.5em;
    vertical-align: -0.125em;
}
</style>
