<template>
    <div>
        <div id="map"></div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            token:
                "pk.eyJ1Ijoibmlzb2w5MSIsImEiOiJjazBjaWRvbTIwMWpmM2hvMDhlYWhhZGV0In0.wyRaVw6FXdw6g3wp3t9FNQ"
        };
    },
    methods: {},
    computed: {},
    mounted() {
        mapboxgl.accessToken = this.token;
        const map = new mapboxgl.Map({
            container: "map", // container id
            style: "mapbox://styles/nisol91/ckfavr6400ebf19mrwoocgtbo", // style URL
            center: [11, 45], // starting position [lng, lat]
            zoom: 5 // starting zoom
        });
        const geocoder = new MapboxGeocoder({
            accessToken: this.token,
            mapboxgl: mapboxgl
        });
        map.addControl(geocoder);
        // console.log(geocoder);
    }
};
</script>

<style scoped>
#map {
    height: 300px;
    width: 100%;
}
</style>
