<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Form, Head } from '@inertiajs/vue3';

defineProps({
    invitations: Array,
    allowedRoles: Array,
});
</script>

<template>
    <Head title="Invitations" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Invitations
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <!-- Invite Form -->
                <div
                    v-if="allowedRoles.length"
                    class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg"
                >
                    <h3 class="mb-4 text-lg font-medium text-gray-900">
                        Send Invitation
                    </h3>
                    <Form
                        :action="route('invitations.store')"
                        method="post"
                        reset-on-success
                        #default="{ errors, processing, wasSuccessful }"
                    >
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label
                                    class="mb-1 block text-sm font-medium text-gray-700"
                                    >Email</label
                                >
                                <input
                                    type="email"
                                    name="email"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="user@example.com"
                                />
                                <p
                                    v-if="errors.email"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ errors.email }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="mb-1 block text-sm font-medium text-gray-700"
                                    >Role</label
                                >
                                <select
                                    name="role"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <option
                                        v-for="role in allowedRoles"
                                        :key="role"
                                        :value="role"
                                    >
                                        {{
                                            role.charAt(0).toUpperCase() +
                                            role.slice(1)
                                        }}
                                    </option>
                                </select>
                                <p
                                    v-if="errors.role"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ errors.role }}
                                </p>
                            </div>
                            <!-- Company name: only shown for SuperAdmin inviting an Admin -->
                            <div
                                v-if="
                                    allowedRoles.includes('admin') &&
                                    !$page.props.auth.user.company_id
                                "
                                class="sm:col-span-2"
                            >
                                <label
                                    class="mb-1 block text-sm font-medium text-gray-700"
                                    >New Company Name</label
                                >
                                <input
                                    type="text"
                                    name="company_name"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Acme Inc."
                                />
                                <p
                                    v-if="errors.company_name"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ errors.company_name }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button
                                type="submit"
                                :disabled="processing"
                                class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700 disabled:opacity-50"
                            >
                                {{
                                    processing
                                        ? 'Sending...'
                                        : 'Send Invitation'
                                }}
                            </button>
                        </div>
                        <p
                            v-if="wasSuccessful"
                            class="mt-2 text-sm text-green-600"
                        >
                            Invitation sent successfully!
                        </p>
                    </Form>
                </div>

                <!-- Invitation List -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">
                            Sent Invitations
                        </h3>
                        <div
                            v-if="invitations.length === 0"
                            class="text-sm text-gray-500"
                        >
                            No invitations sent yet.
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
                                        Email
                                    </th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500"
                                    >
                                        Role
                                    </th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500"
                                    >
                                        Company
                                    </th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500"
                                    >
                                        Invited By
                                    </th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500"
                                    >
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <tr v-for="inv in invitations" :key="inv.id">
                                    <td class="px-4 py-2 text-gray-900">
                                        {{ inv.email }}
                                    </td>
                                    <td
                                        class="px-4 py-2 capitalize text-gray-600"
                                    >
                                        {{ inv.role }}
                                    </td>
                                    <td class="px-4 py-2 text-gray-600">
                                        {{ inv.company?.name ?? '—' }}
                                    </td>
                                    <td class="px-4 py-2 text-gray-600">
                                        {{ inv.inviter?.name ?? '—' }}
                                    </td>
                                    <td class="px-4 py-2">
                                        <span
                                            :class="
                                                inv.accepted_at
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-yellow-100 text-yellow-800'
                                            "
                                            class="rounded px-2 py-0.5 text-xs font-medium"
                                        >
                                            {{
                                                inv.accepted_at
                                                    ? 'Accepted'
                                                    : 'Pending'
                                            }}
                                        </span>
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
