<template>
    <main class="App">

        <app-menu location="main"></app-menu>

        <transition name="fade" mode="out-in" appear>

            <router-view :key="$route.fullPath"></router-view>

        </transition>

    </main>
</template>

<script>
    export default{
        components: {
            container: require('./components/Container/Container.vue')
        }
    }
</script>

<style lang="scss" scoped>

</style>