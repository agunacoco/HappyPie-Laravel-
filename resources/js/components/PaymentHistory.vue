<template>
  <div class="card mb-3 p-20"></div>
</template>

<script>
export default {
  props: [],
  components: {},
  data() {
    return {};
  },
  methods: {
    getPayment() {
      axios
        .get("/api/payment/call")
        .then((response) => {
          console.log("성공");
          console.log(response.data);
          // console.log(response.data.next_redirect_pc_url);
          window.location.href = response.data.next_redirect_pc_url;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  created() {
    console.log("cart입니다");
    this.getCart();
    this.cartItemChanged();
  },
};
</script>
