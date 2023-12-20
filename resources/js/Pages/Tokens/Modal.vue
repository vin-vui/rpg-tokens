<template>
    <TransitionRoot as="template">
        <Dialog as="div" class="relative z-50" @close="close">

            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 backdrop-blur-md bg-white/20 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                        <DialogPanel
                            class="relative transform overflow-hidden bg-white text-left shadow-xl transition-all sm:max-w-3xl">

                            <DialogTitle as="h3" class=" text-base text-center font-semibold leading-6 text-gray-50 py-2"
                                :class="{ 'bg-yellow-600': token != null, 'bg-green-600': token == null }">
                                <span v-if="token != null">Update Token</span>
                                <span v-else>Add Token</span>
                            </DialogTitle>

                            <div class="px-4 ">
                                <div class="mt-3 sm:mt-5 flex gap-4">
                                    <div class="flex flex-col w-full gap-4">

                                        <div class="flex gap-8">
                                            <!-- form -->
                                            <div class="flex gap-2">
                                                <input type="hidden" v-model="form.id">
                                                <div class="flex flex-col justify-start">
                                                    <InputLabel value="Image" />
                                                    <input type="file" accept="image/jpeg, image/png, image/svg" ref="photo"
                                                        @change="previewImg">
                                                    <img v-if="pwImg" :src="pwImg" class="object-contain w-full mt-4" />
                                                    <InputError :message="form.errors.img" />
                                                </div>
                                                <div class="flex flex-col justify-start">
                                                    <InputLabel value="Tags" />
                                                    <fieldset>
                                                        <div class="flex gap-2 flex-wrap">
                                                            <div v-for="(tag, index) in tags" class="flex items-center gap-1">
                                                                <input type="checkbox" :id="tag.id + '_' + index" :value="tag.id" v-model="form.tags">
                                                                <label :for="tag.id + '_' + index">{{ tag.title }}</label>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between gap-4 my-4">
                                            <button type="button"
                                                class="inline-flex w-full justify-center bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                                @click="close">
                                                <ArrowLeftIcon class="mr-1 h-5 w-5" aria-hidden="true" />
                                                Go back
                                            </button>
                                            <div v-if="token != null" class="flex justify-center w-full">
                                                <VueConfirmationButton
                                                    class="text-red-600 hover:text-red-800 transition-all duration-200"
                                                    :messages="customMessages" v-on:confirmation-success="deleteToken">
                                                </VueConfirmationButton>
                                            </div>
                                            <button :loading="form.processing" :disabled="form.processing" @click="submit"
                                                class="inline-flex w-full justify-center bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                                                <CheckIcon class="mr-1 h-5 w-5" aria-hidden="true" />
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </DialogPanel>

                    </TransitionChild>
                </div>
            </div>

        </Dialog>
    </TransitionRoot>
</template>

<script>
import { ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'
import VueConfirmationButton from '@/Components/VueConfirmationButton.vue';
import { CheckIcon, ArrowLeftIcon } from '@heroicons/vue/20/solid';

export default {
    name: 'TokenModal',

    components: {
        Dialog,
        DialogPanel,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        InputLabel,
        InputError,
        VueConfirmationButton,
        CheckIcon, ArrowLeftIcon
    },

    props: {
        token: {
            type: Object,
        },
        tags: {
            type: Object,
        },
    },

    data() {
        return {
            form: this.$inertia.form({
                id: null,
                img: null,
                tags: ref([]),
            }),
            pwImg: '',
            customMessages: [
                'Delete Token',
                'Are you sure?',
                'Done!'
            ],
        };
    },

    watch: {
        token: {
            handler() {
                this.form.id = this.token?.id;
                this.form.img = this.token?.img;
                this.pwImg = this.token?.img;
                this.form.tags = this.token?.tags.map(tag => tag.id);
                console.log(this.form.tags);
            },
            deep: true
        }
    },

    methods: {
        submit() {
            if (this.$refs.photo) {
                if (this.$refs.photo.files[0] !== undefined) {
                    this.form.img = this.$refs.photo.files[0];
                } else {
                    this.form.img = this.token.img;
                }
            }
            this.form.post(route('tokens.store'), {
                preserveState: (page) => Object.keys(page.props.errors).length,
                onSuccess: () => this.close(),
            })
        },
        deleteToken() {
            this.form.delete(route('tokens.destroy', this.token), {
                preserveState: (page) => Object.keys(page.props.errors).length,
                onSuccess: () => this.close(),
            })
        },
        previewImg(e) {
            this.pwImg = URL.createObjectURL(e.target.files[0]);
        },
        close() {
            this.form.clearErrors()
            this.$emit('close')
        },
    },
};
</script>
