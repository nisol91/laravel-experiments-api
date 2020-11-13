<template>
  <div>
    <success v-if="success">Congratulations on your purchase</success>
    <div class="row">
      <div class="col-md-6" v-if="itemsInBasket">
        <div class="form-row">
          <div class="col-md-6 form-group">
            <label for="first_name">First Name</label>
            <input
              type="text"
              class="form-control"
              name="first_name"
              v-model="customer.first_name"
              :class="{ 'is-invalid': errorFor('customer.first_name') }"
            />
            <v-errors :errors="errorFor('customer.first_name')"></v-errors>
          </div>
          <div class="col-md-6 form-group">
            <label for="last_name">Last Name</label>
            <input
              type="text"
              class="form-control"
              name="last_name"
              v-model="customer.last_name"
              :class="{ 'is-invalid': errorFor('customer.last_name') }"
            />
            <v-errors :errors="errorFor('customer.last_name')"></v-errors>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-12 form-group">
            <label for="email">Email</label>
            <input
              type="text"
              class="form-control"
              name="email"
              v-model="customer.email"
              :class="{ 'is-invalid': errorFor('customer.email') }"
            />
            <v-errors :errors="errorFor('customer.email')"></v-errors>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-6 form-group">
            <label for="street">Street</label>
            <input
              type="text"
              class="form-control"
              name="street"
              v-model="customer.street"
              :class="{ 'is-invalid': errorFor('customer.street') }"
            />
            <v-errors :errors="errorFor('customer.street')"></v-errors>
          </div>
          <div class="col-md-6 form-group">
            <label for="city">City</label>
            <input
              type="text"
              class="form-control"
              name="city"
              v-model="customer.city"
              :class="{ 'is-invalid': errorFor('customer.city') }"
            />
            <v-errors :errors="errorFor('customer.city')"></v-errors>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-6 form-group">
            <label for="country">Country</label>
            <input
              type="text"
              class="form-control"
              name="country"
              v-model="customer.country"
              :class="{ 'is-invalid': errorFor('customer.country') }"
            />
            <v-errors :errors="errorFor('customer.country')"></v-errors>
          </div>
          <div class="col-md-4 form-group">
            <label for="state">State</label>
            <input
              type="text"
              class="form-control"
              name="state"
              v-model="customer.state"
              :class="{ 'is-invalid': errorFor('customer.state') }"
            />
            <v-errors :errors="errorFor('customer.state')"></v-errors>
          </div>
          <div class="col-md-2 form-group">
            <label for="zip_code">Zip</label>
            <input
              type="text"
              class="form-control"
              name="zip_code"
              v-model="customer.zip_code"
              :class="{ 'is-invalid': errorFor('customer.zip_code') }"
            />
            <v-errors :errors="errorFor('customer.zip_code')"></v-errors>
          </div>
        </div>
        <div class="form-row pt-2 border-top">
          <div class="col-md-12 form-group">
            <button
              type="submit"
              class="btn btn-lg btn-primary btn-block"
              @click.prevent="book"
              :disabled="loading"
            >
              Checkout and pay
            </button>
            <!-- click.prevent è sempre meglio aggiungerlo quando si tratta di mandare dati,
            cioè in caso di forms, anche se questo tecnicamente non è proprio un form-->
          </div>
        </div>
      </div>
      <div class="col-md-6" v-else>
        <div class="jumbotron">no items in basket</div>
      </div>
      <div class="col-md-6">
        <div class="d-flex justify-content-between">
          <h6 class="text-uppercase text-secondary font-weight-bolder">
            your cart
          </h6>
          <h6 class="badge badge-secondary text-uppercase">
            <span v-if="itemsInBasket">items: {{ itemsInBasket }}</span>
            <span v-else>empty</span>
          </h6>
        </div>
        <!-- per una lista v-for serve il transition group -->
        <transition-group name="fade" tag="span">
          <div v-for="item in basket" :key="item.bookable.id">
            <div class="border-top pt-2 pb-2 d-flex justify-content-between">
              <span>
                <router-link
                  class="btn nav-button"
                  :to="{ name: 'bookable', params: { id: item.bookable.id } }"
                  >{{ item.bookable.title }}</router-link
                >
              </span>
              <span class="font-weight-bold">$ {{ item.price.total }}</span>
            </div>
            <div class="pt-2 pb-2 d-flex justify-content-between">
              <span>from {{ item.dates.from }}</span>
              <span>to {{ item.dates.to }}</span>
            </div>
            <div class="pt-2 pb-2 text-right">
              <button
                class="btn btn-outline-secondary btn-sm"
                @click="$store.dispatch('removeFromBasket', item.bookable.id)"
              >
                <i class="fas fa-trash-alt"></i>
              </button>
            </div>
          </div>
        </transition-group>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";
import validationErrors from "../shared/mixins/validationErrors";

export default {
  mixins: [validationErrors],

  data() {
    return {
      loading: false,
      bookingAttempted: false,
      customer: {
        first_name: null,
        last_name: null,
        email: null,
        street: null,
        city: null,
        country: null,
        state: null,
        zip_code: null,
      },
    };
  },
  methods: {
    async book() {
      this.loading = true;
      this.bookingAttempted = false;
      this.errors = null;

      try {
        await axios.post(`api/checkout`, {
          customer: this.customer,
          //   this.basket viene dal ...mapState e lo mappo, per visualizzare i campi che dico io
          bookings: this.basket.map((basketItem) => ({
            bookable_id: basketItem.bookable.id,
            from: basketItem.dates.from,
            to: basketItem.dates.to,
          })),
        });
        this.$store.dispatch("clearBasket");
      } catch (err) {
        // ritorna questi valori se esistono
        this.errors = err.response && err.response.data.errors;
      }
      this.bookingAttempted = true;
      this.loading = false;
    },
  },
  computed: {
    // metodi vuex--
    ...mapGetters({ itemsInBasket: "itemsInBasket" }),
    // se voglio prendere direttamente basket.items faccio cosi
    ...mapState({ basket: (state) => state.basket.items }),
    // cosi mi prende solo l'oggetto padre
    // ...mapState({ basket: "basket" }),

    // altri metodi--
    // le computed properties di fatto sono come le data, però
    // vengono fuori da metodi che sono sempre in ascolto delle effettive data properties
    // di fatto le computed eseguono operazioni sulle data
    success() {
      return !this.loading && this.itemsInBasket === 0 && this.bookingAttempted;
    },
  },
};
</script>
<style scoped>
h6.badge {
  font-size: 100%;
}
</style>
