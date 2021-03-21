import { BrowserRouter as Router, Link, Route, Switch } from "react-router-dom";
import PrivateRoute from "./components/PrivateRoute";
import Login from "../pages/login";
import Home from "../pages/home";

const Routes = () => (
  <Router basename={window.ADMIN_CONFIGS.prefix}>
    <Link to="/">To Home</Link>
    <Link to="/login">To Login</Link>
    <Switch>
      <Route path="/login" component={Login} />
      <PrivateRoute path="/" component={Home} />
    </Switch>
  </Router>
);

export default Routes;
