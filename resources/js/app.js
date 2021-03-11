import React from "react";
import ReactDOM from "react-dom";
import { DatePicker } from "antd";
import axios from "axios";

axios.defaults.withCredentials = true;
axios.get("/sanctum/csrf-cookie").then(function () {
  axios.post("/api/admin/login", {
    username: "admin",
    password: "123456",
  });
});

setTimeout(() => {
  axios.get("/api/admin/user").then(function (response) {
    console.log(response);
  });
}, 5000);

ReactDOM.render(<DatePicker />, document.getElementById("app"));
