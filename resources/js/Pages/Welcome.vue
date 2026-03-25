<script setup>
import {
    ChartBarIcon,
    CursorArrowRaysIcon,
    LinkIcon,
    UsersIcon,
} from '@heroicons/vue/24/outline';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
    globalStats: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome to ShortyLink" />

    <div
        class="bg-white text-left font-sans selection:bg-emerald-500 selection:text-white"
    >
        <header class="absolute inset-x-0 top-0 z-50">
            <nav
                class="flex items-center justify-between p-6 lg:px-8"
                aria-label="Global"
            >
                <div class="flex lg:flex-1">
                    <div class="flex items-center gap-2">
                        <LinkIcon class="h-8 w-8 text-emerald-600" />
                        <span
                            class="font-sans text-xl font-bold tracking-tight text-slate-900"
                            >ShortyLink</span
                        >
                    </div>
                </div>
                <div v-if="canLogin" class="flex flex-1 justify-end gap-4">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="text-sm font-semibold leading-6 text-slate-900 transition hover:text-emerald-600"
                    >
                        Dashboard <span aria-hidden="true">&rarr;</span>
                    </Link>

                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="text-sm font-semibold leading-6 text-slate-900 transition hover:text-emerald-600"
                        >
                            Log in
                        </Link>
                    </template>
                </div>
            </nav>
        </header>

        <main class="isolate">
            <div class="relative pt-14">
                <div
                    class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
                    aria-hidden="true"
                >
                    <div
                        class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#10b981] to-[#0ea5e9] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
                        style="
                            clip-path: polygon(
                                74.1% 44.1%,
                                100% 61.6%,
                                97.5% 26.9%,
                                85.5% 0.1%,
                                80.7% 2%,
                                72.5% 32.5%,
                                60.2% 62.4%,
                                52.4% 68.1%,
                                47.5% 58.3%,
                                45.2% 34.5%,
                                27.5% 76.7%,
                                0.1% 64.9%,
                                17.9% 100%,
                                27.6% 76.8%,
                                76.1% 97.7%,
                                74.1% 44.1%
                            );
                        "
                    />
                </div>
                <div class="py-24 sm:py-32">
                    <div class="mx-auto max-w-7xl px-6 text-center lg:px-8">
                        <div class="mx-auto max-w-2xl">
                            <h1
                                class="text-4xl font-bold leading-[1.1] tracking-tight text-slate-900 sm:text-6xl"
                            >
                                Shorten URLs. <br />
                                <span
                                    class="bg-gradient-to-r from-emerald-600 to-sky-600 bg-clip-text text-transparent"
                                    >Empower Teams.</span
                                >
                            </h1>
                            <p class="mt-6 text-lg leading-8 text-slate-600">
                                The modern URL shortener built for professional
                                teams. Manage links, track real-time
                                performance, and organize your company assets in
                                one secure workspace.
                            </p>
                            <div
                                class="mt-10 flex items-center justify-center gap-x-6"
                            >
                                <Link
                                    v-if="!$page.props.auth.user"
                                    :href="route('login')"
                                    class="rounded-lg bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900"
                                >
                                    Log in to Start
                                </Link>
                                <Link
                                    v-else
                                    :href="route('dashboard')"
                                    class="rounded-lg bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-50"
                                >
                                    Go to Dashboard
                                </Link>
                                <a
                                    href="#features"
                                    class="group text-sm font-semibold leading-6 text-slate-900"
                                >
                                    See features
                                    <span
                                        class="inline-block transition-transform group-hover:translate-x-1"
                                        aria-hidden="true"
                                        >→</span
                                    >
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="features" class="bg-slate-50 py-24 sm:py-32">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto mb-24 max-w-4xl text-center">
                        <h2
                            class="text-base font-semibold uppercase leading-7 tracking-widest text-emerald-600"
                        >
                            Enterprise Ready
                        </h2>
                        <p
                            class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl"
                        >
                            Everything you need to manage company links
                        </p>
                        <p class="mt-6 text-lg leading-8 text-slate-600">
                            Stop using messy long URLs. ShortyLink gives your
                            company the tools to create, track, and manage all
                            your marketing and internal links with surgical
                            precision.
                        </p>
                    </div>

                    <div class="mt-16">
                        <dl
                            class="grid grid-cols-1 gap-x-12 gap-y-20 lg:grid-cols-3"
                        >
                            <div
                                class="relative flex flex-col items-center rounded-2xl bg-white p-8 text-center shadow-sm ring-1 ring-slate-200"
                            >
                                <div
                                    class="mb-6 flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-600 shadow-lg shadow-emerald-200"
                                >
                                    <LinkIcon
                                        class="h-6 w-6 text-white"
                                        aria-hidden="true"
                                    />
                                </div>
                                <dt
                                    class="text-base font-bold leading-7 text-slate-900"
                                >
                                    Link Management
                                </dt>
                                <dd
                                    class="mt-4 text-center text-base leading-7 text-slate-600"
                                >
                                    Create and organize short codes for any URL.
                                    Perfect for social campaigns, email
                                    marketing, and SMS outreach.
                                </dd>
                            </div>

                            <div
                                class="relative flex flex-col items-center rounded-2xl bg-white p-8 text-center shadow-sm ring-1 ring-slate-200"
                            >
                                <div
                                    class="mb-6 flex h-12 w-12 items-center justify-center rounded-xl bg-sky-600 shadow-lg shadow-sky-200"
                                >
                                    <UsersIcon
                                        class="h-6 w-6 text-white"
                                        aria-hidden="true"
                                    />
                                </div>
                                <dt
                                    class="text-base font-bold leading-7 text-slate-900"
                                >
                                    Team Invitations
                                </dt>
                                <dd
                                    class="mt-4 text-center text-base leading-7 text-slate-600"
                                >
                                    Securely invite colleagues to your
                                    workspace. Role-based access ensures only
                                    authorized users can create links.
                                </dd>
                            </div>

                            <div
                                class="relative flex flex-col items-center rounded-2xl bg-white p-8 text-center shadow-sm ring-1 ring-slate-200"
                            >
                                <div
                                    class="mb-6 flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-600 shadow-lg shadow-indigo-200"
                                >
                                    <ChartBarIcon
                                        class="h-6 w-6 text-white"
                                        aria-hidden="true"
                                    />
                                </div>
                                <dt
                                    class="text-base font-bold leading-7 text-slate-900"
                                >
                                    Real-time Stats
                                </dt>
                                <dd
                                    class="mt-4 text-center text-base leading-7 text-slate-600"
                                >
                                    Monitor visit counts and performance across
                                    your entire company. Data-driven insights to
                                    optimize your presence.
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <div
                class="border-t border-slate-100 bg-white py-24 text-left sm:py-32"
            >
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div
                        class="grid grid-cols-1 gap-x-12 gap-y-16 lg:grid-cols-2 lg:items-center"
                    >
                        <div>
                            <h2
                                class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl"
                            >
                                Streamlined Workflow
                            </h2>
                            <p class="mt-6 text-lg leading-8 text-slate-600">
                                Setting up your company workspace takes seconds.
                                Our intuitive interface is designed to let you
                                focus on what matters most: your content.
                            </p>
                            <div class="mt-10 space-y-8">
                                <div class="flex gap-4">
                                    <div
                                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-sm font-bold text-emerald-700"
                                    >
                                        1
                                    </div>
                                    <div class="text-left">
                                        <p class="font-semibold text-slate-900">
                                            Set up your Company
                                        </p>
                                        <p class="text-slate-600">
                                            Quickly create a dedicated workspace
                                            for your team assets.
                                        </p>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <div
                                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-sm font-bold text-emerald-700"
                                    >
                                        2
                                    </div>
                                    <div class="text-left">
                                        <p class="font-semibold text-slate-900">
                                            Invite Collaborators
                                        </p>
                                        <p class="text-slate-600">
                                            Bring your team on board with
                                            secure, token-based invitations.
                                        </p>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <div
                                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-sm font-bold text-emerald-700"
                                    >
                                        3
                                    </div>
                                    <div class="text-left">
                                        <p class="font-semibold text-slate-900">
                                            Shorten & Track
                                        </p>
                                        <p class="text-slate-600">
                                            Start creating links and watching
                                            the analytics roll in immediately.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="relative">
                            <div
                                class="flex aspect-[4/3] flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl"
                            >
                                <div
                                    class="flex h-8 items-center justify-between border-b border-slate-100 bg-white px-4"
                                >
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="h-3 w-3 rounded bg-emerald-500 shadow-sm shadow-emerald-500/50"
                                        ></div>
                                        <div
                                            class="h-1.5 w-8 rounded bg-slate-200"
                                        ></div>
                                        <div
                                            class="h-1.5 w-8 rounded bg-slate-100"
                                        ></div>
                                        <div
                                            class="h-1.5 w-8 rounded bg-slate-100"
                                        ></div>
                                    </div>
                                    <div
                                        class="h-4 w-4 rounded-full border border-slate-200 bg-slate-100"
                                    ></div>
                                </div>

                                <div
                                    class="flex-1 overflow-y-auto bg-slate-50 p-4 text-left sm:p-6"
                                >
                                    <div class="mb-6 grid grid-cols-3 gap-2">
                                        <div
                                            class="rounded-xl border border-slate-200 bg-white p-2 shadow-sm"
                                        >
                                            <p
                                                class="mb-1 text-left text-[7px] font-bold uppercase leading-tight tracking-wider text-slate-500"
                                            >
                                                Links
                                            </p>
                                            <div
                                                class="flex items-center gap-1 text-left"
                                            >
                                                <LinkIcon
                                                    class="h-3 w-3 text-emerald-600"
                                                />
                                                <p
                                                    class="text-[10px] font-bold leading-none text-slate-900"
                                                >
                                                    {{ globalStats.totalUrls }}
                                                </p>
                                            </div>
                                        </div>
                                        <div
                                            class="rounded-xl border border-slate-200 bg-white p-2 shadow-sm"
                                        >
                                            <p
                                                class="mb-1 text-left text-[7px] font-bold uppercase leading-tight tracking-wider text-slate-500"
                                            >
                                                Teams
                                            </p>
                                            <div
                                                class="flex items-center gap-1 text-left"
                                            >
                                                <UsersIcon
                                                    class="h-3 w-3 text-sky-600"
                                                />
                                                <p
                                                    class="text-[10px] font-bold leading-none text-slate-900"
                                                >
                                                    {{
                                                        globalStats.totalCompanies
                                                    }}
                                                </p>
                                            </div>
                                        </div>
                                        <div
                                            class="rounded-xl border border-slate-200 bg-white p-2 shadow-sm"
                                        >
                                            <p
                                                class="mb-1 text-left text-[7px] font-bold uppercase leading-tight tracking-wider text-slate-500"
                                            >
                                                Visits
                                            </p>
                                            <div
                                                class="flex items-center gap-1 text-left"
                                            >
                                                <CursorArrowRaysIcon
                                                    class="h-3 w-3 text-indigo-600"
                                                />
                                                <p
                                                    class="text-[10px] font-bold leading-none text-slate-900"
                                                >
                                                    {{
                                                        globalStats.totalVisits
                                                    }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="mb-6 rounded-xl border border-slate-200 bg-white p-3 text-left shadow-sm"
                                    >
                                        <h3
                                            class="mb-0.5 text-left text-[9px] font-bold text-slate-900"
                                        >
                                            Welcome back, User!
                                        </h3>
                                        <p
                                            class="mb-3 text-left text-[7px] leading-tight text-slate-500"
                                        >
                                            Manage your short URLs and monitor
                                            their performance from your
                                            dashboard.
                                        </p>
                                        <div
                                            class="inline-flex items-center gap-1.5 rounded bg-emerald-600 px-2 py-1 text-white shadow-sm shadow-emerald-200"
                                        >
                                            <LinkIcon class="h-2.5 w-2.5" />
                                            <span class="text-[8px] font-bold"
                                                >Manage URLs</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900 py-12 sm:py-16">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div
                        class="relative isolate overflow-hidden rounded-3xl bg-emerald-700 px-6 py-12 shadow-2xl sm:px-16 sm:py-16"
                    >
                        <div class="mx-auto max-w-4xl text-center">
                            <h2
                                class="text-3xl font-bold tracking-tight text-white sm:text-4xl"
                            >
                                Ready to clean up your links?
                            </h2>
                            <p
                                class="mx-auto mt-4 max-w-none text-center text-lg leading-8 text-emerald-100"
                            >
                                Join ShortyLink today and give your team the
                                infrastructure they need to manage their digital
                                outreach.
                            </p>
                            <div class="mt-8 flex justify-center gap-x-6">
                                <Link
                                    v-if="!$page.props.auth.user"
                                    :href="route('login')"
                                    class="rounded-md bg-white px-8 py-3 text-sm font-semibold text-emerald-700 shadow-sm transition hover:bg-emerald-50"
                                >
                                    Get Started Now
                                </Link>
                                <Link
                                    v-else
                                    :href="route('dashboard')"
                                    class="rounded-md bg-white px-8 py-3 text-sm font-semibold text-emerald-700 shadow-sm transition hover:bg-emerald-50"
                                >
                                    Dashboard
                                </Link>
                            </div>
                        </div>
                        <svg
                            viewBox="0 0 1024 1024"
                            class="absolute left-1/2 top-1/2 -z-10 h-[64rem] w-[64rem] -translate-x-1/2 -translate-y-1/2 [mask-image:radial-gradient(closest-side,white,transparent)]"
                            aria-hidden="true"
                        >
                            <circle
                                cx="512"
                                cy="512"
                                r="512"
                                fill="url(#gradient)"
                                fill-opacity="0.7"
                            />
                            <defs>
                                <radialGradient id="gradient">
                                    <stop stop-color="#10b981" />
                                    <stop offset="1" stop-color="#0ea5e9" />
                                </radialGradient>
                            </defs>
                        </svg>
                    </div>
                </div>
            </div>
        </main>

        <footer class="border-t border-slate-100 bg-white py-12">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div
                    class="flex flex-col items-center justify-between gap-4 md:flex-row"
                >
                    <div class="flex items-center gap-2">
                        <LinkIcon class="h-6 w-6 text-emerald-600" />
                        <span
                            class="font-sans text-lg font-bold tracking-tight text-slate-900"
                            >ShortyLink</span
                        >
                    </div>
                    <p class="font-sans text-xs leading-5 text-slate-500">
                        &copy; 2026 ShortyLink. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>
