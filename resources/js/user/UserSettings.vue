<template>
  <div class="userSettings">
    <h1>user settings</h1>
    <div class="form-group">
      <label for="email">address</label>
      <input
        type="text"
        name="address"
        placeholder="enter your address"
        class="form-control"
        v-model="userSettings.address"
        :class="[{ 'is-invalid': errorFor('address') }]"
      />
      <v-errors :errors="errorFor('address')"></v-errors>
    </div>

    <div class="form-group">
      <label for="email">orders number</label>
      <input
        type="number"
        name="number_of_orders"
        placeholder="enter your orders number"
        class="form-control"
        v-model="userSettings.number_of_orders"
        :class="[{ 'is-invalid': errorFor('number_of_orders') }]"
      />
      <v-errors :errors="errorFor('number_of_orders')"></v-errors>
    </div>

    <file-loader @upload-file="uploadFile"></file-loader>

    <img :src="getImagePath()" alt="" />
    <!-- <img src="../../../storage/app/public/avatars/52903.png" alt="" /> -->

    <v-switch
      v-model="userSettings.hide_profile"
      :label="`hide_profile user: ${userSettings.hide_profile.toString()}`"
    ></v-switch>
    <v-btn
      class="ma-2"
      :loading="loadingSaveSettings"
      :disabled="loadingSaveSettings"
      color="success"
      @click="saveSettings"
      id="savv"
    >
      Save
      <template v-slot:loader>
        <span>Loading...</span>
      </template>
    </v-btn>
    <div class="d-flex flex-row align-center justify-space-between">
      <h3>categories</h3>
      <modal-form
        :errorsForm="errorsInput"
        :dialog="dialogAdd"
        :inputType="'add'"
        @save-category="addCategory"
        v-model="newName"
      ></modal-form>
    </div>
    <div>
      <h4>add categories to user {{ selectedCategories.length }}</h4>
      <custom-select
        :categoriesList="allCategories"
        v-model="selectedCategories"
        :selectedCategories="selectedCategories"
        @save-categories="addSelectedCategory"
        v-if="selectedCategories.length > 0"
      ></custom-select>
    </div>
    <div class="d-flex flex-column">
      <div v-for="category in categories" :key="category.slug">
        <div class="d-flex flex-row align-center justify-space-between">
          <div>{{ category.slug }}</div>
          <v-btn
            depressed
            color="error"
            class="mx-4"
            @click="removeCategory(category.id)"
          >
            remove from this user
          </v-btn>
          <modal-confirm-delete
            @delete-category="deleteCategory(category.id)"
          ></modal-confirm-delete>
          <div class="my-2">
            <modal-form
              :editName="category.slug"
              :errorsForm="errorsInput"
              :dialog="dialogEdit"
              :inputType="'edit'"
              @save-category="editCategory(category.id)"
              v-model="editName"
            ></modal-form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import validationErrors from "../shared/mixins/validationErrors";

export default {
  mixins: [validationErrors],
  data() {
    return {
      editName: "",
      newName: "",
      errorsInput: null,
      dialogEdit: false,
      dialogAdd: false,
      categories: [],
      allCategories: [],
      selectedCategories: [],
      userSettings: {
        hide_profile: true,
        address: "",
        number_of_orders: 3,
        profile_image: null,
      },
      loadingSaveSettings: false,
      rules: [
        (value) =>
          !value ||
          value.size < 2000000 ||
          "Avatar size should be less than 2 MB!",
      ],
    };
  },
  created() {
    this.getCategories();
    this.getAllCategories();
    this.getUserSettings();
  },
  methods: {
    getImagePath() {
      return this.userSettings.profile_image;
    },
    async uploadFile(file) {
      //   console.log(file);
      let formData = new FormData();
      formData.append("file", file[0]);
      this.userSettings.profile_image = formData;
    },
    async saveSettings() {
      try {
        //  console.log("save user settings");
        // console.log(this.userSettings);

        // saving all the data
        const saveData = await axios.post(
          "api/save-user-settings",
          this.userSettings
        );

        // saving the file with a separate post
        const config = {
          headers: { "content-type": "multipart/form-data" },
        };

        const saveFile = await axios.post(
          "api/save-file",
          this.userSettings.profile_image,
          config
        );
        // quando termino di salvare con successo riprendo i settings
        this.getUserSettings();

        this.loadingSaveSettings = false;
      } catch (error) {
        this.errors = error.response && error.response.data.errors;
      }
    },
    async getUserSettings() {
      try {
        const response = await axios.get("api/get-user-settings");
        //  console.log(response.data.userSettings);
        this.userSettings = response.data.userSettings;

        // ritrasformo i valori 0 e 1 in false e true
        this.userSettings.hide_profile = !!this.userSettings.hide_profile;

        // ritorno l'asset corretto della cartella di storage per essere utilizzato dal frontend
        this.userSettings.profile_image = response.data.assetAvatar;
      } catch (error) {
        this.errors = error.response && error.response.data.errors;
      }
    },
    async getCategories() {
      try {
        const response = await axios.get("api/categories");
        this.categories = response.data.categories;

        // questo per la preselezione della select da passargli
        const cat = [];
        this.categories.forEach((el) => {
          cat.push(el.name);
        });
        this.selectedCategories = cat;
      } catch (error) {
        this.errors = error.response && error.response.data.errors;
      }
    },
    async getAllCategories() {
      try {
        const response = await axios.get("api/categories-all");
        this.allCategories = response.data.categories;
      } catch (error) {
        this.errors = error.response && error.response.data.errors;
      }
    },
    // elimina definitivamente
    async removeCategory(id) {
      try {
        const response = await axios.post("api/remove-category", { id: id });
        // se l eliminazione ha successo la elimino anche dal frontend
        this.categories = this.categories.filter((item) => item.id != id);
        await this.getCategories();
      } catch (error) {
        this.errors = error.response && error.response.data.errors;
      }
    },
    // elimina dall user
    async deleteCategory(id) {
      try {
        const response = await axios.post("api/delete-category", { id: id });
        // se l eliminazione ha successo la elimino anche dal frontend
        this.categories = this.categories.filter((item) => item.id != id);
        await this.getCategories();
        this.getAllCategories();
      } catch (error) {
        this.errors = error.response && error.response.data.errors;
      }
    },
    async editCategory(id) {
      this.errorsInput = null;
      try {
        const edit = await axios.post("api/edit-category", {
          id: id,
          slug: this.editName,
        });
        // se l'edit ha successo richiamo le categorie
        this.getCategories();
      } catch (error) {
        this.errorsInput = error.response.data.message;
      }
    },
    async addCategory() {
      //  console.log("add");
      try {
        const response = await axios.post("api/add-category", {
          slug: this.newName,
        });
        // se l'add ha successo richiamo le categorie
        this.getCategories();
        this.getAllCategories();
      } catch (error) {
        this.errors = error.response && error.response.data.errors;
      }
    },
    async addSelectedCategory(names) {
      //   console.log("addSelected cat");
      try {
        const response = await axios.post("api/add-selected-category", {
          names: names,
        });
        // se l'add ha successo richiamo le categorie
        this.getCategories();
      } catch (error) {
        this.errors = error.response && error.response.data.errors;
      }
    },
  },
};
</script>

<style lang="css">
.userSettings {
  width: 40vw;
}
</style>
