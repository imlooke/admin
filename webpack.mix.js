const mix = require("laravel-mix");

mix
  .less("resources/less/app.less", "resources/assets", {
    lessOptions: { javascriptEnabled: true },
  })
  .js("resources/js/app.js", "resources/assets")
  .react();
