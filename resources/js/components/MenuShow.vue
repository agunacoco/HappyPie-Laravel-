<template>
  <div class="card mb-3 p-20">
    <div v-show="viewShow" class="row g-0 flex justify-center">
      <div class="col-md-5">
        <img
          :src="'/storage/images/' + menu.image"
          class="card-img-top"
          alt="no image"
        />
      </div>
      <div class="col-md-6">
        <div class="card-body">
          <div v-show="!showOrder">
            <h5 class="card-title">{{ menu.menuK }}</h5>
            <div class="flex justify-between">
              <h5 class="card-title">{{ menu.menuE }}</h5>
              <p class="card-text">{{ menu.price }}원</p>
            </div>
            <p class="card-text">
              {{ menu.content }}
            </p>
          </div>
          <div v-show="showBtn">
            <button v-show="!showOrder" @click="getCart">장바구니 담기</button>
            <button v-show="!showOrder" @click="getOrdered">주문하기</button>
            <div v-show="showOrder" class="card">
              <h5 class="card-header">주문하기</h5>
              <div class="p-3">
                <div class="flex justify-between">
                  <p class="">주문금액 : {{ menu.price * unit }}</p>
                  <div class="flex">
                    <button @click="unit--" v-show="this.unit > 1">-</button>
                    <p>{{ unit }}</p>
                    <button @click="unit++">+</button>
                  </div>
                </div>
                <div class="flex">
                  <p>주문개수 : {{ unit }}개</p>
                </div>
                <div class="flex">
                  <p>배송비 : {{ shippingfee }}원</p>
                </div>
                <div class="flex font-semibold">
                  <p>총 결제금액 : {{ menu.price * unit + shippingfee }}원</p>
                </div>
                <p class="font-bold text-lg my-1">배달정보</p>
                <button
                  class="btn btn-outline-info w-full my-1"
                  @click="showApi"
                >
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

                <button
                  class="btn btn-outline-success w-full my-3"
                  @click="postDelivery"
                >
                  결제하기
                </button>
                <div class="flex" @click="onClickBack">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-chevron-double-left"
                    viewBox="0 0 16 16"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"
                    />
                    <path
                      fill-rule="evenodd"
                      d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"
                    />
                  </svg>
                  <p>주문취소</p>
                </div>
              </div>
            </div>
          </div>
          <div v-show="!showBtn">
            <button v-if="auth_user == 1" @click="deletedMenu">삭제하기</button>
            <button v-if="auth_user == 1" @click="getEdit">수정하기</button>
          </div>
        </div>
      </div>
    </div>
    <menu-edit v-show="showEdit" :menu="menu" :categories="categories" />
  </div>
</template>

<script>
import MenuEdit from "./MenuEdit.vue";
export default {
  components: { MenuEdit },
  props: ["menu", "auth_user", "categories"],
  data() {
    return {
      unit: 1,
      showEdit: false,
      viewShow: true,
      showOrder: false,
      showBtn: false,
      userIdArray: [], // menu를 장바구니에 담은 사용자ID
      cart: false,
      zip: "",
      receiver: "",
      addr1: "",
      addr2: "",
      phoneNum: "",
      shippingfee: 2500,
      total: 0,
      partner_order_id: "",
      paymentInfo: "",
    };
  },
  methods: {
    onClickBack() {
      this.showOrder = false;
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
        this.getPayment();
      } else {
        alert("배달정보를 입력해주세요.");
        console.log(this.tototal);
      }
    },
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
    getPayment() {
      this.total = this.menu.price * this.unit + this.shippingfee;
      axios
        .get(
          "/api/payment/call?itemsId=" +
            this.menu.id +
            "&total_amount=" +
            this.total +
            "&user_id=" +
            this.auth_user +
            "&itemsName=" +
            this.menu.menuK +
            "&partner_order_id=" +
            this.partner_order_id +
            "&quantity=" +
            this.unit
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
    getOrdered() {
      if (this.auth_user) {
        this.showOrder = true;
      } else {
        Swal.fire({
          position: "top-center",
          icon: "success",
          title: "로그인을 해주세요",
          confirmButtonText: "로그인 바로가기",
          showConfirmButton: true,
          timer: 3000,
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "/login";
          }
        });
      }
    },

    getCart() {
      if (this.auth_user) {
        if (this.cart) {
          Swal.fire({
            position: "top-center",
            icon: "success",
            title: "이미 장바구니에 담겨있습니다.",
            confirmButtonText: "장바구니 바로가기",
            showConfirmButton: true,
            timer: 1700,
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.replace("/happypies/shoppingcart");
            }
          });
        } else {
          axios
            .post("/happypies/cart/store/" + this.menu.id)
            .then((response) => {
              console.log("장바구니");
              this.userIdArray.push(response.data.id);
              this.checkLikes();
              Swal.fire({
                position: "top-center",
                icon: "success",
                title: "장바구니에 상품이 담겼습니다.",
                confirmButtonText: "장바구니 바로가기",
                showConfirmButton: true,
                timer: 1700,
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location.replace("/happypies/shoppingcart");
                }
              });
            })
            .catch((error) => {
              console.log(error);
            });
        }
      } else {
        Swal.fire({
          position: "top-center",
          icon: "success",
          title: "로그인을 해주세요",
          confirmButtonText: "로그인 바로가기",
          showConfirmButton: true,
          timer: 3000,
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "/login";
          }
        });
      }
    },

    deletedMenu() {
      if (confirm("Are you sure?")) {
        axios
          .delete("/happypies/" + this.menu.id)
          .then((response) => {
            console.log(response.data);
            Swal.fire({
              position: "top-center",
              icon: "success",
              title: "삭제 완료",
              showConfirmButton: false,
              timer: 1700,
            }).then((result) => {
              window.location.replace("/happypies/menu");
            });
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },

    getEdit() {
      this.showEdit = true;
      this.viewShow = false;
    },

    checkLikes() {
      this.cart = this.userIdArray.includes(this.auth_user);
    },

    setCookie(name, value, exp) {
      var date = new Date();
      date.setTime(date.getTime() + exp * 24 * 60 * 60 * 1000);
      document.cookie =
        name + "=" + value + ";expires=" + date.toUTCString() + ";path=/";
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
    this.showEdit = false;
    this.viewShow = true;
    if (this.auth_user == 1) {
      this.showBtn = false;
    } else {
      this.showBtn = true;
    }
    this.userIdArray = this.menu.users.map((elem) => {
      return elem.id;
    });
    this.checkLikes();
  },
};
</script>