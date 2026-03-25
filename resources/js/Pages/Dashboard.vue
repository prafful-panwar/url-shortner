<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {
    BuildingOfficeIcon,
    CursorArrowRaysIcon,
    EnvelopeIcon,
    LinkIcon,
    UsersIcon,
} from '@heroicons/vue/24/outline';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    stats: Array,
});

const iconMap = {
    BuildingOfficeIcon,
    UsersIcon,
    LinkIcon,
    CursorArrowRaysIcon,
    EnvelopeIcon,
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Stats Grid -->
                <div
                    class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4"
                >
                    <div
                        v-for="stat in stats"
                        :key="stat.label"
                        class="overflow-hidden rounded-lg bg-white shadow"
                    >
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <component
                                        :is="iconMap[stat.icon]"
                                        class="h-6 w-6 text-gray-400"
                                        aria-hidden="true"
                                    />
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt
                                            class="truncate text-sm font-medium text-gray-500"
                                        >
                                            {{ stat.label }}
                                        </dt>
                                        <dd>
                                            <div
                                                class="text-lg font-medium text-gray-900"
                                            >
                                                {{ stat.value }}
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions / Welcome -->
                <div
                    class="mt-8 overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Welcome back, {{ $page.props.auth.user.name }}!
                        </h3>
                        <div class="mt-2 max-w-xl text-sm text-gray-500">
                            <p>
                                Manage your short URLs and monitor their
                                performance from your dashboard.
                            </p>
                        </div>
                        <div class="mt-5 flex gap-4">
                            <Link
                                :href="route('short-urls.index')"
                                class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            >
                                <LinkIcon
                                    class="-ml-0.5 mr-1.5 h-5 w-5"
                                    aria-hidden="true"
                                />
                                Manage URLs
                            </Link>
                            <Link
                                v-if="$page.props.auth.user.role !== 'member'"
                                :href="route('invitations.index')"
                                class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                            >
                                <EnvelopeIcon
                                    class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400"
                                    aria-hidden="true"
                                />
                                Send Invitations
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
