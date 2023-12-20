<script setup>
import { Head } from '@inertiajs/vue3';
import Banner from '@/Components/Banner.vue';

defineProps({
    title: String,
});
</script>

<template>
    <div class="">
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-100">
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
