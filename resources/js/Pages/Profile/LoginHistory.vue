<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    activities: [Object, Array],
    isAdmin: Boolean,
    activeSessionsCount: Number
});

const activityList = computed(() => {
    return Array.isArray(props.activities) ? props.activities : (props.activities.data || []);
});

function logoutOtherDevices() {
    if (confirm("Are you sure you want to log out from all other devices and browser sessions?")) {
        router.post('/login-history/logout-other-devices', {}, {
            preserveScroll: true
        });
    }
}
</script>

<template>
    <Head title="Login History & Device Revocation" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                🛡️ Security Activity & Device Revocation Radar
            </h2>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

                <!-- Header Banner -->
                <div class="bg-gradient-to-r from-indigo-700 to-purple-700 rounded-2xl shadow-lg p-8 text-white">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                        <div>
                            <h1 class="text-3xl font-extrabold">
                                Active Sessions & Audit Trail
                            </h1>
                            <p class="mt-2 text-indigo-100 text-sm">
                                Monitor your active device logins, IP addresses, browsers, and revoke remote access.
                            </p>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="bg-white/20 rounded-xl px-5 py-3 backdrop-blur text-center border border-white/10">
                                <p class="text-xs text-indigo-200 uppercase font-semibold">Active Sessions</p>
                                <h2 class="text-2xl font-black mt-0.5">
                                    {{ activeSessionsCount || activityList.length }}
                                </h2>
                            </div>

                            <button 
                                @click="logoutOtherDevices"
                                class="px-5 py-3 bg-rose-500 hover:bg-rose-600 text-white font-bold rounded-xl shadow-md transition-all flex items-center gap-2 text-sm"
                            >
                                ⚡ Logout All Other Devices
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Login Table -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">
                                Recent Security Logins
                            </h2>
                            <p class="text-xs text-gray-500 mt-0.5">
                                Real-time activity logs containing IP address, browser user-agent and timestamp.
                            </p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-bold tracking-wider border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3.5">#</th>
                                    <th v-if="isAdmin" class="px-6 py-3.5">User</th>
                                    <th class="px-6 py-3.5">IP Address</th>
                                    <th class="px-6 py-3.5">Browser</th>
                                    <th class="px-6 py-3.5">Device</th>
                                    <th class="px-6 py-3.5">Login Time</th>
                                    <th class="px-6 py-3.5 text-center">Session Status</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100 text-sm">
                                <tr v-for="(item, index) in activityList" :key="item.id" class="hover:bg-gray-50 transition-all">
                                    <td class="px-6 py-4 font-mono text-xs text-gray-500 font-bold">
                                        {{ index + 1 }}
                                    </td>

                                    <td v-if="isAdmin" class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center text-xs">
                                                {{ item.user ? item.user.name.charAt(0) : 'U' }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-800">{{ item.user?.name || 'Unknown' }}</p>
                                                <p class="text-xs text-gray-400">{{ item.user?.email }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="bg-blue-50 text-blue-700 font-mono px-3 py-1 rounded-full text-xs font-semibold border border-blue-200">
                                            {{ item.ip_address || '127.0.0.1' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <span class="text-base">🌐</span>
                                            <span class="font-medium text-gray-800">{{ item.browser || 'Chrome' }}</span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <span class="text-base">💻</span>
                                            <span class="text-gray-700">{{ item.device || 'Windows Device' }}</span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="text-xs font-semibold text-gray-600">
                                            {{ new Date(item.login_time || item.created_at).toLocaleString() }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <span v-if="item.logout_time" class="px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">
                                            Ended ({{ new Date(item.logout_time).toLocaleTimeString() }})
                                        </span>
                                        <span v-else class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                            🟢 Active Session
                                        </span>
                                    </td>
                                </tr>

                                <tr v-if="activityList.length === 0">
                                    <td :colspan="isAdmin ? 7 : 6" class="text-center py-12 text-gray-400">
                                        <div class="text-4xl mb-2">🔒</div>
                                        <h3 class="text-base font-bold text-gray-700">No Login Activity Found</h3>
                                        <p class="text-xs text-gray-400">Security history will appear here once users log in.</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div v-if="activities.links" class="flex justify-between items-center p-4 border-t border-gray-100 text-xs">
                        <span class="text-gray-500">Showing {{ activities.from || 0 }} to {{ activities.to || 0 }} of {{ activities.total }} logs</span>
                        <div class="flex gap-1">
                            <Link 
                                v-for="link in activities.links" 
                                :key="link.label" 
                                :href="link.url || '#'" 
                                v-html="link.label"
                                class="px-3 py-1.5 rounded-lg border transition-all"
                                :class="{
                                    'bg-indigo-600 text-white border-indigo-600': link.active,
                                    'bg-white text-gray-700 border-gray-300 hover:bg-gray-50': !link.active && link.url,
                                    'text-gray-300 border-gray-200 pointer-events-none': !link.url
                                }" 
                            />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>