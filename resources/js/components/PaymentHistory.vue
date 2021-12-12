<template></template>

<script>
export default {
  props: [],
  components: {},
  data() {
    return {
      is_user_id: "",
      is_tid: "",
      is_order_id: "",
      token: "",
      payInfo: "",
      payInfoSave: "",
      db_order_id: "",
      addr1: "",
      addr2: "",
      phoneNum: "",
      receiver: "",
      zip: "",
      directPayment: "",
    };
  },
  methods: {
    getPayList() {
      axios
        .get(
          "/api/payment/success?tid=" +
            this.is_tid +
            "&pg_token=" +
            this.token +
            "&user_id=" +
            this.is_user_id +
            "&order_id=" +
            this.is_order_id
        )
        .then((response) => {
          console.log("결제정보 성공");
          this.payInfo = response.data;
          this.postPayInfo();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    postPayInfo() {
      this.receiver = this.getCookie("receiver");
      this.addr1 = this.getCookie("addr1");
      this.addr2 = this.getCookie("addr2");
      this.zip = this.getCookie("zip");
      this.phoneNum = this.getCookie("phoneNum");
      this.directPayment = this.getCookie("directPayment");
      this.payInfo.addr1 = this.addr1;
      this.payInfo.addr2 = this.addr2;
      this.payInfo.receiver = this.receiver;
      this.payInfo.zip = this.zip;
      this.payInfo.phoneNum = this.phoneNum;
      if (this.directPayment == 1) {
        this.payInfo.directPayment = this.directPayment;
      }
      axios
        .post("/happypies/payment/store", this.payInfo)
        .then((response) => {
          console.log("결제저장 성공");
          console.log(response.data);
          this.payInfoSave = response.data;
          this.setCookie("db_order_id", this.payInfoSave.id, 1000);
          this.db_order_id = this.getCookie("db_order_id");
          window.location.href = "/happypies/receipt/" + this.db_order_id;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    destroyCart() {
      axios
        .delete("/happypies/cart/destroy")
        .then((response) => {
          console.log("Cart 삭제 성공");
          console.log(response.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    setCookie(name, value, exp) {
      var date = new Date();
      date.setTime(date.getTime() + exp * 24 * 60 * 60 * 1000);
      document.cookie =
        name + "=" + value + ";expires=" + date.toUTCString() + ";path=/";
    },
    getCookie(name) {
      var value = document.cookie.match("(^|;) ?" + name + "=([^;]*)(;|$)");
      return value ? value[2] : null;
    },
    deleteCookie(name) {
      document.cookie = name + "=; expires=Thu, 01 Jan 1999 00:00:10 GMT;";
    },
  },
  created() {
    this.is_tid = this.getCookie("tid"); // tid 번호
    this.is_user_id = this.getCookie("user_id"); //partner_user_id
    this.is_order_id = this.getCookie("partner_order_id"); //partner_order_id
    this.db_order_id = this.getCookie("db_order_id");

    function getParameterByName(name) {
      name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
      var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
      return results == null
        ? ""
        : decodeURIComponent(results[1].replace(/\+/g, " "));
    }
    this.token = getParameterByName("pg_token"); // token 번호

    this.getPayList();

    // if (this.db_order_id) {
    //   console.log(this.db_order_id);
    //   window.location.href = "/happypies/receipt/" + this.db_order_id;
    // }
  },
};
</script>
