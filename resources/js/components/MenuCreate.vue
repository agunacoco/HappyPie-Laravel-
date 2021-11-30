<template>
  <form @submit.prevent="postMenus">
    <div class="form-group">
      <label for="menuK">Menu(Korean)</label>
      <input
        type="text"
        name="menuK"
        class="form-control"
        id="menuK"
        placeholder="Menu Name"
        v-model="menuK"
        required
      />
    </div>
    <div class="form-group">
      <label for="menuE">Menu(English)</label>
      <input
        type="text"
        name="menuE"
        class="form-control"
        id="menuE"
        placeholder="Menu Name"
        v-model="menuE"
        required
      />
    </div>

    <div class="form-group">
      <label for="content">Content</label>
      <textarea
        name="content"
        class="form-control"
        v-model="content"
        placeholder="content"
        required
      ></textarea>
    </div>

    <div class="form-group">
      <label for="price">Price</label>
      <input
        type="text"
        name="price"
        class="form-control"
        id="price"
        placeholder="Price"
        v-model="price"
        required
      />
    </div>
    <div class="form-group">
      <label>Category</label>
      <div class="flex">
        <div class="form-check">
          <input
            v-model="checkedCategories"
            value="cake"
            class="form-check-input"
            type="checkbox"
            id="cake"
          />
          <label for="cake">Cake</label>
        </div>
        <div class="form-check ml-2">
          <input
            v-model="checkedCategories"
            value="desserts"
            class="form-check-input"
            type="checkbox"
            id="desserts"
          />
          <label for="desserts">Cookies/Pie</label>
        </div>
        <div class="form-check ml-2">
          <input
            v-model="checkedCategories"
            value="drink"
            class="form-check-input"
            type="checkbox"
            id="drink"
          />
          <label for="drink">Drink</label>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="images">Picture</label>
      <input
        multiple
        type="file"
        name="images[]"
        class="form-control-file"
        id="images"
        required
      />
    </div>
    <div class="form-group">
      <label for="image">Picture</label>
      <input
        multiple
        type="file"
        name="image"
        class="form-control-file"
        id="image"
        @change="onFileChange"
        required
      />
    </div>

    <div class="form-group">
      <img
        v-bind:src="imagePreview"
        width="200"
        height="200"
        v-show="showPreview"
      />
    </div>

    <div class="form-group">
      <input type="submit" class="btn btn-success" />
    </div>
  </form>
</template>
<script>
export default {
  data() {
    return {
      image: "",
      menuK: "",
      menuE: "",
      content: "",
      price: "",
      imagePreview: "",
      showPreview: false,
      checkedCategories: [],
    };
  },
  methods: {
    postMenus() {
      const formData = new FormData();
      formData.append("menuK", this.menuK);
      formData.append("menuE", this.menuE);
      formData.append("content", this.content);
      formData.append("price", this.price);
      formData.append("image", this.image);
      formData.append("categories", this.checkedCategories);
      axios
        .post("/happypies/store", formData)
        .then((response) => {
          console.log("이미지 미리보기 성공");
          this.menuK = "";
          this.menuE = "";
          this.content = "";
          this.price = "";
          this.checkedCategories = [];
          // this.image = "";
          const imageInput = document.querySelector("#image");
          imageInput.value = imageInput.defaultValue;
          this.imagePreview = null;
          this.showPreview = false;
          Swal.fire({
            position: "top-center",
            icon: "success",
            title: "Menu 작성완료",
            showConfirmButton: false,
            timer: 1700,
          }).then((result) => {
            this.$parent.getMenu();
            window.scrollTo(0, 0);
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },

    onFileChange(e) {
      this.image = e.target.files[0];

      let reader = new FileReader();
      reader.addEventListener(
        "load",
        function () {
          this.showPreview = true;
          this.imagePreview = reader.result;
        }.bind(this),
        false
      );
      if (this.image) {
        if (/\.(jpe?g|png|gif)$/i.test(this.image.name)) {
          console.log("showimage 성공");
          reader.readAsDataURL(this.image);
        }
      } else {
        this.showPreview = false;
      }
    },
  },
};
</script>
