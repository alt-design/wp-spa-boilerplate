<template>
    <div class="Home" v-if="$store.state.post">

        <p>You are currently viewing the {{$store.state.post.post_title}} page. Edit this template -
            ~/src/Views/Home/Home.vue</p>

        <!--<page-builder></page-builder>-->

    </div>
</template>

<script type="text/babel">
  import PageBuilder from '../../Components/PageBuilder'

  export default{
    components: {
      PageBuilder
    }
  }
</script>