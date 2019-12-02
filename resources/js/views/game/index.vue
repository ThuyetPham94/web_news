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
      <el-table-column :label="$t('table.game_name_vi')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type" @click="handleUpdate(scope.row)">{{ scope.row.game_name_vi }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.game_name_en')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type" @click="handleUpdate(scope.row)">{{ scope.row.game_name_en }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.photo')" min-width="150px">
        <template slot-scope="scope">
          <img :src="imgUrl(scope.row.photo)">
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

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList"/>

    <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible">
      <el-form ref="dataForm" :rules="rules" :model="temp"
        label-position="left"
        label-width="70px">
        <div class="col-12">
          <el-form-item label-width="140px" :label="$t('table.game_name_vi')" prop="game_name_vi">
            <el-input v-model="temp.game_name_vi"/>
          </el-form-item>
          <el-form-item label-width="140px" :label="$t('table.game_name_en')" prop="game_name_en">
            <el-input v-model="temp.game_name_en"/>
          </el-form-item>
          <el-form-item label-width="140px" :label="$t('table.upload')">
            <single-upload ref="upload_photo" :lable="'Upload ảnh'"></single-upload>
          </el-form-item>
        </div>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">{{ $t('table.cancel') }}</el-button>
        <el-button type="primary" @click="dialogStatus==='create' ? createData(): updateData()">{{ $t('table.confirm') }}</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import { fetchList, createGame, updateGame, deleteGame } from '@/api/game';
import Pagination from '@core/components/Pagination';
import SingleUpload from '@/components/Upload/SingleUpload';
import _ from 'lodash';
import { getToken } from '@/utils/auth';

export default {
  name: 'Word',
  components: {
    Pagination,
    SingleUpload,
  },
  data() {
    return {
      tableKey: 0,
      list: [],
      total: 0,
      listLoading: true,
      user: {},
      topics: '',
      levels: '',
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
        game_name_vi: '',
        game_name_en: '',
      },
      dialogFormVisible: false,
      dialogStatus: '',
      textMap: {
        update: 'Cập nhập trò chơi',
        create: 'Thêm mới trò chơi',
      },
      dialogPvVisible: false,
      rules: {
        game_name_vi: [{ required: true, message: 'Tên game không được trống', trigger: 'change' }],
      },
      formData: new FormData(),
      dialogFormImport: false,
      header: {},
    };
  },
  created() {
    this.getList();
  },
  methods: {
    submitUpload() {
      this.$refs.upload.submit();
    },
    handleImport() {
      const token = getToken();
      this.header = { Authorization: 'Bearer ' + token };
      this.dialogFormImport = true;
    },
    imgUrl(image) {
      const i = image || 'no-image.jpg';
      return `/upload/image/${i}`;
    },
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
        game_name_vi: '',
        game_name_en: '',
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
          !this.$refs.upload_photo.file || this.formData.append('file', this.$refs.upload_photo.file);
          this.appendData();
          createGame(this.formData).then((res) => {
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
    appendData() {
      _.forEach(this.temp, (t, i) => {
        this.formData.append(`${i}`, t);
      });
    },
    deleteData(formData) {
      formData.forEach(function(val, key, fD) {
        formData.delete(key);
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
          !this.$refs.upload_photo.file || this.formData.append('file', this.$refs.upload_photo.file);
          this.appendData();
          updateGame(this.formData).then((res) => {
            if (res.success) {
              const index = this.list.findIndex(i => i.id === tempData.id);
              this.list.splice(index, 1, tempData);
              this.dialogFormVisible = false;
              this.getList();
              this.deleteData(this.formData);
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
        deleteGame({ id: row.id }).then((res) => {
          if (res.success) {
            const index = this.list.indexOf(row);
            this.list.splice(index, 1);
            this.dialogFormVisible = false;
            this.$notify({
              title: 'Success',
              message: 'Xóa từ thành công !!!',
              type: 'success',
              duration: 2000,
            });
          }
        });
      }
    },
  },
  mounted() {
    this.$on('pagination', res => {
      console.log(res);
    });
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
