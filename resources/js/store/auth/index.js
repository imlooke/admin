import token from "../../utils/token";

const initialState = {
  isLoggedIn: false,
};

const reducer = (state = initialState, action) => {
  switch (action.type) {
    case "AUTH_CHECK":
      return check(state);
    case "AUTH_LOGIN":
      return login(state, action.payload);
    case "AUTH_LOGOUT":
      return logout(state);
    default:
      return state;
  }
};

function check(state) {
  if (token.get()) {
    state.isLoggedIn = true;
  }
  return state;
}

function login(state, payload) {
  token.set(payload);
  state.isLoggedIn = true;
  return state;
}

function logout(state) {
  token.remove();
  state.isLoggedIn = false;
  return state;
}

export default reducer;
