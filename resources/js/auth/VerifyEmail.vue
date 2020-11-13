<template>
  <div>
    verify
    <div class="btn btn-dark" @click="verify">click here to verify</div>
  </div>
</template>
<script>
import { mapActions } from "vuex";

export default {
  methods: {
    ...mapActions({
      verifyEmail: "verifyEmail",
    }),
    verify() {
      this.verifyEmail(this.$route.query).then(() => {
        this.$router.push({ name: "login" });
      });
    },
  },
  created() {
    //     console.log(this.$route.query);
  },
};
</script>
