<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-100">
    <div x-data="{ sidebarIsOpen: false }" class="relative flex w-full flex-col md:flex-row">
        <!-- This allows screen readers to skip the sidebar and go directly to the main content. -->
        <a class="sr-only" href="#main-content">skip to the main content</a>

        <!-- dark overlay for when the sidebar is open on smaller screens  -->
        <div x-cloak x-show="sidebarIsOpen" class="fixed inset-0 z-20 bg-neutral-950/10 backdrop-blur-xs md:hidden"
            aria-hidden="true" x-on:click="sidebarIsOpen = false" x-transition.opacity></div>

        <nav x-cloak
            class="fixed left-0 z-30 flex h-svh w-60 shrink-0 flex-col border-r border-neutral-300 bg-green-300 p-4 transition-transform duration-300 md:w-64 md:translate-x-0 md:relative dark:border-neutral-700 dark:bg-neutral-900"
            x-bind:class="sidebarIsOpen ? 'translate-x-0' : '-translate-x-60'" aria-label="sidebar navigation">
            <!-- logo  -->
            <a href="#" class="flex items-center gap-2 ml-2">
                <img src="/images/logo-pku.png" alt="Logo" class="h-10 w-auto object-contain" />

                <div class="flex flex-col leading-tight">
                    <span class="text-sm font-bold text-neutral-900">
                        SITAMA
                    </span>
                    <span class="text-xs text-neutral-500">
                        Sistem Informasi Tugas Magang
                    </span>
                </div>
            </a>


            <!-- sidebar links  -->
            <div class="flex flex-col gap-2 overflow-y-auto pb-6 my-4">

                <a href="{{ route('dashboard') }}" wire:navigate
                    class="flex items-center rounded-lg gap-2 px-3 py-2 text-sm font-medium transition
{{ request()->routeIs('dashboard')
    ? 'bg-emerald-50 text-emerald-700'
    : 'text-neutral-600 hover:bg-black/5 hover:text-neutral-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                        class="size-5 shrink-0" aria-hidden="true">
                        <path
                            d="M15.5 2A1.5 1.5 0 0 0 14 3.5v13a1.5 1.5 0 0 0 1.5 1.5h1a1.5 1.5 0 0 0 1.5-1.5v-13A1.5 1.5 0 0 0 16.5 2h-1ZM9.5 6A1.5 1.5 0 0 0 8 7.5v9A1.5 1.5 0 0 0 9.5 18h1a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 10.5 6h-1ZM3.5 10A1.5 1.5 0 0 0 2 11.5v5A1.5 1.5 0 0 0 3.5 18h1A1.5 1.5 0 0 0 6 16.5v-5A1.5 1.5 0 0 0 4.5 10h-1Z" />
                    </svg>
                    <span>Dashboard</span>
                </a>
                @if (strtolower(auth()->user()->role) === 'admin')
                    <a href="{{ route('users.index') }}" wire:navigate
                        class="flex items-center rounded-lg gap-2 px-3 py-2 text-sm font-medium transition
{{ request()->routeIs('users.*')
    ? 'bg-emerald-50 text-emerald-700'
    : 'text-neutral-600 hover:bg-black/5 hover:text-neutral-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="size-5 shrink-0" aria-hidden="true">
                            <path
                                d="M10 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM6 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM1.49 15.326a.78.78 0 0 1-.358-.442 3 3 0 0 1 4.308-3.516 6.484 6.484 0 0 0-1.905 3.959c-.023.222-.014.442.025.654a4.97 4.97 0 0 1-2.07-.655ZM16.44 15.98a4.97 4.97 0 0 0 2.07-.654.78.78 0 0 0 .357-.442 3 3 0 0 0-4.308-3.517 6.484 6.484 0 0 1 1.907 3.96 2.32 2.32 0 0 1-.026.654ZM18 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM5.304 16.19a.844.844 0 0 1-.277-.71 5 5 0 0 1 9.947 0 .843.843 0 0 1-.277.71A6.975 6.975 0 0 1 10 18a6.974 6.974 0 0 1-4.696-1.81Z" />
                        </svg>
                        <span>Manage User</span>
                        <span class="sr-only">active</span>
                    </a>
                @endif
                <div x-data="{
                    isExpanded: {{ request()->routeIs('tasks.*') ? 'true' : 'false' }}
                }" class="flex flex-col">
                    <button @click="isExpanded = !isExpanded"
                        class="flex items-center justify-between rounded-lg gap-2 px-3 py-2 text-sm font-medium transition
        {{ request()->routeIs('tasks.*')
            ? 'bg-emerald-50 text-emerald-700'
            : 'text-neutral-600 hover:bg-black/5 hover:text-neutral-900' }}">
                        <div class="flex items-center gap-2">
                            <!-- icon parent -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M5 3.75A1.75 1.75 0 0 1 6.75 2h6.5A1.75 1.75 0 0 1 15 3.75v12.5A1.75 1.75 0 0 1 13.25 18h-6.5A1.75 1.75 0 0 1 5 16.25V3.75ZM7.5 6a.75.75 0 0 0 0 1.5h5a.75.75 0 0 0 0-1.5h-5Zm0 3.25a.75.75 0 0 0 0 1.5h5a.75.75 0 0 0 0-1.5h-5Zm0 3.25a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z"
                                    clip-rule="evenodd" />
                            </svg>

                            <span>Task</span>
                        </div>

                        <!-- arrow -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="size-4 transition-transform" :class="isExpanded ? 'rotate-180' : ''">
                            <path fill-rule="evenodd"
                                d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <ul x-show="isExpanded" x-collapse x-cloak class="mt-1 ml-3">
                        @if (strtolower(auth()->user()->role) === 'admin')
                            <li>
                                <a href="{{ route('tasks.create') }}"
                                    class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm transition
                {{ request()->routeIs('tasks.create')
                    ? 'bg-emerald-50 text-emerald-700'
                    : 'text-neutral-600 hover:bg-black/5 hover:text-neutral-900' }}">

                                    <!-- icon create -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="size-4">
                                        <path
                                            d="M10 5a.75.75 0 0 1 .75.75v3.5h3.5a.75.75 0 0 1 0 1.5h-3.5v3.5a.75.75 0 0 1-1.5 0v-3.5h-3.5a.75.75 0 0 1 0-1.5h3.5v-3.5A.75.75 0 0 1 10 5Z" />
                                    </svg>

                                    Create Task
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ route('tasks.index') }}" wire:navigate
                                class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm transition
                {{ request()->routeIs('tasks.index')
                    ? 'bg-emerald-50 text-emerald-700'
                    : 'text-neutral-600 hover:bg-black/5 hover:text-neutral-900' }}">

                                <!-- icon list -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="size-4">
                                    <path fill-rule="evenodd"
                                        d="M3 5.75A.75.75 0 0 1 3.75 5h12.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 5.75Zm0 4.25a.75.75 0 0 1 .75-.75h12.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 10Zm0 4.25a.75.75 0 0 1 .75-.75h8.5a.75.75 0 0 1 0 1.5h-8.5a.75.75 0 0 1-.75-.75Z"
                                        clip-rule="evenodd" />
                                </svg>

                                List Task
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </nav>

        <!-- top navbar & main content  -->
        <div class="h-svh w-full overflow-y-auto bg-white dark:bg-neutral-950">
            <!-- top navbar  -->
            <nav class="sticky top-0 z-10 flex items-center justify-between border-b border-neutral-300 bg-green-300 px-4 py-2 dark:border-neutral-700 dark:bg-neutral-900"
                aria-label="top navibation bar">

                <!-- sidebar toggle button for small screens  -->
                <button type="button" class="md:hidden inline-block text-neutral-600 dark:text-neutral-300"
                    x-on:click="sidebarIsOpen = true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-5"
                        aria-hidden="true">
                        <path
                            d="M0 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5-1v12h9a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zM4 2H2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h2z" />
                    </svg>
                    <span class="sr-only">sidebar toggle</span>
                </button>

                <!-- breadcrumbs  -->
                <nav class="hidden md:inline-block text-sm font-medium text-neutral-600 dark:text-neutral-300"
                    aria-label="breadcrumb">
                    {{-- <ol class="flex flex-wrap items-center gap-1">
                        <li class="flex items-center gap-1">
                            <a href="#" class="hover:text-neutral-900 dark:hover:text-white">Dashboard</a>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor"
                                fill="none" stroke-width="2" class="size-4" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </li>

                        <li class="flex items-center gap-1 font-bold text-neutral-900 dark:text-white"
                            aria-current="page">Marketing</li>
                    </ol> --}}
                </nav>


                <!-- Profile Menu  -->
                <div x-data="{ userDropdownIsOpen: false }" class="relative" x-on:keydown.esc.window="userDropdownIsOpen = false">
                    <button type="button"
                        class="flex w-full items-center rounded-sm gap-2 p-2 text-left text-neutral-600 hover:bg-black/5 hover:text-neutral-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black dark:text-neutral-300 dark:hover:bg-white/5 dark:hover:text-white dark:focus-visible:outline-white"
                        x-bind:class="userDropdownIsOpen ? 'bg-black/10 dark:bg-white/10' : ''" aria-haspopup="true"
                        x-on:click="userDropdownIsOpen = ! userDropdownIsOpen"
                        x-bind:aria-expanded="userDropdownIsOpen">
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}"
                            class="size-8 object-cover rounded-sm" alt="avatar" aria-hidden="true" />
                        <div class="hidden md:flex flex-col">
                            <span class="text-sm font-bold text-neutral-900 dark:text-white">{{ auth()->user()->name }}</span>
                            <span class="text-xs" aria-hidden="true">{{ auth()->user()->role }}</span>
                            <span class="sr-only">profile settings</span>
                        </div>
                    </button>

                    <!-- menu -->
                    <div x-cloak x-show="userDropdownIsOpen"
                        class="absolute top-14 right-0 z-20 h-fit w-48 border divide-y divide-neutral-300 border-neutral-300 bg-white dark:divide-neutral-700 dark:border-neutral-700 dark:bg-neutral-950 rounded-sm"
                        role="menu" x-on:click.outside="userDropdownIsOpen = false"
                        x-on:keydown.down.prevent="$focus.wrap().next()"
                        x-on:keydown.up.prevent="$focus.wrap().previous()" x-transition=""
                        x-trap="userDropdownIsOpen">

                        <div class="flex flex-col py-1.5">
                            <a href="#"
                                class="flex items-center gap-2 px-2 py-1.5 text-sm font-medium text-neutral-600 underline-offset-2 hover:bg-black/5 hover:text-neutral-900 focus-visible:underline focus:outline-hidden dark:text-neutral-300 dark:hover:bg-white/5 dark:hover:text-white"
                                role="menuitem">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="size-5 shrink-0" aria-hidden="true">
                                    <path
                                        d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957 9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 0 0-13.074.003Z" />
                                </svg>
                                <span>Profile</span>
                            </a>
                        </div>

                        <div class="flex flex-col py-1.5">
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button
                                    class="w-full flex items-center gap-2 px-2 py-1.5 text-sm font-medium text-neutral-600 underline-offset-2 hover:bg-black/5 hover:text-neutral-900 focus-visible:underline focus:outline-hidden dark:text-neutral-300 dark:hover:bg-white/5 dark:hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="size-5 shrink-0" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M3 4.25A2.25 2.25 0 0 1 5.25 2h5.5A2.25 2.25 0 0 1 13 4.25v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 0-.75-.75h-5.5a.75.75 0 0 0-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75v-2a.75.75 0 0 1 1.5 0v2A2.25 2.25 0 0 1 10.75 18h-5.5A2.25 2.25 0 0 1 3 15.75V4.25Z"
                                            clip-rule="evenodd" />
                                        <path fill-rule="evenodd"
                                            d="M6 10a.75.75 0 0 1 .75-.75h9.546l-1.048-.943a.75.75 0 1 1 1.004-1.114l2.5 2.25a.75.75 0 0 1 0 1.114l-2.5 2.25a.75.75 0 1 1-1.004-1.114l1.048-.943H6.75A.75.75 0 0 1 6 10Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Sign Out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- main content  -->
            <div id="main-content" class="p-4">
                <div
                    class="overflow-y-auto shadow-sm rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-950">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    @fluxScripts
</body>

</html>
