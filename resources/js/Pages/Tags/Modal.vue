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
                            class="relative transform overflow-hidden bg-white text-left shadow-xl transition-all sm:w-full sm:max-w-xl">

                            <DialogTitle as="h3" class=" text-base text-center font-semibold leading-6 text-gray-50 py-2"
                                :class="{ 'bg-yellow-600': tag != null, 'bg-green-600': tag == null }">
                                <span v-if="tag != null">Update Tag</span>
                                <span v-else>Add Tag</span>
                            </DialogTitle>

                            <div class="flex flex-col gap-4 px-4 py-8">
                                <input type="hidden" v-model="form.id">
                                <div class="flex flex-col w-full gap-4">
                                    <div class="flex flex-col justify-start">
                                        <InputLabel value="Title" />
                                        <input type="text" v-model="form.title">
                                        <InputError :message="form.errors.title" />
                                    </div>
                                </div>
                                <div class="flex flex-col w-full gap-4">
                                    <input type="hidden" v-model="form.id">
                                    <div class="flex flex-col justify-start">
                                        <InputLabel value="Type" />
                                        <select v-model="form.type" class="">
                                            <option v-for="option in selectOptions" :key="option.value"
                                                :value="option.value">
                                                {{ option.text }}
                                            </option>
                                        </select>
                                        <InputError :message="form.errors.type" />
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between gap-4 mt-2">
                                <button type="button"
                                    class="inline-flex w-full justify-center bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                    @click="close">
                                    <ArrowLeftIcon class="mr-1 h-5 w-5" aria-hidden="true" />
                                    Go back
                                </button>
                                <div v-if="tag != null" class="flex whitespace-nowrap items-center">
                                    <VueConfirmationButton
                                        class="text-red-600 hover:text-red-800 transition-all duration-200"
                                        :messages="customMessages" v-on:confirmation-success="deleteTag">
                                    </VueConfirmationButton>
                                </div>
                                <button :loading="form.processing" :disabled="form.processing" @click="submit"
                                    class="inline-flex w-full justify-center bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                                    <CheckIcon class="mr-1 h-5 w-5" aria-hidden="true" />
                                    Submit
                                </button>
                            </div>

                        </DialogPanel>

                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'
import VueConfirmationButton from '@/Components/VueConfirmationButton.vue';
import { CheckIcon, ArrowLeftIcon } from '@heroicons/vue/20/solid';

export default {
    name: 'TagModal',

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
        tag: {
            type: Object,
        },
    },

    data() {
        return {
            form: this.$inertia.form({
                id: null,
                title: '',
                type: '',
            }),
            selectOptions: [
                { value: 'gender', text: 'Gender' },
                { value: 'class', text: 'Class' },
                { value: 'race', text: 'Race' },
                { value: 'alignment', text: 'Alignment' },
                { value: 'weapon', text: 'Weapon' },
                { value: 'miscellaneous', text: 'Miscellaneous' },
            ],
            preview: '',
            customMessages: [
                'Delete Tag',
                'Are you sure?',
                'Done!'
            ],
        };
    },

    watch: {
        tag: {
            handler() {
                this.form.id = this.tag?.id;
                this.form.title = this.tag?.title;
                this.form.type = this.tag?.type;
            },
            deep: true
        }
    },

    methods: {
        submit() {
            this.form.post(route('tags.store'), {
                preserveState: (page) => Object.keys(page.props.errors).length,
                onSuccess: () => this.close(),
            })
        },
        deleteTag() {
            this.form.delete(route('tags.destroy', this.tag), {
                preserveState: (page) => Object.keys(page.props.errors).length,
                onSuccess: () => this.close(),
            })
        },
        close() {
            this.form.clearErrors()
            this.$emit('close')
        },
    },
};
</script>
