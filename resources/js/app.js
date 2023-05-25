// import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler';
const app = createApp({});


import stockOut from './components/stock_out.vue';
import ReceiverList from './components/receivers/index.vue';
import LaravelVuePagination from 'laravel-vue-pagination';
import StockOutHistory from './components/outhistory.vue';
import ExampleComponent from './components/ExampleComponent.vue';
import oderManagement from './components/orderManagement.vue';
import ordersList from './components/orders.vue';
// import Select2 from 'vue3-select2-component';


app.component('stock-out', stockOut);
app.component('receivers-list', ReceiverList);
app.component('paginate',LaravelVuePagination);
app.component('stock-out-history',StockOutHistory);
app.component('example-component',ExampleComponent);
app.component('oder-management',oderManagement);
app.component('oder-list',ordersList);
// app.component('Select2', Select2)
app.mount('#app');
