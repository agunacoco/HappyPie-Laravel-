<template></template>

<script>
export default {
  props: [],
  components: {},
  data() {
    return {
      transitionOn: true, //슬라이드가 움직일때 트렌지션을 줄 것인지
      cardArray: [], // 슬라이드 카드가 담길 배열 mounted에서 담아준다.
      slideCoord: -300,
    };
  },
  methods: {
    resetCardArrayToRight() {
      // 슬라이드 카드 배열 끝에 맨 앞에 있던 카드를 추가
      this.cardArray.splice(this.cardArray.length, 0, this.cardArray[0]);

      // 맨 끝에 추가한 후 맨 앞에 있던 카드는 삭제
      this.cardArray.splice(0, 1);

      // 잠시 transition 을 off 하기
      this.transitionOn = false;

      // slideCoord를 초기값으로 설정
      this.slideCoord = -300;
    },

    // 슬라이드 오른쪽 버튼 클릭이벤트 @click=" moveSlideToRight"
    moveSlideToRight() {
      // -300 씩 이동
      this.slideCoord = this.slideCoord - 300;

      // transitionOn은 true로
      this.transitionOn = true;

      // 0.5초 뒤에 배열의 순서를 바꾸고 slideCoord값을 다시 초기 값으로 설정
      // 이때만 transition을 off하여 움직이지 않는 것 처럼 눈속임한다.
      // 여기 setTimeout의 delay 시간은 css의 transition의 duration과 같게 설정해야한다.
      setTimeout(this.resetCardArrayToRight, 500);
    },
  },
  created() {},
};
</script>
