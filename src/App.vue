<template>
    <main>

        <app-header></app-header>

        <transition name="app" mode="out-in" appear>
            <router-view :key="$route.fullPath"></router-view>
        </transition>

        <app-footer></app-footer>

    </main>
</template>

<script type="text/babel">
    import AppHeader from './Components/Header/Header'
    import AppFooter from './Components/Footer/Footer'

    export default{
        components: {
            AppHeader,
            AppFooter
        }
    }
</script>

<style lang="scss" scoped>

    .app-enter-active, .app-leave-active {
        transition: opacity .5s
    }

    .app-enter, .app-leave-active {
        opacity: 0
    }

</style>