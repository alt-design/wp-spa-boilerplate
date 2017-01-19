<template>
    <main class="App">

        <app-header></app-header>

        <transition name="fade" mode="out-in" appear>
            <router-view :key="$route.fullPath"></router-view>
        </transition>

        <app-footer></app-footer>

    </main>
</template>

<script type="text/babel">
    export default{
        components: {
            appHeader: require('./components/Header/Header.vue'),
            appFooter: require('./components/Header/Header.vue'),
        }
    };
</script>

<style lang="scss" scoped>

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }

    .fade-enter, .fade-leave-active {
        opacity: 0
    }

</style>