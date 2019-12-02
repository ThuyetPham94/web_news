<template>
  <div class="app-container">
    <div class="filter-container">
      <el-button class="filter-item" style="margin-left: 10px;" type="primary" icon="el-icon-edit" @click="handleCreate">{{ $t('table.add') }}</el-button>
      <el-button class="filter-item" style="margin-left: 10px;" type="primary" icon="el-icon-edit" @click="handleImport">{{ $t('table.import') }}</el-button>
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
      <el-table-column :label="$t('table.word_name_vi')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type" @click="handleUpdate(scope.row)">{{ scope.row.word_name_vi }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.word_name_en')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type" @click="handleUpdate(scope.row)">{{ scope.row.word_name_en }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.photo')" min-width="150px">
        <template slot-scope="scope">
          <img :src="imgUrl(scope.row.photo)">
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.related_words_vi')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type" @click="handleUpdate(scope.row)">{{ scope.row.related_words_vi }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.related_words_en')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type" @click="handleUpdate(scope.row)">{{ scope.row.related_words_en }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.antonym_vi')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type" @click="handleUpdate(scope.row)">{{ scope.row.antonym_vi }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.antonym_en')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type" @click="handleUpdate(scope.row)">{{ scope.row.antonym_en }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.function_vi')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type" @click="handleUpdate(scope.row)">{{ scope.row.function_vi }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.function_en')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type" @click="handleUpdate(scope.row)">{{ scope.row.function_en }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.material_vi')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type" @click="handleUpdate(scope.row)">{{ scope.row.material_vi }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.material_en')" min-width="150px">
        <template slot-scope="scope">
          <span class="link-type" @click="handleUpdate(scope.row)">{{ scope.row.material_en }}</span>
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
        <div class="col-6">
          <el-form-item label-width="140px" :label="$t('table.topic_id')" prop="topic_id">
            <el-select v-model="temp.topic_id" class="filter-item" placeholder="Hãy chọn topic">
              <el-option v-for="item in topics" :key="item.id" :label="item.topic_name_vi" :value="item.id"/>
            </el-select>
          </el-form-item>
          <el-form-item label-width="140px" :label="$t('table.word_name_vi')" prop="word_name_vi">
            <el-input v-model="temp.word_name_vi"/>
          </el-form-item>
          <el-form-item label-width="140px" :label="$t('table.word_name_en')" prop="word_name_en">
            <el-input v-model="temp.word_name_en"/>
          </el-form-item>
          <el-form-item label-width="140px" :label="$t('table.related_words_vi')" prop="related_words_vi">
            <el-input v-model="temp.related_words_vi"/>
          </el-form-item>
          <el-form-item label-width="140px" :label="$t('table.related_words_en')" prop="related_words_en">
            <el-input v-model="temp.related_words_en"/>
          </el-form-item>
          <el-form-item label-width="140px" :label="$t('table.antonym_vi')" prop="antonym_vi">
            <el-input v-model="temp.antonym_vi"/>
          </el-form-item>
          <el-form-item label-width="140px" :label="$t('table.antonym_en')" prop="antonym_en">
            <el-input v-model="temp.antonym_en"/>
          </el-form-item>
        </div>
        <div class="col-6">
          <el-form-item label-width="140px" :label="$t('table.level_id')" prop="level_id">
            <el-select v-model="temp.level_id" class="filter-item" placeholder="Hãy chọn level">
              <el-option v-for="item in levels" :key="item.id" :label="item.name_vi" :value="item.id"/>
            </el-select>
          </el-form-item>
          <el-form-item label-width="140px" :label="$t('table.function_vi')" prop="function_vi">
            <el-input v-model="temp.function_vi"/>
          </el-form-item>
          <el-form-item label-width="140px" :label="$t('table.function_en')" prop="function_en">
            <el-input v-model="temp.function_en"/>
          </el-form-item>
          <el-form-item label-width="140px" :label="$t('table.material_vi')" prop="material_vi">
            <el-input v-model="temp.material_vi"/>
          </el-form-item>
          <el-form-item label-width="140px" :label="$t('table.material_en')" prop="material_en">
            <el-input v-model="temp.material_en"/>
          </el-form-item>
          <el-form-item label-width="140px" :label="$t('table.upload')">
            <single-upload ref="upload_photo" :lable="'Upload ảnh'"></single-upload>
          </el-form-item>
          <el-form-item label-width="140px" :label="$t('table.upload_audio_vi')">
            <single-upload ref="upload_audio_vi" :lable="'Upload audio'"></single-upload>
          </el-form-item>
          <el-form-item label-width="140px" :label="$t('table.upload_audio_en')">
            <single-upload ref="upload_audio_en" :lable="'Upload audio'"></single-upload>
          </el-form-item>
        </div>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">{{ $t('table.cancel') }}</el-button>
        <el-button type="primary" @click="dialogStatus==='create' ? createData(): updateData()">{{ $t('table.confirm') }}</el-button>
      </div>
    </el-dialog>

    <el-dialog title="import words" :visible.sync="dialogFormImport">
      <el-upload
        class="upload-demo"
        ref="upload"
        action="/api/words/import"
        :headers="header"
        :auto-upload="false">
        <el-button slot="trigger" size="small" type="primary">select file</el-button>
        <el-button style="margin-left: 10px;" size="small" type="success" @click="submitUpload">upload to server</el-button>
        <div class="el-upload__tip" slot="tip">Chon file excel bạn muốn import</div>
      </el-upload>
    </el-dialog>

  </div>
</template>

<script>
import { fetchList, createWord, updateWord, deleteWord } from '@/api/words';
import Pagination from '@core/components/Pagination';
import SingleUpload from '@/components/Upload/SingleUpload';
import _ from 'lodash';
import { getUserInfor, getToken } from '@/utils/auth';
import { getTopic } from '@/api/topic';
import { getLevels } from '@/api/words_level';

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
        user_id: '',
        topic_id: '',
        word_name_vi: '',
        word_name_en: '',
        related_words_vi: '',
        related_words_en: '',
        antonym_vi: '',
        antonym_en: '',
        function_vi: '',
        function_en: '',
        material_vi: '',
        material_en: '',
        level_id: '',
        word_system_id: 0,
      },
      dialogFormVisible: false,
      dialogStatus: '',
      textMap: {
        update: 'Cập nhập level',
        create: 'Thêm mới level',
      },
      dialogPvVisible: false,
      rules: {
        topic_id: [{ required: true, message: 'Topic không được trống', trigger: 'change' }],
        word_name_vi: [{ required: true, message: 'Từ không được trống', trigger: 'change' }],
        word_name_en: [{ required: true, message: 'Từ (en) không được trống', trigger: 'change' }],
        related_words_vi: [{ required: true, message: 'Từ liên quan không được trống', trigger: 'change' }],
        related_words_en: [{ required: true, message: 'Từ liên quan (en) không được trống', trigger: 'change' }],
        antonym_vi: [{ required: true, message: 'Từ trái nghĩa không được trống', trigger: 'change' }],
        antonym_en: [{ required: true, message: 'Từ trái nghĩa (en) không được trống', trigger: 'change' }],
        function_vi: [{ required: true, message: 'Chức năng không được trống', trigger: 'change' }],
        function_en: [{ required: true, message: 'Chức năng (en) không được trống', trigger: 'change' }],
        material_vi: [{ required: true, message: 'Vật chất không được trống', trigger: 'change' }],
        material_en: [{ required: true, message: 'Vật chất (en) không được trống', trigger: 'change' }],
        level_id: [{ required: true, message: 'Level không được trống', trigger: 'change' }],
      },
      formData: new FormData(),
      dialogFormImport: false,
      header: {},
    };
  },
  created() {
    this.user = JSON.parse(getUserInfor());
    this.temp.id = this.user.id;
    this.listQuery.user_id = this.$route.query.user_id;
    this.getList();
    getTopic().then(res => {
      this.topics = res.data;
    });
    getLevels().then(res => {
      this.levels = res.data;
    });
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
        user_id: this.user.id,
        topic_id: '',
        word_name_vi: '',
        word_name_en: '',
        related_words_vi: '',
        related_words_en: '',
        antonym_vi: '',
        antonym_en: '',
        function_vi: '',
        function_en: '',
        material_vi: '',
        material_en: '',
        level_id: '',
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
          !this.$refs.upload_audio_vi.file || this.formData.append('audio_vi', this.$refs.upload_audio_vi.file);
          !this.$refs.upload_audio_en.file || this.formData.append('audio_en', this.$refs.upload_audio_en.file);
          this.appendData();
          createWord(this.formData).then((res) => {
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
    updateData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          const tempData = Object.assign({}, this.temp);
          !this.$refs.upload_photo.file || this.formData.append('file', this.$refs.upload_photo.file);
          !this.$refs.upload_audio_vi.file || this.formData.append('audio_vi', this.$refs.upload_audio_vi.file);
          !this.$refs.upload_audio_en.file || this.formData.append('audio_en', this.$refs.upload_audio_en.file);
          this.appendData();
          updateWord(this.formData).then((res) => {
            if (res.success) {
              const index = this.list.findIndex(i => i.id === tempData.id);
              this.list.splice(index, 1, tempData);
              this.dialogFormVisible = false;
              this.getList();
              this.formData = new FormData();
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
        deleteWord({ id: row.id }).then((res) => {
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
