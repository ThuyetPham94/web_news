<template>
  <div class="tab-container">
    <el-tabs v-model="activeName" style="margin-top:15px;">
      <el-tab-pane v-for="item in tabMapOptions" :label="item.label" :key="item.key" :name="item.key">
        <keep-alive>
          <tab-pane v-if="activeName==item.key" :type="item.key"/>
        </keep-alive>
      </el-tab-pane>
    </el-tabs>
  </div>
</template>

<script>
import TabPane from './components/TabPane';

export default {
  name: 'Tab',
  components: { TabPane },
  data() {
    return {
      tabMapOptions: [
        { label: 'Tất cả', key: 'all' },
        { label: 'Phục vụ', key: 'waiter' },
        { label: 'Bếp', key: 'chef' },
        { label: 'Thu Ngân', key: 'cashier' },
      ],
      activeName: 'all',
      createdTimes: 0,
    };
  },
};
</script>

<style scoped>
  .tab-container{
    margin: 30px;
  }
</style>
