<template>
    <div>
        <div class="">
            <input
                @keyup="
                    $emit('input', $event.target.value);
                    $emit('get-coords', coordinates);
                    getPlace();
                "
                type="text"
                class="form-control"
                v-model="search"
                :class="{ 'is-invalid': errorsCity }"
            />
            <div v-if="errorsCity" class="cityError">Insert city</div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["value", "errorsCity"],
    data() {
        return {
            coordinates: null,
            search: this.$props.value,
            token:
                "pk.eyJ1Ijoibmlzb2w5MSIsImEiOiJjazBjaWRvbTIwMWpmM2hvMDhlYWhhZGV0In0.wyRaVw6FXdw6g3wp3t9FNQ"
        };
    },
    methods: {
        async getPlace() {
            try {
                this.coordinates = (
                    await axios.get(
                        `https://api.mapbox.com/geocoding/v5/mapbox.places/${this.search}.json?limit=5&language=it-IT&access_token=${this.token}`
                    )
                ).data.features[0].center;
                // console.log(this.coordinates);
            } catch (error) {}
        }
    },
    computed: {}
};
</script>

<style scoped>
.cityError {
    font-size: 11px;
    color: red;
    display: block;
}
</style>
