<template>
  <div class="m-4" v-if="menuitems.links.length > 3">
    <div class="flex flex-wrap -mb-1">
      <button
        @click="pageClicked(menuitems.next_page_url)"
        class="
          px-4
          py-3
          mb-1
          mr-1
          text-sm
          leading-4
          border
          bg-white-300
          rounded
          hover:bg-blue-300
          focus:border-indigo-500 focus:text-indigo-500
        "
      >
        다음
      </button>
      <button
        @click="pageClicked(menuitems.next_page_url)"
        class="
          px-4
          py-3
          mb-1
          mr-1
          text-sm
          leading-4
          border
          bg-white-300
          rounded
          hover:bg-blue-300
          focus:border-indigo-500 focus:text-indigo-500
        "
      >
        다음
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    menuitems: Array,
  },
  data() {
    return {};
  },
  methods: {
    pageClicked(url) {
      this.$emit("pageClicked", url);
    },
  },
};
</script>
