<template>
  <div>
    <div class="flex justify-center">
      <div class="row">
        <div class="col">
          <label for="image" class="form-label">File</label>
          <input
            type="file"
            class="form-control"
            name="image"
            id="image"
            rows="3"
          />
        </div>
        <div class="col-md-7">
          <div class="card-body mt-3">
            <label for="menuK" class="form-label">Menu Name(Korean)</label
            ><br />
            <input
              name="menuK"
              id="menuK"
              class="text-lg font-semibold"
              placeholder="menu name"
            /><br /><br />
            <label for="menuE" class="form-label">Menu Name(English)</label
            ><br />
            <input
              name="menuE"
              id="menuE"
              class="text-lg font-semibold"
              placeholder="menu name"
            />
            <br /><br />
            <label for="content" class="form-label">Content</label><br />
            <textarea
              name="content"
              id="content"
              placeholder="content"
              class="text-lg leading-relaxed text-blueGray-500"
            >
            </textarea>
          </div>
        </div>
      </div>
    </div>
    <div class="flex justify-center">
      <button @click="postMenus">Submit</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      image: null,
      menuK: "",
      menuE: "",
      content: "",
    };
  },
  methods: {
    postMenus() {
      axios.post("/happypie/store", {
        content: this.content,
        menuK: this.menuK,
        menuE: this.menuE,
        image: this.image,
      });
    },
  },
};
</script>
