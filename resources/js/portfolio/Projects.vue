<template>
  <div
    class="projectsGallery d-flex justify-content-center align-items-center flex-column"
  >
    <div v-if="loading" class="splash-box">
      <v-progress-circular
        :size="70"
        color="blue-grey darken-3"
        indeterminate
        class="splash-box-progress"
      ></v-progress-circular>
    </div>
    <div v-if="!loading" class="filters">
      <v-chip-group column multiple class="chips">
        <v-chip
          filter
          outlined
          class="ma-2 projectsChip"
          filter-icon="mdi-plus"
          v-for="cat in cats"
          :key="cat"
          @click="filterByCat(cat)"
          >{{ cat }}</v-chip
        >
      </v-chip-group>
      <div class="orderBy" @click="orderByName">
        order by name
        <span
          ><i
            class="fas"
            :class="{
              'fa-arrow-up': toggleSearchByName,
              'fa-arrow-down': !toggleSearchByName,
            }"
          ></i
        ></span>
      </div>
    </div>
    <v-card
      v-for="project in filteredProjects"
      :key="project.id"
      class="projectCard"
    >
      <div class="projectTitle">
        <h1>{{ project.name }}</h1>
      </div>
      <div class="d-flex flex-column justify-content-center">
        <div class="projDescription">
          {{ project.description }}
        </div>
        <div class="text-align-center-center">
          technologies: {{ project.additional_data }}
        </div>
      </div>
      <img
        v-if="project.media[0]"
        class="projectImage"
        :src="`storage/${project.media[0].storage_path}`"
        alt=""
      />

      <v-btn v-if="project.disabled" color="" rounded dark disabled>
        <router-link
          id="routerInsideVButtonDisabled"
          class="d-flex justify-content-center align-items-center"
          :to="{ name: 'project', params: { id: project.id } }"
          >coming soon...
        </router-link></v-btn
      >
      <v-btn v-if="!project.disabled" color="primary" rounded dark>
        <router-link
          class="routerInsideVButton d-flex justify-content-center align-items-center"
          :to="{ name: 'project', params: { id: project.id } }"
          >to the project
        </router-link></v-btn
      >
    </v-card>
  </div>
</template>
<script>
export default {
  data() {
    return {
      projects: [],
      filteredProjects: [],

      cats: ["web", "mobile"],
      selectedCats: [],
      toggleSearchByName: true,
      loading: false,
    };
  },
  created() {
    this.$store.commit("toggleHomePage", false);
    this.getProjects();
  },
  computed: {},
  methods: {
    orderByName() {
      if (this.toggleSearchByName) {
        this.filteredProjects = _.orderBy(
          this.filteredProjects,
          [
            function (project) {
              return project.name;
            },
          ],
          ["asc"]
        );
      } else {
        this.filteredProjects = _.orderBy(
          this.filteredProjects,
          [
            function (project) {
              return project.name;
            },
          ],
          ["desc"]
        );
      }
      this.toggleSearchByName = !this.toggleSearchByName;
    },
    filterByCat(cat) {
      this.filteredProjects = [];

      if (this.selectedCats.indexOf(cat) === -1) {
        this.selectedCats.push(cat);
      } else {
        // ricorda che quando applichi approcci funzionali e sempre meglio creare una copia della prop
        // ci fai tutte le operazioni che devi e poi la riassegni alla fine
        var temp = this.selectedCats.filter((n) => {
          return n !== cat;
        });
        this.selectedCats = temp;
      }

      this.projects.forEach((project) => {
        this.selectedCats.forEach((category) => {
          if (project.additional_data.includes(category)) {
            this.filteredProjects.push(project);
          }
        });
      });
      if (this.selectedCats.length == 0) {
        this.getProjects();
      }
    },
    async getProjects() {
      try {
        this.loading = true;
        const response = await axios.get("api/get-projects");
        this.projects = response.data.projects;
        // sorting projects on the base of 'in_evidence' field
        this.projects = _.orderBy(
          this.projects,
          [
            function (proj) {
              return proj.in_evidence;
            },
          ],
          ["desc"]
        );

        //mi serve per i filtri
        this.filteredProjects = this.projects;
        this.loading = false;
      } catch (error) {
        this.errors = error.response && error.response.data.errors;
      }
    },
  },
};
</script>
<style lang="scss">
.orderBy {
  cursor: pointer;
}
.filters {
  width: 80%;
  height: 70px;
  background: rgb(73, 84, 90);
  border-radius: 10px;
  padding: 20px 10px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-direction: row;
}
.projectsGallery {
  width: 100%;
  min-height: 500px;
  padding: 30px;

  .projectCard {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-direction: row;
    cursor: pointer;
    margin: 20px;

    width: 80%;
    height: 100px;
    padding: 20px;
    transition: 0.5s;

    &:hover {
      background: rgb(195, 195, 195);
      transition: 0.5s;
    }
  }
  .projDescription {
    font-size: 18px;
    font-weight: bold;
  }
  .projectImage {
    max-height: 100%;
    margin: 0 10px;
  }
  .projectTitle {
    h1 {
      font-size: 25px;
    }
    margin-right: 20px;
  }
}
</style>
