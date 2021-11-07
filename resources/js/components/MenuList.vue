<template>
  <div class="card mb-3 p-10">
    <menu-item />
    <button @click="btnClicked">Menu Create</button>
    <div v-if="numClick == true" class="card mb-3 p-10"><menu-create /></div>
  </div>
</template>

<script>
import MenuItem from "./MenuItem.vue";
import MenuCreate from "./MenuCreate.vue";
export default {
  components: { MenuItem, MenuCreate },
  data() {
    return {
      numClick: false,
    };
  },
  methods: {
    btnClicked() {
      this.numClick = !this.numClick;
    },
  },
};
</script>
