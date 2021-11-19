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
            <button>-</button>
            <button>개수</button>
            <button>+</button>
            <button>삭제</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["menu"],
  created() {
    console.log(this.menu);
  },
};
</script>
