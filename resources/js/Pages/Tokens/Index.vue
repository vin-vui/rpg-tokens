<template>

    <div class="px-4 py-2 flex items-center justify-between bg-white sticky top-0 z-40">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tokens
        </h2>
        <button type="button" @click="showTokenModal(null)"
            class="inline-flex items-center gap-x-2 rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            <PlusCircleIcon class="-ml-0.5 h-5 w-5" aria-hidden="true" />
            Add Token
        </button>
    </div>

    <div class="px-4 mt-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 2xl:grid-cols-5 gap-6">
            <TokenCard v-for="token in tokens" :key="token.id" :tags="token.tags" :token="token" @click="showTokenModal(token)" />
        </div>
    </div>

    <TokenModal :token="selectedToken" :tags="tags" :show="isModalTokenVisible" @close="closeTokenModal" />

</template>

<script>
import TokenCard from '@/Pages/Tokens/Card.vue'
import TokenModal from '@/Pages/Tokens/Modal.vue'
import { PlusCircleIcon } from '@heroicons/vue/20/solid'

export default {
    name: 'TokenIndex',

    components: {
        TokenCard,
        TokenModal,
        PlusCircleIcon
    },

    props: {
        tokens: {
            type: Object,
        },
        tags: {
            type: Object,
        },
    },

    data() {
        return {
            isModalTokenVisible: false,
            selectedToken: null,
        }
    },

    methods: {
        showTokenModal(token) {
            this.isModalTokenVisible = true;
            this.selectedToken = token;
        },
        closeTokenModal() {
            this.isModalTokenVisible = false;
        }
    }
}
</script>
