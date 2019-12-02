<template>
  <div>
    <el-table :data="list" border fit highlight-current-row style="width: 100%">

      <el-table-column
        v-loading="loading"
        align="center"
        label="STT"
        type="index"
        width="65"
        element-loading-text="Pleas be patient！">
      </el-table-column>

      <el-table-column width="180px" align="center" label="Mã số thẻ">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>

      <el-table-column min-width="300px" label="Họ">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>

      <el-table-column width="110px" align="center" label="Tên">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>

      <el-table-column width="120px" label="Vị trí">
        <template slot-scope="scope">
          <span>{{ scope.row.position }}</span>
        </template>
      </el-table-column>
    </el-table>
    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />
  </div>
</template>

<script>
import { fetchList } from '@/api/user';
import Pagination from '@core/components/Pagination';
import { mapGetters } from 'vuex';

export default {
  props: {
    type: {
      type: String,
      default: 'all',
    },
  },
  components: {
    Pagination,
  },
  computed: {
    ...mapGetters(['restaurantId']),
  },
  data() {
    return {
      list: null,
      listQuery: {
        page: 1,
        limit: 5,
        type: this.type,
        sort: '+id',
      },
      total: 0,
      loading: false,
    };
  },
  created() {
    this.getList();
  },
  methods: {
    getList() {
      this.loading = true;
      this.$emit('create'); // for test
      fetchList(this.listQuery, this.restaurantId).then(response => {
        this.list = response.data.items.data;
        this.total = this.list.length;
        this.loading = false;
      });
    },
  },
};
</script>

