<template>
  <div class="card">
    <h5 class="card-header">
      <div class="flex justify-between">
        <p class="font-medium text-base pt-2">
          메뉴 {{ this.payment.item_code.split(",").length }}개 -
          {{ this.payment.total }}(결제완료)
        </p>

        <button
          v-if="
            payment.order_status == '주문준비중' ||
            payment.order_status == '주문확인'
          "
          type="button"
          class="btn btn-outline-info"
          @click="clickBtn"
        >
          준비완료
        </button>
        <button
          v-if="payment.order_status == '배송중'"
          type="button"
          class="btn btn-secondary"
        >
          완료
        </button>
      </div>
    </h5>
    <div class="card-body p-3">
      <p>주문일자 : {{ this.paymentDate[0] }} {{ this.paymentDate[1] }}</p>
      <p>주문번호 : {{ this.payment.order_id }}</p>
      <p>주문자 : {{ this.payment.user.name }}</p>
      <p>주문상품 (총 {{ this.payment.quantity }}개)</p>
      <order-image
        class="flex justify-center"
        v-for="menu in payment.menus"
        :key="menu.id"
        :menu="menu"
      />
      <div class="card p-3">
        <div class="text-base font-bold my-2">배송정보</div>
        <div v-if="this.payment.delivery">
          <p>{{ this.payment.delivery.addr1 }}</p>
          <p>[우편번호] {{ this.payment.delivery.detailaddr }}</p>
          <p>{{ this.payment.delivery.addr2 }}</p>
          <p>받는 사람 : {{ this.payment.delivery.receiver }}</p>
          <p>{{ this.payment.delivery.phone }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import OrderImage from "./OrderImage.vue";
export default {
  props: ["payment"],
  components: { OrderImage },
  data() {
    return {
      menu: "",
      paymentDate: [],
      menuIds: [],
      payments: "",
      order_status: this.payment.order_status,
      showBotton: false,
    };
  },
  methods: {
    clickBtn() {
      if (this.payment.order_status == "주문준비중") {
        axios
          .patch(
            "/happypies/ordersheet/status/" +
              this.payment.id +
              "?status=준비완료"
          )
          .then((response) => {
            console.log(response.data);
            this.payments = response.data;
            this.$emit("returnSheet", this.payments);
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
  },
  created() {
    this.paymentDate = this.payment.approved_at.split("T");
    // if (this.order_status == "주문준비중") {
    //   this.showBotton = false;
    // }
    // if (this.order_status == "배송중") {
    //   this.showBotton = true;
    //   this.status = "완료";
    // }
  },
};
</script>
