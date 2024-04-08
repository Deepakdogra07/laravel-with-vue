<script setup>
defineProps({ userProfile: Array })
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <div class="min-h-screen flex items-center justify-center p-6 sm:p-12">
    <div class="bg-white w-full max-w-md p-8 rounded shadow-md">




      <Link href="/user/editProfile" class="text-blue-500 mb-6 inline-block">Edit Profile</Link>






      <h1 class="text-2xl font-semibold mb-4 text-gray-700">Profile:</h1>

      <div class="mb-4">
        <label class="block text-gray-600 font-bold">Name:</label>
        <span class="text-gray-800">{{ userProfile.name }}</span>
      </div>

      <div class="mb-4">
        <label class="block text-gray-600 font-bold">Email:</label>
        <span class="text-gray-800">{{ userProfile.email }}</span>
      </div>

      <div class="mb-4">
        <label class="block text-gray-600 font-bold">Address:</label>
        <span class="text-gray-800">{{ userProfile.address }}</span>
      </div>

      <div class="mb-4">
        <label class="block text-gray-600 font-bold">Phone:</label>
        <span class="text-gray-800">{{ userProfile.phone }}</span>
      </div>
    </div>
  </div>
</template>

<style>
/* You can add additional custom styles here */
</style>
