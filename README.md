# Laravel Boilerplate

### nuovo progetto:

per un nuovo progetto ci sono 2 alternative:

-   si crea progetto da 0 poi si copiano files e pezzi di codice dal boilerplate, all'occorrenza.
-   si copia l'intero boilerplate, poi man mano si elimina roba che non serve (forse è la soluzione migliore, almeno per i primi progetti, perchè ti da già un'app comunque funzionante out of the box)

### parti mancanti da aggiungere/imparare:

-   [ ] vue-native (da documentazione, clonando le app che mette a disposizione) oppure vueNativeScript (sempre da documentazione e clonando app boilerplate)
-   [ ] integrazione con firebase (notifiche, altro?)
-   [ ] cerca i migliori boilerplate/starter kit/admin panel (io diffiderei comunque delle cose prefatte, e comunque dai boilerplate/admin panel prefatti prenderei solo parti di codice utile da aggiungere al mio, se possibile)

###### cose fatte

-   [x] email verification
-   [x] auth forgotten-reset password (programming with peter lesson 6-7)
-   [x] gestione ruoli e protezione chiamate http(laravel guards/gates) (programming with peter lesson 10-11-19) .22
-   [x] user details / change password (programming with peter lesson 13) .22
-   [x] crud completa (in particolare salvataggio e modifica dati) + caricamento files (storage) (hidran) .26
-   [x] caricamento files

### after cloning a laravel-vue webapp:

```
rename .env.example to .env
composer install
php artisan key:generate
(for errors see storage/logs/laravel.log)
php artisan storage:link
npm install
```

---

### useful links

-   laravel

https://www.youtube.com/watch?v=MjyT-h6fQco&list=PLRoT2Wf8XDsCoow0l5-HXDlEFZJp7alSI&ab_channel=ProgrammingwithPeter
https://github.com/mp27

https://github.com/piotr-jura-udemy/laravel-cheat-sheet

https://learninglaravel.net/cheatsheet/#

https://qiita.com/netfish/items/1094f18fa32f03c614c3

crud

https://www.codewall.co.uk/laravel-crud-demo-with-resource-controller-tutorial/

-   vue

https://devhints.io/vue

-   starter/boilerplate

https://madewithlaravel.com/laravel-vue-spa

https://spark.laravel.com/docs/11.0/installation

https://github.com/cretueusebiu/laravel-vue-spa

https://github.com/AnowarCST/laravel-vue-crud-starter

### main steps laravel:

```
npm install
composer require laravel/ui
npm run watch

php artisan make:model Bookable -m
php artisan make:controller Api/BookableController
php artisan make:controller Api/BookableController --resource (se voglio creare già tutte le routes automaticamente)
php artisan make:factory BookableFactory --model=Bookable
php artisan make:seeder BookablesTableSeeder
php artisan migrate:refresh --seed
php artisan make:resource BookableIndexResource (la risorsa mi espone solo alcuni fields di quel model che decido io)
php artisan make:controller Api/BookableAvailabilityController --invokable (questo per i single action controller, che gestiscono solo un metodo)
```

### migrations useful commands:

```
// drops everything
php artisan migrate:reset
php artisan migrate:fresh

```

---

### main steps vue:

vedi documentazione.

### vuetify

vedi docs.

### note:

Questo boilerplate non va capito al 100% in ogni singola parte, va più visto come una serie
di funzionalità e di tools che conosci abbastanza bene e sai come utilizzare a grandi linee.
L'importante è riuscire a COLLEZIONARE il maggior numero di use cases e funzionalità, di modo da poter avere codice FUNZIONANTE che si può utilizzare all'occorrenza, come un pezzo di puzzle, per generare velocemente una applicazione performante in tutte le sue parti, senza troppo overhead.
Poi per esempio, magari non sai come funzionano le guards o i gates a menadito, però sai come far ritornare al codice di laravel un response e sai come usare lo stato dell'app di vuex, quindi alla fine puoi fare qualsiasi cosa conoscendo anche solo sti due concetti.
