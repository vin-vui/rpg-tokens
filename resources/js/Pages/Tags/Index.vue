<template>
    <AppLayout>

        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Tags
                </h2>
                <button type="button"  @click="showModal(null)"
                    class="inline-flex items-center gap-x-2 rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <PlusCircleIcon class="-ml-0.5 h-5 w-5" aria-hidden="true" />
                    Add Tag
                </button>
            </div>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
            <div class="flex flew-wrap gap-4">
                <TagCard v-for="tag in tags" :key="tag.id" :tag="tag" @click="showModal(tag)" />
            </div>
        </div>

        <TagModal :tag="selectedTag" :show="isModalVisible" @close="closeModal" />

    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import TagCard from '@/Pages/Tags/Card.vue'
import TagModal from '@/Pages/Tags/Modal.vue'
import { PlusCircleIcon } from '@heroicons/vue/20/solid'

export default {
    components: {
        AppLayout,
        TagCard,
        TagModal,
        PlusCircleIcon
    },

    props: {
        tags: {
            type: Array,
        },
    },

    data() {
        return {
            isModalVisible: false,
            selectedTag: null,
        }
    },

    methods: {
        showModal(tag) {
            this.isModalVisible = true;
            this.selectedTag = tag;
        },
        closeModal() {
            this.isModalVisible = false;
        }
    }
}
</script>
