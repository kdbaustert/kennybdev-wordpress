<script setup>
import { computed, ref } from 'vue'
import { filterProjects } from '../js/filter-projects'

// Props arrive from PHP via data-props (template-parts/front/projects.php).
const props = defineProps({
  projects: { type: Array, required: true },
  techColors: { type: Object, default: () => ({}) },
})

const selected = ref([])
const query = ref('')

// Chips ordered by how many projects use them, so the useful ones lead.
const tags = computed(() => {
  const counts = new Map()
  for (const project of props.projects) {
    for (const tag of project.tags) counts.set(tag, (counts.get(tag) ?? 0) + 1)
  }
  return [...counts.entries()]
    .sort((a, b) => b[1] - a[1] || a[0].localeCompare(b[0]))
    .map(([tag]) => tag)
})

const visible = computed(() =>
  filterProjects(props.projects, selected.value, query.value)
)

const isFiltering = computed(
  () => selected.value.length > 0 || query.value.trim() !== ''
)

function toggle(tag) {
  selected.value = selected.value.includes(tag)
    ? selected.value.filter(t => t !== tag)
    : [...selected.value, tag]
}

function reset() {
  selected.value = []
  query.value = ''
}

function chipStyle(tag) {
  const color = props.techColors[tag]
  return color ? { '--chip': color } : null
}

// Keep each project's number from the full list, so "07" stays 07 when filtered.
const numberOf = project =>
  String(props.projects.indexOf(project) + 1).padStart(2, '0')
</script>

<template>
  <div class="project-filter">
    <div class="project-filter__controls">
      <ul class="chip-list" aria-label="Filter by technology">
        <li v-for="tag in tags" :key="tag">
          <button
            type="button"
            class="chip"
            :style="chipStyle(tag)"
            :aria-pressed="selected.includes(tag)"
            @click="toggle(tag)"
          >
            {{ tag }}
          </button>
        </li>
      </ul>

      <input
        v-model="query"
        type="search"
        class="form-control"
        placeholder="Search projects"
        aria-label="Search projects"
      />
    </div>

    <p class="project-filter__count" aria-live="polite">
      Showing {{ visible.length }} of {{ projects.length }}
    </p>

    <ol v-if="visible.length" class="project-index">
      <li v-for="project in visible" :key="project.id" class="project-row">
        <span class="project-row__num">{{ numberOf(project) }}</span>
        <div>
          <h3 class="project-row__title">
            <a :href="project.link">{{ project.title }}</a>
          </h3>
          <span class="project-row__domain">{{ project.domain }}</span>
        </div>
        <ul class="chip-list project-row__tags">
          <li v-for="tag in project.tags" :key="tag">
            <span class="chip" :style="chipStyle(tag)">{{ tag }}</span>
          </li>
        </ul>
      </li>
    </ol>

    <div v-else class="project-empty">
      <p>No projects match those filters.</p>
      <button type="button" class="btn btn-outline-light" @click="reset">
        Clear filters
      </button>
    </div>

    <button
      v-if="isFiltering && visible.length"
      type="button"
      class="btn btn-link px-0 mt-3"
      @click="reset"
    >
      Clear filters
    </button>
  </div>
</template>
