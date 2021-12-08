<template>
  <div class="card mb-3 p-20">
    <div v-show="!viewShow">
      <img
        :src="'/storage/images/noorder.png'"
        class="m-auto p-10"
        alt="no image"
      />
      <p class="text-3xl text-center">주문내역이 없습니다.</p>
    </div>
    <div v-show="viewShow">
      <order-item
        class="flex justify-center"
        v-for="payment in payments.data"
        :key="payment.id"
        :payment="payment"
        :user="user"
      />
      <pagination-link
        @pageClicked="getPage($event)"
        v-if="payments.links != null"
        :links="payments.links"
      />
    </div>
  </div>
</template>

<script>
import OrderItem from "./OrderItem.vue";
import PaginationLink from "./PaginationLink.vue";
export default {
  props: ["user"],
  components: { OrderItem, PaginationLink },
  data() {
    return {
      payments: [],
      viewShow: false,
    };
  },
  methods: {
    getPage(url) {
      console.log(url);
      axios
        .get(url)
        .then((response) => {
          console.log(response.data);
          this.payments = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getPayment() {
      axios
        .get("/happypies/orderlist/index")
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
    this.getPayment();
  },
};
</script>
