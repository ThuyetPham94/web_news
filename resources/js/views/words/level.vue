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
      <el-table-column :label="$t('table.name_vi')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type" @click="handleUpdate(scope.row)">{{ scope.row.name_vi }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.name_en')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type" @click="handleUpdate(scope.row)">{{ scope.row.name_en }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.description_vi')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type" @click="handleUpdate(scope.row)">{{ scope.row.description_vi }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.description_en')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type" @click="handleUpdate(scope.row)">{{ scope.row.description_en }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.photo')" min-width="150px">
        <template slot-scope="scope">
          <img :src="imgUrl(scope.row.word_level_photo)">
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
        <el-form-item label-width="140px" :label="$t('table.name_vi')" prop="name_vi">
          <el-input v-model="temp.name_vi"/>
        </el-form-item>
        <el-form-item label-width="140px" :label="$t('table.name_en')" prop="name_en">
          <el-input v-model="temp.name_en"/>
        </el-form-item>
        <el-form-item label-width="140px" :label="$t('table.description_vi')" prop="description_vi">
          <el-input v-model="temp.description_vi"/>
        </el-form-item>
        <el-form-item label-width="140px" :label="$t('table.description_en')" prop="description_en">
          <el-input v-model="temp.description_en"/>
        </el-form-item>
        <el-form-item label-width="140px" :label="$t('table.upload')" prop="word_level_photo">
          <single-upload ref="upload" :lable="'Upload ảnh'"></single-upload>
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
import { fetchList, createWordLevel, updateWordLevel, deleteWordLevel } from '@/api/words_level';
import Pagination from '@core/components/Pagination';
import SingleUpload from '@/components/Upload/SingleUpload';
import _ from 'lodash';

export default {
  name: 'Level',
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
        name_vi: '',
        name_en: '',
        description_vi: '',
        description_en: '',
      },
      dialogFormVisible: false,
      dialogStatus: '',
      textMap: {
        update: 'Cập nhập level',
        create: 'Thêm mới level',
      },
      dialogPvVisible: false,
      rules: {
        name_vi: [{ required: true, message: 'Tên level không được trống', trigger: 'change' }],
        name_en: [{ required: true, message: 'Tên level(en) không được trống', trigger: 'change' }],
        description_vi: [{ required: true, message: 'Mô tả không được trống', trigger: 'change' }],
        description_en: [{ required: true, message: 'Mô tả(en) không được trống', trigger: 'change' }],
      },
      formData: new FormData(),
    };
  },
  created() {
    this.getList();
  },
  methods: {
    imgUrl(image) {
      const i = image || 'no-image.jpg';
      return `/upload/image/${i}`;
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
    resetTemp() {
      this.temp = {
        id: undefined,
        name_vi: '',
        name_en: '',
        description_vi: '',
        description_en: '',
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
          this.formData.append('file', this.$refs.upload.file);
          this.appendData();
          createWordLevel(this.formData).then((res) => {
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
    handleUpdate(row) {
      this.temp = Object.assign({}, row);
      this.dialogStatus = 'update';
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate();
      });
    },
    deleteData(formData) {
      formData.forEach(function(val, key, fD) {
        formData.delete(key);
      });
    },
    updateData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          const tempData = Object.assign({}, this.temp);
          !this.$refs.upload.file || this.formData.append('file', this.$refs.upload.file);
          this.appendData();
          updateWordLevel(this.formData).then((res) => {
            if (res.success) {
              const index = this.list.findIndex(i => i.id === tempData.id);
              this.list.splice(index, 1, tempData);
              this.dialogFormVisible = false;
              this.getList();
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
        deleteWordLevel({ id: row.id }).then((res) => {
          if (res.success) {
            const index = this.list.indexOf(row);
            this.list.splice(index, 1);
            this.dialogFormVisible = false;
            this.$notify({
              title: 'Success',
              message: 'Xóa level thành công !!!',
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
