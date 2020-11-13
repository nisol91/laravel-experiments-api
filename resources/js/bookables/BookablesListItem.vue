<template>
  <div class="listItem">
    <div class="text-white listItemCard">
      <div class="card-body">
        <router-link class="linkBookable" :to="{name: 'bookable', params: {id: id}}">
          <h4 class="card-title">{{title}}</h4>
        </router-link>

        <p class="card-text small">{{description}}</p>
        <!-- <p class="card-text">{{price}}</p> -->
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: { title: String, description: String, id: Number },
  data() {
    return {
      titoloReactive: this.title,
    };
  },
  mounted() {
    // console.log(`titoloReactive--->${this.titoloReactive}`);
  },
};
</script>

<style lang="css" scoped>
.listItem {
  margin: 1%;
  width: 23%;
}
.listItemCard {
  height: 300px;
  background: rgb(80, 77, 77);
}
.linkBookable {
  color: white;
}
</style>
