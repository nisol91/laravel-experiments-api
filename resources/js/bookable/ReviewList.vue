<template>
  <div>
    <h6 class="reviewTitle text-uppercase">review list</h6>
    <div v-if="loading">Loading...</div>
    <div v-else>
      <div
        class="reviewBox"
        v-for="(review, index) in this.reviews"
        :key="index"
      >
        <div class="infoReview">
          <div>Nicola S.</div>
          <div class="createdAt">
            <!-- applicazione del filter -->
            {{ review.created_at | fromNow }}
          </div>
          <div class="reviewContent">{{ review.content }}</div>
        </div>
        <div class="rating">
          <star-rating :value="review.rating"></star-rating>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    bookableId: [String, Number],
  },
  data() {
    return {
      loading: false,
      reviews: null,
    };
  },
  created() {
    this.loading = true;

    // si potrebbe prendere l'id dalla rotta con $route.params.id,
    // come faccio per <availability>
    // ma è molto meglio passarlo dal componente padre.
    //    console.log(`this.bookableId-->${this.bookableId}`);
    axios
      .get(`/api/bookables/${this.bookableId}/reviews`)
      .then((response) => (this.reviews = response.data.data))
      .then((this.loading = false));
  },
  methods: {},
  computed: {},
  filters: {
    // i filters servono per rendere reattivi metodi che
    // provengono da librerie esterne
    // lo commento perchè lo ho abilitato globalmente in app.js
    /* fromNow(value) {
            return moment(value).fromNow();
        } */
  },
};
</script>

<style scoped>
.reviewTitle {
  padding: 20px 0;
  color: grey;
}
.reviewBox {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  border-bottom: 1px solid lightblue;
  margin: 20px 0;
}
.rating {
}
.infoReview {
  width: 80%;
}
.createdAt {
  font-size: 12px;
  margin-top: 10px;
}
.reviewContent {
  font-size: 13px;
  margin-top: 10px;
}
</style>
