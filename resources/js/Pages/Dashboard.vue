<template>
    <AppLayout>

        <Head :title="title" />

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
import { Head } from '@inertiajs/vue3';

export default {
    name: 'Dashboard',

    components: {
        AppLayout,
        TokenIndex,
        TagIndex,
        Head,
    },

    props: {
        tokens: {
            type: Array,
        },
        tags: {
            type: Array,
        },
    },

    data() {
        return {
            title: 'Dashboard',
        }
    },
}
</script>
