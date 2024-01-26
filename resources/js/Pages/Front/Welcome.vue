<template>
    <Head :title="title" />

    <div
        class="flex flex-col bg-fixed bg-cover bg-no-repeat min-h-screen bg-[url(https://images.unsplash.com/photo-1576092762791-dd9e2220abd1?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D)]">

        <div class="md:fixed md:w-72 px-4 py-6 md:pl-6 md:pr-0 lg:py-8 lg:pl-8 md:inset-y-0 flex flex-col justify-between">
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
                    <div v-for="(tagsOfType, type) in groupedTags" :key="type" class="mb-6">
                        <h3 class="font-annie uppercase text-white font-semibold">{{ type }}</h3>
                        <div class="flex flex-wrap items-center gap-2">
                            <button :id="tag.id" :value="tag.id" v-for="tag in tagsOfType"
                                class="font-archi flex items-center gap-2 fancy-button border-2 px-2 py-1" :class="{
                                    'border-gray-800 bg-gray-800 text-gray-100 hover:text-gray-800 hover:bg-gray-100 hover:border-gray-100': selectedTags.includes(tag.id.toString()),
                                    'border-gray-100 bg-gray-100 text-gray-800 hover:text-gray-100 hover:bg-gray-800 hover:border-gray-800': !selectedTags.includes(tag.id.toString())
                                }" @click="toggleTag(tag.id)">
                                <span>{{ tag.title }}</span>
                                <span
                                    class="fancy-button font-bold text-xs bg-gray-900 text-gray-50 py-0.5 px-1.5 rounded-lg">
                                    {{ tag.tokens_count }}
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hidden md:flex">
                <a href="https://www.buymeacoffee.com/vinvui" target="_blank">
                    <img src="https://cdn.buymeacoffee.com/buttons/v2/default-yellow.png" alt="Buy Me A Coffee"
                        class="fancy-button border-[#ffdd00]" style="height: 60px !important;width: 217px !important;">
                </a>
            </div>
        </div>

        <div class="md:ml-72 mx-auto p-6 lg:p-8 overflow-x-hidden">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 2xl:grid-cols-5 gap-6">
                <div v-for="token in tokens" :key="token.id">
                    <div ref="element" :id="'print_' + token.id"
                        class="hover:shadow-xl cursor-pointer p-2 bg-cover rounded-md"
                        style="background-image: url('./annie-spratt-xvU-X0GV9-o-unsplash.webp');">
                        <img ref="imageRef" :data-src="token.img" :alt="token.title" class="object-cover w-full h-full">
                    </div>
                    <div class="w-full py-4 flex flex-col justify-between">
                        <div class="flex justify-between items-center gap-2">
                            <div class="flex flex-wrap items-center gap-2">
                                <div v-for="tag in token.tags" @click="toggleTag(tag.id)"
                                    class="fancy-button font-archi cursor-pointer bg-gray-100 border-gray-100 text-gray-800 px-2 py-0.5 rounded-md text-xs transition-all duration-300 hover:text-gray-100 hover:bg-gray-800">
                                    <span class="">{{ tag.title }}</span>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button @click="printCard(token.id)" title="print" class="group cursor-pointer">
                                    <svg class="group-hover:text-gray-100 transition-all duration-300 lg:h-6 lg:w-6 h-8 w-8"
                                        xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5">
                                            <path
                                                d="M22 12c0 2.828 0 4.243-.879 5.121c-.641.642-1.567.815-3.121.862m-12 0c-1.553-.047-2.48-.22-3.121-.862C2 16.243 2 14.828 2 12c0-2.828 0-4.243.879-5.121C3.757 6 5.172 6 8 6h8c2.828 0 4.243 0 5.121.879c.3.3.498.662.628 1.121" />
                                            <path
                                                d="M17.983 6c-.047-1.553-.22-2.48-.862-3.121C16.243 2 14.828 2 12 2c-2.828 0-4.243 0-5.121.879c-.642.641-.815 1.568-.862 3.121M18 12v4c0 2.828 0 4.243-.879 5.121c-.641.642-1.567.815-3.121.862M6 12v4c0 2.828 0 4.243.879 5.121c.641.642 1.568.815 3.121.862" />
                                            <path
                                                d="M12 11c3.412 0 5.873.713 7.5 1.443m-15 0a15.792 15.792 0 0 1 3.5-1.08" />
                                        </g>
                                    </svg>
                                </button>
                                <a :href="token.img" target="_blank" download title="download" class="group cursor-pointer">
                                    <svg class="group-hover:text-gray-100 transition-all duration-300 lg:h-6 lg:w-6 h-8 w-8"
                                        xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5">
                                            <path stroke-linejoin="round" d="M12 22v-6m0 6l2-2m-2 2l-2-2" />
                                            <path
                                                d="M22 13.353c0 2.343-1.444 4.353-3.5 5.207M14.381 8.027a5.765 5.765 0 0 1 1.905-.321c.654 0 1.283.109 1.87.309m-11.04 2.594a4.351 4.351 0 0 0-.83-.08C3.919 10.53 2 12.426 2 14.765c0 1.896 1.261 3.501 3 4.041m2.116-8.197a5.577 5.577 0 0 1-.354-1.962C6.762 5.528 9.32 3 12.476 3c2.94 0 5.361 2.194 5.68 5.015m-11.04 2.594a4.29 4.29 0 0 1 1.55.634m9.49-3.228A5.73 5.73 0 0 1 20.463 9.5" />
                                        </g>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import VanillaTilt from 'vanilla-tilt'
import { ref, onMounted, nextTick } from 'vue'
import { Head } from '@inertiajs/vue3';

export default {
    components: {
        VanillaTilt,
        Head,
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
        title: {
            type: String,
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

        this.$refs.imageRef.forEach((ref) => {
            this.refs.push(ref);
        });
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
        printCard(tokenId) {
            // Obtenez le HTML à imprimer à partir de l'élément
            const prtHtml = document.getElementById('print_' + tokenId).innerHTML;
            console.log(prtHtml);

            // Ouvrez la fenêtre d'impression
            const WinPrint = window.open('', '', 'left=0,top=0,width=0,height=0,toolbar=0,scrollbars=0,status=0');

            WinPrint.document.write(
                `<!DOCTYPE html>
                <html>
                <head>
                    <style>
                        @page {
                            size: A4;
                        }
                        @media print {
                            img {
                                object-fit: contain;
                                width: 2.5in;
                                min-width: 2.5in;
                                height: 3.5in;
                            }
                        }
                    </style>
                </head>
                <body>
                    ${prtHtml}
                </body>
                </html>`
            );

            WinPrint.document.close();
            WinPrint.focus();
            WinPrint.print();
            WinPrint.onafterprint = function () {
                WinPrint.close();
            };
        }
    },

    setup() {
        const element = ref(null);
        const imageRef = ref(null);
        const refs = ref([]);

        onMounted(() => {
            VanillaTilt.init(element.value, { glare: true, scale: 1.1, "max-glare": 0.5 });

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        observer.unobserve(img);
                    }
                });
            });

            nextTick(() => {
                refs.value.forEach((ref) => {
                    observer.observe(ref);
                });
            });
        });

        return {
            element,
            imageRef,
            refs
        };
    }
}
</script>
