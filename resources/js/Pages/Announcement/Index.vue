<template>
  <AppLayout>
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Announcements</h1>
        <button @click="showCreate = true"
          class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
          <PlusIcon class="w-4 h-4" />
          New Announcement
        </button>
      </div>

      <div class="space-y-4">
        <div v-for="item in announcements.data" :key="item.id"
          class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
          <div class="flex items-start justify-between gap-4">
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-2 mb-1">
                <span v-if="item.is_pinned" class="text-xs text-yellow-500">
                  <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zm-5 5a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm-1 4a1 1 0 100 2h8a1 1 0 100-2H5z"/></svg>
                </span>
                <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full" :class="typeClass(item.type)">
                  {{ item.type }}
                </span>
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ item.title }}</h3>
              </div>
              <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ item.content }}</p>
              <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">{{ item.created_by_name }} &middot; {{ item.created_at }}</p>
            </div>
            <button @click="togglePin(item)" class="text-xs text-gray-400 hover:text-yellow-500 shrink-0" title="Pin">
              <svg class="w-4 h-4" :class="{ 'text-yellow-500': item.is_pinned }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
            </button>
          </div>
        </div>
        <div v-if="!announcements.data?.length"
          class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-8 text-center text-gray-500 dark:text-gray-400">
          No announcements
        </div>
      </div>

      <!-- Create Modal -->
      <div v-if="showCreate" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.self="showCreate = false">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-xl border border-gray-200 dark:border-gray-800 w-full max-w-lg mx-4 p-6">
          <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">New Announcement</h3>
          <form @submit.prevent="createAnnouncement" class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
              <input v-model="form.title" required
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
              <select v-model="form.type"
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                <option value="info">Info</option>
                <option value="warning">Warning</option>
                <option value="urgent">Urgent</option>
                <option value="achievement">Achievement</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Content</label>
              <textarea v-model="form.content" rows="4" required
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white"></textarea>
            </div>
            <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
              <input v-model="form.is_published" type="checkbox" class="rounded border-gray-300 dark:border-gray-700" />
              Publish immediately
            </label>
            <div class="flex justify-end gap-3 mt-6">
              <button type="button" @click="showCreate = false"
                class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">Cancel</button>
              <button type="submit" :disabled="creating"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors disabled:opacity-50">
                {{ creating ? 'Creating...' : 'Create' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { PlusIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  announcements: { type: Object, default: () => ({ data: [] }) },
})

const showCreate = ref(false)
const creating = ref(false)
const form = ref({ title: '', content: '', type: 'info', is_published: false })

function typeClass(type) {
  const map = {
    info: 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
    warning: 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400',
    urgent: 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
    achievement: 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
  }
  return map[type] || 'bg-gray-100 text-gray-700'
}

function createAnnouncement() {
  creating.value = true
  fetch(route('api.announcements.store'), {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
    credentials: 'include',
    body: JSON.stringify(form.value),
  }).then(() => {
    showCreate.value = false
    form.value = { title: '', content: '', type: 'info', is_published: false }
    router.reload({ preserveScroll: true })
  }).finally(() => { creating.value = false })
}

function togglePin(announcement) {
  fetch(route('api.announcements.pin', announcement.id), {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
    credentials: 'include',
  }).then(() => {
    router.reload({ preserveScroll: true })
  })
}
</script>
