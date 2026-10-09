<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

const props = defineProps({
    users: Object,
    filters: Object,
    statistics: Object
})

const page = usePage()
const currentUser = computed(() => page.props.auth.user)

const search = ref(props.filters.search ?? '')
const sort = ref(props.filters.sort ?? 'id_asc')
const perPage = ref(props.filters.perPage ?? 10)
const role = ref(props.filters.role ?? '')
const status = ref(props.filters.status ?? '')

function filterUsers() {
    router.get('/users', {
        search: search.value,
        sort: sort.value,
        perPage: perPage.value,
        role: role.value,
        status: status.value
    }, {
        preserveState: true,
        replace: true
    })
}

function toggleUserStatus(user) {
    if (user.id === currentUser.value.id) {
        alert("You cannot block your own admin account.")
        return
    }

    const action = user.status === 'blocked' ? 'Unblock' : 'Block'
    if (confirm(`Are you sure you want to ${action} user '${user.name}'?`)) {
        router.post(`/users/${user.id}/toggle-status`, {}, {
            preserveScroll: true
        })
    }
}

function updateUserRole(user, newRole) {
    if (user.id === currentUser.value.id && newRole !== 'admin') {
        alert("You cannot demote your own admin account.")
        return
    }

    router.post(`/users/${user.id}/update-role`, {
        role: newRole
    }, {
        preserveScroll: true
    })
}

function revokeUserSessions(user) {
    if (confirm(`Revoke all active login sessions for '${user.name}'?`)) {
        router.post(`/users/${user.id}/revoke-sessions`, {}, {
            preserveScroll: true
        })
    }
}
</script>

<template>

    <Head title="User Management & RBAC Studio" />

    <AuthenticatedLayout>

        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    🛡️ User Management, Active Sessions & RBAC Radar
                </h2>
                <span class="text-xs bg-indigo-100 text-indigo-800 font-semibold px-3 py-1 rounded-full border border-indigo-200">
                    Admin Portal
                </span>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <!-- STATISTICS CARDS -->
                <div class="grid grid-cols-2 md:grid-cols-6 gap-4">

                    <div class="bg-blue-600 text-white rounded-xl p-4 shadow-sm border border-blue-700">
                        <p class="text-xs uppercase font-semibold text-blue-100">Total Users</p>
                        <h2 class="text-2xl font-extrabold mt-1">
                            {{ statistics.totalUsers }}
                        </h2>
                    </div>

                    <div class="bg-emerald-600 text-white rounded-xl p-4 shadow-sm border border-emerald-700">
                        <p class="text-xs uppercase font-semibold text-emerald-100">Active Users</p>
                        <h2 class="text-2xl font-extrabold mt-1">
                            {{ statistics.activeUsers }}
                        </h2>
                    </div>

                    <div class="bg-rose-600 text-white rounded-xl p-4 shadow-sm border border-rose-700">
                        <p class="text-xs uppercase font-semibold text-rose-100">Blocked Users</p>
                        <h2 class="text-2xl font-extrabold mt-1">
                            {{ statistics.blockedUsers }}
                        </h2>
                    </div>

                    <div class="bg-amber-500 text-white rounded-xl p-4 shadow-sm border border-amber-600">
                        <p class="text-xs uppercase font-semibold text-amber-100">Verified Email</p>
                        <h2 class="text-2xl font-extrabold mt-1">
                            {{ statistics.verifiedUsers }}
                        </h2>
                    </div>

                    <div class="bg-indigo-600 text-white rounded-xl p-4 shadow-sm border border-indigo-700">
                        <p class="text-xs uppercase font-semibold text-indigo-100">Admins</p>
                        <h2 class="text-2xl font-extrabold mt-1">
                            {{ statistics.adminUsers }}
                        </h2>
                    </div>

                    <div class="bg-slate-700 text-white rounded-xl p-4 shadow-sm border border-slate-800">
                        <p class="text-xs uppercase font-semibold text-slate-200">Normal Users</p>
                        <h2 class="text-2xl font-extrabold mt-1">
                            {{ statistics.normalUsers }}
                        </h2>
                    </div>

                </div>

                <!-- USER TABLE CONTAINER -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

                    <!-- FILTERS BAR -->
                    <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">

                        <div class="relative flex-1">
                            <input 
                                v-model="search" 
                                @keyup="filterUsers" 
                                type="text" 
                                placeholder="Search by Name, Email or Role..."
                                class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            >
                        </div>

                        <div class="flex flex-wrap gap-3">

                            <!-- Status Filter -->
                            <select v-model="status" @change="filterUsers" class="border border-gray-300 rounded-xl px-3 py-2 text-sm font-medium bg-white">
                                <option value="">All Statuses</option>
                                <option value="active">🟢 Active</option>
                                <option value="blocked">🔴 Blocked</option>
                            </select>

                            <!-- Role Filter -->
                            <select v-model="role" @change="filterUsers" class="border border-gray-300 rounded-xl px-3 py-2 text-sm font-medium bg-white">
                                <option value="">All Roles</option>
                                <option value="admin">👑 Admin</option>
                                <option value="user">👤 User</option>
                            </select>

                            <!-- Sort Filter -->
                            <select v-model="sort" @change="filterUsers" class="border border-gray-300 rounded-xl px-3 py-2 text-sm font-medium bg-white">
                                <option value="id_asc">ID Ascending</option>
                                <option value="id_desc">ID Descending</option>
                                <option value="name_asc">Name A-Z</option>
                                <option value="name_desc">Name Z-A</option>
                                <option value="latest">Newest First</option>
                                <option value="oldest">Oldest First</option>
                            </select>

                            <!-- Rows Per Page -->
                            <select v-model="perPage" @change="filterUsers" class="border border-gray-300 rounded-xl px-3 py-2 text-sm font-medium bg-white">
                                <option value="10">10 Rows</option>
                                <option value="25">25 Rows</option>
                                <option value="50">50 Rows</option>
                            </select>

                        </div>

                    </div>

                    <!-- TABLE -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left border-collapse">

                            <thead>
                                <tr class="bg-gray-50 text-gray-500 text-xs uppercase font-bold tracking-wider border-b border-gray-200">
                                    <th class="px-4 py-3">ID</th>
                                    <th class="px-4 py-3">User Details</th>
                                    <th class="px-4 py-3">Role (RBAC)</th>
                                    <th class="px-4 py-3 text-center">Status</th>
                                    <th class="px-4 py-3 text-center">Active Sessions</th>
                                    <th class="px-4 py-3">Joined Date</th>
                                    <th class="px-4 py-3 text-right">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100 text-sm">

                                <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-50/80 transition-all">

                                    <td class="px-4 py-3.5 font-mono text-xs text-gray-500 font-bold">
                                        #{{ user.id }}
                                    </td>

                                    <td class="px-4 py-3.5">
                                        <div class="font-semibold text-gray-900">{{ user.name }}</div>
                                        <div class="text-xs text-gray-500">{{ user.email }}</div>
                                    </td>

                                    <td class="px-4 py-3.5">
                                        <select 
                                            :value="user.role" 
                                            @change="updateUserRole(user, $event.target.value)"
                                            class="text-xs font-semibold px-2.5 py-1 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-indigo-500"
                                        >
                                            <option value="user">User</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </td>

                                    <td class="px-4 py-3.5 text-center">
                                        <span v-if="user.status === 'blocked'" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700">
                                            🔴 Blocked
                                        </span>
                                        <span v-else class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                            🟢 Active
                                        </span>
                                    </td>

                                    <td class="px-4 py-3.5 text-center font-mono text-xs font-bold text-gray-600">
                                        {{ user.login_activities_count || 0 }} Activity Logs
                                    </td>

                                    <td class="px-4 py-3.5 text-xs text-gray-500">
                                        {{ new Date(user.created_at).toLocaleDateString() }}
                                    </td>

                                    <td class="px-4 py-3.5 text-right">
                                        <div class="flex justify-end gap-2">
                                            
                                            <!-- Block / Unblock Button -->
                                            <button 
                                                @click="toggleUserStatus(user)"
                                                :disabled="user.id === currentUser.id"
                                                :class="[
                                                    'px-3 py-1.5 rounded-lg text-xs font-bold transition-all shadow-sm flex items-center gap-1',
                                                    user.status === 'blocked' 
                                                        ? 'bg-emerald-600 hover:bg-emerald-700 text-white' 
                                                        : 'bg-rose-600 hover:bg-rose-700 text-white disabled:opacity-40'
                                                ]"
                                            >
                                                <span v-if="user.status === 'blocked'">🔓 Unblock</span>
                                                <span v-else>🚫 Block User</span>
                                            </button>

                                            <!-- Revoke Sessions Button -->
                                            <button 
                                                @click="revokeUserSessions(user)"
                                                class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold shadow-sm transition-all flex items-center gap-1"
                                                title="Revoke Active Login Sessions"
                                            >
                                                ⚡ Revoke Sessions
                                            </button>

                                        </div>
                                    </td>

                                </tr>

                                <tr v-if="users.data.length === 0">
                                    <td colspan="7" class="text-center py-8 text-gray-400 font-medium">
                                        No users found matching your filters.
                                    </td>
                                </tr>

                            </tbody>

                        </table>
                    </div>

                    <!-- PAGINATION -->
                    <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-100">
                        <span class="text-xs text-gray-500">
                            Showing {{ users.from || 0 }} to {{ users.to || 0 }} of {{ users.total }} users
                        </span>

                        <div class="flex gap-1">
                            <Link 
                                v-for="link in users.links" 
                                :key="link.label" 
                                :href="link.url || '#'" 
                                v-html="link.label"
                                class="px-3 py-1.5 text-xs font-semibold rounded-lg border transition-all"
                                :class="{
                                    'bg-indigo-600 text-white border-indigo-600': link.active,
                                    'bg-white text-gray-700 hover:bg-gray-50 border-gray-300': !link.active && link.url,
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