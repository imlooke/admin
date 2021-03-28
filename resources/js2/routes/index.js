import { BrowserRouter as Router, Link, Route, Switch } from "react-router-dom";
import PrivateRoute from "./components/PrivateRoute";
import Login from "../pages/login";
import routes from "./routes";

const Routes = () => (
  <Router basename={window.ADMIN_CONFIGS.prefix}>
    <Switch>
      <Route path="/login" exact component={Login} />
      {routes.map((route, i) => {
        return <PrivateRoute key={i} {...route} />;
      })}
    </Switch>
  </Router>
);

export default Routes;
