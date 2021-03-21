const keyName = "imlooke-admin::access_token";

const token = {
  set(token) {
    localStorage.setItem(keyName, token);
  },
  get() {
    return localStorage.getItem(keyName);
  },
  remove() {
    localStorage.removeItem(keyName);
  },
};

export default token;
