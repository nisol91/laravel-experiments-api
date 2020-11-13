<template>
  <div>
    <div class="text-uppercase font-weight-bold text-secondary">
      price breakdown
    </div>
    <div
      v-for="(days, price) in price.breakdown"
      :key="price"
      class="pt-2 pb-2 border-bottom border-top d-flex justify-content-between"
    >
      <span>{{ days }} x {{ price }}$,</span>
      <span>{{ days * price }}$</span>
    </div>
    <div class="text-break d-flex justify-content-between">
      <span>total:</span>
      <span>{{ price.total }}$</span>
    </div>
  </div>
</template>

<script>
export default {
  props: ["price"],
  data() {
    return {};
  },
  created() {
    //   console.log(this.price);
  },
  methods: {},
  computed: {},
};
</script>

<style scoped>
label {
  color: grey;
  font-weight: bolder;
}
.is-invalid {
  border-color: rgb(94, 59, 59);
  background-image: none;
}
.invalid-feedback {
  color: rgb(94, 59, 59);
}
</style>
