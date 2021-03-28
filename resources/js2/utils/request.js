import axios from "axios";

const instance = axios.create({
  baseURL: "/api/admin",
});

instance.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response.status === 401) {
      console.log(401);
    }
  }
);

export default instance;
