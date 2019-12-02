<template>
	<div class="dashboard-editor-container">
    <h2 style="text-align: center;">MÓN BÁN CHẠY</h2>
    <el-row :gutter="32">
      <dish-card width_card="250px" height_card="250px" float="right" margin_top="30px" height_img="60px"/>
      <dish-card height_card="300px"/>
      <dish-card width_card="250px" height_card="250px" margin_top="30px" height_img="60px"/>
    </el-row>
    <el-card class="box-card-component" style="margin-left:8px; margin-top: 40px">
			<el-tabs v-model="activeName" style="margin-top:15px;">
				<el-tab-pane label="Món đánh giá tốt" key="first" name="first">
					<keep-alive>
						<carousel/>
					</keep-alive>
				</el-tab-pane>
				<el-tab-pane label="Món đánh giá kém" key="second" name="second">
					<keep-alive>
						<carousel/>
					</keep-alive>
				</el-tab-pane>
			</el-tabs>
		</el-card>
  </div>
</template>

<script>

import dishCard from './components/dishCard';
import carousel from './components/carousel';
import { mapGetters } from 'vuex';

export default {
  name: 'product',
  computed: {
    ...mapGetters(['avatar']),
  },
  components: {
    dishCard,
    carousel,
  },
  data() {
    return {
      activeName: 'first',
    };
  },
};
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.dashboard-editor-container {
  padding: 32px;
  background-color: rgb(240, 242, 245);
}
.box-card-component {
	text-align: center;
}
#number-one {
	height: 300px;
}
.img-circle {
	border-radius: 50%;
	height: 100px;
}
</style>
