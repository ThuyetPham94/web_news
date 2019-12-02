<template>
	<el-col :xs="24" :sm="24" :lg="8">
		<el-card class="box-card-component" :style="{ width: width_card, height: height_card, float: float, 'margin-left': margin_left, 'margin-top': margin_top }">
			<div>
				<div style="padding-top:25px;">
					<span>3</span>
				</div>
				<div style="padding-top:25px;">
					<img :src="avatar+'?imageView2/1/w/80/h/80'" class="img-circle" :style="{ height: height_img }">
				</div>
				<div style="padding-top:25px;">
					<span>Mực chiên</span>
				</div>
			</div>
		</el-card>
	</el-col>
</template>

<script>

import { mapGetters } from 'vuex';

export default {
  name: 'dishCard',
  computed: {
    ...mapGetters(['avatar']),
  },
  props: ['width_card', 'height_card', 'image_card', 'float', 'margin_left', 'margin_top', 'height_img'],
};
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.box-card-component {
	text-align: center;
}
.img-circle {
	border-radius: 50%;
	height: 100px;
}
</style>
