// Static (non-variable) font files. The variable Montserrat from Google Fonts
// has overlapping contours, and -webkit-text-stroke on the outlined headings
// draws every one of them. Latin subset only; Vite copies the woff2 into dist.
import '@fontsource/montserrat/latin-400.css'
import '@fontsource/montserrat/latin-500.css'
import '@fontsource/montserrat/latin-600.css'
import '@fontsource/montserrat/latin-700.css'
import '@fontsource/jetbrains-mono/latin-400.css'
import '@fontsource/jetbrains-mono/latin-500.css'

import '../scss/main.scss'

// Only the Bootstrap plugins the theme uses. Importing 'bootstrap' whole
// would pull in carousel, modal, tooltip and the rest for nothing.
import 'bootstrap/js/dist/collapse'
import 'bootstrap/js/dist/dropdown'

import { mountIslands } from './islands'

mountIslands()
