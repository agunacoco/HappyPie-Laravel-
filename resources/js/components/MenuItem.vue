<template>
  <div class="col my-3">
    <div class="card" style="width: 20rem">
      <a @click="getMenuShow" :href="link">
        <img
          :src="'/storage/images/' + menuitem.image"
          class="card-img-top"
          alt="no image"
        />
      </a>
      <div class="card-body">
        <a>
          <div class="flex justify-center">
            <h5 class="text-base font-bold card-title flex justify-center">
              {{ menuitem.menuK }}
            </h5>
            <p class="text-sm card-text flex justify-center ml-1">
              {{ menuitem.menuE }}
            </p>
          </div>
        </a>
        <p class="card-text flex justify-center">{{ menuitem.price }}원</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["menuitem"],
  data() {
    return {
      link: "/happypies/show/",
    };
  },
  methods: {
    getMenuShow() {
      this.link = this.link + this.menuitem.id;
    },
  },
};
</script>