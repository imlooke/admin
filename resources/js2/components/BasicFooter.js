import { CopyrightOutlined, GithubOutlined } from "@ant-design/icons";
import { Fragment } from "react";
import { Layout } from "antd";

const { Footer } = Layout;

const BasicFooter = () => {
  return (
    <Footer>
      <Fragment>
        Copyright <CopyrightOutlined />
      </Fragment>
    </Footer>
  );
};

export default BasicFooter;
