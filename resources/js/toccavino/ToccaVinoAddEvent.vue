<template>
  <div
    class="d-flex justify-content-center align-items-center tv-footer col-md-12"
  >
    <div class="text-white">toccavino add event</div>
    <div class="col-md-6">
      <div class="form-row">
        <div class="col-md-6 form-group">
          <label for="name">Name</label>
          <input
            type="text"
            class="form-control"
            name="first_name"
            v-model="event.name"
            :class="{ 'is-invalid': errorFor('event.name') }"
          />
          <v-errors :errors="errorFor('event.name')"></v-errors>
        </div>
        <div class="col-md-6 form-group">
          <label for="description">description</label>
          <input
            type="text"
            class="form-control"
            name="street"
            v-model="event.description"
            :class="{ 'is-invalid': errorFor('event.description') }"
          />
          <v-errors :errors="errorFor('event.description')"></v-errors>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-6 form-group">
          <label for="city">City</label>
          <mapbox-search
            v-model="event.city"
            @get-coords="setCoords"
            :errorsCity="errors"
          ></mapbox-search>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-6 form-group">
          <label for="price">price</label>

          <input
            type="text"
            class="form-control"
            name="price"
            v-model="event.price"
            :class="{ 'is-invalid': errorFor('event.price') }"
          />
          <v-errors :errors="errorFor('event.price')"></v-errors>
        </div>
      </div>

      <div class="form-row">
        <div class="col-md-6 form-group">
          <label for="price">from</label>

          <input
            type="text"
            class="form-control"
            name="from"
            v-model="event.from"
            :class="{ 'is-invalid': errorFor('event.from') }"
          />
          <v-errors :errors="errorFor('event.from')"></v-errors>
        </div>
        <div class="col-md-6 form-group">
          <label for="price">to</label>

          <input
            type="text"
            class="form-control"
            name="to"
            v-model="event.to"
            :class="{ 'is-invalid': errorFor('event.to') }"
          />
          <v-errors :errors="errorFor('event.to')"></v-errors>
        </div>
      </div>

      <div class="form-row pt-2 border-top">
        <div class="col-md-12 form-group">
          <button
            type="submit"
            class="btn btn-lg btn-primary btn-block"
            @click.prevent="addEvent"
          >
            save event
          </button>
          <!-- click.prevent è sempre meglio aggiungerlo quando si tratta di mandare dati,
          cioè in caso di forms, anche se questo tecnicamente non è proprio un form-->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";
import validationErrors from "../shared/mixins/validationErrors";
import router from "../routes";

export default {
  mixins: [validationErrors],

  data() {
    return {
      loading: false,
      event: {
        name: null,
        description: null,
        street: null,
        city: null,
        coords: {
          lat: 0,
          lng: 0,
        },
      },
      validation: {
        name: false,
      },
    };
  },
  computed: {},
  methods: {
    setCoords(val) {
      if (val != null) {
        this.event.coords.lat = parseFloat(val[0].toFixed(1));
        this.event.coords.lng = parseFloat(val[1].toFixed(1));
      }
    },
    async addEvent() {
      this.loading = true;
      this.capitalize(this.event.name);
      //  console.log(this.event.name);
      try {
        await axios.post(`api/wine-events`, {
          event: this.event,
        });
        router.push({
          name: "toccaVinoHome",
          params: { eventName: this.event.name },
        });
      } catch (error) {
        if (error.response.status === 422) {
          this.errors = error.response.data.errors;
          //   console.log("errors: ");
          //   console.log(this.errors);
        }
        this.status = error.response.status;
      }
      this.loading = false;
    },
    capitalize(value) {
      if (!value) return "";
      value = value.toString();
      this.event.name = value.charAt(0).toUpperCase() + value.slice(1);
    },
  },
  filters: {},
  computed: {
    // ...mapGetters({ itemsInBasket: "itemsInBasket" }),
    // se voglio prendere direttamente basket.items faccio cosi
    // ...mapState({ basket: state => state.basket.items })
    // cosi mi prende solo l'oggetto padre
    // ...mapState({ basket: "basket" }),
  },
};
</script>

<style scoped></style>
