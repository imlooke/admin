const mix = require("laravel-mix");

mix.browserSync({
  proxy: "localhost:8080/admin",
  files: ["resources/less/**/*", "resources/js/**/*"],
});

mix
  .less("resources/less/app.less", "resources/assets", {
    lessOptions: { javascriptEnabled: true },
  })
  .js("resources/js/app.js", "resources/assets")
  .react();
