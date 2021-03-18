import { BrowserRouter as Router, Route, Link } from "react-router-dom";
import Login from "../pages/Login.jsx";
import Home from "../pages/Home";

const Routes = () => (
  <Router>
    <Link to="/admin/home">To Home</Link>
    <Link to="/admin/login">To Login</Link>
    <Route path="/admin/login" component={Login}></Route>
    <Route path="/admin/home" component={Home}></Route>
  </Router>
);

export default Routes;
