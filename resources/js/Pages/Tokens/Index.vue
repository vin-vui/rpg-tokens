<template>
    <AppLayout>

        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Tokens
                </h2>
                <button type="button"  @click="showModal(null)"
                    class="inline-flex items-center gap-x-2 rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <PlusCircleIcon class="-ml-0.5 h-5 w-5" aria-hidden="true" />
                    Add Token
                </button>
            </div>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
            <div class="grid grid-cols-4 gap-4">
                <TokenCard v-for="token in tokens" :key="token.id" :token="token" @click="showModal(token)" />
            </div>
        </div>

        <TokenModal :token="selectedToken" :tags="tags" :show="isModalVisible" @close="closeModal" />

    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import TokenCard from '@/Pages/Tokens/Card.vue'
import TokenModal from '@/Pages/Tokens/Modal.vue'
import { PlusCircleIcon } from '@heroicons/vue/20/solid'

export default {
    components: {
        AppLayout,
        TokenCard,
        TokenModal,
        PlusCircleIcon
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
            isModalVisible: false,
            selectedToken: null,
        }
    },

    methods: {
        showModal(token) {
            this.isModalVisible = true;
            this.selectedToken = token;
        },
        closeModal() {
            this.isModalVisible = false;
        }
    }
}
</script>
