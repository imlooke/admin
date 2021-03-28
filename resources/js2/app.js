import { Provider } from "react-redux";
import React from "react";
import ReactDOM from "react-dom";
import Routes from "./routes";
import store from "./store";
import { authCheck } from "./store/auth/actions";

store.dispatch(authCheck());

ReactDOM.render(
  <Provider store={store}>
    <Routes />
  </Provider>,
  document.getElementById("app")
);
