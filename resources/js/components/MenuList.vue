<template>
  <div class="card mb-3 p-20">
    <div class="flex justify-between mb-3">
      <ul class="nav justify-content-center">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">All</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Cake</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Drink</a>
        </li>
      </ul>

      <form class="d-flex">
        <input
          class="form-control me-2"
          type="search"
          placeholder="Search"
          aria-label="Search"
        />
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
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
import MenuItem from "./MenuItem.vue";
import MenuCreate from "./MenuCreate.vue";
export default {
  components: { MenuItem, MenuCreate },
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
        .get("/happypies/index")
        .then((response) => {
          console.log("getMenu 성공");
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
