<template>
  <div>
    <div class="">reset password form</div>
    <div class="" v-if="passwordReset">password reset successfully</div>
    <div class="form-group">
      <label for="email">E-mail</label>
      <input
        type="text"
        name="email"
        placeholder="Enter your e-mail"
        class="form-control"
        v-model="user.email"
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
        v-model="user.password"
        :class="[{ 'is-invalid': errorFor('password') }]"
      />
      <v-errors :errors="errorFor('password')"></v-errors>
    </div>

    <!-- 'password_confirmation' is read by laravel backend to check passwords -->
    <div class="form-group">
      <label for="email">Confirm your Password</label>
      <input
        type="password"
        name="password_confirmation"
        placeholder="Confirm your password"
        class="form-control"
        v-model="user.password_confirmation"
        :class="[{ 'is-invalid': errorFor('password_confirmation') }]"
      />
      <v-errors :errors="errorFor('password_confirmation')"></v-errors>
    </div>
    <button
      type="submit"
      class="btn btn-primary btn-lg btn-block"
      @click.prevent="resetPassword"
    >
      Reset Password
    </button>
  </div>
</template>
<script>
import { mapActions } from "vuex";
import validationErrors from "../shared/mixins/validationErrors";

export default {
  mixins: [validationErrors],
  data() {
    return {
      user: {
        email: null,
        password: null,
        password_confirmation: null,
      },
      passwordReset: false,
    };
  },
  methods: {
    ...mapActions({
      verifyEmail: "verifyEmail",
    }),
    async resetPassword() {
      this.passwordReset = false;
      this.error = null;
      const token = this.$route.query.token;

      // l' operatore ... destruttura l'oggetto user
      try {
        await axios.post("/api/reset-password", {
          ...this.user,
          token,
        });
        this.passwordReset = true;
      } catch (error) {
        this.error = error.response.data.errors.email[0];
      }
    },
  },
  created() {
    // console.log(this.$route.query);
  },
};
</script>
