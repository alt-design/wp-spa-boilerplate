<template>
    <div class="Breadcrumbs">
        <router-link v-if="$store.state.post.breadcrumbs"
                     v-for="breadcrumb of $store.state.post.breadcrumbs"
                     class="Breadcrumbs__breadcrumb"
                     :class="{
                        'Breadcrumbs__breadcrumb--active' : $store.state.post.post_title === breadcrumb.title
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
                    return link.replace(this.$store.state.url, '')
                }
            }
        }
    }
</script>

<style lang="scss" rel="stylesheet/scss">
    @import '../../Assets/SCSS/Imports/variables';
    @import '../../Assets/SCSS/Imports/mixins';

    .Breadcrumbs {

        &__breadcrumb {

        }

    }
</style>
