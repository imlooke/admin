import React from "react";
import { Button } from "antd";
import { connect } from "react-redux";
import { authLogout } from "../../store/auth/actions";

class Home extends React.Component {
  handleClick = (e) => {
    this.props.dispatch(authLogout());
    this.props.history.replace({ pathname: "/login" });
  };

  render() {
    return (
      <div>
        <h1>Home</h1>
        <Button type="danger" onClick={this.handleClick}>
          logout
        </Button>
      </div>
    );
  }
}

export default connect()(Home);
