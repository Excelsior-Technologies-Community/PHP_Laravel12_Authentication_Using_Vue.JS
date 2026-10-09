<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    stats: {
        type: Object,
        default: () => ({
            totalUsers: 0,
            activeUsers: 0,
            blockedUsers: 0,
            totalLogins: 0,
            recentLogins: []
        })
    }
});
</script>

<template>

    <Head title="Admin Dashboard & Security Center" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                👑 Super Admin Dashboard & Security Command Center
            </h2>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

                <!-- Welcome Banner -->
                <div class="bg-gradient-to-r from-indigo-700 via-purple-700 to-pink-700 rounded-2xl shadow-lg p-8 text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <h1 class="text-3xl font-extrabold tracking-tight">
                            Welcome Back, Administrator 👋
                        </h1>
                        <p class="mt-2 text-indigo-100 text-sm font-medium">
                            Full Control over User Access, Active Sessions, Blocked Accounts & Audit Logs.
                        </p>
                    </div>

                    <Link 
                        href="/users" 
                        class="px-6 py-3 bg-white text-indigo-700 font-bold rounded-xl shadow hover:bg-indigo-50 transition-all flex items-center gap-2 text-sm"
                    >
                        ⚡ Open User Control Center
                    </Link>
                </div>

                <!-- Live Statistics Grid -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                    <div class="bg-white rounded-2xl shadow-sm p-6 border-l-4 border-indigo-500 border border-gray-100">
                        <p class="text-xs font-semibold uppercase text-gray-400">Total Registered Users</p>
                        <h2 class="text-3xl font-extrabold text-indigo-600 mt-2">
                            {{ stats.totalUsers || 0 }}
                        </h2>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm p-6 border-l-4 border-emerald-500 border border-gray-100">
                        <p class="text-xs font-semibold uppercase text-gray-400">Active Non-Blocked Users</p>
                        <h2 class="text-3xl font-extrabold text-emerald-600 mt-2">
                            {{ stats.activeUsers || 0 }}
                        </h2>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm p-6 border-l-4 border-rose-500 border border-gray-100">
                        <p class="text-xs font-semibold uppercase text-gray-400">Blocked Accounts</p>
                        <h2 class="text-3xl font-extrabold text-rose-600 mt-2">
                            {{ stats.blockedUsers || 0 }}
                        </h2>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm p-6 border-l-4 border-purple-500 border border-gray-100">
                        <p class="text-xs font-semibold uppercase text-gray-400">Total Login Activities</p>
                        <h2 class="text-3xl font-extrabold text-purple-600 mt-2">
                            {{ stats.totalLogins || 0 }}
                        </h2>
                    </div>

                </div>

                <!-- Quick Actions & Recent Logins -->
                <div class="grid lg:grid-cols-3 gap-8">

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 space-y-4">
                        <h2 class="text-lg font-bold text-gray-900 border-b pb-3 flex items-center gap-2">
                            ⚡ Quick Administration
                        </h2>

                        <div class="space-y-3">
                            <Link
                                href="/users"
                                class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition-all text-sm shadow-sm"
                            >
                                👥 User & RBAC Management
                            </Link>

                            <Link
                                href="/login-history"
                                class="block text-center bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 rounded-xl transition-all text-sm shadow-sm"
                            >
                                📜 Audit Logs & Session Radar
                            </Link>

                            <Link
                                href="/profile"
                                class="block text-center bg-gray-800 hover:bg-gray-900 text-white font-semibold py-3 rounded-xl transition-all text-sm shadow-sm"
                            >
                                ⚙️ Admin Profile Settings
                            </Link>
                        </div>
                    </div>

                    <!-- Recent Login Audit Log Widget -->
                    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                        <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-100">
                            <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                🛡️ Recent Login Audit Log
                            </h2>
                            <Link href="/login-history" class="text-xs font-semibold text-indigo-600 hover:underline">
                                View Full History →
                            </Link>
                        </div>

                        <div v-if="!stats.recentLogins || stats.recentLogins.length === 0" class="text-center py-8 text-gray-400 text-sm">
                            No recent login activities logged.
                        </div>

                        <div v-else class="space-y-3 max-h-80 overflow-y-auto">
                            <div 
                                v-for="log in stats.recentLogins" 
                                :key="log.id"
                                class="flex justify-between items-center bg-gray-50 p-3 rounded-xl border border-gray-100 text-xs"
                            >
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-indigo-100 text-indigo-700 font-bold rounded-full flex items-center justify-center text-xs">
                                        {{ log.user ? log.user.name.charAt(0) : 'U' }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900">{{ log.user ? log.user.name : 'Unknown User' }}</div>
                                        <div class="text-gray-500 font-mono">{{ log.ip_address }} • {{ log.browser }} • {{ log.device }}</div>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-700">
                                        Logged In
                                    </span>
                                    <div class="text-gray-400 mt-1">{{ new Date(log.created_at).toLocaleTimeString() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </AuthenticatedLayout>

</template>