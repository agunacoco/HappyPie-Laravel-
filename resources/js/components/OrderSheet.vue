<template>
  <div class="card mb-3 p-20">
    <div class="text-xl font-semibold">총 매출액: {{ total }}</div>
    <div class="text-xl font-semibold">오늘의 매출액: {{ todayTotal }}</div>
    <div class="row">
      <div class="col-4">
        <div v-show="!viewShow">
          <img
            :src="'/storage/images/noorder.png'"
            class="m-auto p-10"
            alt="no image"
          />
          <p class="text-3xl text-center">주문내역이 없습니다.</p>
        </div>
        <div v-show="viewShow">
          <sheet-item
            class="flex justify-center"
            v-for="payment in payments.data"
            :key="payment.id"
            :payment="payment"
            @receipted="receiptedSheet"
            ref="sheetitem"
          />
          <pagination-link
            @pageClicked="getPage($event)"
            v-if="payments.links != null"
            :links="payments.links"
          />
        </div>
      </div>
      <div class="col-8">
        <div class="card-body">
          <sheet-show
            v-if="payment"
            :payment="payment"
            @returnSheet="returnSheet"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PaginationLink from "./PaginationLink.vue";
import SheetItem from "./SheetItem.vue";
import SheetShow from "./SheetShow.vue";
export default {
  props: [],
  components: { PaginationLink, SheetItem, SheetShow },
  data() {
    return {
      payments: "",
      viewShow: false,
      showSheet: false,
      payment: "",
      total: "",
      todayDate: "",
      itemDate: "",
      todayItem: "",
      todayTotal: "",
    };
  },
  methods: {
    returnSheet(payments) {
      // this.payments = payments;
      this.getOrderSheet();
      // console.log(this.payments);
      this.payment = "";
    },
    receiptedSheet(payment) {
      this.payment = payment;
      // console.log(this.payment);
    },
    getPage(url) {
      console.log(url);
      axios
        .get(url)
        .then((response) => {
          // console.log(response.data);
          this.payments = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getOrderSheet() {
      axios
        .get("/happypies/ordersheet/list")
        .then((response) => {
          console.log(response.data);
          this.payments = response.data;
          if (this.payments.data.length == 0) {
            this.viewShow = false;
          } else {
            this.viewShow = true;
          }
          this.getTotal();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getTotal() {
      this.itemDate = "";
      this.todayItem = [];
      this.total = 0;
      this.todayTotal = 0;
      this.payments.data.forEach((payment) => {
        this.total += +payment.total;
        // console.log(payment.created_at);
        var date = payment.created_at.split("T");
        if (this.todayDate == date[0]) {
          this.todayItem.push(payment);
          this.todayTotal += +payment.total;
        }
      });
    },
  },
  created() {
    this.getOrderSheet();
    var today = new Date();
    var year = today.getFullYear();
    var month = ("0" + (today.getMonth() + 1)).slice(-2);
    var day = ("0" + today.getDate()).slice(-2);
    this.todayDate = year + "-" + month + "-" + day;
  },
};
</script>
