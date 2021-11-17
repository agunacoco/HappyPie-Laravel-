<template>
  <div class="row g-0 flex justify-center">
    <div class="col-md-4">
      <img
        v-bind:src="imagePreview"
        width="200"
        height="200"
        class="card-img-top"
      /><br />
      <input
        multiple
        type="file"
        name="image"
        class="form-control-file"
        id="image"
        @change="onFileChange"
      />
    </div>
    <div class="col-md-6">
      <div class="card-body">
        <div class="form-group">
          <label for="menuK">Menu(Korean)</label><br />
          <input
            type="text"
            name="menuK"
            class="card-title"
            id="menuK"
            v-model="menuK"
            required
          />
        </div>
        <div class="form-group">
          <label for="menuE">Menu(English)</label><br />
          <input
            type="text"
            name="menuE"
            class="card-title"
            id="menuE"
            v-model="menuE"
            required
          />
        </div>
        <div class="form-group">
          <label for="content">Content</label><br />
          <textarea
            style="
              white-space: pre-line;
              width: 100%;
              border: 1;
              overflow: visible;
              text-overflow: ellipsis;
            "
            rows="10"
            name="content"
            class="card-title"
            v-model="content"
            required
          ></textarea>
        </div>
        <div class="card-text">
          <label for="price">Price</label><br />
          <input
            type="text"
            name="price"
            class="card-title"
            id="price"
            v-model="price"
            required
          />
        </div>
        <br />
        <button @click="updatedMenu">수정하기</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["menu"],
  data() {
    return {
      image: "",
      menuK: this.menu.menuK,
      menuE: this.menu.menuE,
      content: this.menu.content,
      price: this.menu.price,
      imagePreview: "",
      checkedCategories: [],
    };
  },
  methods: {
    updatedMenu() {
      console.log("update");
      const formData = new FormData();
      formData.append("menuK", this.menuK);
      formData.append("menuE", this.menuE);
      formData.append("content", this.content);
      formData.append("price", this.price);
      formData.append("image", this.image);
      formData.append("_method", "PATCH");
      axios
        .post("/happypies/" + this.menu.id, formData)
        .then((response) => {
          console.log("update 성공");
          // this.image = "";
          const imageInput = document.querySelector("#image");
          imageInput.value = imageInput.defaultValue;
          this.imagePreview = "";
          Swal.fire({
            position: "top-center",
            icon: "success",
            title: "Menu 수정완료",
            showConfirmButton: false,
            timer: 1700,
          }).then((result) => {
            window.location.replace("/happypies/show/" + this.menu.id);
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
          this.imagePreview = reader.result;
        }.bind(this),
        false
      );
      if (this.image) {
        if (/\.(jpe?g|png|gif)$/i.test(this.image.name)) {
          console.log("showimage 성공");
          console.log(this.image);
          reader.readAsDataURL(this.image);
        }
      }
    },
  },
  created() {
    console.log("hah");
    this.imagePreview = "/storage/images/" + this.menu.image;
  },
};
</script>