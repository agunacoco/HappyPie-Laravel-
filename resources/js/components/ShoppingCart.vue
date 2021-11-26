<template>
  <div class="card mb-3 p-20">
    <div class="row row-cols-1 row-cols-sm-2 g-4">
      <div class="col-sm-8">
        <p class="text-2xl font-extrabold">장바구니</p>
        <cart-item
          v-for="cartItem in cartItems"
          :key="cartItem.id"
          :menu="cartItem"
          @itempay="getCart()"
        />
      </div>
      <div class="col-sm-4">
        <div class="card-body">
          <p class="text-xl font-extrabold">주문내역</p>
          <div class="flex">
            <p>총 상품금액</p>
            <p>{{ total }}</p>
          </div>
          <button
            @click="getPayment"
            type="button"
            class="btn btn-outline-success w-full"
          >
            결제하기
          </button>
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
    return {
      cartItems: [],
      payItems: [],
      total: 0,
    };
  },
  methods: {
    // getTotalMoney(menu) {
    //   console.log("pay");
    //   this.payItems.push(menu.price * menu.pivot.count);
    //   this.total = this.payItems.reduce(function add(sum, currValue) {
    //     return sum + currValue;
    //   }, 0);
    //   console.log(this.total);
    // },
    getPayment() {
      const headers = {
        "Content-type": "application/x-www-form-urlencoded;charset=utf-8",
        Authorization: "KakaoAK 2aec59941467f41efd86c2720cdb0c0b",
      };
      const params = new URLSearchParams();
      params.append("cid", "TC0ONETIME");
      params.append("partner_order_id", "partner_order_id");
      params.append("partner_user_id", "partner_user_id");
      params.append("item_name", "테스트 상품");
      params.append("quantity", "1");
      params.append("total_amount", "110");
      params.append("tax_free_amount", "0");
      params.append("vat_amount", "10");
      params.append("approval_url", "http://localhost:8080/");
      params.append("fail_url", "http://localhost:8080/");
      params.append("cancel_url", "http://localhost:8080/");
      axios
        .post("https://kapi.kakao.com/v1/payment/ready", params, headers)
        .then((response) => {
          console.log(response.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getCart() {
      axios
        .get("/happypies/shoppingcart/list")
        .then((response) => {
          console.log("cart list 성공");
          this.cartItems = response.data;
          this.cartItemChanged();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    cartItemChanged() {
      this.total = 0;
      this.cartItems.forEach((cartItem) => {
        this.total += cartItem.price * cartItem.pivot.count;
        console.log(cartItem.pivot.count);
        console.log(this.total);
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
