const mix = require("laravel-mix");
const webpack = require("webpack");

mix.webpackConfig({
  plugins: [
    // load `moment/locale/zh-cn.js`
    new webpack.ContextReplacementPlugin(/moment[/\\]locale$/, /zh-cn/),
  ],
});

mix.browserSync({
  proxy: "localhost:8080/admin",
  files: ["resources/less/**/*", "resources/scss/**/*", "resources/js/**/*"],
});

mix.less("resources/less/app.less", "dist/css", {
  lessOptions: {
    javascriptEnabled: true,
  },
});

mix.js("resources/js/app.js", "dist/js").vue();
