<template>
    <div class="PageBuilder">
        <div v-if="$store.state.page && $store.state.page.acf">
            <div v-for="block of $store.state.page.acf.content_block.value">

                <example v-if="block.acf_fc_layout === 'example'" :content="block"></example>

            </div>
        </div>
    </div>
</template>

<script>

    export default{
        components: {
//            ...    : require('...'),
        }
    }

</script>
