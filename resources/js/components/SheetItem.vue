<template>
  <div class="card">
    <h5 class="card-header flex justify-between">
      <p class="font-bold text-lg">
        {{ this.paymentDate[0] }} {{ this.paymentDate[1] }}
        {{ this.status }}
      </p>
      <div
        v-if="
          this.payment.order_status == '주문준비중' ||
          this.payment.order_status == '주문확인'
        "
      >
        <button
          v-show="!status"
          type="button"
          class="btn btn-primary"
          @click="clickRecipt"
        >
          {{ this.btnStatus }}
        </button>
        <button
          v-show="status"
          type="button"
          class="btn btn-outline-primary"
          @click="patchStatus"
        >
          {{ this.btnStatus }}
        </button>
      </div>
      <button
        v-if="this.payment.order_status == '배송중'"
        @click="clickRecipt"
        type="button"
        class="btn btn-secondary"
      >
        {{ this.btnStatus }}
      </button>
    </h5>
    <div class="card-body p-3">
      <p class="font-medium text-base">{{ this.payment.item_name }}</p>
      <p>결제완료 {{ this.payment.total }}원</p>
      <p v-if="this.payment.delivery">
        {{ this.payment.delivery.addr1 }}
        {{ this.payment.delivery.addr2 }}
      </p>
    </div>
  </div>
</template>

<script>
export default {
  props: ["payment"],
  components: {},
  data() {
    return {
      paymentDate: [],
      status: "",
      btnStatus: "",
      showBtn: false,
      order_status: this.payment.order_status,
    };
  },
  methods: {
    clickRecipt() {
      this.$emit("receipted", this.payment);
    },
    getSheet() {
      console.log("getSheet");
      axios
        .get("/happypies/ordersheet/show" + this.payment.id)
        .then((response) => {
          // console.log(response.data);
          this.payment = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    patchStatus() {
      if (this.order_status == "주문확인") {
        this.status = "";
        this.btnStatus = "접수";

        axios
          .patch(
            "/happypies/ordersheet/status/" +
              this.payment.id +
              "?status=접수완료"
          )
          .then((response) => {
            console.log("접수dhjs");
            this.payment = response.data;
            console.log(response.data);
            this.$emit("receipted", this.payment);
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
  },
  created() {
    console.log(this.payment);
    this.paymentDate = this.payment.approved_at.split("T");
    if (this.order_status == "주문확인") {
      this.status = "요청";
      this.btnStatus = "접수";
    } else if (this.order_status == "주문준비중") {
      this.status = "";
      this.btnStatus = "접수";
    } else if (this.order_status == "배송중") {
      this.status = "";
      this.btnStatus = "완료";
      this.showBtn = true;
    }
  },
};
</script>
