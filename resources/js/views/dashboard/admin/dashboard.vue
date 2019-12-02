<template>
  <div class="dashboard-editor-container">
    <div class="filter-container">
      <el-select v-model="listQuery.date" style="width: 140px" class="filter-item" @change="handleFilter">
        <el-option v-for="item in datefilter" :key="item.key" :label="item.display_name" :value="item.key"/>
      </el-select>
    </div>
    <panel-group @handleSetLineChartData="handleSetLineChartData" v-bind="result"/>

    <el-row :gutter="32">
      <el-col :xs="24" :sm="24" :lg="15">
        <div class="chart-wrapper">
          <line-chart :chart-data="lineChartData" @getDataChart="getDataChart"/>
        </div>
      </el-col>
      <el-col :xs="24" :sm="24" :lg="9">
        <div class="chart-wrapper">
          <div class="mallki-text">{{ new Date(detailChart.date) | parseTime('{d}/{m}/{y}') }}</div>
          <label>{{ detailChart.revenues | toThousandFilter }}</label>
          <div class="mallki-text">Tổng doanh thu</div>
          <label>{{ detailChart.bills }}</label>
          <div class="mallki-text">Tổng đơn</div>
          <pie-chart :valueChart="dataPieChart"/>
          <router-link class="inlineBlock" id="footer-link" :to="{name: 'bill-dashboard'}">Xem chi tiết lượt đơn
          </router-link>
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import PanelGroup from './components/PanelGroup';
import LineChart from './components/LineChart';
import PieChart from './components/PieChart';
import { fetchList } from '@/api/user';
import { fetchList as fetchListBill } from '@/api/bill';
import { mapGetters } from 'vuex';

const datefilter = [
  { key: '7', display_name: '7 ngày', active: true },
  { key: '30', display_name: '1 tháng', active: false },
];

export default {
  name: 'DashboardAdmin',
  components: {
    LineChart,
    PieChart,
    PanelGroup,
  },
  data() {
    return {
      lineChartData: {
        listDate: [],
        actualData: [],
      },
      dataChart: {},
      result: {
        userNumber: 0,
        totalBill: 0,
        totalRevenue: 0,
      },
      dataPieChart: {
        noon: {
          value: 0,
          sum: 0,
        },
        night: {
          value: 0,
          sum: 0,
        },
      },
      totalPerWeek: 0,
      listQuery: {
        type: ['user'],
      },
      datefilter,
      detailChart: {
        date: '',
        bills: 0,
        revenues: 0,
      },
    };
  },
  computed: {
    ...mapGetters(['restaurantId']),
  },
  created() {
    this.getList();
  },
  methods: {
    getList() {
      fetchList(this.listQuery, this.restaurantId).then(response => {
        this.result.userNumber = response.data.userNumber;
      });
      fetchListBill(this.listQuery, this.restaurantId).then(response => {
        this.result.totalBill = response.data.totalBill;
        this.result.totalRevenue = response.data.totalRevenue;
        this.totalPerWeek = response.data.total;

        const results = response.data.dataCharts;
        this.dataChart = results;
        this.lineChartData = results.totalRevenue;

        const noon = results.detailBills[results.detailBills.length - 1][0];
        const night = results.detailBills[results.detailBills.length - 1][1];
        this.dataPieChart.noon = JSON.parse(JSON.stringify(noon));
        this.dataPieChart.night = JSON.parse(JSON.stringify(night));

        this.detailChart.date = this.lineChartData.listDate[this.lineChartData.listDate.length - 1];
        this.detailChart.bills = results.totalBill.actualData[results.totalBill.actualData - 1];
        this.detailChart.revenues = this.lineChartData.actualData[this.lineChartData.actualData.length - 1];
      });
    },
    handleSetLineChartData(type) {
      const data = JSON.parse(JSON.stringify(this.dataChart));
      this.lineChartData = data[type];
    },
    getDataChart(type) {
      this.detailChart.date = this.lineChartData.listDate[type];
      this.detailChart.bills = this.dataChart.totalBill.actualData[type];
      this.detailChart.revenues = this.lineChartData.actualData[type];

      const noon = this.dataChart.detailBills[type][0];
      const night = this.dataChart.detailBills[type][1];
      this.dataPieChart.noon = JSON.parse(JSON.stringify(noon));
      this.dataPieChart.night = JSON.parse(JSON.stringify(night));
    },
    handleFilter() {
      this.getList();
    },
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
.mallki-text {
  margin-bottom: 10px
}
#footer-link > a {
  text-decoration: underline;
}
#footer-link {
  text-align: right;
  padding: 10px 0px 20px;
}
</style>
