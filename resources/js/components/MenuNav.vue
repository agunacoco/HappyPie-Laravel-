<template>
  <div class="flex justify-between mb-3">
    <ul class="nav justify-content-center">
      <li class="nav-item">
        <button @click="clickedAll" class="nav-link active">All</button>
      </li>
      <li class="nav-item">
        <button @click="clickedPie" class="nav-link active">Cookies/Pie</button>
      </li>
      <li class="nav-item">
        <button @click="clickedCake" class="nav-link active">Cake</button>
      </li>
      <li class="nav-item">
        <button @click="clickedDrink" class="nav-link active">Drink</button>
      </li>
    </ul>

    <form @submit.prevent="clickedSearch" class="d-flex">
      <input
        v-model="searchContent"
        class="form-control me-2"
        type="search"
        placeholder="Search"
        aria-label="Search"
      />
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchContent: "",
    };
  },
  methods: {
    clickedSearch() {
      axios
        .get("/happypies/index?search=" + this.searchContent.trim())
        .then((response) => {
          console.log("search 성공");
          this.menus = response.data;
          this.$emit("clickCate", this.menus);
        })
        .catch((error) => {
          console.log(error);
        });
    },

    clickedAll() {
      axios
        .get("/happypies/index?category=all")
        .then((response) => {
          console.log("all 성공");
          this.menus = response.data;
          this.$emit("clickCate", this.menus);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    clickedPie() {
      axios
        .get("/happypies/index?category=cookiepie")
        .then((response) => {
          console.log("pie 성공");
          this.menus = response.data;
          this.$emit("clickCate", this.menus);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    clickedCake() {
      axios
        .get("/happypies/index?category=cake")
        .then((response) => {
          console.log("cake 성공");
          this.menus = response.data;
          this.$emit("clickCate", this.menus);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    clickedDrink() {
      axios
        .get("/happypies/index?category=drink")
        .then((response) => {
          console.log("drink 성공");
          this.menus = response.data;
          this.$emit("clickCate", this.menus);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
