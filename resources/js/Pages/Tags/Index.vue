<template>
    <div class="px-4 py-2 flex items-center justify-between bg-white sticky top-0 z-40">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tags
        </h2>
        <button type="button" @click="showModal(null)"
            class="inline-flex items-center gap-x-2 rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            <PlusCircleIcon class="-ml-0.5 h-5 w-5" aria-hidden="true" />
            Add Tag
        </button>
    </div>

    <div class="px-4 mt-8">
        <div v-for="(tagsOfType, type) in groupedTags" :key="type">
            <h3 class="font-semibold mt-6 mb-2 uppercase bg-gray-200 py-1 px-2">{{ type }}</h3>
            <div class="flex flex-wrap gap-4">
                <TagCard v-for="tag in tagsOfType" :key="tag.id" :tag="tag" @click="showModal(tag)" />
            </div>
        </div>
    </div>

    <TagModal :tag="selectedTag" :show="isModalVisible" @close="closeModal" />
</template>

<script>
import TagCard from '@/Pages/Tags/Card.vue'
import TagModal from '@/Pages/Tags/Modal.vue'
import { PlusCircleIcon } from '@heroicons/vue/20/solid'

export default {
    name: 'TagIndex',

    components: {
        TagCard,
        TagModal,
        PlusCircleIcon
    },

    props: {
        tags: {
            type: Object,
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
    },

    computed: {
        groupedTags() {
            const grouped = {};
            this.tags.forEach(tag => {
                if (!grouped[tag.type]) {
                    grouped[tag.type] = [];
                }
                grouped[tag.type].push(tag);
            });
            return grouped;
        }
    },
}
</script>
