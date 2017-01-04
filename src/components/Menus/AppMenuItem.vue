<template>
    <li :class="[location + '__ul__li', item.classes ? item.classes : '']">
        <router-link :class="location + '__ul__li__a'"
                     :to="'/' + getSlug(item.url)"
                     :target="item.target ? item.target : ''"
                     :title="item.title ? item.title : ''"
                     v-html="item.title"
                     exact>
        </router-link>

        <!--submenu-->
        <ul :class="location + '__ul'" v-if="item.children">
            <app-menu-item v-for="(item,key) of item.children" :item="item" :location="location" :depth="depth + 1"></app-menu-item>
        </ul>
        <!--/end submenu-->
    </li>
</template>

<script>
    export default{
        props  : {
            item    : Object,
            location: String,
            depth   : {
                type   : Number,
                default: 0
            }
        },
        methods: {
            getSlug(string){
                return string.replace(this.$store.state.url, '', string);

            }
        }
    }
</script>