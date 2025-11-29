<script setup lang="ts">
const props = defineProps<{
  categories: string
  groupName: string[] // e.g., ['All', 'Milks & Dairies', ...]
  selectedGroup: string // The currently selected group name from App.vue
}>()

const emit = defineEmits(['update-group'])

const selectGroup = (group: string) => {
  emit('update-group', group)
}
</script>

<template>
  <div class="flex flex-row justify-between items-center">
    <div class="text-3xl font-bold mt-10 mb-5 ml-5">{{ categories }}</div>
  </div>

  <div>
    <div class="text-lg font-bold text-center text-body">
      <ul class="flex flex-wrap -mb-px">
        <li class="mr-2" v-for="group in props.groupName" :key="group">
          <a
            href="#"
            @click.prevent="selectGroup(group)"
            :class="{
              // 3. Apply the active/highlighted styles if this group is currently selected
              'text-gray-600 border-b-2 border-b-green-600': group === props.selectedGroup,
              'text-gray-500 hover:text-green-600 hover:border-green-600':
                group !== props.selectedGroup,
            }"
            class="inline-block p-4 rounded-t-lg border-b-2 border-transparent transition-colors duration-150"
          >
            {{ group }}
          </a>
        </li>
      </ul>
    </div>
  </div>
</template>
