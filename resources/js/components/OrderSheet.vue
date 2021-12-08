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
      <sheet-item
        class="flex justify-center"
        v-for="orderSheet in orderSheets.data"
        :key="orderSheet.id"
        :sheet="orderSheet"
      />
      <pagination-link
        @pageClicked="getPage($event)"
        v-if="orderSheets.links != null"
        :links="orderSheets.links"
      />
    </div>
  </div>
</template>

<script>
import PaginationLink from "./PaginationLink.vue";
export default {
  props: [],
  components: { PaginationLink },
  data() {
    return {
      orderSheets: "",
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
    getOrderSheet() {
      axios
        .get("/happypies/ordersheet/list")
        .then((response) => {
          console.log(response.data);
          this.orderSheets = response.data;
          if (this.orderSheets.data.length == 0) {
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
