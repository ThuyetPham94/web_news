<template>
  <div class="app-container">
    <div class="filter-container">
      <el-select v-model="listQuery.date" style="width: 140px" class="filter-item" @change="handleFilter">
        <el-option v-for="item in datefilter" :key="item.key" :label="item.display_name" :value="item.key"/>
      </el-select>
    </div>

    <el-table
      v-loading="listLoading"
      :key="tableKey"
      :data="list"
      fit
      highlight-current-row
      style="width: 100%;">
      <el-table-column label="Ngày" width="150px" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.created_at | parseTime('{d}/{m}/{y}') }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Giờ" width="150px" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.created_at | parseTime('{h}h{i}') }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Mã đơn" width="150px">
        <template slot-scope="scope">
          <span>{{ scope.row.order_id }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Tổng giá trị" min-width="80px" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.order.total_money | toThousandFilter }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Ghi chú" min-width="110px" align="center">
        <template slot-scope="scope">
          <span style="color:red;">{{ scope.row.order.comment }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Actions" width="120">
        <template slot-scope="scope">
          <router-link :to="'/dashboard/bill/'+scope.row.id">
            <el-button type="primary" size="small" icon="el-icon-edit">Xem chi tiết</el-button>
          </router-link>
        </template>
      </el-table-column>
    </el-table>

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />

  </div>
</template>

<script>
import { fetchList } from '@/api/bill';
import waves from '@core/directive/waves'; // Waves directive
import Pagination from '@core/components/Pagination'; // Secondary package based on el-pagination
import { mapGetters } from 'vuex';

const datefilter = [
  { key: '7', display_name: '7 ngày' },
  { key: '30', display_name: '1 tháng' },
];

export default {
  name: 'ComplexTable',
  components: {
    Pagination,
  },
  computed: {
    ...mapGetters(['restaurantId']),
  },
  directives: { waves },
  data() {
    return {
      tableKey: 0,
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 20,
        importance: undefined,
        title: undefined,
        type: undefined,
        sort: '+id',
      },
      datefilter,
    };
  },
  created() {
    this.getList();
  },
  methods: {
    getList() {
      this.listLoading = true;
      fetchList(this.listQuery, this.restaurantId).then(response => {
        this.list = response.data.data.data;
        this.total = response.data.totalBill;

        // Just to simulate the time of the request
        this.listLoading = false;
      });
    },
    handleFilter() {
      this.listQuery.page = 1;
      this.getList();
    },
  },
};
</script>
<style rel="stylesheet/css" scoped>
.el-button--mini, .el-button--mini.is-round {
  padding: 7px 10px;
}
</style>
