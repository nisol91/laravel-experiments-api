<template>
  <div>
    <div class="card card-body">
      <form>
        <div class="" v-if="emailSent">email sent!</div>
        <div class="" v-if="error">{{ error }}</div>

        <div class="form-group">
          <label for="email">E-mail</label>
          <input
            type="text"
            name="email"
            placeholder="Enter your e-mail"
            class="form-control"
            v-model="email"
          />
        </div>
        <button
          type="submit"
          class="btn btn-primary btn-lg btn-block"
          @click.prevent="sendResetLink"
        >
          Send reset link
        </button>
      </form>
    </div>
  </div>
</template>
<script>
import { mapActions } from "vuex";

export default {
  data() {
    return {
      email: "",
      emailSent: false,
      error: null,
    };
  },
  methods: {
    ...mapActions({
      verifyEmail: "verifyEmail",
    }),
    async sendResetLink() {
      this.emailSent = false;
      this.error = null;

      try {
        await axios.post("/api/forgot-password", {
          email: this.email,
        });
        this.emailSent = true;
      } catch (error) {
        this.error = error.response.data.errors.email[0];
      }
    },
  },
  created() {},
};
</script>
