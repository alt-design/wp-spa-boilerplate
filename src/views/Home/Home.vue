<template>
    <div class="Home" v-if="$store.state.page">

        <p>This is a home page template, you are currently viewing:</p>
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

<style lang="scss" scoped rel="stylesheet/scss">

</style>
