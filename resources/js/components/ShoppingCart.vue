<template>
  <div class="card mb-3 p-20">
    <div class="row row-cols-1 row-cols-sm-2 g-4">
      <div class="col-sm-8">
        <p class="text-3xl font-extrabold">장바구니</p>
        <div v-show="!showCart">
          <img
            :src="'/storage/images/nocart.png'"
            class="m-auto"
            alt="no image"
          />
          <p class="text-3xl text-center">텅비었습니다</p>
        </div>
        <div v-show="showCart">
          <cart-item
            v-for="cartItem in cartItems"
            :key="cartItem.id"
            :menu="cartItem"
            @itempay="getCart()"
          />
        </div>
      </div>
      <div class="col-sm-4">
        <div class="card-body">
          <p class="text-xl font-extrabold mb-3">주문내역</p>
          <div class="flex">
            <p>주문상품개수 : {{ this.quantity }}개</p>
          </div>
          <div class="flex">
            <p>배송비 : {{ shippingfee }}원</p>
          </div>
          <div class="flex">
            <p>상품금액 : {{ total }}원</p>
          </div>
          <div class="flex">
            <p>총 결제 금액 : {{ total + shippingfee }}원</p>
          </div>
          <button
            v-show="!showBtn"
            class="btn btn-outline-success w-full mt-1"
            @click="getAddressSet"
          >
            주문하기
          </button>
          <div v-show="showBtn">
            <p class="font-bold text-lg my-1">배달정보</p>
            <button class="btn btn-outline-info w-full my-1" @click="showApi">
              주소API 호출
            </button>
            <p>
              기본주소 : <span>{{ addr1 }}</span>
            </p>

            <p>
              우편번호 : <span>{{ zip }}</span>
            </p>
            <div>상세주소 :</div>
            <input
              type="text"
              name="add2"
              class="form-control"
              id="add2"
              v-model="addr2"
              style="font-size: 15px"
              required
            />
            <div>받으시는 분 :</div>
            <input
              type="text"
              name="reciver"
              class="form-control"
              id="reciver"
              v-model="receiver"
              style="font-size: 15px"
              required
            />
            <div>전화번호:</div>
            <input
              type="tel"
              name="phoneNum"
              class="form-control"
              id="phoneNum"
              v-model="phoneNum"
              style="font-size: 15px"
              required
            />

            <!-- <img alt="no image" class="max-w-full rounded-lg" src="{{  }}" /> -->
            <button
              v-show="showBtn"
              @click="postDelivery"
              type="button"
              class="w-full my-3"
            >
              <img
                :src="'/storage/images/payment_icon_yellow_medium.png'"
                class="m-auto"
                alt="no image"
              />
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
      showCart: false,
      cartItems: [],
      itemsId: [],
      itemsName: [],
      quantity: 0,
      shippingfee: 2500,
      total: 0,
      receiver: "",
      phoneNum: "",
      tototal: 0,
      showBtn: false,
      zip: "",
      addr1: "",
      addr2: "",
      paymentInfo: "",
      delivery: [],
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
          this.zip = data.zonecode;
          this.addr1 = fullRoadAddr;
        },
      }).open();
    },

    getAddressSet() {
      if (!this.showCart) {
        alert("상품을 담아주세요");
      } else {
        this.showBtn = true;
      }
    },

    postDelivery() {
      this.delivery = [];
      if (
        this.addr1 &&
        this.addr2 &&
        this.phoneNum &&
        this.zip &&
        this.receiver
      ) {
        this.setCookie("addr1", this.addr1, 1000);
        this.setCookie("addr2", this.addr2, 1000);
        this.setCookie("phoneNum", this.phoneNum, 1000);
        this.setCookie("zip", this.zip, 1000);
        this.setCookie("receiver", this.receiver, 1000);
        this.setCookie("directPayment", 0, 1000);
        this.getPayment();
      } else {
        alert("배달정보를 입력해주세요.");
        console.log(this.tototal);
      }
    },

    getPayment() {
      this.tototal = this.total + this.shippingfee;
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
            this.partner_order_id +
            "&quantity=" +
            this.quantity
        )
        .then((response) => {
          console.log("kakaopay 성공");
          this.paymentInfo = response.data;
          console.log(this.paymentInfo);
          this.setCookie("user_id", this.auth_user, 1000); // partner_user_id
          this.setCookie("partner_order_id", this.partner_order_id, 1000); // partner_order_id
          window.location.href = this.paymentInfo.next_redirect_pc_url;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    setCookie(name, value, exp) {
      var date = new Date();
      date.setTime(date.getTime() + exp * 24 * 60 * 60 * 1000);
      document.cookie =
        name + "=" + value + ";expires=" + date.toUTCString() + ";path=/";
    },

    getCart() {
      axios
        .get("/happypies/shoppingcart/list")
        .then((response) => {
          console.log("cart list 성공");
          this.cartItems = response.data;
          console.log(this.cartItems.length);
          if (this.cartItems.length) {
            this.showCart = true;
          } else {
            this.showCart = false;
          }
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
      this.quantity = 0;
      this.cartItems.forEach((cartItem) => {
        this.total += cartItem.price * cartItem.pivot.count;
        this.quantity += +cartItem.pivot.count;
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
    function generateRandomCode(n) {
      let str = "";
      for (let i = 0; i < n; i++) {
        str += Math.floor(Math.random() * 10);
      }
      return str;
    }
    this.partner_order_id = generateRandomCode(6);
    this.getCart();
    this.cartItemChanged();
  },
};
</script>
