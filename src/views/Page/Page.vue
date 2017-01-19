<template>
    <div class="Page" v-if="$store.state.page">

        <p>This is a standard page template, you are currently viewing:</p>
        <h1 v-if="$store.state.page.post_title">{{$store.state.page.post_title}}</h1>

        <!--<page-builder></page-builder>-->

    </div>
</template>

<script type="text/babel">
    export default{
        components: {
            pageBuilder: require('../../components/PageBuilder/PageBuilder.vue')
        }
    };


</script>

<style lang="sass" scoped rel="stylesheet/scss">

</style>
