<template>
  <div class="w-50 m-auto align-items-center d-flex">
    <div class="" v-if="isLoggedIn">you are already logged in</div>
    <div class="card card-body" v-else>
      <form>
        <div class="form-group">
          <label for="email">E-mail</label>
          <input
            type="text"
            name="email"
            placeholder="Enter your e-mail"
            class="form-control"
            v-model="email"
            :class="[{ 'is-invalid': errorFor('email') }]"
          />
          <v-errors :errors="errorFor('email')"></v-errors>
        </div>

        <div class="form-group">
          <label for="email">Password</label>
          <input
            type="password"
            name="password"
            placeholder="Enter your password"
            class="form-control"
            v-model="password"
            :class="[{ 'is-invalid': errorFor('password') }]"
          />
          <v-errors :errors="errorFor('password')"></v-errors>
        </div>

        <button
          type="submit"
          class="btn btn-primary btn-lg btn-block"
          :disabled="loading"
          @click.prevent="login"
        >
          Log-in
        </button>
        <div class="" v-if="!isEmailVerified">
          You need to verify your email in order to login
        </div>

        <hr />

        <div>
          No account yet?
          <router-link :to="{ name: 'register' }" class="font-weight-bold"
            >Register</router-link
          >
        </div>

        <div>
          Forgotten password?
          <router-link :to="{ name: 'forgotPassword' }" class="font-weight-bold"
            >Reset password</router-link
          >
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import validationErrors from "../shared/mixins/validationErrors";
import { logIn } from "../shared/utils/auth";
import { mapState } from "vuex";

export default {
  mixins: [validationErrors],
  data() {
    return {
      email: null,
      password: null,
      loading: false,
    };
  },
  computed: {
    ...mapState({
      isLoggedIn: "isLoggedIn",
      isEmailVerified: "isEmailVerified",
    }),
  },
  methods: {
    async login() {
      this.loading = true;
      this.errors = null;
      try {
        await axios.get("/sanctum/csrf-cookie");

        // questo e l endpoint /login di laravel.
        const response = await axios.post("/api/login", {
          email: this.email,
          password: this.password,
        });

        // se il login ha successo:
        // setto token
        localStorage.setItem("token", response.data.access_token);
        // save in storage
        logIn();
        // guardo il ruolo
        this.$store.dispatch("getUserRole");
        //   console.log("ruolo index " + this.userRole);
        // load user in the state
        this.$store.dispatch("loadUser");
        // push home route (dovrebbe funzionare anche router.push, pero importando router)
        this.$router.push({
          name: "home",
        });
      } catch (error) {
        this.errors = error.response && error.response.data.errors;
      }
      this.loading = false;
    },

    // ma serve sto metodologout messo qui??
    async logout() {
      try {
        this.$store.dispatch("logout");
      } catch (error) {
        this.$store.dispatch("logout");
      }
    },
  },
};
</script>
