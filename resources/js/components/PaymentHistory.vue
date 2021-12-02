<template>
  <div class="card mb-3 p-20">
    <p>카카오페이 결제가 정상적으로 완료되었습니다.</p>
    <p>결제일시: {{ this.payInfo.approved_at }}</p>
    <p>상품명: {{ this.payInfo.item_name }}</p>
    <p>결제금액: {{ this.payInfo.amount.total }}</p>
  </div>
</template>

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
      axios
        .post("/happypies/payment/store", this.payInfo)
        .then((response) => {
          console.log("결제저장 성공");
          console.log(response.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  created() {
    console.log("payment history");
    var getCookie = function (name) {
      var value = document.cookie.match("(^|;) ?" + name + "=([^;]*)(;|$)");
      return value ? value[2] : null;
    };
    this.is_tid = getCookie("tid"); // tid 번호
    this.is_user_id = getCookie("user_id"); //partner_user_id
    this.is_order_id = getCookie("partner_order_id"); //partner_order_id

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
  },
};
</script>
