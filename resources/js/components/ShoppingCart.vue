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
            <p>총 상품개수</p>
            <p>{{ itemsId.length }}개</p>
          </div>
          <div class="flex">
            <p>배송비</p>
            <p>{{ shippingfee }}원</p>
          </div>
          <div class="flex">
            <p>상품금액</p>
            <p>{{ total }}원</p>
          </div>
          <div class="flex">
            <p>총 결제 금액</p>
            <p>{{ total + shippingfee }}원</p>
          </div>
          <button @click="getAddressSet">결제하기</button>
          <button
            v-show="showBtn"
            @click="getPayment"
            type="button"
            class="btn btn-outline-success w-full"
          >
            결제하기
          </button>

          <div>
            <h1>
              우편번호: <span>{{ zip }}</span>
            </h1>
            <h1>
              기본주소: <span>{{ addr1 }}</span>
            </h1>
            <h1>
              상세주소: <span>{{ addr2 }}</span>
            </h1>
            <div ref="embed"></div>
            <button class="btn btn-outline-success w-full" @click="showApi">
              주소API 호출
            </button>
          </div>
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
      itemsId: [],
      shippingfee: 2500,
      total: 0,
      showBtn: false,
      zip: "",
      addr1: "",
      addr2: "",
    };
  },
  methods: {
    showApi() {
      new window.daum.Postcode({
        oncomplete: (data) => {
          let fullRoadAddr = data.roadAddress;
          let extraRoadAddr = "";
          if (data.bname !== "" && /[동|로|가]$/g.test(data.bname)) {
            extraRoadAddr += data.bname;
          }
          if (data.buildingName !== "" && data.apartment === "Y") {
            extraRoadAddr +=
              extraRoadAddr !== ""
                ? ", " + data.buildingName
                : data.buildingName;
          }
          if (extraRoadAddr !== "") {
            extraRoadAddr = " (" + extraRoadAddr + ")";
          }
          if (fullRoadAddr !== "") {
            fullRoadAddr += extraRoadAddr;
          }
          this.zip = data.zonecode; //5자리 새우편번호 사용
          this.addr1 = fullRoadAddr;
        },
      }).embed(this.$refs.embed);
    },

    getAddressSet() {
      this.showBtn = true;
    },

    getPayment() {
      axios
        .get("/api/payment/call")
        .then((response) => {
          console.log("kakaopay 성공");
          window.location.href = response.data.next_redirect_pc_url;
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
          this.itemId();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    cartItemChanged() {
      this.total = 0;
      this.itemsCount = 0;
      this.cartItems.forEach((cartItem) => {
        this.total += cartItem.price * cartItem.pivot.count;
      });
    },
    itemId() {
      this.itemsId = [];
      this.cartItems.forEach((cartItem) => {
        this.itemsId.push(cartItem.id);
      });
      console.log(this.itemsId);
    },
  },
  created() {
    console.log("cart입니다");
    this.getCart();
    this.cartItemChanged();
  },
};
</script>
