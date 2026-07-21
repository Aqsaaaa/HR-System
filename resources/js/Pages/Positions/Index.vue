<template>
  <AppLayout>
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Positions</h1>
        <button @click="showCreate = true"
          class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
          + Add Position
        </button>
      </div>

      <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
        <table class="w-full text-sm">
          <thead class="bg-gray-50 dark:bg-gray-800/50">
            <tr>
              <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Title</th>
              <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Code</th>
              <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Department</th>
              <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Type</th>
              <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Headcount</th>
              <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</th>
              <th class="text-right px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
            <tr v-for="pos in positions.data" :key="pos.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/30">
              <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ pos.title }}</td>
              <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ pos.code || '-' }}</td>
              <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ pos.department?.name || '-' }}</td>
              <td class="px-4 py-3 text-gray-600 dark:text-gray-400 capitalize">{{ pos.employment_type || '-' }}</td>
              <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ pos.current_headcount || 0 }} / {{ pos.max_headcount || '∞' }}</td>
              <td class="px-4 py-3">
                <span class="px-2 py-0.5 text-xs rounded-full"
                  :class="pos.is_active ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400'">
                  {{ pos.is_active ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td class="px-4 py-3 text-right">
                <button @click="edit(pos)" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 text-xs mr-2">Edit</button>
                <button @click="confirmDelete(pos)" class="text-red-600 hover:text-red-700 dark:text-red-400 text-xs">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
        <div v-if="!positions.data.length" class="text-center py-12 text-sm text-gray-500 dark:text-gray-400">
          No positions yet.
        </div>
      </div>

      <!-- Create/Edit Modal -->
      <div v-if="showCreate || editing" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.self="closeModal">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 w-full max-w-lg mx-4">
          <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ editing ? 'Edit Position' : 'New Position' }}</h2>
          <form @submit.prevent="submit" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title *</label>
                <input v-model="form.title" type="text" required
                  class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Code</label>
                <input v-model="form.code" type="text"
                  class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm" />
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department</label>
                <select v-model="form.department_id"
                  class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm">
                  <option :value="null">None</option>
                  <option v-for="d in departments" :key="d.id" :value="d.id">{{ d.name }}</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Employment Type</label>
                <select v-model="form.employment_type"
                  class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm">
                  <option value="">Select...</option>
                  <option value="full-time">Full Time</option>
                  <option value="part-time">Part Time</option>
                  <option value="contract">Contract</option>
                  <option value="internship">Internship</option>
                </select>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Max Headcount</label>
                <input v-model="form.max_headcount" type="number" min="0"
                  class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm" />
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
              <textarea v-model="form.description" rows="3"
                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm"></textarea>
            </div>
            <div class="flex items-center gap-2">
              <input v-model="form.is_active" type="checkbox" id="is_active" class="rounded border-gray-300 dark:border-gray-700" />
              <label for="is_active" class="text-sm text-gray-700 dark:text-gray-300">Active</label>
            </div>
            <div class="flex justify-end gap-3 pt-2">
              <button type="button" @click="closeModal" class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Cancel</button>
              <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">{{ editing ? 'Update' : 'Create' }}</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Delete Confirmation -->
      <div v-if="deleting" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.self="deleting = null">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 w-full max-w-sm mx-4">
          <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Delete Position?</h2>
          <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Are you sure you want to delete <strong>{{ deleting.title }}</strong>?</p>
          <div class="flex justify-end gap-3">
            <button @click="deleting = null" class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Cancel</button>
            <button @click="destroy" class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  positions: { type: Object, required: true },
  departments: { type: Array, default: () => [] },
})

const showCreate = ref(false)
const editing = ref(null)
const deleting = ref(null)

const form = reactive({
  title: '',
  code: '',
  description: '',
  department_id: null,
  employment_type: '',
  max_headcount: null,
  is_active: true,
})

function resetForm() {
  form.title = ''
  form.code = ''
  form.description = ''
  form.department_id = null
  form.employment_type = ''
  form.max_headcount = null
  form.is_active = true
}

function edit(pos) {
  editing.value = pos
  form.title = pos.title
  form.code = pos.code || ''
  form.description = pos.description || ''
  form.department_id = pos.department_id
  form.employment_type = pos.employment_type || ''
  form.max_headcount = pos.max_headcount
  form.is_active = pos.is_active
}

function closeModal() {
  showCreate.value = false
  editing.value = null
  resetForm()
}

function submit() {
  const routeName = editing.value ? 'positions.update' : 'positions.store'
  const params = editing.value ? { id: editing.value.id } : {}
  router.post(route(routeName, params), { ...form }, {
    onSuccess: () => closeModal(),
  })
}

function confirmDelete(pos) {
  deleting.value = pos
}

function destroy() {
  router.delete(route('positions.destroy', { id: deleting.value.id }), {
    onSuccess: () => deleting.value = null,
  })
}
</script>
