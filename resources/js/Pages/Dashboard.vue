<template>
    <AppLayout>

        <div class="flex">
            <div class="w-3/12">
                <TagIndex :tags="tags" />
            </div>
            <div class="w-9/12">
                <TokenIndex :tokens="tokens" :tags="tags" />
            </div>
        </div>

    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import TokenIndex from '@/Pages/Tokens/Index.vue'
import TagIndex from '@/Pages/Tags/Index.vue'

export default {
    name: 'Dashboard',

    components: {
        AppLayout,
        TokenIndex,
        TagIndex,
    },

    props: {
        tokens: {
            type: Array,
        },
        tags: {
            type: Array,
        },
    },
}
</script>
