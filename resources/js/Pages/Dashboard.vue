<script setup lang="ts">
import Hero from '@/Components/Dashboard/Hero.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <!-- Hero -->
        <Hero />

        <!-- Job List -->
        <div class="bg-white">
            <div class="container py-5">
                <!-- TODO: Add job list here -->
            </div>
        </div>
    </AuthenticatedLayout>
</template>
