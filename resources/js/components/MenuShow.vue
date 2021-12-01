<template>
  <div class="card mb-3 p-20">
    <div v-show="viewShow" class="row g-0 flex justify-center">
      <div class="col-md-6">
        <img
          :src="'/storage/images/' + menu.image"
          class="card-img-top"
          alt="no image"
        />
      </div>
      <div class="col-md-6">
        <div class="card-body">
          <h5 class="card-title">{{ menu.menuK }}</h5>
          <h5 class="card-title">{{ menu.menuE }}</h5>
          <p class="card-text">
            {{ menu.content }}
          </p>
          <p class="card-text">
            <small class="text-muted">{{ menu.price }}</small>
          </p>
          <button @click="getCart">장바구니 담기</button>
          <button @click="getPayment">주문하기</button>

          <button v-if="auth_user == 1" @click="deletedMenu">삭제하기</button>
          <button v-if="auth_user == 1" @click="getEdit">수정하기</button>
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
      showEdit: false,
      viewShow: true,
      userIdArray: [], // menu를 장바구니에 담은 사용자ID
      cart: false,
    };
  },
  methods: {
    getPayment() {
      if (this.auth_user) {
        if (this.cart) {
          axios
            .patch("/happypies/cart/count/" + this.menu.id + "/?count=plus")
            .then((response) => {
              console.log("장바구니 개수++");
              axios
                .get("/api/payment/call")
                .then((response) => {
                  console.log("kakaopay 성공");
                  window.location.href = response.data.next_redirect_pc_url;
                })
                .catch((error) => {
                  console.log(error);
                });
            })
            .catch((error) => {
              console.log(error);
            });
        } else {
          axios
            .post("/happypies/cart/store/" + this.menu.id)
            .then((response) => {
              this.userIdArray.push(response.data.id);
              this.checkLikes();
              axios
                .get("/api/payment/call")
                .then((response) => {
                  console.log("kakaopay 성공");
                  window.location.href = response.data.next_redirect_pc_url;
                })
                .catch((error) => {
                  console.log(error);
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
  },
  created() {
    this.showEdit = false;
    this.viewShow = true;
    this.userIdArray = this.menu.users.map((elem) => {
      return elem.id;
    });
    console.log(this.userIdArray);
    this.checkLikes();
  },
};
</script>