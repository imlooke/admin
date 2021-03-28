import { ConfigProvider, Button, message } from "ant-design-vue";

export const useAntdv = (app) => {
  app.use(Button);
  app.use(ConfigProvider);
  app.config.globalProperties.$message = message;
};
