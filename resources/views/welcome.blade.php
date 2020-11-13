<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>NszDeveloperStudio</title>

    {{--  <!-- Fonts -->  --}}
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    {{-- icon --}}
    <link rel="icon" href="{{ URL::asset('/myicon3.ico') }}" type="image/x-icon"/>

    {{--  <!-- vue local -->  --}}
    <script src="{{ asset('js/app.js') }}" defer></script>

    {{--  <!-- VueJS cdn -->  --}}
    {{--  <script src="https://cdn.jsdelivr.net/npm/vue@latest/dist/vue.min.js"></script>  --}}

    {{--  vuetify icons cdn  --}}
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">

    {{-- css --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{--  <!-- Mapbox-->  --}}
    <script src="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css" rel="stylesheet" />

    {{--  <!-- Mapbox GEOcoder-->  --}}
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js"></script>
    <link
    rel="stylesheet"
    href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.css"
    type="text/css"
    />


</head>

<body>

    <div id="app">
        <index></index>
    </div>

</body>

</html>
