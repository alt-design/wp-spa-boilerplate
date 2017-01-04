<template>
    <main class="App">

        <transition name="fade" mode="out-in" appear>

            <router-view :key="$route.fullPath"></router-view>

        </transition>

    </main>
</template>

<script>
    export default{}
</script>

<style lang="scss" scoped>

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }

    .fade-enter, .fade-leave-active {
        opacity: 0
    }

</style>