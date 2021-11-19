<template>
  <div class="card mb-3 p-20">
    <div class="row row-cols-1 row-cols-sm-2 g-4">
      <div class="col-sm-8">
        <p class="text-2xl font-extrabold">장바구니</p>
        <cart-item v-for="menu in menus" :key="menu.id" :menu="menu" />
      </div>
      <div class="col-sm-4">
        <div class="card-body">
          <p class="text-xl font-extrabold">주문내역</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CartItem from "./CartItem.vue";
export default {
  props: ["menus", "auth_user"],
  components: { CartItem },
  data() {
    return {};
  },
  methods: {},
};
</script>
