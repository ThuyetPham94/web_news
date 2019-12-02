<template>
	<div class="dashboard-editor-container">
		<h2 style="margin-left: 10px;">CHI TIẾT HÓA ĐƠN</h2>
		<el-row :gutter="32">
      <el-col :xs="24" :sm="24" :lg="19">
        <el-card class="box-card-component order-info" style="margin-left:8px;">
					<div slot="header" class="box-card-header">
						<strong><span>Mã đơn: {{ list.bill.order_id }}</span></strong>
						<span class="table-info">Bàn {{ list.table }} - {{ list.bill.created_at | parseTime('{d}/{m}/{y}') }} - {{ list.bill.created_at | parseTime('{h}h{i}') }}</span>
					</div>
					<div style="position:relative;">
						<div style="padding-top:25px;">
							<label class="left-text">Phục vụ bởi</label>
							<label class="mallki-text">{{ list.waiter }}</label>
						</div>
						<div style="padding-top:20px;">
							<label class="left-text">Thu ngân</label>
							<label class="mallki-text">{{ list.cashier }}</label>
						</div>
						<div class="order-detail">
							<div class="header">
								<el-table
									v-loading="listLoading"
									:key="tableKey"
									:data="list.orderDetail"
									fit
									highlight-current-row
									style="width: 100%;">
									<el-table-column label="STT" width="150px" align="center" type="index">
									</el-table-column>
									<el-table-column label="Mặt hàng" width="250px">
										<template slot-scope="scope">
											<span>{{ scope.row.dish.name }}</span>
										</template>
									</el-table-column>
									<el-table-column label="SL" width="100px">
										<template slot-scope="scope">
											<span>{{ scope.row.id }}</span>
										</template>
									</el-table-column>
									<el-table-column label="Đơn giá" width="150px">
										<template slot-scope="scope">
											<span>{{ scope.row.dish.price | toThousandFilter }}</span>
										</template>
									</el-table-column>
									<el-table-column label="Thành tiền" min-width="150px">
										<template slot-scope="scope">
											<span>{{ scope.row.price | toThousandFilter }}</span>
										</template>
									</el-table-column>
								</el-table>
							</div>
							<div class="footer">
								<el-table
									v-loading="listLoading"
									:key="tableKey"
									:data="list.summary"
									fit
									highlight-current-row
									style="width: 100%;">
									<el-table-column width="150px" align="center">
									</el-table-column>
									<el-table-column width="250px">
										<template slot-scope="scope">
											<span>{{ scope.row.field1 }}</span>
										</template>
									</el-table-column>
									<el-table-column width="100px" label="Số lượng">
										<template slot-scope="scope">
											<span>{{ scope.row.field2 }}</span>
										</template>
									</el-table-column>
									<el-table-column width="100px" label="Tổng tiền">
										<template slot-scope="scope">
											<span>{{ scope.row.field3 | toThousandFilter }}</span>
										</template>
									</el-table-column>
								</el-table>
							</div>
						</div>
					</div>
				</el-card>
      </el-col>
      <el-col :xs="24" :sm="24" :lg="5">
				<el-card class="box-card-component" style="margin-left:8px;">
					<div slot="header" class="box-card-header user-info">
						<strong><span>THÔNG TIN KHÁCH HÀNG</span></strong>
					</div>
					<div>
						<div style="padding-top:25px;">
							<label class="left-text">Họ tên</label>
							<label class="mallki-text">{{ list.customer.name }}</label>
						</div>
						<div style="padding-top:20px;">
							<label class="left-text">Số ĐT</label>
							<label class="mallki-text">{{ list.customer.phone }}</label>
						</div>
						<div style="padding-top:20px;">
							<label class="left-text">Hình thức thanh toán</label>
							<label class="mallki-text">{{ list.bill.payment_method }}</label>
						</div>
						<div style="padding-top:30px;" class="user-detail">
							<router-link class="inlineBlock" :to="{name: 'order-dashboard'}">Xem hồ sơ khách hàng
						</router-link>
						</div>
					</div>
				</el-card>
      </el-col>
    </el-row>
	</div>
</template>

<script>

import { fetchBill } from '@/api/bill';

export default {
  name: 'orderDetail',
  data() {
    return {
      tableKey: 0,
      list: null,
      listLoading: true,
    };
  },
  created() {
    const id = this.$route.params && this.$route.params.id;
    this.fetchData(id);
  },
  methods: {
    fetchData(id) {
      this.listLoading = true;
      fetchBill(id)
        .then(response => {
          console.log(response);
          this.list = response.data;
          this.listLoading = false;
        })
        .catch(err => {
          console.log(err);
        });
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
.table-info {
	float: right;
}
.header {
	border-bottom: 1px solid #000;
}
.footer {
	position: relative;
}
.user-info {
	text-align: center;
	padding: 15px;
}
.order-info {
	padding: 20px 50px;
}
.order-detail {
	margin-top: 20px;
	padding: 20px;
	padding-top:20px;
	border: 1px solid #000;
}
.box-card-component {

  .box-card-header {
    position: relative;
  }
  .mallki-text {
    font-weight: 200;
    padding-right: 5px;
    float: right;
  }
  .left-text {
		padding-left: 5px;
    font-weight: 600;
  }
  .panThumb {
    z-index: 100;
    height: 70px!important;
    width: 70px!important;
    position: absolute!important;
    top: -45px;
    left: 0px;
    border: 5px solid #ffffff;
    background-color: #fff;
    margin: auto;
    box-shadow: none!important;
    >>> .pan-info {
      box-shadow: none!important;
    }
  }
  // @media only screen and (max-width: 1510px){
  //   .mallki-text{
  //     display: none;
  //   }
  // }
}
.user-detail {
	text-align: center;
	text-decoration: underline;
	font-style: italic;
}
</style>
