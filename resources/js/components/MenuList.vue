<template>
  <div class="card mb-3 p-20">
    <menu-nav @clickCate="changeMenu" />
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
      <menu-item
        class="flex justify-center"
        v-for="(menuitem, index) in menuitems"
        :key="index"
        :menuitem="menuitem"
      />
    </div>

    <button v-if="auth_user == 1" @click="btnClicked">Menu Create</button>
    <div v-if="numClick == true" class="card mb-3 p-10"><menu-create /></div>
  </div>
</template>

<script>
import MenuItem from "./MenuItem";
import MenuCreate from "./MenuCreate";
import MenuNav from "./MenuNav";

export default {
  components: { MenuItem, MenuCreate, MenuNav },
  props: ["menus", "auth_user"],
  data() {
    return {
      numClick: false,
      menuitems: [],
      menuwriter: 1,
    };
  },
  methods: {
    btnClicked() {
      this.numClick = !this.numClick;
    },
    getMenu() {
      axios
        .get("/happypies/index?category=all")
        .then((response) => {
          console.log("getMenu 성공");
          this.menuitems = response.data;
          this.numClick = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    changeMenu(name) {
      this.menuitems = name;
    },
    pageClicked(url) {
      this.$emit("pageClicked", url);
    },
  },

  created() {
    // id를 모아 새로운 배열 만들고 새로 만든 배열을 userIdArray에 담는다.
    console.log("created 성공");
    this.getMenu();
  },
};
</script>
