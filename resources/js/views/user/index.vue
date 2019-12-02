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
      <el-table-column :label="$t('table.first_name')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type">{{ scope.row.first_name }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.sur_and_last_name')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type">{{ scope.row.sur_and_last_name }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.phone_number')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type">{{ scope.row.phone_number }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.email')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type">{{ scope.row.email }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.is_suspend')" min-width="150px">
        <template slot-scope="scope">
          <el-switch v-model="scope.row.is_suspend" @change="onChange({ field: 'is_suspend', id: scope.row.id }, $event)"/>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.expire_time')" min-width="150px">
        <template slot-scope="scope">
          <el-date-picker
            v-model="scope.row.expire_time"
            type="datetime"
            format="yyyy-MM-dd HH:mm:ss"
            placeholder="Select date and time"
            @change="onChange({ field: 'expire_time', id: scope.row.id }, $event)"
            value-format="yyyy-MM-dd H:mm:ss"
          />
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.student')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type" @click="goToStudent(scope.row.id)">Xem chi tiết</span>
        </template>
      </el-table-column>
    </el-table>

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />

  </div>
</template>

<script>
import { fetchList, updateField } from '@/api/user';
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
    this.getList();
  },
  methods: {
    goToStudent(userId) {
      this.$router.push({
        name: 'student',
        query: { user_id: userId },
      });
    },
    onChange(data, event) {
      if (typeof event === 'boolean') {
        event = event ? 1 : 0;
      }
      const params = {
        fieldUpdate: data.field,
        id: data.id,
        value: event,
      };
      updateField(params).then(res => {
        if (res.success) {
          this.$notify({
            title: 'Success',
            message: 'Cập nhập thành công !!!',
            type: 'success',
            duration: 2000,
          });
        }
      });
    },
    getList(query = {}) {
      if (_.size(query)) {
        this.listQuery.page = query.page;
        this.listQuery.limit = query.limit;
      }
      this.listLoading = true;
      fetchList(this.listQuery).then(response => {
        this.list = response.data.data;
        this.total = response.data.total;
        this.listLoading = false;
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
