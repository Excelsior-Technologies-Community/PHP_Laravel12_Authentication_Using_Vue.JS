<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

               
                <!-- Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

                    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-500">
                        <p class="text-gray-500">Framework</p>
                        <h2 class="text-3xl font-bold text-blue-600">
                            Laravel 12
                        </h2>
                    </div>

                    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-green-500">
                        <p class="text-gray-500">Frontend</p>
                        <h2 class="text-3xl font-bold text-green-600">
                            Vue 3
                        </h2>
                    </div>

                    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-purple-500">
                        <p class="text-gray-500">Authentication</p>
                        <h2 class="text-2xl font-bold text-purple-600">
                            Breeze
                        </h2>
                    </div>

                    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-yellow-500">
                        <p class="text-gray-500">Database</p>
                        <h2 class="text-2xl font-bold text-yellow-600">
                            MySQL
                        </h2>
                    </div>

                </div>

                <!-- Quick Actions -->
                <div class="grid md:grid-cols-2 gap-6">

                    <div class="bg-white rounded-xl shadow p-6">

                        <h2 class="text-xl font-bold mb-5">
                            🚀 Quick Actions
                        </h2>

                        <div class="space-y-4">

                            <Link
                                href="/users"
                                class="block bg-indigo-600 text-white text-center py-3 rounded-lg hover:bg-indigo-700 transition"
                            >
                                User Management
                            </Link>

                            <Link
                                href="/profile"
                                class="block bg-green-600 text-white text-center py-3 rounded-lg hover:bg-green-700 transition"
                            >
                                Edit Profile
                            </Link>

                        </div>

                    </div>

                    <div class="bg-white rounded-xl shadow p-6">

                        <h2 class="text-xl font-bold mb-5">
                            📋 Project Features
                        </h2>

                        <ul class="space-y-3 text-gray-700">

                            <li>✅ Login & Register Authentication</li>

                            <li>✅ Email Verification</li>

                            <li>✅ User Search</li>

                            <li>✅ User Pagination</li>

                            <li>✅ User Sorting</li>

                            <li>✅ Dashboard Statistics</li>

                            <li>✅ Responsive UI</li>

                            <li>✅ Vue + Inertia.js</li>

                        </ul>

                    </div>

                </div>

                <!-- Technology Stack -->
                <div class="bg-white rounded-xl shadow p-6 mt-8">

                    <h2 class="text-xl font-bold mb-5">
                        💻 Technology Stack
                    </h2>

                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">

                        <div class="bg-gray-100 rounded-lg p-4 text-center font-semibold">
                            Laravel 12
                        </div>

                        <div class="bg-gray-100 rounded-lg p-4 text-center font-semibold">
                            Vue 3
                        </div>

                        <div class="bg-gray-100 rounded-lg p-4 text-center font-semibold">
                            Inertia.js
                        </div>

                        <div class="bg-gray-100 rounded-lg p-4 text-center font-semibold">
                            Tailwind CSS
                        </div>

                        <div class="bg-gray-100 rounded-lg p-4 text-center font-semibold">
                            MySQL
                        </div>

                    </div>

                </div>

            </div>
        </div>

    </AuthenticatedLayout>
</template>