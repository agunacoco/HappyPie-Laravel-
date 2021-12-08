<template>
  <div class="card my-2">
    <a @click="getMenuShow" :href="link">
      <div class="row g-0">
        <div class="col-md-4">
          <div @click="showOrderItem">
            <img
              :src="'/storage/images/' + menu.image"
              class="w-32"
              alt="no image"
            />
          </div>
        </div>
        <div class="col-md-6 mt-4">
          <p>{{ this.menu.menuK }}</p>
          <p>{{ this.menu.menuE }}</p>
        </div>
      </div>
    </a>
  </div>
</template>

<script>
export default {
  props: ["menu"],
  components: {},
  data() {
    return {
      itemShow: false,
      link: "/happypies/show/",
    };
  },
  methods: {
    showOrderItem() {},
    getMenuShow() {
      this.link = this.link + this.menu.id;
    },
  },
  created() {
    console.log(this.menu);
    console.log(this.menu.menuK);
  },
};
</script>
