import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// WordPress enqueues dist/theme.js and dist/theme.css by fixed name
// (inc/assets.php), so there is no manifest to read and no hash in the
// filename. Cache busting comes from filemtime() on the PHP side instead.
export default defineConfig(({ mode }) => ({
  plugins: [vue()],
  base: './',
  build: {
    outDir: 'dist',
    emptyOutDir: true,
    sourcemap: mode === 'development',
    minify: mode !== 'development',
    rolldownOptions: {
      input: { theme: 'src/js/main.js' },
      output: {
        entryFileNames: '[name].js',
        chunkFileNames: '[name].js',
        assetFileNames: '[name][extname]',
      },
    },
  },
  css: {
    preprocessorOptions: {
      scss: {
        // Bootstrap 5.3 is still written with @import and global functions,
        // which current Dart Sass flags on every build. These are warnings
        // about Bootstrap's source, not ours, so they are silenced here
        // rather than drowning out real errors.
        quietDeps: true,
        silenceDeprecations: [
          'import',
          'global-builtin',
          'color-functions',
          'if-function',
        ],
      },
    },
  },
}))
