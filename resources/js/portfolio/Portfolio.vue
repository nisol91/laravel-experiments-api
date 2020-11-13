<template>
  <div class="boxPortfolio">
    <div id="home" class="scale-in-center">
      <div class="box-sx">
        <h1 id="mainTitle">{{ $t("message.home1") }}</h1>
        <h2>{{ $t("message.home2") }}</h2>
      </div>
      <div class="trianglesBox">
        <img :src="'/triangles_2.png'" alt="" />
      </div>
    </div>
    <div id="projects" class="projects" v-in-viewport.once>
      <div class="box-sx">
        <h1>
          projects <span><i class="far fa-folder-open"></i></span>
        </h1>
        <h4>
          active projects ->
          <span class="font-weight-bold">{{ projectsNumber }}</span>
        </h4>
        <h4>{{ $t("message.projects") }}</h4>
        <div>
          <router-link class="routerLinkProjBtn" :to="{ name: 'projects' }">
            <div class="projBtnBox">
              <div class="projBtn">to the projects</div>
            </div>
          </router-link>
        </div>
      </div>
      <div class="trianglesBox">
        <img :src="'/triangles.png'" alt="" />
      </div>
    </div>
    <div id="about" class="about" v-in-viewport.once>
      <div class="box-sx">
        <h1>
          about <span><i class="far fa-user"></i></span>
        </h1>
        <h4>
          I am nicola, software developer from italy, I have worked as sowftware
          engineer for various companies such as ufirst, managing both fontend
          and backend technologies
        </h4>
      </div>
      <div class="trianglesBox">
        <img :src="'/triangles_3.png'" alt="" />
      </div>
    </div>
    <div id="skills" class="skills" v-in-viewport.once>
      <h1>
        skills and services <span><i class="fas fa-laptop-code"></i></span>
      </h1>
      <h4>{{ $t("message.skills") }}</h4>
      <div>
        <div class="skillBox d-flex justify-content-between align-items-center">
          Php: Laravel, Wordpress<v-progress-linear
            v-model="valueProg_1"
            color="teal darken-3"
          ></v-progress-linear>
        </div>
        <div class="skillBox d-flex justify-content-between align-items-center">
          Javascript: VueJs, Nativescript, JQuery<v-progress-linear
            v-model="valueProg_2"
            color="indigo darken-2"
          ></v-progress-linear>
        </div>
        <div class="skillBox d-flex justify-content-between align-items-center">
          Database: MySQL
          <v-progress-linear
            v-model="valueProg_3"
            color="blue lighten-2"
          ></v-progress-linear>
        </div>
      </div>
      <div>
        <h4>services:</h4>
        <h4>
          <span class="dotList"><i class="far fa-dot-circle"></i></span>
          Laravel-Vue Custom Applications
        </h4>
        <h4>
          <span class="dotList"><i class="far fa-dot-circle"></i></span
          >Wordpress: website or ecommerce
        </h4>
        <h4>
          <span class="dotList"><i class="far fa-dot-circle"></i></span>Mobile
          Applications
        </h4>
      </div>
    </div>
    <div id="contact" label="contact" class="contact" v-in-viewport.once>
      <h1>
        contact <span><i class="far fa-envelope"></i></span>
      </h1>
      <h5>{{ $t("message.contact") }}</h5>
      <h4>nszdevstudio@gmail.com</h4>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      valueProg_1: 0,
      valueProg_2: 0,
      valueProg_3: 0,
      projectsNumber: 0,
    };
  },
  created() {
    this.$store.commit("toggleHomePage", true);

    this.progressBar();
    this.projectsNumberGrow();
  },
  computed: {},
  methods: {
    projectsNumberGrow() {
      setInterval(() => {
        if (this.projectsNumber < 12) {
          this.projectsNumber += 1;
        }
      }, 300);
    },
    progressBar() {
      setInterval(() => {
        if (this.valueProg_1 < 80) {
          this.valueProg_1 = this.valueProg_1 + 8;
        }
        if (this.valueProg_2 < 95) {
          this.valueProg_2 = this.valueProg_2 + 5;
        }
        if (this.valueProg_3 < 85) {
          this.valueProg_3 = this.valueProg_3 + 4;
        }
      }, 100);
    },
  },
};
</script>
<style lang="scss">
.boxPortfolio {
  #mainTitle {
    font-weight: bold;
    font-size: 42px;
  }
  h1 {
    font-size: 40px;
    margin-bottom: 30px;
  }
}
#home,
#projects,
#about,
#skills,
#contact {
  width: 100%;
  height: 400px;
  border-bottom: 1px solid grey;
  padding: 40px 60px;
}
#home {
  //   height: 100vh;
  background: rgb(82, 106, 149);
  clip-path: polygon(0 0, 100% 0, 100% 100%, 0 calc(100% - 5vw));
  display: flex;
  justify-content: space-around;
}
#projects {
  background: rgb(136, 159, 180);
  display: flex;
  justify-content: space-around;
}
#about {
  background: rgb(75, 92, 122);
  display: flex;
  justify-content: space-around;
  h4 {
    width: 70%;
  }
}
#skills {
  background: rgb(125, 161, 230);
  clip-path: polygon(0 0, 100% 0, 100% 70%, 0 calc(100% - 5vw));
  height: 600px;
}
#contact {
  background: rgb(64, 71, 85);
  height: 200px;
}

.skillBox {
  margin: 20px;
}
.icons-box {
  width: 100px;
  i {
    cursor: pointer;
  }
}
.box-sx {
  width: 80%;
}
.trianglesBox {
  img {
    width: 550px;
  }
}
.dotList {
  margin: 0 10px;
}

// fade animations entrance

.projects {
  opacity: 0;
}
.projects.in-viewport {
  opacity: 1;
  -webkit-animation: puff-in-center 0.7s cubic-bezier(0.47, 0, 0.745, 0.715)
    both;
  animation: puff-in-center 0.7s cubic-bezier(0.47, 0, 0.745, 0.715) both;
}
.about {
  opacity: 0;
}
.about.in-viewport {
  opacity: 1;
  -webkit-animation: scale-in-center 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94)
    both;
  animation: scale-in-center 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
}
.skills {
  opacity: 0;
}
.skills.in-viewport {
  opacity: 1;
  -webkit-animation: scale-in-center 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94)
    both;
  animation: scale-in-center 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
}
.contact {
  opacity: 0;
  transition: opacity 3s;
}
.contact.in-viewport {
  opacity: 1;
}
</style>


