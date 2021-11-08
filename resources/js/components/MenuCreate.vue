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
      />
    </div>

    <div class="form-group">
      <label for="content">Content</label>
      <textarea
        name="content"
        class="form-control"
        v-model="content"
        placeholder="content"
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
      />
    </div>

    <div class="form-group">
      <img
        v-bind:src="imagePreview"
        width="100"
        height="100"
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
      image: null,
      menuK: null,
      menuE: null,
      content: null,
      price: null,
      imagePreview: null,
      showPreview: false,
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
      axios
        .post("/happypies/store", formData)
        .then((response) => {
          console.log("성공");
          this.menuK = "";
          this.menuE = "";
          this.content = "";
          this.price = "";
          // this.image = "";
          const imageInput = document.querySelector("#image");
          imageInput.value = imageInput.defaultValue;
          this.imagePreview = null;
          this.showPreview = false;
          this.$parent.getMenu();
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
          console.log("here");
          reader.readAsDataURL(this.image);
        }
      } else {
        this.showPreview = false;
      }
    },
  },
};
</script>
