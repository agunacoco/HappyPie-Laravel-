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

          <div v-show="showBtn" class="">
            <h1>
              우편번호: <span>{{ zip }}</span>
            </h1>
            <h1>
              기본주소: <span>{{ addr1 }}</span>
            </h1>
            <div>상세주소: <input v-model="addr2" /></div>
            <button class="btn btn-outline-success w-full" @click="showApi">
              주소API 호출
            </button>
            <button
              v-show="showBtn"
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
  </div>
</template>

<script>
import Input from "../../../vendor/laravel/breeze/stubs/inertia-vue/resources/js/Components/Input.vue";
import CartItem from "./CartItem.vue";
export default {
  props: ["menus", "auth_user"],
  components: { CartItem, Input },
  data() {
    return {
      cartItems: [],
      itemsId: [],
      itemsName: [],
      shippingfee: 2500,
      total: 0,
      tototal: 0,
      showBtn: false,
      zip: "",
      addr1: "",
      addr2: "",
      paymentInfo: "",
      partner_order_id: 0,
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
      }).open();
    },

    getAddressSet() {
      this.showBtn = true;
    },

    getPayment() {
      this.tototal = this.total + this.shippingfee;
      function generateRandomCode(n) {
        let str = "";
        for (let i = 0; i < n; i++) {
          str += Math.floor(Math.random() * 10);
        }
        return str;
      }
      this.partner_order_id = generateRandomCode(6);
      axios
        .get(
          "/api/payment/call?itemsId=" +
            this.itemsId +
            "&total_amount=" +
            this.tototal +
            "&user_id=" +
            this.auth_user +
            "&itemsName=" +
            this.itemsName +
            "&partner_order_id=" +
            this.partner_order_id
        )
        .then((response) => {
          console.log("kakaopay 성공");
          this.paymentInfo = response.data;
          console.log(this.paymentInfo);
          var setCookie = function (name, value, exp) {
            var date = new Date();
            date.setTime(date.getTime() + exp * 24 * 60 * 60 * 1000);
            document.cookie =
              name + "=" + value + ";expires=" + date.toUTCString() + ";path=/";
          };
          setCookie("user_id", this.auth_user, 1000); // partner_user_id
          setCookie("partner_order_id", this.partner_order_id, 1000); // partner_order_id
          window.location.href = this.paymentInfo.next_redirect_pc_url;
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
      this.itemsName = [];
      this.cartItems.forEach((cartItem) => {
        this.itemsName.push(cartItem.menuK);
        this.itemsId.push(cartItem.id);
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
