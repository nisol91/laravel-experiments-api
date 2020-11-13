<template>
  <div>
    <div class="flex_3" v-if="!loading">
      <div class="singleBookableCard">
        <div class="card">
          <div class="card-body">
            <h1 class="card-title">name: {{ user.name }}</h1>
            <h3 class="card-text">email:{{ user.email }}</h3>
            <h3 class="card-text">joined: {{ user.created_at }}</h3>
          </div>
        </div>
      </div>
      <div class="singleBookableCard">
        <div class="card">
          change name
          <div class="card-body">
            <div class="form-group">
              <label for="name">Name</label>
              <input
                type="text"
                name="name"
                placeholder="Enter your name"
                class="form-control"
                v-model="user.name"
                :class="[{ 'is-invalid': errorFor('name') }]"
              />
              <v-errors :errors="errorFor('name')"></v-errors>
            </div>
          </div>
          <button
            type="submit"
            class="btn btn-primary btn-lg btn-block"
            @click.prevent="changeDetails"
          >
            Save
          </button>
        </div>
      </div>
      <div class="singleBookableCard">
        <div class="card">
          change psw
          <div class="card-body">
            <div class="form-group">
              <label for="email">Old Password</label>
              <input
                type="password"
                name="oldPassword"
                placeholder="Enter your oldPassword"
                class="form-control"
                v-model="user.oldPassword"
                :class="[{ 'is-invalid': errorFor('oldPassword') }]"
              />
              <v-errors :errors="errorFor('oldPassword')"></v-errors>
            </div>
            <!--  -->
            <div class="form-group">
              <label for="email">Password</label>
              <input
                type="password"
                name="newPassword"
                placeholder="Enter your new password"
                class="form-control"
                v-model="user.newPassword"
                :class="[{ 'is-invalid': errorFor('newPassword') }]"
              />
              <v-errors :errors="errorFor('newPassword')"></v-errors>
            </div>

            <!-- 'password_confirmation' is read by laravel backend to check passwords -->
            <div class="form-group">
              <label for="email">Confirm your Password</label>
              <input
                type="password"
                name="newPassword_confirmation"
                placeholder="Confirm your new password"
                class="form-control"
                v-model="user.newPassword_confirmation"
                :class="[
                  { 'is-invalid': errorFor('newPassword_confirmation') },
                ]"
              />
              <v-errors
                :errors="errorFor('newPassword_confirmation')"
              ></v-errors>
            </div>
            <button
              type="submit"
              class="btn btn-primary btn-lg btn-block"
              @click.prevent="changePassword"
            >
              Save
            </button>
          </div>
        </div>
      </div>
      <div>
        <user-settings></user-settings>
      </div>
    </div>
  </div>
</template>


<script>
import { mapState } from "vuex";
import validationErrors from "../shared/mixins/validationErrors";

export default {
  mixins: [validationErrors],
  data() {
    return {
      user: {
        name: "",
        email: "",
        created_at: "",
        oldPassword: "",
        newPassword: "",
        newPassword_confirmation: "",
      },
      loading: true,
    };
  },
  created() {
    //  console.log(this.$route.params.id);
    this.getUser();
  },
  methods: {
    async getUser() {
      try {
        const response = await axios.get(`/api/user`);
        //    console.log(response);
        this.user = response.data.user_data;
        this.loading = false;
      } catch (error) {
        //   console.log(error);
        this.errors = error.response && error.response.data.errors;
      }
    },
    async changeDetails() {
      //  console.log("ch details");
      try {
        const response = await axios.post(`/api/change-details`, {
          name: this.user.name,
        });
      } catch (error) {
        this.errors = error.response && error.response.data.errors;
      }
    },
    async changePassword() {
      //  console.log("ch psw");
      try {
        const response = await axios.post(`/api/change-password`, {
          oldPassword: this.user.oldPassword,
          newPassword: this.user.newPassword,
          newPassword_confirmation: this.user.newPassword_confirmation,
        });
      } catch (error) {
        //  console.log(error);
        this.errors = error.response && error.response.data.errors;
      }
    },
  },
};
</script>
