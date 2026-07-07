<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/vue3';


</script>


<template>


<Head title="Admin Dashboard"/>


<AuthenticatedLayout>


<template #header>

<h2 class="text-xl font-semibold text-gray-800">

Admin Dashboard

</h2>

</template>



<div class="py-10">


<div class="max-w-7xl mx-auto px-6 lg:px-8">



<!-- Welcome Banner -->


<div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-2xl shadow-xl p-8 text-white mb-8">


<h1 class="text-4xl font-bold">

Welcome Admin 👋

</h1>


<p class="mt-3 text-indigo-100 text-lg">

Manage your application, users and security settings from here.

</p>


</div>





<!-- Statistics Cards -->


<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">



<div class="bg-white rounded-2xl shadow p-6 border-l-4 border-indigo-500">


<p class="text-gray-500">

Role

</p>


<h2 class="text-3xl font-bold text-indigo-600">

Administrator

</h2>


</div>




<div class="bg-white rounded-2xl shadow p-6 border-l-4 border-green-500">


<p class="text-gray-500">

Authentication

</p>


<h2 class="text-3xl font-bold text-green-600">

Secure

</h2>


</div>




<div class="bg-white rounded-2xl shadow p-6 border-l-4 border-purple-500">


<p class="text-gray-500">

Access Level

</p>


<h2 class="text-3xl font-bold text-purple-600">

Full Access

</h2>


</div>



</div>






<!-- Quick Actions -->


<div class="grid md:grid-cols-2 gap-6">



<div class="bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold mb-5">

⚡ Quick Actions

</h2>



<div class="space-y-4">


<Link
href="/users"
class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl transition"
>

Manage Users

</Link>



<Link
href="/login-history"
class="block text-center bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-xl transition"
>

View Login Activity

</Link>



<Link
href="/profile"
class="block text-center bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl transition"
>

Update Profile

</Link>


</div>


</div>







<div class="bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold mb-5">

🔐 Security Features

</h2>


<ul class="space-y-3 text-gray-700">


<li>
✅ Role Based Access Control
</li>


<li>
✅ Admin Middleware Protection
</li>


<li>
✅ Login Activity Tracking
</li>


<li>
✅ Laravel 12 Authentication
</li>


<li>
✅ Vue 3 + Inertia SPA
</li>


</ul>


</div>


</div>





</div>


</div>


</AuthenticatedLayout>


</template>