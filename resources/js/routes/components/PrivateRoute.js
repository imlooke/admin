import { Redirect, Route } from "react-router-dom";
import { connect } from "react-redux";

const PrivateRoute = ({ component: Component, isLoggedIn, ...rest }) => {
  return (
    <Route
      {...rest}
      render={(props) => {
        return isLoggedIn ? (
          <Component {...props} />
        ) : (
          <Redirect
            to={{
              pathname: "/login",
              state: { from: props.location },
            }}
          />
        );
      }}
    />
  );
};

function mapStateToProps(store) {
  return {
    isLoggedIn: store.auth.isLoggedIn,
  };
}

export default connect(mapStateToProps)(PrivateRoute);
