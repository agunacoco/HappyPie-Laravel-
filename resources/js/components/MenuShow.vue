<template>
  <div class="card mb-3 p-14">
    <div class="row g-0 flex justify-center">
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
          <button>장바구니 담기</button>
          <button>주문하기</button>
          <button @click="deleteMenu">삭제하기</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["menu"],
  methods: {
    deleteMenu() {
      if (confirm("Are you sure?")) {
        axios
          .delete("/happypies/" + this.menu.id)
          .then((response) => {
            console.log(response.data);
            this.$parent.getMenu;
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
  },
};
</script>