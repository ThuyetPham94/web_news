<template>
  <div class="app-container">
    <h3 v-text="updateTitle"></h3>
    <el-form ref="dataForm" :rules="rules" :model="game"
      label-position="left"
      style="margin-left:50px;">
      <el-form-item label-width="140px" :label="$t('table.game_name_vi')" prop="name_vi">
        <el-input v-model="game.name_vi"/>
      </el-form-item>
      <el-form-item label-width="140px" :label="$t('table.game_name_en')" prop="name_en">
        <el-input v-model="game.name_en"/>
      </el-form-item>
      <el-form-item label-width="140px" :label="$t('table.level_id')" prop="level_id">
        <el-select class="filter-item" filterable
          v-model="game.level_id"
          placeholder="Hãy chọn level"
          disabled
          @change="filterWord()">
          <el-option v-for="item in levels"
            :key="item.id"
            :label="item.name_vi"
            :value="item.id"/>
        </el-select>
      </el-form-item>
      <el-form-item label-width="140px" :label="$t('table.word_name_vi')" prop="word_id">
        <el-select class="filter-item" filterable
          placeholder="Hãy chọn word"
          v-model="tmpWord"
          @change="onChangeWord">
          <el-option v-for="item in wordsPart"
            :key="item.id"
            :label="item.word_name_vi"
            :value="item.id"/>
        </el-select>
      </el-form-item>
      <el-form-item label-width="140px">
        <el-button @click="addDragResize">{{ $t('table.add') }}</el-button>
      </el-form-item>
      <el-form-item label-width="140px" :label="$t('table.photo')" prop="photo">
        <div class="img-container" ref="img-container">
          <img :src="imgPath(game.photo)" ref="photo">
          <VueDragResize
            :class="'img-drag'"
            v-for="(img, index) in images"
            v-bind:key="index"
            :isActive="true"
            :w="img.height"
            :h="img.width"
            :x="img.left"
            :y="img.top"
            v-on:resizing="resize(index, $event)"
            v-on:dragging="resize(index, $event)"
            :parentLimitation="true"
            @deactivated="deActive"
            @clicked="onActivated(index)"
            :z="999">
            <span class="remove" @click="removeDrag(index)">X</span>
            <div class="image-preview" v-if="img.word_id">
              <img :src="imgPreview(index)">
            </div>
          </VueDragResize>
        </div>
      </el-form-item>
    </el-form>
    <div slot="footer" class="dialog-footer">
      <el-button @click="dialogFormVisible = false">{{ $t('table.cancel') }}</el-button>
      <el-button type="primary" @click="updateData()">{{ $t('table.confirm') }}</el-button>
    </div>
  </div>
</template>

<script>
import { findGame, updateGame } from '@/api/game_contect';
import { getLevels } from '@/api/words_level';
import VueDragResize from 'vue-drag-resize';
import _ from 'lodash';
import { fetchAll } from '@/api/words';

export default {
  name: 'UpdateGame',
  components: {
    VueDragResize,
  },
  data() {
    return {
      game: {},
      updateTitle: 'Cập nhập trò chơi',
      photo_options: {},
      tmpWord: '',
      tmpIndex: '',
      rules: {
        name_vi: [{ required: true, message: 'Tên trò chơi không được trống', trigger: 'change' }],
        name_en: [{ required: true, message: 'Tên trò chơi(en) không được trống', trigger: 'change' }],
      },
      childrenOptions: [],
      baseLevels: [1, 2, 3],
      images: [],
      flag: 0,
      words: {},
      levels: {},
      wordsPart: [],
    };
  },
  created() {
    const gameId = this.$route.query.id;
    getLevels(4).then(res => {
      if (res.success) {
        this.levels = _.filter(res.data, level => {
          return this.baseLevels.findIndex(i => i === level.id) >= 0;
        });
      }
    });
    findGame({ id: gameId }).then(res => {
      if (res.success) {
        this.game = res.data;
        this.photo_options = JSON.parse(this.game.photo_options);
        this.childrenOptions = JSON.parse(this.game.children_options);
        fetchAll().then(res => {
          if (res.success) {
            this.words = res.data;
            this.pushImage(this.childrenOptions);
          }
        });
      }
    });
    fetchAll().then(res => {
      if (res.success) {
        this.words = res.data;
        this.pushImage(this.childrenOptions);
        this.addWordsPart();
      }
    });
  },
  methods: {
    onActivated(index) {
      this.tmpIndex = index;
      this.tmpWord = this.images[index].word_id;
    },
    deActive() {
      console.log('deactove');
      this.tmpIndex = '';
      this.tmpWord = '';
      console.log(this.tmpIndex);
      console.log(this.tmpWord);
    },
    onChangeWord() {
      if (this.tmpIndex === '') {
        return;
      }
      console.log('active');
      console.log(this.tmpIndex);
      console.log(this.tmpWord);
      this.images[this.tmpIndex].word_id = this.tmpWord;
    },
    imgPath(img) {
      return `/upload/image/${img}`;
    },
    imgPreview(index) {
      if (!this.images[index].word_id) {
        return;
      }
      const word = this.wordsPart.find(w => {
        return w.id === this.images[index].word_id;
      });
      return this.imgPath(word.photo);
    },
    filterWord() {
      _.forEach(this.images, (img) => {
        img.word_id = '';
      });
      this.addWordsPart();
    },
    addWordsPart() {
      this.wordsPart = _.filter(this.words, (word) => {
        return word.level_id === this.game.level_id;
      });
    },
    resize(index, newRect) {
      this.images[index].width = newRect.width;
      this.images[index].left = newRect.left;
      this.images[index].top = newRect.top;
      this.images[index].height = newRect.height;
    },
    addDragResize() {
      this.pushImage();
    },
    pushImage(time = 1) {
      if (!time) {
        return;
      }
      if (time === 1) {
        this.images.push({
          width: 230,
          height: 230,
          top: 0,
          left: 0,
          word_id: this.tmpWord,
        });
        this.addWordsPart(this.images.length - 1);
        return;
      }
      const num = _.size(time);
      for (let i = 0; i < num; i++) {
        this.images.push({
          width: this.calWidth(i),
          height: this.calHeight(i),
          top: this.calTop(i),
          left: this.calLeft(i),
          word_id: this.getWordId(i),
        });
        this.addWordsPart(i);
      }
    },
    getWordId(index) {
      return this.childrenOptions[index].word_id;
    },
    calHeight(index) {
      return parseInt((this.photo_options.height * this.childrenOptions[index].height / 100).toFixed(0));
    },
    calWidth(index) {
      return parseInt((this.photo_options.width * this.childrenOptions[index].width / 100).toFixed(0));
    },
    calTop(index) {
      return parseInt((this.photo_options.height * this.childrenOptions[index].top / 100).toFixed(0));
    },
    calLeft(index) {
      return parseInt((this.photo_options.width * this.childrenOptions[index].left / 100).toFixed(0));
    },
    removeDrag(index) {
      this.images.splice(index, 1);
    },
    updateData() {
      if (this.images.length) {
        this.handleRatio();
        this.game.children_options = JSON.stringify({ ...this.childrenOptions });
      }
      updateGame(this.game).then(res => {
        if (res.success) {
          this.$notify({
            title: 'Success',
            message: 'Cập nhập thành công !!!',
            type: 'success',
            duration: 2000,
          });
          this.$router.push({ name: 'game' });
        }
      });
    },
    handleRatio() {
      this.childrenOptions = [];
      const photoOptions = this.photo_options;
      _.forEach(this.images, (i, k) => {
        this.childrenOptions.push({
          height: ((i.height / photoOptions.height) * 100).toFixed(1),
          width: ((i.height / photoOptions.width) * 100).toFixed(1),
          left: ((i.left / photoOptions.width) * 100).toFixed(1),
          top: ((i.top / photoOptions.height) * 100).toFixed(1),
          word_id: i.word_id,
        });
      });
    },
  },
};
</script>
<style scoped>
.img-container {
  max-width: 100%;
  min-height: 800px;
}
.img-container img{
  width: 100%;
  height: auto;
}
.img-drag {
  background-color: rgba(255, 255, 255, 0.9);
}
.image-preview {
  max-width: 225px;
}
.image-preview img {
  width: 100%;
  height: auto;
}
span.remove {
  position: absolute;
  right: -6%;
  top: -6%;
  z-index: 9999;
  height: 30px;
  width: 30px;
  background: #000;
  color: #fff;
  text-align: center;
  border-radius: 50%;
  font-size: 16px;
  line-height: 30px;
  font-weight: bolder;
  cursor: pointer;
}
</style>
