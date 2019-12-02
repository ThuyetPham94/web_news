import { login, logout, getInfo, getMasterData } from '@/api/login';
import { getToken, setToken, removeToken, setUserInfor, removeUser } from '@/utils/auth';

const user = {
  state: {
    token: getToken(),
    name: '',
    email: '',
    phone: '',
    avatar: '',
    restaurantId: 0,
    roles: [],
    masterData: [],
  },

  mutations: {
    SET_TOKEN: (state, token) => {
      state.token = token;
    },
    SET_NAME: (state, name) => {
      state.name = name;
    },
    SET_EMAIL: (state, email) => {
      state.email = email;
    },
    SET_PHONE: (state, phone) => {
      state.phone = phone;
    },
    SET_AVATAR: (state, avatar) => {
      state.avatar = avatar;
    },
    SET_RESTAURANT_ID: (state, restaurantId) => {
      state.restaurantId = restaurantId;
    },
    SET_ROLES: (state, roles) => {
      state.roles = roles;
    },
    SET_USER_INFOR: (state, user) => {
      state.user = user;
    },
    SET_MASTER_DATA: (state, data) => {
      state.masterData = data;
    },
  },

  actions: {
    /**
     * Login action
     * @param {callbak} param0
     * @param {email, password} userInfo
     */
    Login({ commit }, userInfo) {
      const email = userInfo.email.trim();
      return new Promise((resolve, reject) => {
        login(email, userInfo.password)
          .then(response => {
            const token = response.token;
            setToken(token);
            setUserInfor(response.data);
            commit('SET_TOKEN', token);
            commit('SET_USER_INFOR', response.data);
            resolve();
          })
          .catch(error => {
            reject(error);
          });
      });
    },

    masterData({ commit }) {
      return new Promise((resolve, reject) => {
        getMasterData()
          .then(response => {
            commit('SET_MASTER_DATA', response.data);
            resolve();
          })
          .catch(error => {
            reject(error);
          });
      });
    },

    /**
     * Get user information
     * @param {*} param0
     */
    GetInfo({ commit, state }) {
      return new Promise((resolve, reject) => {
        getInfo(state.token)
          .then(response => {
            const data = response.data;
            if (data.role) {
              commit('SET_ROLES', [data.role]);
            } else {
              reject('getInfo: role must be set');
            }
            commit('SET_NAME', data.name);
            commit('SET_AVATAR', data.photo);
            commit('SET_EMAIL', data.email);
            commit('SET_PHONE', data.phone);
            commit('SET_RESTAURANT_ID', data.restaurant_id);
            // commit('SET_AVATAR', 'http://i.pravatar.cc/32');
            resolve(response);
          })
          .catch(error => {
            reject(error);
          });
      });
    },

    /**
     * Logout action
     * @param {*} param0
     */
    LogOut({ commit, state }) {
      return new Promise((resolve, reject) => {
        logout(state.token)
          .then(() => {
            commit('SET_TOKEN', '');
            commit('SET_ROLES', []);
            removeToken();
            removeUser();
            resolve();
          })
          .catch(error => {
            reject(error);
          });
      });
    },

    /**
     * Logout processing
     * @param {*} param0
     */
    FedLogOut({ commit }) {
      return new Promise(resolve => {
        commit('SET_TOKEN', '');
        removeToken();
        resolve();
      });
    },

    /**
     * Change role of user
     * This method is to demo the directive v-permission.
     *
     * @param {*} param0
     * @param {*} role
     */
    ChangeRoles({ commit, dispatch }, role) {
      return new Promise(resolve => {
        commit('SET_ROLES', [role]);
        dispatch('GenerateRoutes', { roles: [role] }); // Re-render sidebar menu with new permission
        resolve();
      });
    },
  },
};

export default user;
