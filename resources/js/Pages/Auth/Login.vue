<template>
  <GuestLayout>
    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Sign in to your account</h2>

    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
        <input id="email" v-model="form.email" type="email" required autofocus
          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors"
          placeholder="name@company.com" />
        <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email }}</p>
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
        <input id="password" v-model="form.password" type="password" required
          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors"
          placeholder="Enter your password" />
        <p v-if="errors.password" class="mt-1 text-sm text-red-600">{{ errors.password }}</p>
      </div>

      <div class="flex items-center justify-between">
        <label class="flex items-center gap-2">
          <input type="checkbox" v-model="form.remember" class="rounded border-gray-300 dark:border-gray-700 text-blue-600 focus:ring-blue-500" />
          <span class="text-sm text-gray-600 dark:text-gray-400">Remember me</span>
        </label>
        <a href="/forgot-password" class="text-sm text-blue-600 hover:text-blue-500">Forgot password?</a>
      </div>

      <button type="submit" :disabled="processing"
        class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
        <span v-if="processing">Signing in...</span>
        <span v-else>Sign in</span>
      </button>
    </form>

    <p v-if="error" class="mt-4 text-sm text-red-600 text-center">{{ error }}</p>
  </GuestLayout>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'

const props = defineProps({
  errors: { type: Object, default: () => ({}) },
  error: { type: String, default: '' },
})

const processing = ref(false)
const form = reactive({
  email: '',
  password: '',
  remember: false,
})

function submit() {
  processing.value = true
  router.post('/login', form, {
    preserveState: true,
    onFinish: () => { processing.value = false },
  })
}
</script>
