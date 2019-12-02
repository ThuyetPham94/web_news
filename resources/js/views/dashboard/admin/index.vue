<template>
  <div class="dashboard-editor-container">

    <panel-group
      :total-users="totalUsers"
      :total-words="totalWords"
      :total-topics="totalTopics"
      :total-levels="totalWordLevels"
      :user-active="userActive"
      :user-suspend="userSuspend"
      />
  </div>
</template>

<script>
import PanelGroup from './components/PanelGroup';
import _ from 'lodash';
export default {
  name: 'DashboardAdmin',
  components: {
    PanelGroup,
  },
  data() {
    return {
      totalUsers: 0,
      totalTopics: 0,
      totalWords: 0,
      totalWordLevels: 0,
      userActive: 0,
      userSuspend: 0,
    };
  },
  created() {
    const users = this.$store.getters.master_data.users;
    this.totalUsers = _.size(users);
    this.totalTopics = _.size(this.$store.getters.master_data.topics);
    this.totalWords = _.size(this.$store.getters.master_data.words);
    this.totalWordLevels = _.size(this.$store.getters.master_data.word_level);
    const userActive = _.filter(users, u => {
      return u.is_active === 1;
    });
    const userSuspend = _.filter(users, u => {
      return u.is_suspend === 1;
    });
    this.userActive = _.size(userActive);
    this.userSuspend = _.size(userSuspend);
  },
};
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.dashboard-editor-container {
  padding: 32px;
  background-color: rgb(240, 242, 245);
  .chart-wrapper {
    background: #fff;
    padding: 16px 16px 0;
    margin-bottom: 32px;
  }
}
</style>
