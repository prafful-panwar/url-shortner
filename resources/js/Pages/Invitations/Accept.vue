<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Form, Head } from '@inertiajs/vue3';

defineProps({
    invitation: Object,
    token: String,
});
</script>

<template>
    <Head title="Accept Invitation" />

    <GuestLayout>
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-900">You're invited!</h2>
            <p class="mt-2 text-sm text-gray-600">
                Join <strong>{{ invitation.company.name }}</strong> as a
                <strong class="capitalize">{{ invitation.role }}</strong
                >.
            </p>
        </div>

        <Form
            :action="route('invitations.register', token)"
            method="post"
            #default="{ errors, processing }"
        >
            <div class="space-y-4">
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700"
                        >Name</label
                    >
                    <input
                        type="text"
                        name="name"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Your full name"
                    />
                    <p v-if="errors.name" class="mt-1 text-sm text-red-600">
                        {{ errors.name }}
                    </p>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700"
                        >Email</label
                    >
                    <input
                        type="email"
                        :value="invitation.email"
                        disabled
                        class="w-full rounded-md border-gray-300 bg-gray-50 text-gray-500 shadow-sm"
                    />
                    <input
                        type="hidden"
                        name="email"
                        :value="invitation.email"
                    />
                    <p v-if="errors.email" class="mt-1 text-sm text-red-600">
                        {{ errors.email }}
                    </p>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700"
                        >Password</label
                    >
                    <input
                        type="password"
                        name="password"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    />
                    <p v-if="errors.password" class="mt-1 text-sm text-red-600">
                        {{ errors.password }}
                    </p>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700"
                        >Confirm Password</label
                    >
                    <input
                        type="password"
                        name="password_confirmation"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    />
                </div>
            </div>
            <div class="mt-6">
                <button
                    type="submit"
                    :disabled="processing"
                    class="w-full rounded-md bg-indigo-600 px-4 py-2 font-medium text-white hover:bg-indigo-700 disabled:opacity-50"
                >
                    {{
                        processing
                            ? 'Creating account...'
                            : 'Accept & Create Account'
                    }}
                </button>
            </div>
        </Form>
    </GuestLayout>
</template>
