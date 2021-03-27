import PropTypes from "prop-types";
import BasicFooter from "../components/BasicFooter";

const BasicLayout = ({ children, ...props }) => {
  const { customClass } = props;

  return (
    <div className={"im-layout" + (customClass ? ` ${customClass}` : "")}>
      {children}
      <BasicFooter />
    </div>
  );
};

BasicLayout.propTypes = {
  children: PropTypes.object.isRequired,
  customClass: PropTypes.string,
};

export default BasicLayout;
