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
          <button>주문하기</button>

          <button v-if="auth_user == 1" @click="deletedMenu">삭제하기</button>
          <button v-if="auth_user == 1" @click="getEdit">수정하기</button>
        </div>
      </div>
    </div>
    <menu-edit v-show="showEdit" :menu="menu" />
  </div>
</template>

<script>
import MenuEdit from "./MenuEdit.vue";
export default {
  components: { MenuEdit },
  props: ["menu", "auth_user"],
  data() {
    return {
      showEdit: false,
      viewShow: true,
    };
  },
  methods: {
    getCart() {
      Swal.fire({
        position: "top-center",
        icon: "success",
        title: "장바구니에 상품이 담겼습니다.",
        confirmButtonText: "장바구니 바로가기",
        showConfirmButton: true,
        timer: 1700,
      }).then((result) => {});
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
  },
  created() {
    this.showEdit = false;
    this.viewShow = true;
  },
};
</script>