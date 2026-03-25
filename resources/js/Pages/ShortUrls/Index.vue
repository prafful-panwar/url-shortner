<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Form, Head, router } from '@inertiajs/vue3';

defineProps({
    shortUrls: Array,
    canCreate: Boolean,
});

function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this URL?')) {
        router.delete(route('short-urls.destroy', id));
    }
}
</script>

<template>
    <Head title="Short URLs" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Short URLs
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <!-- Create Form -->
                <div
                    v-if="canCreate"
                    class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg"
                >
                    <h3 class="mb-4 text-lg font-medium text-gray-900">
                        Create Short URL
                    </h3>
                    <Form
                        :action="route('short-urls.store')"
                        method="post"
                        reset-on-success
                        #default="{ errors, processing, wasSuccessful }"
                    >
                        <div class="flex items-start gap-4">
                            <div class="flex-1">
                                <input
                                    type="url"
                                    name="original_url"
                                    placeholder="https://example.com/long-url"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                />
                                <p
                                    v-if="errors.original_url"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ errors.original_url }}
                                </p>
                            </div>
                            <button
                                type="submit"
                                :disabled="processing"
                                class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700 disabled:opacity-50"
                            >
                                {{ processing ? 'Creating...' : 'Shorten' }}
                            </button>
                        </div>
                        <p
                            v-if="wasSuccessful"
                            class="mt-2 text-sm text-green-600"
                        >
                            Short URL created successfully!
                        </p>
                    </Form>
                </div>

                <!-- URL List -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">
                            Short URLs
                        </h3>
                        <div
                            v-if="shortUrls.length === 0"
                            class="text-sm text-gray-500"
                        >
                            No short URLs found.
                        </div>
                        <table
                            v-else
                            class="min-w-full divide-y divide-gray-200 text-sm"
                        >
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500"
                                    >
                                        Short URL
                                    </th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500"
                                    >
                                        Original URL
                                    </th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500"
                                    >
                                        Company
                                    </th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500"
                                    >
                                        Created By
                                    </th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500"
                                    >
                                        Visits
                                    </th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500"
                                    >
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <tr v-for="url in shortUrls" :key="url.id">
                                    <td class="px-4 py-2">
                                        <a
                                            :href="`/s/${url.short_code}`"
                                            target="_blank"
                                            class="font-mono text-indigo-600 hover:underline"
                                        >
                                            /s/{{ url.short_code }}
                                        </a>
                                    </td>
                                    <td
                                        class="max-w-xs truncate px-4 py-2 text-gray-600"
                                    >
                                        {{ url.original_url }}
                                    </td>
                                    <td class="px-4 py-2 text-gray-600">
                                        {{ url.company?.name ?? '—' }}
                                    </td>
                                    <td class="px-4 py-2 text-gray-600">
                                        {{ url.user?.name ?? '—' }}
                                    </td>
                                    <td class="px-4 py-2 text-gray-600">
                                        {{ url.visits }}
                                    </td>
                                    <td class="px-4 py-2">
                                        <button
                                            v-if="canCreate"
                                            @click="confirmDelete(url.id)"
                                            class="text-xs text-red-600 hover:underline"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
