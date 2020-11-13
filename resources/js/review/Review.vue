<template>
  <div>
    <!-- componente con slot -->
    <success v-if="success">Thank you for adding your review</success>
    <fatal-error v-if="error"></fatal-error>
    <div v-if="!success && !error" class="row">
      <div
        :class="[
          'bookingInfo',
          { 'col-md-4': loading && !alreadyReviewed },
          { 'd-none': displayNone },
        ]"
      >
        <div class="card">
          <div class="card-body">
            <div v-if="loading">loading...</div>

            <div v-if="hasBooking">
              <div>
                Go to the bookable
                <router-link
                  class
                  v-bind:to="{
                    name: 'bookable',
                    params: { id: booking.bookable.bookable_id },
                  }"
                  >{{ booking.bookable.title }}</router-link
                >
              </div>
              <div>
                you stayed here from {{ booking.from }} to {{ booking.to }}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div
        :class="[
          { 'col-md-6': !loading && !alreadyReviewed },
          { 'col-md-12': !loading && alreadyReviewed },
        ]"
      >
        <div v-if="loading">loading...</div>
        <div v-else>
          <div v-if="alreadyReviewed">already reviewed</div>
          <div v-else>
            <div class="form-group">
              <label for="rating" class="text-muted"
                >select the star rating</label
              >
              <!-- event emitter rating:changed: ogni volta che viene emesso dal children,
          avviene "review.rating = $event". $event è ciò che viene emesso dall'event emitter.
          il data binding è 2 way, poichè se cambia il valore che gli passa il parent, cambia il numero
              di stelle piene-->
              <!-- <star-rating :rating="review.rating" v-on:input="review.rating = $event"></star-rating> -->

              <!-- in alternativa si può utilizzare v-model, che rende tutto piu semplice e fa esattamente
              quello che $emit-$event fanno ma in maniera piu macchinosa. il child deve comunque emettere un evento-->
              <star-rating v-model="review.rating"></star-rating>
            </div>
            <div class="form-group">
              <label for="content" class="text-muted"
                >describe your experience</label
              >
              <textarea
                name="content"
                id
                cols="30"
                rows="10"
                class="form-control"
                v-model="review.content"
                :class="{ 'is-invalid': errorFor('content') }"
              ></textarea>
              <v-errors :errors="errorFor('content')"></v-errors>
            </div>
            <button
              type="submit"
              class="btn btn-lg btn-primary btn-block"
              @click.prevent="submit"
              :disabled="sending"
            >
              Submit your review
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { is404, is422 } from "../shared/utils/response";
import validationErrors from "../shared/mixins/validationErrors";
export default {
  mixins: [validationErrors],
  data() {
    return {
      review: {
        id: null,
        rating: 5,
        content: "contenuto review",
      },
      existingReview: null,
      loading: false,
      sending: false,
      booking: null,
      error: false,
      success: false,
    };
  },
  created() {
    this.errors = null;
    this.review.id = this.$route.params.id;
    this.loading = true;

    axios
      .get(`/api/review/${this.review.id}`)
      .then((response) => (this.existingReview = response.data.data))
      .catch((err) => {
        //   is404() function in shared utils components
        if (is404(err)) {
          // se il controller ritorna 404 vuole dire che l id della
          //   review non c è gia quindi controllo se compare nei booking review id.
          //    se anche li non compare allora va bene:
          return axios
            .get(`/api/booking-by-review/${this.review.id}`)
            .then((response) => {
              this.booking = response.data.data;
            })
            .catch((err) => {
              if (!is404(err)) {
                this.error = true;
              }
              //or
              //   this.error = !is404(err);
              //or
              //   is404(err) ? {} : this.error = true;
            });
        }
        // se l'errore è diverso da 404 do errore
        this.error = true;
      })
      .then((response) => {
        // console.log(response);
        // console.log(this.booking.booking_id);
        this.loading = false;
      });
  },
  computed: {
    alreadyReviewed() {
      return this.hasReview || !this.hasBooking;
    },
    hasReview() {
      return this.existingReview != null;
    },
    hasBooking() {
      return this.booking != null;
    },
    displayNone() {
      return !this.loading && this.alreadyReviewed;
    },
  },
  methods: {
    submit() {
      this.sending = true;
      this.success = false;
      axios
        .post("/api/review", this.review)
        .then((response) => {
          //   console.log(response);
          // se il response.status è 201 allora this.success diventa true
          this.success = response.status === 201;
        })
        .catch((err) => {
          if (is422(err)) {
            const errors = err.response.data.errors;
            //    console.log(errors);
            if (errors["content"] && _.size(errors) === 1) {
              this.errors = errors;
              return;
            }
          }
          //  console.log(err);
          this.error = true;
        })
        .then(() => (this.sending = false));
    },
    onRatingChanged(rating) {
      //     console.log(rating);
    },
  },
};
</script>

<style scoped>
.bookingInfo {
  margin: 0 50px;
}
</style>
