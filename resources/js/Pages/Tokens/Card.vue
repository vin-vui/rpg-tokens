<template>
    <div class="hover:shadow-2xl cursor-pointer transition-all duration-200 z-20 p-2 hover:scale-110 hover:z-30 rounded-md bg-[url('./annie-spratt-xvU-X0GV9-o-unsplash.webp')]">
        <img :src="token.img" :alt="token.title" class="object-cover w-full h-full" />
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
        tags: {
            type: Object,
        },
    }
}
</script>
