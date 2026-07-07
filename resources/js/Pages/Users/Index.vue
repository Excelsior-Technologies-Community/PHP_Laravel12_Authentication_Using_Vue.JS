<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    users: Object,
    filters: Object,
    statistics: Object
})

const search = ref(props.filters.search ?? '')
const sort = ref(props.filters.sort ?? 'id_asc')
const perPage = ref(props.filters.perPage ?? 4)
const role = ref(props.filters.role ?? '')

function filterUsers() {
    router.get('/users', {
        search: search.value,
        sort: sort.value,
        perPage: perPage.value,
        role: role.value
    }, {
        preserveState: true,
        replace: true
    })
}
</script>

<template>

    <Head title="Users" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-xl font-semibold text-gray-800">
                User Management
            </h2>
        </template>

        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <!-- Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-6 gap-5 mb-8">

                    <div class="bg-blue-500 text-white rounded-lg p-5 shadow">
                        <p>Total Users</p>
                        <h2 class="text-3xl font-bold">
                            {{ statistics.totalUsers }}
                        </h2>
                    </div>

                    <div class="bg-green-500 text-white rounded-lg p-5 shadow">
                        <p>Verified Users</p>
                        <h2 class="text-3xl font-bold">
                            {{ statistics.verifiedUsers }}
                        </h2>
                    </div>

                    <div class="bg-yellow-500 text-white rounded-lg p-5 shadow">
                        <p>Today's Users</p>
                        <h2 class="text-3xl font-bold">
                            {{ statistics.todayUsers }}
                        </h2>
                    </div>

                    <div class="bg-purple-500 text-white rounded-lg p-5 shadow">
                        <p>This Month</p>
                        <h2 class="text-3xl font-bold">
                            {{ statistics.thisMonthUsers }}
                        </h2>
                    </div>

                    <!-- Admin Users -->

                    <div class="bg-indigo-500 text-white rounded-lg p-5 shadow">

                        <p>
                            Admins
                        </p>

                        <h2 class="text-3xl font-bold">
                            {{ statistics.adminUsers }}
                        </h2>

                    </div>



                    <!-- Normal Users -->

                    <div class="bg-gray-700 text-white rounded-lg p-5 shadow">

                        <p>
                            Normal Users
                        </p>

                        <h2 class="text-3xl font-bold">
                            {{ statistics.normalUsers }}
                        </h2>

                    </div>
                </div>

                <!-- User Table -->
                <div class="bg-white rounded-lg shadow p-6">

                    <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">

                        <input v-model="search" @keyup="filterUsers" type="text" placeholder="Search Name or Email..."
                            class="border rounded-lg px-4 py-2 w-full md:w-1/2">

                        <div class="flex gap-3">

                            <select v-model="role" @change="filterUsers" class="border rounded-lg px-4 py-2">

                                <option value="">
                                    All Roles
                                </option>

                                <option value="admin">
                                    Admin
                                </option>

                                <option value="user">
                                    User
                                </option>

                            </select>

                            <select v-model="sort" @change="filterUsers" class="border rounded-lg px-4 py-2">
                                <option value="id_asc">ID Ascending</option>
                                <option value="id_desc">ID Descending</option>
                                <option value="name_asc">Name A-Z</option>
                                <option value="name_desc">Name Z-A</option>
                                <option value="latest">Newest</option>
                                <option value="oldest">Oldest</option>
                            </select>

                            <select v-model="perPage" @change="filterUsers" class="border rounded-lg px-4 py-2">
                                <option value="4">4 Rows</option>
                                <option value="10">10 Rows</option>
                                <option value="25">25 Rows</option>
                                <option value="50">50 Rows</option>
                            </select>

                        </div>

                    </div>

                    <table class="min-w-full border border-gray-300">

                        <thead class="bg-gray-100">

                            <tr>

                                <th class="border px-4 py-2">ID</th>

                                <th class="border px-4 py-2">
                                    Name
                                </th>

                                <th class="border px-4 py-2">
                                    Email
                                </th>

                                <th class="border px-4 py-2">
                                    Role
                                </th>

                                <th class="border px-4 py-2">
                                    Created At
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-50">

                                <td class="border px-4 py-2">{{ user.id }}</td>

                                <td class="border px-4 py-2">{{ user.name }}</td>

                                <td class="border px-4 py-2">{{ user.email }}</td>

                                <td class="border px-4 py-2 text-center">


                                    <span v-if="user.role === 'admin'"
                                        class="px-3 py-1 rounded-full text-sm bg-purple-100 text-purple-700 font-semibold">
                                        Admin
                                    </span>


                                    <span v-else
                                        class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-700 font-semibold">
                                        User
                                    </span>


                                </td>

                                <td class="border px-4 py-2">
                                    {{ new Date(user.created_at).toLocaleDateString() }}
                                </td>

                            </tr>

                            <tr v-if="users.data.length === 0">

                                <td colspan="5" class="text-center py-6">
                                    No users found.
                                </td>

                            </tr>

                        </tbody>

                    </table>

                    <!-- Pagination -->

                    <div class="flex justify-center gap-2 mt-6">

                        <Link v-for="link in users.links" :key="link.label" :href="link.url || '#'" v-html="link.label"
                            class="px-4 py-2 border rounded" :class="{
                                'bg-indigo-600 text-white': link.active,
                                'pointer-events-none opacity-50': !link.url
                            }" />

                    </div>

                </div>

            </div>
        </div>

    </AuthenticatedLayout>

</template>