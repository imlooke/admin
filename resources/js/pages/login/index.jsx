import React from "react";
import { Button } from "antd";
import { connect } from "react-redux";
import { Redirect } from "react-router-dom";
import { authLogin } from "../../store/auth/actions";

class Login extends React.Component {
  handleClick = (e) => {
    this.props.dispatch(authLogin("test"));

    let { from } = this.props.location.state || {
      from: { pathname: "/" },
    };

    this.props.history.replace(from);
  };

  render() {
    if (this.props.isLoggedIn) {
      return <Redirect to="/" />;
    }

    return (
      <div>
        <h1>Login</h1>
        <Button type="primary" onClick={this.handleClick}>
          login
        </Button>
      </div>
    );
  }
}

function mapStateToProps(store) {
  return {
    isLoggedIn: store.auth.isLoggedIn,
  };
}

export default connect(mapStateToProps)(Login);
