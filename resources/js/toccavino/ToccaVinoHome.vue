<template>
  <div>
    <div class="d-flex justify-content-between">
      <h1>welcome to tocca vino</h1>
      <router-link class="btn nav-button" :to="{ name: 'toccaVinoAddEvent' }">
        <div class="btn btn-secondary">add your own wine event</div>
      </router-link>
      <router-link class="btn nav-button" :to="{ name: 'toccaVinoPayment' }">
        <div class="btn btn-secondary">support us</div>
      </router-link>
    </div>

    <h3>...sottotitolo...</h3>
    <success-banner
      v-if="bannerEventName"
      :bannerEventName="bannerEventName"
    ></success-banner>

    <h6 class="tv-searchBar border-top border-bottom">
      <div>searchbar</div>
      <input
        type="text"
        v-model="searchValue"
        class="form-control"
        @keyup="searchEvent(searchValue)"
      />
    </h6>
    <h6 class="tv-map border-top border-bottom">
      <mapbox-map></mapbox-map>
    </h6>

    <div class="btn btn-secondary" @click="sortPrice">sort by price</div>
    <div class="btn btn-secondary" @click="sortName">sort by name</div>

    <div v-if="loading">loading....</div>
    <div v-if="!loading">
      <transition-group name="flip-list">
        <div
          class="pt-2 border-top tv-wineEventCard"
          v-for="event in wineEventsFiltered"
          :key="event.id"
        >
          <div class="d-flex justify-content-between">
            <span>{{ event.name }}</span>
            <span>{{ event.city }}</span>
            <span>${{ event.price }}</span>
          </div>
          <div class="mt-4">{{ event.description }}</div>
          <div class="mt-4">IMMAGINE</div>
        </div>
      </transition-group>
      <!-- <div class="navigatePagination d-flex justify-content-between">
                <i class="fas fa-angle-left freccia" @click="pagePrev"></i>
                <i class="fas fa-angle-right freccia" @click="pageNext"></i>
            </div> -->
    </div>
    <tocca-vino-footer></tocca-vino-footer>
  </div>
</template>

<script>
import ToccaVinoFooter from "../toccavino/ToccaVinoFooter";
export default {
  components: {
    ToccaVinoFooter: ToccaVinoFooter,
  },
  data() {
    return {
      // currentPagePagination: 1,
      bannerEventName: this.$route.params.eventName,
      searchValue: null,
      loading: false,
      wineEvents: null,
      wineEventsFiltered: null,
      sorting: {
        price: false,
        name: false,
      },
    };
  },
  created() {
    this.getEvents();
  },
  methods: {
    async getEvents() {
      this.loading = true;

      try {
        this.wineEvents = (
          await axios.get(
            `api/wine-events`
            // `api/wine-events?page=${this.currentPagePagination}`
          )
        ).data;
        //  console.log(this.wineEvents);
      } catch (error) {}
      this.loading = false;
      this.wineEventsFiltered = this.wineEvents;
    },
    // eventuale pagination
    pageNext() {
      this.currentPagePagination += 1;
      //  console.log(this.currentPagePagination);
      this.getEvents();
    },
    pagePrev() {
      if (this.currentPagePagination != 1) {
        this.currentPagePagination -= 1;
        //   console.log(this.currentPagePagination);

        this.getEvents();
      }
    },
    searchEvent(val) {
      this.wineEventsFiltered = _.filter(this.wineEvents, function (o) {
        return (
          o.name.includes(val) ||
          o.city.includes(val) ||
          o.price.toString().includes(val)
        );
      });
      //    console.log(this.wineEventsFiltered);
    },
    sortPrice() {
      if (this.sorting.price) {
        this.wineEventsFiltered = _.reverse(
          _.sortBy(this.wineEventsFiltered, ["price"])
        );
        this.sorting.price = false;
      } else {
        this.wineEventsFiltered = _.sortBy(this.wineEventsFiltered, ["price"]);
        this.sorting.price = true;
      }
    },
    sortName() {
      if (this.sorting.name) {
        this.wineEventsFiltered = _.reverse(
          _.sortBy(this.wineEventsFiltered, ["name"])
        );
        this.sorting.name = false;
      } else {
        this.wineEventsFiltered = _.sortBy(this.wineEventsFiltered, ["name"]);
        this.sorting.name = true;
      }
    },
  },
  computed: {},
};
</script>

<style scoped>
.tv-searchBar {
  margin: 50px 0;
}
.tv-map {
  margin: 50px 0;
  height: 400px;
  width: 100%;
}
.tv-wineEventCard {
  margin: 50px 0;
}
.flip-list-move {
  transition: transform 1s;
}
.freccia {
  font-size: 20px;
  cursor: pointer;
}
</style>
