<template>
    <div class="bg-white hover:shadow-xl cursor-pointer transition-all duration-200 z-30">
        <div class="flex p-2">
            <div class="w-full p-4 flex flex-col justify-between">
                <div class="">
                    <h3 class="text-xl">{{ tag.title }}</h3>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ArrowTopRightOnSquareIcon } from '@heroicons/vue/20/solid'

export default {
    components: {
        ArrowTopRightOnSquareIcon
    },

    props: {
        tag: {
            type: Object,
        },
    },
}
</script>
