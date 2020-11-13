<template>
  <div class="p-4 d-flex flex-column">
    <div v-if="project.disabled">coming soon</div>
    <div v-if="!project.disabled">
      <router-link
        class="backBtn d-flex justify-content-center align-items-center"
        :to="{ name: 'projects' }"
        >back to projects</router-link
      >
      <div class="titleProjBar d-flex flex-row">
        <h3 class="projText">
          Title: <span class="projTextBold">{{ project.name }}</span>
        </h3>
      </div>
      <div>
        <h4 class="projText">
          Description:
          <span class="projTextBold">{{ project.description }}</span>
        </h4>
        <h6 class="projText">
          Technologies:
          <span class="projTextBold">{{ project.additional_data }}</span>
        </h6>
        <v-btn v-if="project.url != '.'" color="primary" rounded dark>
          <a
            class="routerInsideVButton linkProjBtn d-flex justify-content-center align-items-center"
            :href="project.url"
            >links</a
          >
        </v-btn>
        <v-btn
          v-if="
            project.additional_data &&
            project.additional_data.includes('interactive')
          "
          color="primary"
          rounded
          dark
        >
          <router-link
            class="linkProjBtn d-flex justify-content-center align-items-center"
            :to="{ name: 'laravelBnB' }"
            >to the interactive project</router-link
          >
        </v-btn>
      </div>

      <div class="mediaProj d-flex flex-row align-items-start">
        <div class="mediaSx">
          <h4 v-if="$i18n.locale == 'en'">
            {{ project.long_description }}
          </h4>
          <h4 v-if="$i18n.locale == 'it'">
            {{ project.long_description_ita }}
          </h4>
        </div>
        <div
          class="mediaDx d-flex flex-column justify-content-center align-items-center"
        >
          <!-- IMPORTANTE-------METTI SEMPRE IL / ALL INIZIO DEI PERCORSI -->
          <img
            v-for="image in project.media"
            :key="image.storage_path"
            class="projectImage2"
            :src="`/storage/${image.storage_path}`"
            alt=""
          />
          <video
            v-if="
              project.media &&
              project.media.length > 0 &&
              project.media[0].storage_path_video != '.'
            "
            width="600"
            height="240"
            controls
            class="projVideo"
          >
            <source
              :src="`/storage/${project.media[0].storage_path_video}`"
              type="video/mp4"
            />
            Your browser does not support the video tag.
          </video>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      id: this.$route.params.id,
      project: {},
    };
  },
  created() {
    this.$store.commit("toggleHomePage", false);

    this.getProject();
  },
  methods: {
    async getProject() {
      try {
        const response = await axios.get(`/api/get-project/${this.id}`);
        this.project = response.data.project;
        //   console.log(response.data.project);
      } catch (error) {
        this.errors = error.response && error.response.data.errors;
      }
    },
  },
};
</script>
<style lang="scss">
.linkProjBtn {
  //   width: 200px;
}
.mediaSx {
  width: 100%;
  padding-right: 10px;
  border-right: 2px solid rgba(81, 86, 95, 0.616);
}
.mediaDx {
  width: 100%;
}
.projectImage2 {
  margin: 20px 10px;
  width: 60%;
  &:hover {
  }
}
.projText {
  margin: 30px 0px;
}
.projTextBold {
  font-weight: bold;
}
.projVideo {
  margin: 20px 10px;
}
.mediaProj {
  border-top: 1px solid rgba(60, 69, 85, 0.616);
  margin: 30px 0px;
  padding: 30px 0px;
  flex-wrap: wrap !important;
}
.backBtn {
  width: 200px;
  margin-bottom: 20px;
  padding: 10px;
  border: 1px solid grey;
  &:hover {
    background: grey;
    transition: 0.5s;
  }
}
</style>
