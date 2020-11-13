<template>
  <div>
    <div class="text-uppercase font-weight-bold text-secondary">
      availability
      <transition name="fade">
        <span v-if="noAvailability" class="text-danger">(no available)</span>
        <span v-if="hasAvailability" class="text-success">(available!)</span>
      </transition>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="from">From</label>
        <input
          type="text"
          name="from"
          placeholder="Start date"
          class="form-control"
          v-model="from"
          @keyup.enter="check"
          :class="{ 'is-invalid': errorFor('from') }"
        />

        <v-errors :errors="errorFor('from')"></v-errors>
      </div>
      <div class="form-group col-md-6">
        <label for="to">To</label>
        <input
          type="text"
          name="to"
          placeholder="End date"
          class="form-control"
          v-model="to"
          @keyup.enter="check"
          :class="{ 'is-invalid': errorFor('to') }"
        />

        <v-errors :errors="errorFor('to')"></v-errors>
      </div>
    </div>
    <button-check :loading="loading" :buttonCheck="check">Check</button-check>
    <!-- <button
            class="btn btn-secondary btn-block"
            @click="check"
            :disabled="loading"
        >
            <span v-if="!loading">Check!</span>
            <span v-if="loading">
                <i class="fas fa-circle-notch fa-spin"></i> Checking....
            </span>
    </button>-->
  </div>
</template>

<script>
import validationErrors from "../shared/mixins/validationErrors";
import { mapState } from "vuex";

export default {
  mixins: [validationErrors],

  data() {
    return {
      from: this.$store.state.lastSearch.from,
      to: this.$store.state.lastSearch.to,
      loading: false,
      status: null,
    };
  },
  methods: {
    check() {
      // vuex
      //  console.log(this.$store);
      // per richiamare una action uso dispatch, mentre per richiamare
      // una mutation uso commit (la mutation è richiamata dentro la action)
      this.$store.dispatch("setLastSearch", {
        from: this.from,
        to: this.to,
      });

      // console.log("i check");
      this.loading = true;
      this.errors = null;
      axios
        .get(
          `/api/bookables/${this.$route.params.id}/availability?from=${this.from}&to=${this.to}`
        )
        .then((response) => {
          this.status = response.status;
          //   console.log(this.status);
          //   custom event emitter: quando nel componente cambia la availability,
          //   si puo triggerare un metodo del componente padre con @availability!(in questo caso bookable)
          //  è come un @click ma custom
          this.$emit("availability", this.hasAvailability);
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors;
            //   console.log("errors: ");
            //   console.log(this.errors);
          }
          this.status = error.response.status;
          this.$emit("availability", this.hasAvailability);
        })
        .then(() => {
          this.loading = false;
        });
    },
  },
  computed: {
    // binding values to vuex: il mapState serve per importare una configurazione
    // di state dell app in quel componente
    // ...mapState({ lastSearch: "lastSearch" }),
    // volendo si puo scrivere anche cosi:
    // ...mapState(["lastSearch"]),
    // ----
    hasErrors() {
      // it returns true if the conditions are satisfied
      //  console.log("hasErrors: ");
      //  console.log(this.status === 422 && this.errors !== null);
      return this.status === 422 && this.errors !== null;
    },
    hasAvailability() {
      return this.status === 200;
    },
    noAvailability() {
      return this.status === 404;
    },
  },
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
