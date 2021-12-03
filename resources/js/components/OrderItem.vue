<template>
  <div class="card mb-3 p-20">
    <p>카카오페이 결제가 정상적으로 완료되었습니다.</p>
    <p>결제일시: {{ this.payment.approved_at }}</p>
    <p>주문번호: {{ this.payment.order_id }}</p>
    <p>상품명: {{ this.payment.item_name }}</p>
    <p>결제금액: {{ this.payment.total }}</p>
  </div>
</template>

<script>
export default {
  props: ["payment"],
  components: {},
  data() {
    return {};
  },
  methods: {},
  created() {},
};
</script>
