<template>
  <AppLayout>
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Notifications</h1>
        <button v-if="unread_count > 0" @click="markAllAsRead"
          class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">
          Mark all as read
        </button>
      </div>

      <div class="space-y-2">
        <div v-for="n in notifications.data" :key="n.id"
          class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4 flex items-start justify-between gap-4"
          :class="{ 'border-l-4 border-l-blue-500': !n.read_at }">
          <div class="flex-1 min-w-0">
            <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ n.data.title || n.data.message || 'Notification' }}</h3>
            <p v-if="n.data.message" class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ n.data.message }}</p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ timeAgo(n.created_at) }}</p>
          </div>
          <button v-if="!n.read_at" @click="markAsRead(n.id)"
            class="text-xs text-blue-600 hover:text-blue-700 dark:text-blue-400 whitespace-nowrap shrink-0">
            Mark read
          </button>
        </div>

        <div v-if="!notifications.data.length" class="text-center py-12 text-gray-500 dark:text-gray-400 text-sm">
          No notifications yet.
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  notifications: { type: Object, required: true },
  unread_count: { type: Number, required: true },
})

function timeAgo(date) {
  const diff = Date.now() - new Date(date).getTime()
  const mins = Math.floor(diff / 60000)
  if (mins < 1) return 'just now'
  if (mins < 60) return mins + 'm ago'
  const hrs = Math.floor(mins / 60)
  if (hrs < 24) return hrs + 'h ago'
  const days = Math.floor(hrs / 24)
  return days + 'd ago'
}

function markAsRead(id) {
  router.post(route('notifications.read', id))
}

function markAllAsRead() {
  router.post(route('notifications.read-all'))
}
</script>
