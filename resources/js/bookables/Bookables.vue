<template>
  <div>
    <h1>main bookables {{ rowsNumber }}</h1>
    <div v-if="loading">loading bookables....</div>
    <div v-else>
      <!-- <div
        class="row"
        v-for="row in rowsNumber"
        :key="'row' + row"
      >{{rowsNumberPlusString("stringaaaa", row)}}</div>-->
      <div class="flex_1">
        <!-- questa forma e molto piu leggera di quella sotto commentata, perche passo un intero oggetto -->
        <bookable-list-item
          v-bind="bookable"
          v-for="(bookable, index) in bookables"
          :key="index"
        ></bookable-list-item>
        <!-- <bookable-list-item
          v-bind:title="bookable.title"
          :content="bookable.description"
          v-bind:id="bookable.price"
          v-for="(bookable, index) in bookables"
          :key="index"
        ></bookable-list-item>-->
      </div>
    </div>
  </div>
</template>

<script>
import BookableListItem from "./BookablesListItem";
export default {
  components: {
    BookableListItem: BookableListItem,
  },
  data() {
    return {
      bookables: null,
      loading: true,
    };
  },
  // computed methods are always in listening of changes
  computed: {
    rowsNumber() {
      return this.bookables != null ? Math.ceil(this.bookables.length / 3) : 0;
    },
  },
  methods: {
    rowsNumberPlusString(str, rowsNumber) {
      return str + " " + rowsNumber;
    },
  },
  created() {
    const req = axios
      .get("api/bookables")
      .then((response) => {
        this.bookables = response.data.data;
        this.loading = false;
      })
      .catch((response) => {
        //  console.log("error--->" + response)
      });
    // console.log(req);

    // console.log("component created");

    // setTimeout(() => {
    //   this.bookables = [
    //     {
    //       title: "cheap ville",
    //       content: "really beautyful ville but cheap",
    //       price: 2300,
    //     },
    //     {
    //       title: "expensive ville",
    //       content: "mystic wonderful",
    //       price: 2100,
    //     },
    //     {
    //       title: "expensive ville",
    //       content: "mystic wonderful",
    //       price: 1300,
    //     },
    //     {
    //       title: "expensive ville",
    //       content: "mystic wonderful",
    //       price: 5600,
    //     },
    //     {
    //       title: "expensive ville",
    //       content: "mystic wonderful",
    //       price: 1000,
    //     },
    //     {
    //       title: "expensive ville",
    //       content: "mystic wonderful",
    //     },
    //     {
    //       title: "expensive ville",
    //       content: "mystic wonderful",
    //     },
    //   ];
    //   this.loading = false;
    // }, 1000);
  },
};
</script>

