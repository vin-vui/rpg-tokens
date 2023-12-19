<template>
    <div class="hover:shadow-xl cursor-pointer transition-all duration-200 hover:opacity-60 bg-black group">
        <img :src="token.img" :alt="token.title" class="object-cover w-full h-full group-hover:" />
        <!-- <div class="w-full p-4 flex flex-col justify-between">
                <div class="flex flex-wrap items-center gap-2">
                    <div class="text-sm text-gray-300">Tags</div>
                    <div v-for="tag in token.tags"
                        class="bg-gray-100 border-gray-400 text-gray-800 px-2 py-0.5 rounded-md text-xs flex items-center gap-1">
                        <img :src="tag.img" :alt="tag.title" class="h-3">
                        <div class="">{{ tag.title }}</div>
                    </div>
                </div>
            </div> -->
    </div>
</template>

<script>
import { ArrowTopRightOnSquareIcon } from '@heroicons/vue/20/solid'

export default {
    components: {
        ArrowTopRightOnSquareIcon,
    },
    props: {
        token: {
            type: Object,
        },
    }
}
</script>
