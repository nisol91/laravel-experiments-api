<template>
  <div>
    <div class="flex_2" v-if="!loading">
      <div class="singleBookableCard">
        <div class="card">
          <div class="card-body">
            <h1 class="card-title">{{ bookable.title }}</h1>
            <h3 class="card-text">{{ bookable.description }}</h3>
          </div>
        </div>
        <review-list :bookable-id="this.$route.params.id"></review-list>
      </div>

      <div class="singleBookableCard">
        <!-- @availability è un custom event (vedi componente child availability) -->
        <availability
          @availability="checkPrice($event)"
          class="mb-4"
        ></availability>
        <transition name="fade">
          <price-breakdown
            v-if="price"
            :price="price"
            class="mb-4"
          ></price-breakdown>
        </transition>
        <transition name="fade">
          <button
            class="btn btn-outline-secondary btn-block"
            v-if="price"
            @click="addToBasket"
            :disabled="inBasketAlready"
          >
            Book Now!
          </button>
        </transition>
        <button
          class="btn btn-outline-secondary btn-block"
          v-if="inBasketAlready"
          @click="removeFromBasket"
        >
          Remove from basket
        </button>
        <div v-if="inBasketAlready" class="mt-4 warning text-muted">
          object added to basket
        </div>
      </div>
    </div>
    <div v-else>loading....</div>
  </div>
</template>

<script>
import Availability from "./Availability";
import ReviewList from "./ReviewList";
import PriceBreakdown from "./PriceBreakdown";
import { mapState } from "vuex";

export default {
  components: {
    Availability,
    ReviewList,
    PriceBreakdown,
  },
  data() {
    return {
      bookable: null,
      loading: true,
      price: null,
    };
  },
  created() {
    //   console.log(this.$route.params.id);
    axios.get(`/api/bookables/${this.$route.params.id}`).then((response) => {
      this.bookable = response.data.data;
      this.loading = false;
    });
  },
  methods: {
    async checkPrice(hasAvailability) {
      //  console.log(hasAvailability);
      if (!hasAvailability) {
        this.price = null;
        return;
      }

      //   async / await è analogo alla notazione nested,
      //  ma in certi casi è piu leggibile
      try {
        this.price = (
          await axios.get(
            `/api/bookables/${this.bookable.id}/price?from=${this.lastSearch.from}&to=${this.lastSearch.to}`
          )
        ).data.data;

        // console.log(this.price);
      } catch (error) {
        this.price = null;
      }
    },
    addToBasket() {
      this.$store.dispatch("addToBasket", {
        bookable: this.bookable,
        price: this.price,
        dates: this.lastSearch,
      });
    },
    removeFromBasket() {
      this.$store.dispatch("removeFromBasket", this.bookable.id);
    },
  },
  computed: {
    //   imports lastSearch from store state
    ...mapState({ lastSearch: "lastSearch" }),
    // questo computed chiama una higher order function nei getters
    // passandole l'id
    // Questa funzione controlla che l'elemento sia già o meno nel basket
    // con un reduce
    inBasketAlready() {
      // piccolo controllo se il bookable c'è
      if (this.bookable === null) {
        return false;
      }
      return this.$store.getters.inBasketAlready(this.bookable.id);
    },
  },
};
</script>

<style lang="css">
.singleBookableCard {
  width: 500px;
  margin: 10px 20px;
}
</style>
