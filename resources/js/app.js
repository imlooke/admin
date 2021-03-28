import { createApp } from "vue";
import { useAntdv } from "./plugins/ant-design-vue";
import { useRequest } from "./utils/request";
import App from "./App.vue";

const app = createApp(App);
app.config.productionTip = false;

useAntdv(app);
useRequest(app);
app.mount("#app");
