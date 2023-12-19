<template>
    <div class="bg-fixed bg-cover bg-no-repeat min-h-screen bg-[url(https://images.unsplash.com/photo-1576092762791-dd9e2220abd1?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D)]">
        <!-- https://images.unsplash.com/photo-1598985348522-aab254d10928?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D -->
        <div class="fixed w-72 p-8 inset-y-0 flex flex-col justify-between">
            <div class="">
                <div class="flex flex-col gap-6">
                    <div
                        class="font-annie font-bold tracking-widest text-white py-2 bg-cyan-500 px-2 text-center text-2xl fancy-button border-4 border-cyan-500">
                        {{ tokens.length }} {{ tokens.length == 1 ? 'token' : 'tokens' }} found
                    </div>
                    <button type="button"
                        class="font-archi fancy-button border-2 border-red-600 inline-flex justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 hover:border-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
                        @click="resetTags">
                        Reset {{ selectedTags.length }} {{ selectedTags.length == 1 ? 'filter' : 'filters' }}
                    </button>
                </div>
                <div class="mt-6">
                    <div class="flex flex-wrap items-center gap-2">
                        <button :id="tag.id" :value="tag.id" v-for="tag in tags"
                            class="font-archi flex items-center gap-2 fancy-button border-2 px-2 py-1"
                            :class="{
                                'border-gray-800 bg-gray-800 text-gray-100 hover:text-gray-800 hover:bg-gray-100 hover:border-gray-100': selectedTags.includes(tag.id.toString()),
                                'border-gray-100 bg-gray-100 text-gray-800 hover:text-gray-100 hover:bg-gray-800 hover:border-gray-800': !selectedTags.includes(tag.id.toString())
                            }" @click="toggleTag(tag.id)">
                            <span>{{ tag.title }}</span>
                            <span class="fancy-button font-bold text-xs bg-gray-900 text-gray-50 py-0.5 px-1.5 rounded-lg">
                                {{ tag.tokens_count }}
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="">
                <a href="https://www.buymeacoffee.com/vinvui" target="_blank">
                    <img src="https://cdn.buymeacoffee.com/buttons/v2/default-yellow.png" alt="Buy Me A Coffee"
                        class="fancy-button border-[#ffdd00]"
                        style="height: 60px !important;width: 217px !important;">
                </a>
            </div>
        </div>

        <div class="ml-72 mx-auto p-6 lg:p-8 ">
            <div class="grid grid-cols-4 gap-6">
                <div v-for="token in tokens" :key="token.id">
                    <div ref="element" class="hover:shadow-xl cursor-pointer bg-cover rounded-md"
                        style="background-image: url('./annie-spratt-xvU-X0GV9-o-unsplash.webp');">
                        <img :src="token.img" :alt="token.title" class="object-cover w-full h-full p-2">
                    </div>
                    <div class="w-full py-4 flex flex-col justify-between">
                        <div class="flex justify-between items-center">
                            <div class="flex flex-wrap items-center gap-2">
                                <div v-for="tag in token.tags" @click="toggleTag(tag.id)"
                                    class="fancy-button font-archi cursor-pointer bg-gray-100 border-gray-100 text-gray-800 px-2 py-0.5 rounded-md text-xs transition-all duration-300 hover:text-gray-100 hover:bg-gray-800">
                                    <span class="">{{ tag.title }}</span>
                                </div>
                            </div>
                            <a :href="token.img" target="_blank" download title="download" class="group cursor-pointer">
                                <svg class="group-hover:text-gray-100 transition-all duration-300 h-8 w-8"
                                    xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M7 17h10v-2H7v2Zm5-3l4-4l-1.4-1.4l-1.6 1.55V6h-2v4.15L9.4 8.6L8 10l4 4Zm0 8q-2.075 0-3.9-.788t-3.175-2.137q-1.35-1.35-2.137-3.175T2 12q0-2.075.788-3.9t2.137-3.175q1.35-1.35 3.175-2.137T12 2q2.075 0 3.9.788t3.175 2.137q1.35 1.35 2.138 3.175T22 12q0 2.075-.788 3.9t-2.137 3.175q-1.35 1.35-3.175 2.138T12 22Zm0-2q3.35 0 5.675-2.325T20 12q0-3.35-2.325-5.675T12 4Q8.65 4 6.325 6.325T4 12q0 3.35 2.325 5.675T12 20Zm0-8Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import VanillaTilt from 'vanilla-tilt'
import { ref, onMounted } from 'vue'

export default {
    components: {
        VanillaTilt,
    },

    props: {
        tokens: {
            type: Object,
        },
        tags: {
            type: Object,
        },
        selectedTags: {
            type: Array,
        },
    },

    data() {
        return {
            selected: this.$inertia.form({
                tags: ref([]),
            }),
        }
    },

    mounted() {
        this.selected.tags = this.selectedTags;
    },

    methods: {
        toggleTag(tagId) {
            if (!this.selected.tags.includes(tagId.toString())) {
                this.selected.tags.push(tagId);
            } else {
                const index = this.selected.tags.indexOf(tagId.toString());
                this.selected.tags.splice(index, 1);
            }
            this.loadTags();
        },
        resetTags() {
            this.selected.tags = [];
            this.loadTags();
        },
        loadTags() {
            this.selected.get(route('home'));
        },
    },

    setup() {
        const element = ref(null);

        onMounted(() => {
            VanillaTilt.init(element.value, { glare: true, scale: 1.1 });
        });

        return {
            element
        };
    }
}
</script>
