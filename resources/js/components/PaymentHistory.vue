<template>
  <div class="card mb-3 p-20">dd</div>
</template>

<script>
export default {
  props: ["paymentInfo"],
  components: {},
  data() {
    return {
      getPayList() {
        console.log(this.paymentInfo);
      },
    };
  },
  methods: {},
  created() {
    this.getPayList();
    // axios
    //   .get("/api/payment/success")
    //   .then((response) => {
    //     console.log("success성공");
    //     console.log(response.data);
    //     // window.location.href = response.data.next_redirect_pc_url;
    //   })
    //   .catch((error) => {
    //     console.log(error);
    //   });
  },
};
</script>
