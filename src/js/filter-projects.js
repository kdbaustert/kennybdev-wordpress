// Pure filtering logic for the project index, kept out of the component so
// it can be read (and tested) without mounting Vue.

function normalize(text) {
  return text.toLowerCase().normalize('NFD').replace(/\p{Diacritic}/gu, '')
}

function matchesQuery(project, query) {
  const needle = normalize(query.trim())
  if (!needle) return true

  const haystack = normalize(
    [project.title, project.domain, project.summary, ...project.tags].join(' ')
  )
  return haystack.includes(needle)
}

/**
 * Does this project pass the selected tech chips?
 *
 * @param {string[]} projectTags  e.g. ['PHP', 'ACF', 'Custom WordPress']
 * @param {string[]} selectedTags the chips currently pressed; [] means none
 * @returns {boolean}
 */
function matchesTags(projectTags, selectedTags) {
  // TODO(kenny): decide what pressing more than one chip means.
  return true
}

export function filterProjects(projects, selectedTags, query) {
  return projects.filter(
    project =>
      matchesTags(project.tags, selectedTags) && matchesQuery(project, query)
  )
}
