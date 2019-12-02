<template>
  <div :class="className" :style="{height:height,width:width}"/>
</template>

<script>
import echarts from 'echarts';
require('echarts/theme/macarons'); // echarts theme
import { debounce } from '@/utils';

export default {
  props: {
    className: {
      type: String,
      default: 'chart',
    },
    width: {
      type: String,
      default: '100%',
    },
    height: {
      type: String,
      default: '340px',
    },
    valueChart: {
      type: Object,
    },
  },
  data() {
    return {
      chart: null,
    };
  },
  watch: {
    valueChart: {
      deep: true,
      handler(val) {
        this.setOptions(val.noon, val.night);
      },
    },
  },
  mounted() {
    this.initChart();
    this.__resizeHandler = debounce(() => {
      if (this.chart) {
        this.chart.resize();
      }
    }, 80);
    window.addEventListener('resize', this.__resizeHandler);
  },
  beforeDestroy() {
    if (!this.chart) {
      return;
    }
    window.removeEventListener('resize', this.__resizeHandler);
    this.chart.dispose();
    this.chart = null;
  },
  methods: {
    initChart() {
      this.chart = echarts.init(this.$el, 'macarons');
      this.setOptions();
    },
    setOptions({ value, sum } = {}, { value: value1, sum: sum1 } = {}) {
      this.chart.setOption({
        tooltip: {
          trigger: 'item',
          formatter: '{a} <br/>{b} : {c} ({d}%)',
        },
        legend: {
          left: 'center',
          bottom: '10',
          data: ['Trưa ' + (sum / 1000000) + 'tr', 'Tối ' + (sum1 / 1000000) + 'tr'],
        },
        grid: {
          top: '250px',
        },
        calculable: true,
        series: [
          {
            name: 'Thống kê',
            type: 'pie',
            roseType: 'radius',
            radius: [15, 95],
            center: ['50%', '50%'],
            label: {
              formatter: '{b} : {c} ({d}%)',
            },
            data: [
              {
                value, name: 'Trưa ' + (sum / 1000000) + 'tr',
              },
              {
                value: value1, name: 'Tối ' + (sum1 / 1000000) + 'tr',
              },
            ],
            animationEasing: 'cubicInOut',
            animationDuration: 2600,
          },
        ],
      });
    },
  },
};
</script>
