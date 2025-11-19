// vite.config.js
import { defineConfig } from "file:///C:/Laravel/sistem-informasi-masjid-uika/node_modules/vite/dist/node/index.js";
import laravel from "file:///C:/Laravel/sistem-informasi-masjid-uika/node_modules/laravel-vite-plugin/dist/index.mjs";
import "file:///C:/Laravel/sistem-informasi-masjid-uika/node_modules/tinymce/tinymce.js";
import "file:///C:/Laravel/sistem-informasi-masjid-uika/node_modules/tinymce/themes/silver/index.js";
import "file:///C:/Laravel/sistem-informasi-masjid-uika/node_modules/tinymce/plugins/advlist/index.js";
import "file:///C:/Laravel/sistem-informasi-masjid-uika/node_modules/tinymce/plugins/link/index.js";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/sass/app.scss",
        "resources/js/app.js"
      ],
      refresh: true
    })
  ]
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFxMYXJhdmVsXFxcXHNpc3RlbS1pbmZvcm1hc2ktbWFzamlkLXVpa2FcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIkM6XFxcXExhcmF2ZWxcXFxcc2lzdGVtLWluZm9ybWFzaS1tYXNqaWQtdWlrYVxcXFx2aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vQzovTGFyYXZlbC9zaXN0ZW0taW5mb3JtYXNpLW1hc2ppZC11aWthL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSc7XG5pbXBvcnQgbGFyYXZlbCBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcbmltcG9ydCAndGlueW1jZS90aW55bWNlJztcbmltcG9ydCAndGlueW1jZS90aGVtZXMvc2lsdmVyJztcbmltcG9ydCAndGlueW1jZS9wbHVnaW5zL2Fkdmxpc3QnO1xuaW1wb3J0ICd0aW55bWNlL3BsdWdpbnMvbGluayc7XG5cbmV4cG9ydCBkZWZhdWx0IGRlZmluZUNvbmZpZyh7XG4gICAgcGx1Z2luczogW1xuICAgICAgICBsYXJhdmVsKHtcbiAgICAgICAgICAgIGlucHV0OiBbXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9zYXNzL2FwcC5zY3NzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2pzL2FwcC5qcycsXG4gICAgICAgICAgICBdLFxuICAgICAgICAgICAgcmVmcmVzaDogdHJ1ZSxcbiAgICAgICAgfSksXG4gICAgXSxcbn0pO1xuIl0sCiAgIm1hcHBpbmdzIjogIjtBQUE2UyxTQUFTLG9CQUFvQjtBQUMxVSxPQUFPLGFBQWE7QUFDcEIsT0FBTztBQUNQLE9BQU87QUFDUCxPQUFPO0FBQ1AsT0FBTztBQUVQLElBQU8sc0JBQVEsYUFBYTtBQUFBLEVBQ3hCLFNBQVM7QUFBQSxJQUNMLFFBQVE7QUFBQSxNQUNKLE9BQU87QUFBQSxRQUNIO0FBQUEsUUFDQTtBQUFBLE1BQ0o7QUFBQSxNQUNBLFNBQVM7QUFBQSxJQUNiLENBQUM7QUFBQSxFQUNMO0FBQ0osQ0FBQzsiLAogICJuYW1lcyI6IFtdCn0K
