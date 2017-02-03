<template>
    <div class="PageBuilder">
        <div v-if="$store.state.post && $store.state.post.acf">
            <div v-for="block of $store.state.post.acf.content_block.value">

                <example v-if="block.acf_fc_layout === 'example'" :content="block"></example>

            </div>
        </div>
    </div>
</template>

<script type="text/babel">

    export default{
        components: {
//            ...    : require('...'),
        }
    }

</script>
