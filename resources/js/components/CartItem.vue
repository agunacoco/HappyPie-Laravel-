<template>
  <div class="col my-4">
    <div class="card">
      <div class="row">
        <div class="col-md-5">
          <a>
            <img
              :src="'/storage/images/' + menu.image"
              class="card-img-top"
              alt="no image"
            />
          </a>
        </div>
        <div class="col-md-7">
          <div class="card-body">
            <h5 class="text-base font-bold card-title">
              {{ menu.menuK }}
            </h5>
            <p class="text-sm card-text">
              {{ menu.menuE }}
            </p>
            <p class="card-text">{{ menu.price }}원</p>

            <div class="flex">
              <button @click="clickCountMinus">-</button>
              <p>{{ unit }}</p>
              <button @click="clickCountPlus">+</button>
              <button class="ml-2" @click="deletedcart">삭제</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["menu"],
  data() {
    return {
      unit: 1,
    };
  },
  methods: {
    clickCountMinus() {
      this.unit--;
    },
    clickCountPlus() {
      this.unit++;
    },
    deletedcart() {
      if (confirm("Are you sure?")) {
        axios
          .delete("/happypies/cart/" + this.menu.id)
          .then((response) => {
            console.log(response.data);
            Swal.fire({
              position: "top-center",
              icon: "success",
              title: "장바구니 상품 빼기",
              showConfirmButton: false,
              timer: 1700,
            });
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
  },
  created() {
    console.log(this.menu);
  },
};
</script>
