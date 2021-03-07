<template>
    <app-layout>
        <template #header>
            <h2 class="h4 font-weight-bold">
                Tarefas
            </h2>
        </template>

        <app-content />
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import AppContent from '@/Layouts/AppContent'

    export default {
        components: {
            AppLayout,
            AppContent,
        },
    }
</script>
