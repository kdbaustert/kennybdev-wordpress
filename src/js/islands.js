import { createApp } from 'vue'
import ProjectFilter from '../vue/ProjectFilter.vue'
import JournalSearch from '../vue/JournalSearch.vue'

// PHP renders <div data-vue="project-filter" data-props='{...}'> and the
// page stays server-rendered everywhere else. Each island is its own small
// Vue app, so a broken one cannot take the rest of the page down with it.
const registry = {
  'project-filter': ProjectFilter,
  'journal-search': JournalSearch,
}

export function mountIslands(root = document) {
  root.querySelectorAll('[data-vue]').forEach(el => {
    const component = registry[el.dataset.vue]
    if (!component) {
      console.warn(`[theme] no Vue island registered as "${el.dataset.vue}"`)
      return
    }

    let props = {}
    try {
      props = el.dataset.props ? JSON.parse(el.dataset.props) : {}
    } catch (error) {
      console.error(`[theme] bad data-props on "${el.dataset.vue}"`, error)
      return
    }

    createApp(component, props).mount(el)
  })
}
