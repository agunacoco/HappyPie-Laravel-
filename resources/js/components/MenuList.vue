<template>
  <div class="card mb-3 p-10">
    <menu-item
      v-for="(menuitem, index) in menuitems"
      :key="index"
      :menuitem="menuitem"
    />
    <button @click="btnClicked">Menu Create</button>
    <div v-if="numClick == true" class="card mb-3 p-10"><menu-create /></div>
  </div>
</template>

<script>
import MenuItem from "./MenuItem.vue";
import MenuCreate from "./MenuCreate.vue";
export default {
  components: { MenuItem, MenuCreate },
  props: ["menus"],
  data() {
    return {
      numClick: false,
      menuitems: [],
    };
  },
  methods: {
    btnClicked() {
      this.numClick = !this.numClick;
    },
    getMenu() {
      axios
        .get("/happypies/index")
        .then((response) => {
          console.log("getMenu 성공");
          console.log(response.data);
          this.menuitems = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  created() {
    // id를 모아 새로운 배열 만들고 새로 만든 배열을 userIdArray에 담는다.
    console.log("created 성공");
    this.getMenu();
  },
};
</script>
