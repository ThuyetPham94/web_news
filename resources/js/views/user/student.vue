<template>
  <div class="app-container">
    <el-table
      v-loading="listLoading"
      :key="tableKey"
      :data="list"
      border
      fit
      highlight-current-row
      style="width: 100%;"
      @sort-change="sortChange">
      <el-table-column :label="$t('table.id')" prop="id" sortable="custom" align="center" width="65">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.student_name')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type" @click="goToWord(scope.row.user_id)">{{ scope.row.student_name }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.photo')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type">{{ scope.row.photo }}</span>
        </template>
      </el-table-column>
    </el-table>

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />

  </div>
</template>

<script>
import { fetchList } from '@/api/student';
import Pagination from '@core/components/Pagination';
import _ from 'lodash';

export default {
  name: 'User',
  components: {
    Pagination,
  },
  data() {
    return {
      tableKey: 0,
      list: [],
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
    };
  },
  created() {
    this.listQuery.user_id = this.$route.query.user_id;
    this.getList();
  },
  methods: {
    getList(query = {}) {
      this.listLoading = true;
      if (_.size(query)) {
        this.listQuery.page = query.page;
        this.listQuery.limit = query.limit;
      }
      fetchList(this.listQuery).then(response => {
        this.list = response.data.data;
        this.total = response.data.total;
        this.listLoading = false;
      });
    },
    goToWord(userId) {
      this.$router.push({
        name: 'Words',
        query: { user_id: userId },
      });
    },
    handleFilter() {
      this.listQuery.page = 1;
      this.getList();
    },
    sortChange(data) {
      const { prop, order } = data;
      if (prop === 'id') {
        this.sortByID(order);
      }
    },
    sortByID(order) {
      if (order === 'ascending') {
        this.listQuery.sort = '+id';
      } else {
        this.listQuery.sort = '-id';
      }
      this.handleFilter();
    },
  },
};
</script>
<style rel="stylesheet/css" scoped>
.el-button--mini, .el-button--mini.is-round {
  padding: 7px 10px;
}
.col-6 {
  display: inline-block;
  max-width: 48%;
  vertical-align: top;
  margin-left: 1%;
}
</style>
