export function authCheck() {
  return {
    type: "AUTH_CHECK",
  };
}

export function authLogin(payload) {
  return {
    type: "AUTH_LOGIN",
    payload,
  };
}

export function authLogout() {
  return {
    type: "AUTH_LOGOUT",
  };
}
