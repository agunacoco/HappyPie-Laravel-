<template>
  <div class="card mb-3 p-20">
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
          // console.log(response.data);
          this.payments = response.data;
          if (this.payments.data.length == 0) {
            this.viewShow = false;
          } else {
            this.viewShow = true;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  created() {
    this.getOrderSheet();
  },
};
</script>
