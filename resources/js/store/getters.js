const getters = {
  sidebar: state => state.app.sidebar,
  language: state => state.app.language,
  device: state => state.app.device,
  visitedViews: state => state.tagsView.visitedViews,
  cachedViews: state => state.tagsView.cachedViews,
  token: state => state.user.token,
  avatar: state => state.user.avatar,
  restaurantId: state => state.user.restaurantId,
  name: state => state.user.name,
  addRouters: state => state.permission.addRouters,
  roles: state => state.user.roles,
  permission_routers: state => state.permission.routers,
  master_data: state => state.user.masterData,
};
export default getters;
