const mix = require("laravel-mix");
const AntdDayjsWebpackPlugin = require("antd-dayjs-webpack-plugin");

mix.webpackConfig({
  plugins: [new AntdDayjsWebpackPlugin()],
  resolve: {
    extensions: [".js", ".jsx"],
  },
});

mix.browserSync({
  proxy: "localhost:8080/admin",
  files: ["resources/less/**/*", "resources/js/**/*"],
});

mix.less("resources/less/app.less", "public/css", {
  lessOptions: { javascriptEnabled: true },
});
mix.js("resources/js/app.js", "public/js").react();
