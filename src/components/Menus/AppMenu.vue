<template>
    <ul class="menu" :class="location + '__ul'">
        <app-menu-item v-for="(item,key) of items" :item="item" :key="key" :location="location"></app-menu-item>
    </ul>
</template>

<script>
    export default{
        props: {
            location: String
        },
        data(){
            return {
                items: Object
            }
        },
        created(){
            this.$http.get('/wp-json/wp-api-menus/v2/menu-locations/' + this.location).then(res => {
                if (res.data.length > 0) {
                    this.items = res.data;
                } else {
                    console.error('Failed to retrieve menu ' + this.location + ', check the menu location is correct and the menu is not empty.');
                }
            });
        }
    }
</script>
