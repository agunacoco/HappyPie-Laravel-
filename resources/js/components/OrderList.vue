<template>
  <div class="card mb-3 p-20">
    <order-item
      class="flex justify-center"
      v-for="payment in payments"
      :key="payment.id"
      :payment="payment"
    />
  </div>
</template>

<script>
import OrderItem from "./OrderItem.vue";
export default {
  props: ["payments"],
  components: { OrderItem },
  data() {
    return {};
  },
  methods: {},
  created() {},
};
</script>
