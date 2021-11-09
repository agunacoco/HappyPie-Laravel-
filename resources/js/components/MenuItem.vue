<template>
  <div class="card" style="width: 18rem">
    <img
      :src="'/storage/images/' + menuitem.image"
      class="card-img-top"
      alt="..."
    />
    <div class="card-body">
      <p class="card-text">
        {{ menuitem.menuK }}
      </p>
      <p class="card-text">
        {{ menuitem.menuE }}
      </p>
    </div>
  </div>
</template>

<script>
export default {
  props: ["menuitem"],
  methods: {},
};
</script>