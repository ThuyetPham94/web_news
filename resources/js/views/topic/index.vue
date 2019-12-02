<template>
  <div class="app-container">
    <div class="filter-container">
      <el-button class="filter-item" style="margin-left: 10px;" type="primary" icon="el-icon-edit" @click="handleCreate">{{ $t('table.add') }}</el-button>
    </div>

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
      <el-table-column :label="$t('table.topic_name_vi')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type" @click="handleUpdate(scope.row)">{{ scope.row.topic_name_vi }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.topic_name_en')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type" @click="handleUpdate(scope.row)">{{ scope.row.topic_name_en }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.actions')" align="center" width="230" class-name="small-padding fixed-width">
        <template slot-scope="scope">
          <el-button type="primary" size="mini" @click="handleUpdate(scope.row)">{{ $t('table.edit') }}</el-button>
          <el-button v-if="scope.row.status!='deleted'" size="mini" type="danger" @click="handleDelete(scope.row)">{{ $t('table.delete') }}
          </el-button>
        </template>
      </el-table-column>
    </el-table>

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />

    <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible">
      <el-form ref="dataForm" :rules="rules" :model="temp"
        label-position="left"
        label-width="70px"
        style="width: 400px; margin-left:50px;">
        <el-form-item label-width="140px" :label="$t('table.topic_name_vi')" prop="topic_name_vi">
          <el-input v-model="temp.topic_name_vi"/>
        </el-form-item>
        <el-form-item label-width="140px" :label="$t('table.topic_name_en')" prop="topic_name_en">
          <el-input v-model="temp.topic_name_en"/>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">{{ $t('table.cancel') }}</el-button>
        <el-button type="primary" @click="dialogStatus==='create' ? createData(): updateData()">{{ $t('table.confirm') }}</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>
import { fetchList, createTopic, updateTopic, deleteTopic } from '@/api/topic';
import Pagination from '@core/components/Pagination';
import _ from 'lodash';

export default {
  name: 'Topic',
  components: { Pagination },
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
      temp: {
        id: undefined,
        topic_name_en: '',
        topic_name_vi: '',
      },
      dialogFormVisible: false,
      dialogStatus: '',
      textMap: {
        update: 'Cập nhập topic',
        create: 'Thêm mới Topic',
      },
      rules: {
        topic_name_vi: [{ required: true, message: 'Topic is required', trigger: 'change' }],
        topic_name_en: [{ required: true, message: 'Topic (en) is required', trigger: 'change' }],
      },
    };
  },
  created() {
    this.getList();
  },
  methods: {
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
    resetTemp() {
      this.temp = {
        id: undefined,
        topic_name_en: '',
        topic_name_vi: '',
      };
    },
    handleCreate() {
      this.resetTemp();
      this.dialogStatus = 'create';
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate();
      });
    },
    createData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          createTopic(this.temp).then((res) => {
            if (res.success) {
              this.getList();
              this.dialogFormVisible = false;
              this.$notify({
                title: 'Success',
                message: 'Thêm mới thành công !!!',
                type: 'success',
                duration: 2000,
              });
            }
          });
        }
      });
    },
    handleUpdate(row) {
      this.temp = Object.assign({}, row);
      this.dialogStatus = 'update';
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate();
      });
    },
    updateData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          const tempData = Object.assign({}, this.temp);
          updateTopic(tempData).then((res) => {
            if (res.success) {
              const index = this.list.findIndex(i => i.id === tempData.id);
              this.list.splice(index, 1, tempData);
              this.dialogFormVisible = false;
              this.$notify({
                title: 'Success',
                message: 'Cập nhập thành công !!!',
                type: 'success',
                duration: 2000,
              });
            }
          });
        }
      });
    },
    handleDelete(row) {
      if (confirm('Bạn có chắc chắn muốn xóa dòng này ?')) {
        deleteTopic({ id: row.id }).then((res) => {
          if (res.success) {
            const index = this.list.indexOf(row);
            this.list.splice(index, 1);
            this.dialogFormVisible = false;
            this.$notify({
              title: 'Success',
              message: 'Xóa topic thành công !!!',
              type: 'success',
              duration: 2000,
            });
          }
        });
      }
    },
  },
};
</script>
<style rel="stylesheet/css" scoped>
.el-button--mini, .el-button--mini.is-round {
  padding: 7px 10px;
}
</style>
