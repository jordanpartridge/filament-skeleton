<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Filament Admin Panel Skeleton</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100">
<div class="min-h-screen">
    <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-primary-500 selection:text-white">
        <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
            <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                <div class="flex lg:justify-center lg:col-start-2">
                    <svg class="h-12 w-auto lg:h-16 text-primary-600 dark:text-primary-500" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-1-9H8v2h3v3h2v-3h3v-2h-3V8h-2v3z"/>
                    </svg>
                </div>

                <nav class="-mx-3 flex flex-1 justify-end gap-2">
                    <a href="https://github.com/JustinByrne/filament-skeleton"
                       class="rounded-md px-3 py-2 text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white transition">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="https://packagist.org/packages/justinbyrne/filament-skeleton"
                       class="rounded-md px-3 py-2 text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white transition">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0L1.605 6v12L12 24l10.395-6V6L12 0zm6 16.59c0 .705-.646 1.29-1.529 1.29-.631 0-1.351-.255-1.801-.81l-2.999-3.015c-.467-.48-1.277-.48-1.744 0L6.93 17.07c-.45.555-1.17.81-1.801.81-.883 0-1.529-.585-1.529-1.29V7.41c0-.705.646-1.29 1.529-1.29.631 0 1.351.255 1.801.81l2.999 3.015c.467.48 1.277.48 1.744 0l2.999-3.015c.45-.555 1.17-.81 1.801-.81.883 0 1.529.585 1.529 1.29v9.18z"/>
                        </svg>
                    </a>
                            <a href="{{ url('/admin') }}" class="rounded-md px-3 py-2 text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white transition">
                                Dashboard
                            </a>
                </nav>
            </header>

            <main class="mt-6">
                <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                    <a href="https://filamentphp.com/docs"
                       class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-lg transition duration-300 hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <div class="relative flex w-full flex-1 items-center">
                            <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-primary-500/10 dark:bg-primary-500/20 sm:size-16">
                                <svg class="size-5 sm:size-6 text-primary-600 dark:text-primary-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-xl font-semibold">Documentation</h2>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                    Access Filament's comprehensive documentation to learn how to build powerful admin panels with this skeleton.
                                </p>
                            </div>
                        </div>
                    </a>

                    <a href="https://filamentphp.com/plugins"
                       class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-lg transition duration-300 hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <div class="relative flex w-full flex-1 items-center">
                            <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-primary-500/10 dark:bg-primary-500/20 sm:size-16">
                                <svg class="size-5 sm:size-6 text-primary-600 dark:text-primary-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-xl font-semibold">Plugin Marketplace</h2>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                    Extend your admin panel with our growing collection of community plugins and themes.
                                </p>
                            </div>
                        </div>
                    </a>

                    <div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-lg dark:bg-gray-800">
                        <div class="relative flex w-full flex-1 items-center">
                            <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-primary-500/10 dark:bg-primary-500/20 sm:size-16">
                                <svg class="size-5 sm:size-6 text-primary-600 dark:text-primary-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-xl font-semibold">Pre-built Features</h2>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                    This skeleton includes activity logging and login link functionality out of the box.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-lg dark:bg-gray-800">
                        <div class="relative flex w-full flex-1 items-center">
                            <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-primary-500/10 dark:bg-primary-500/20 sm:size-16">
                                <svg class="size-5 sm:size-6 text-primary-600 dark:text-primary-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-xl font-semibold">Development Tools</h2>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                    Includes Pest for testing, Pint for styling, and Pail for improved logging during development.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="py-16 text-center text-sm text-gray-600 dark:text-gray-400">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }}
