<template>
  <div class="min-h-screen bg-gray-50 dark:bg-gray-950">
    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 transform -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-in-out"
      :class="{ 'translate-x-0': sidebarOpen }">
      <div class="flex items-center h-16 px-6 border-b border-gray-200 dark:border-gray-800">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">HRIS</h1>
      </div>
      <nav class="p-4 space-y-1 overflow-y-auto" style="height: calc(100vh - 4rem);">
        <a v-for="item in navigation" :key="item.name"
          :href="item.href"
          class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors"
          :class="isCurrent(item.href)
            ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300'
            : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800'">
          <component :is="item.icon" class="w-5 h-5" />
          {{ item.name }}
        </a>
      </nav>
    </aside>

    <!-- Overlay -->
    <div v-if="sidebarOpen" class="fixed inset-0 z-40 bg-black/50 lg:hidden" @click="sidebarOpen = false" />

    <!-- Main -->
    <div class="lg:pl-64">
      <!-- Header -->
      <header class="sticky top-0 z-30 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
        <div class="flex items-center justify-between h-16 px-4 sm:px-6">
          <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>

          <div class="flex-1" />

          <div class="flex items-center gap-4">
            <button @click="toggleDark" class="p-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
              <svg v-if="isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
              </svg>
              <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
              </svg>
            </button>

            <div class="relative" v-click-outside="() => profileOpen = false">
              <button @click="profileOpen = !profileOpen" class="flex items-center gap-2 p-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">
                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                  {{ auth.user.name.charAt(0).toUpperCase() }}
                </div>
                <span class="hidden sm:block">{{ auth.user.name }}</span>
              </button>

              <div v-if="profileOpen" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg shadow-lg py-1">
                <a href="/auth/profile" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Profile</a>
                <a href="/settings" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Settings</a>
                <hr class="my-1 border-gray-200 dark:border-gray-800" />
                <a href="/logout" method="post" as="button" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-800">Logout</a>
              </div>
            </div>
          </div>
        </div>
      </header>

      <!-- Page Content -->
      <main class="p-4 sm:p-6 lg:p-8">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3'
import {
  HomeIcon,
  UsersIcon,
  BuildingOfficeIcon,
  BriefcaseIcon,
  ClockIcon,
  CalendarDaysIcon,
  CurrencyDollarIcon,
  UserGroupIcon,
  StarIcon,
  MegaphoneIcon,
  BellIcon,
  Cog6ToothIcon,
  DocumentTextIcon,
  ChartBarIcon,
} from '@heroicons/vue/24/outline'

const page = usePage()
const auth = computed(() => page.props.auth || { user: {} })
const sidebarOpen = ref(false)
const profileOpen = ref(false)
const isDark = ref(false)

const navigation = [
  { name: 'Dashboard', href: '/dashboard', icon: HomeIcon },
  { name: 'Employees', href: '/employees', icon: UsersIcon },
  { name: 'Departments', href: '/departments', icon: BuildingOfficeIcon },
  { name: 'Positions', href: '/positions', icon: BriefcaseIcon },
  { name: 'Attendance', href: '/attendance', icon: ClockIcon },
  { name: 'Leave', href: '/leave', icon: CalendarDaysIcon },
  { name: 'Payroll', href: '/payroll', icon: CurrencyDollarIcon },
  { name: 'Recruitment', href: '/recruitment', icon: UserGroupIcon },
  { name: 'Performance', href: '/performance', icon: StarIcon },
  { name: 'Announcements', href: '/announcements', icon: MegaphoneIcon },
  { name: 'Reports', href: '/reports', icon: DocumentTextIcon },
  { name: 'Analytics', href: '/analytics', icon: ChartBarIcon },
  { name: 'Notifications', href: '/notifications', icon: BellIcon },
  { name: 'Settings', href: '/settings', icon: Cog6ToothIcon },
]

function isCurrent(href) {
  if (typeof window === 'undefined') return false
  return window.location.pathname.startsWith(href)
}

function toggleDark() {
  isDark.value = !isDark.value
  document.documentElement.classList.toggle('dark', isDark.value)
  localStorage.setItem('theme', isDark.value ? 'dark' : 'light')
}

onMounted(() => {
  const theme = localStorage.getItem('theme')
  isDark.value = theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)
  document.documentElement.classList.toggle('dark', isDark.value)
})
</script>
