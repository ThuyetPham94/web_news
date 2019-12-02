<template>
  <div class="container">
    <div class="large-12 medium-12 small-12 cell upload-btn-wrapper">
      <button class="btn">{{ lable }}</button>
      <input type="file" id="myfile" ref="file" v-on:change="handleFileUpload()"/>
      <span v-text="file.name" class="readonly"/>
    </div>
    <div class="image-preview-action">
      <i class="el-icon-delete" @click="rmImage"/>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SingleUpload',
  data() {
    return {
      file: '',
    };
  },
  props: {
    lable: {
      type: String,
    },
  },
  methods: {
    rmImage() {
      this.file = '';
    },
    handleFileUpload() {
      this.file = this.$refs.file.files[0];
    },
  },
};
</script>

<style scoped>
.upload-btn-wrapper {
  position: relative;
  overflow: hidden;
  display: inline-block;
}

.btn {
  border: 2px solid gray;
  color: gray;
  background-color: white;
  padding: 8px 20px;
  border-radius: 8px;
  font-size: 16px;
  font-weight: bold;
}
.readonly {
  box-sizing: border-box;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.upload-btn-wrapper input[type=file] {
  font-size: 100px;
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
}
</style>
