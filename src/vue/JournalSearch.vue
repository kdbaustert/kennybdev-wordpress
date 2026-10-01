<script setup>
import { onBeforeUnmount, ref, watch } from 'vue'

// endpoint is rest_url('wp/v2/posts') from PHP. With plain permalinks that is
// "/?rest_route=/wp/v2/posts", so params are added through URL, never by
// string concatenation.
const props = defineProps({
  endpoint: { type: String, required: true },
  perPage: { type: Number, default: 6 },
})

const query = ref('')
const results = ref([])
const status = ref('idle') // idle | loading | done | error

let timer = null
let controller = null

// WordPress returns titles and excerpts as HTML. Parsing to text avoids
// v-html, so nothing in a post can inject markup into this widget.
function toText(html) {
  return new DOMParser()
    .parseFromString(html, 'text/html')
    .body.textContent.trim()
}

async function search(term) {
  controller?.abort()
  controller = new AbortController()
  status.value = 'loading'

  const url = new URL(props.endpoint, window.location.origin)
  url.searchParams.set('search', term)
  url.searchParams.set('per_page', String(props.perPage))
  url.searchParams.set('_fields', 'id,link,title,excerpt')

  try {
    const response = await fetch(url, { signal: controller.signal })
    if (!response.ok) throw new Error(`HTTP ${response.status}`)

    const posts = await response.json()
    results.value = posts.map(post => ({
      id: post.id,
      link: post.link,
      title: toText(post.title.rendered),
      excerpt: toText(post.excerpt.rendered),
    }))
    status.value = 'done'
  } catch (error) {
    if (error.name === 'AbortError') return
    console.error('[theme] journal search failed', error)
    status.value = 'error'
  }
}

watch(query, value => {
  clearTimeout(timer)
  const term = value.trim()

  if (term.length < 2) {
    controller?.abort()
    results.value = []
    status.value = 'idle'
    return
  }

  timer = setTimeout(() => search(term), 250)
})

onBeforeUnmount(() => {
  clearTimeout(timer)
  controller?.abort()
})
</script>

<template>
  <div class="journal-search" role="search">
    <label class="visually-hidden" for="journal-search-input">
      Search the journal
    </label>
    <input
      id="journal-search-input"
      v-model="query"
      type="search"
      class="form-control form-control-lg"
      placeholder="Search the journal"
      autocomplete="off"
    />

    <p class="journal-search__status" aria-live="polite">
      <template v-if="status === 'loading'">Searching…</template>
      <template v-else-if="status === 'error'">
        Search is unavailable right now. The posts below are still browsable.
      </template>
      <template v-else-if="status === 'done' && !results.length">
        Nothing matches "{{ query.trim() }}". Try a shorter word.
      </template>
    </p>

    <ul v-if="results.length" class="journal-search__results">
      <li v-for="post in results" :key="post.id">
        <a :href="post.link">
          <strong>{{ post.title }}</strong>
          <span>{{ post.excerpt }}</span>
        </a>
      </li>
    </ul>
  </div>
</template>
