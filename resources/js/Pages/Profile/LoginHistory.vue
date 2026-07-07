<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';


const props = defineProps({

    activities: Object,
    isAdmin: Boolean

});


</script>


<template>

    <Head title="Login History" />


    <AuthenticatedLayout>


        <template #header>

            <h2 class="text-xl font-semibold text-gray-800">
                Login Activity History
            </h2>

        </template>



        <div class="py-10">


            <div class="max-w-7xl mx-auto px-6 lg:px-8">



                <!-- Header Card -->

                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-xl p-8 text-white mb-8">


                    <div class="flex flex-col md:flex-row justify-between items-center">


                        <div>

                            <h1 class="text-3xl font-bold">

                                Security Activity

                            </h1>


                            <p class="mt-2 text-indigo-100">

                                Monitor your recent login sessions and account security

                            </p>

                        </div>



                        <div class="mt-5 md:mt-0 bg-white/20 rounded-xl px-6 py-4 backdrop-blur">


                            <p class="text-sm">
                                Total Logins
                            </p>


                            <h2 class="text-3xl font-bold">

                                {{ activities.length }}

                            </h2>


                        </div>



                    </div>


                </div>





                <!-- Login Table -->


                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">


                    <div class="p-6 border-b">


                        <h2 class="text-xl font-bold text-gray-800">

                            Recent Login Activity

                        </h2>


                        <p class="text-gray-500 text-sm mt-1">
                            Monitor user login sessions, devices, and security activity
                        </p>


                    </div>





                    <div class="overflow-x-auto">



                        <table class="w-full text-left">


                            <thead class="bg-gray-100">


                                <tr>


                                    <th class="px-6 py-4 text-gray-600 font-semibold">

                                        #

                                    </th>

                                    <th v-if="isAdmin" class="px-6 py-4 text-gray-600 font-semibold">
                                        User
                                    </th>

                                    <th class="px-6 py-4 text-gray-600 font-semibold">

                                        IP Address

                                    </th>


                                    <th class="px-6 py-4 text-gray-600 font-semibold">

                                        Browser

                                    </th>


                                    <th class="px-6 py-4 text-gray-600 font-semibold">

                                        Device

                                    </th>


                                    <th class="px-6 py-4 text-gray-600 font-semibold">

                                        Login Time

                                    </th>


                                </tr>


                            </thead>




                            <tbody>


                                <tr v-for="(item, index) in activities" :key="item.id"
                                    class="border-b hover:bg-indigo-50 transition">



                                    <td class="px-6 py-4 font-semibold text-gray-700">

                                        {{ index + 1 }}

                                    </td>

                                    <td v-if="isAdmin" class="px-6 py-4">

                                        <div class="flex items-center gap-3">


                                            <div
                                                class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">

                                                👤

                                            </div>


                                            <div>

                                                <p class="font-semibold text-gray-800">

                                                    {{ item.user?.name }}

                                                </p>


                                                <p class="text-xs text-gray-500">

                                                    {{ item.user?.email }}

                                                </p>


                                            </div>


                                        </div>

                                    </td>


                                    <td class="px-6 py-4">


                                        <div class="flex items-center gap-2">


                                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">

                                                {{ item.ip_address }}

                                            </span>


                                        </div>


                                    </td>




                                    <td class="px-6 py-4">


                                        <div class="flex items-center gap-3">


                                            <div
                                                class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">


                                                🌐


                                            </div>


                                            <div>


                                                <p class="font-medium text-gray-800">

                                                    {{ item.browser }}

                                                </p>


                                                <p class="text-xs text-gray-500">

                                                    Browser Session

                                                </p>


                                            </div>


                                        </div>


                                    </td>





                                    <td class="px-6 py-4">


                                        <div class="flex items-center gap-3">


                                            <div
                                                class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">


                                                💻


                                            </div>


                                            <p class="text-gray-700">

                                                {{ item.device }}

                                            </p>


                                        </div>


                                    </td>





                                    <td class="px-6 py-4">


                                        <span class="bg-purple-100 text-purple-700 px-4 py-2 rounded-lg text-sm">


                                            {{ item.login_time }}


                                        </span>


                                    </td>




                                </tr>




                                <!-- Empty State -->


                                <tr v-if="activities.length === 0">


                                    <td :colspan="isAdmin ? 6 : 5" class="text-center py-12">


                                        <div class="text-5xl mb-3">

                                            🔒

                                        </div>


                                        <h3 class="text-lg font-semibold text-gray-700">

                                            No Login Activity Found

                                        </h3>


                                        <p class="text-gray-500">

                                            Your login history will appear here.

                                        </p>


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