<template>
  <div class="card mb-3">
    <h5 class="card-header">{{ this.paymentDate[0] }}</h5>
    <div class="card-body p-3">
      <p class="text-lg font-bold">
        주문처리상태 : {{ this.payment.order_status }}
      </p>
      <p>주문일자 : {{ this.paymentDate[0] }} {{ this.paymentDate[1] }}</p>
      <p>주문번호 : {{ this.payment.order_id }}</p>
      <p>주문자 : {{ this.payment.user.name }}</p>
      <p>결제금액 : {{ this.payment.total }}</p>
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
          <p>받는 사람 {{ this.payment.delivery.receiver }}</p>
          <p>{{ this.payment.delivery.phone }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import OrderImage from "./OrderImage.vue";
export default {
  props: ["payment", "user"],
  components: { OrderImage },
  data() {
    return {
      itemShow: false,
      menu: "",
      paymentDate: [],
    };
  },
  methods: {},
  created() {
    this.menu = this.payment.menus;
    this.paymentDate = this.payment.approved_at.split("T");
    // console.log(this.payment.deliverist.addr1);
  },
};
</script>
