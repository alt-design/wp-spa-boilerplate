<template>
    <div class="Breadcrumbs">
        <router-link v-if="$store.state.page.breadcrumbs"
                     v-for="breadcrumb of $store.state.page.breadcrumbs"
                     class="Breadcrumbs__breadcrumb"
                     :class="{
                        'Breadcrumbs__breadcrumb--active' : $store.state.page.post_title === breadcrumb.title
                      }"
                     :to="'/' + relativeLink(breadcrumb.permalink)"
        >
            <span>{{breadcrumb.title}}</span>
        </router-link>
    </div>
</template>

<script type="text/babel">
    export default {
        methods: {
            relativeLink(link){
                if (link) {
                    return link.replace(this.$store.state.url, '');
                }
            }
        }
    }
</script>

<style lang="sass" rel="stylesheet/scss">
    @import '../../assets/scss/imports/variables';
    @import '../../assets/scss/imports/mixins';

    .Breadcrumbs {

        &__breadcrumb {

        }
    }
</style>
