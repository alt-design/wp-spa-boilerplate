<template>
    <section class="container"
             :style="{
                maxWidth : maxWidth,
                marginTop : marginTop,
                marginBottom : marginBottom,
                zIndex : zIndex
             }"
             :class="{ 'container--no-padding' :  noPadding }">
        <slot></slot>
    </section>
</template>

<script type="text/babel">
    export default{
        props: {
            marginTop   : String,
            marginBottom: String,
            noPadding   : String,
            zIndex      : String,
            maxWidth    : String
        }
    }
</script>

<style lang="sass" rel="stylesheet/scss" scoped>
    @import "../../assets/scss/imports/variables";
    @import "../../assets/scss/imports/mixins";

    .container {
        display: block;
        position: relative;
        clear: both;
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px;

        @include min($sm) {
            padding: 0 40px;
        }
    }

    .container--no-padding {
        padding: 0;
    }
</style>
