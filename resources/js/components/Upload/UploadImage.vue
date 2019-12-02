<template>
  <div class="upload-container">
    <el-upload
      v-if="!imageUrl.length"
      :data="additionalData"
      :on-change="handleImageSuccess"
      :show-file-list="false"
      action=""
      :multiple="false"
      :auto-upload="false"
      class="image-uploader"
      drag>
      <i class="el-icon-upload"/>
      <div class="el-upload__text">Drag files here or <em>Click to upload</em></div>
    </el-upload>
    <div class="image-preview" v-show="imageUrl.length>1">
      <div v-show="imageUrl.length>1" class="image-preview-wrapper">
        <img :src="imageUrl">
        <div class="image-preview-action">
          <i class="el-icon-delete" @click="rmImage"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { uploadImage } from '@/api/game_contect';

export default {
  name: 'UploadImage',
  data() {
    return {
      tempUrl: '',
      additionalData: {},
      url: '',
      file: '',
      img: '',
    };
  },
  props: {
    image: {
      type: String,
      default: '',
    },
  },
  computed: {
    imageUrl() {
      return this.url;
    },
  },
  created() {
    if (this.image) {
      this.img = this.image;
      this.url = `/upload/image/${this.image}`;
    }
  },
  methods: {
    rmImage() {
      this.url = '';
    },
    handleImageSuccess(file) {
      this.file = file.raw;
      const url = URL.createObjectURL(this.file);
      this.url = url;
      this.uploadImg();
    },
    uploadImg(file) {
      const data = new FormData();
      data.append('file', this.file);
      uploadImage(data).then(res => {
        if (res.success) {
          this.img = res.data;
        }
      });
    },
  },
};
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
@import "~@/styles/mixin.scss";
.upload-container {
  width: 100%;
  position: relative;
  @include clearfix;
  .image-uploader {
    width: 100%;
    float: left;
  }
  .image-preview {
    width: 100%;
    height: 100%;
    position: relative;
    border: 1px dashed #d9d9d9;
    float: left;
    .image-preview-wrapper {
      position: relative;
      width: 100%;
      height: 100%;
      img {
        width: 100%;
        height: auto;
      }
    }
    .image-preview-action {
      position: absolute;
      width: 100%;
      height: 100%;
      left: 0;
      top: 0;
      cursor: default;
      text-align: center;
      color: #fff;
      opacity: 0;
      font-size: 20px;
      background-color: rgba(0, 0, 0, .5);
      transition: opacity .3s;
      cursor: pointer;
      text-align: center;
      line-height: 200px;
      .el-icon-delete {
        font-size: 36px;
      }
    }
    &:hover {
      .image-preview-action {
        opacity: 1;
      }
    }
  }
  .image-app-preview {
    width: 320px;
    height: 180px;
    position: relative;
    border: 1px dashed #d9d9d9;
    float: left;
    margin-left: 50px;
    .app-fake-conver {
      height: 44px;
      position: absolute;
      width: 100%; // background: rgba(0, 0, 0, .1);
      text-align: center;
      line-height: 64px;
      color: #fff;
    }
  }
}
</style>
