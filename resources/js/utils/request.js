import axios from "axios";

const request = axios.create({
  baseURL: "/api/admin",
});

request.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response.status === 401) {
      console.log(401);
    }
  }
);

export const useRequest = (app) => {
  app.config.globalProperties.$request = request;
};

export default request;
