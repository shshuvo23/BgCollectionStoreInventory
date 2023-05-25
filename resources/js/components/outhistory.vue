<template>
 <div>
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Stock Out History of {{ style_name }}</h6>
        <div class="mb-3">
            <select class="form-control select2-for w-50 ml-auto" name="style_name" id="style_name" onchange="call()">
                        <option value="" selected disabled hidden> --Style Name-- </option>
                        <option v-for="(style, index) in styles"  :key="index" :value="style.id"> {{ style.style_no+' ('+style.buyer_name+')'}} </option>
            </select>
       </div>

       <div>
            <select class="form-control" name="style_name" id="style_name_id" v-on:change="getStockHistory()" v-model="style_id" hidden>
                        <option value="" selected disabled hidden> --Style Name-- </option>
                        <option v-for="(style, index) in styles"  :key="index" :value="style.id"> {{ style.style_no }} </option>
            </select>
       </div>
        <table class="table" id="datatable">
  <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Style No</th>
        <th scope="col">Receiver Name</th>
        <th scope="col">Line no</th>
        <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(item, index) in stockOutHistories" :key="index">
      <td scope="row">{{ index++}}</td>
      <td class="text-primary">{{ item.style_no }}</td>
      <td>{{ item.receiver_name }}</td>
      <td><span class="badge bg-success">{{ item.line_no }}</span></td>
      <td>
        <a :href="routeName+'/'+item.id" class="btn btn-sm btn-primary">Details</a>

        <!-- <a v-if="stock_out_auth==1" :href="stockOutInfoEditRoute+'/'+item.id" class="btn btn-sm btn-primary ml-2">Edit</a> -->
    </td>
    </tr>

  </tbody>
</table>
<!-- <paginate :data="stockOutHistories" @pagination-change-page="getStockHistory" ></paginate> -->
    </div>
</template>

<script>
//   import "jquery/dist/jquery.min.js";
//   import "datatables.net-dt/js/dataTables.dataTables";
//   import "datatables.net-dt/css/jquery.dataTables.min.css";
//   import axios from "axios";
//   import $ from "jquery";

import axios from "axios";
export default {
    data(){
        return{
            pageNumber:"",
            stockOutHistories:[],
            styles:"",
            style_id:"",
            style_name:"",
            routeName: "stock-out-history-info",
            stock_out_auth:'',
            stockOutInfoEditRoute:'stock-out-edit-info',
            searchKey:'',
            search: '',
      headers: [
        {
          text: 'Dessert (100g serving)',
          align: 'start',
          sortable: false,
          value: 'name',
        },
        { text: 'Calories', value: 'calories' },
        { text: 'Fat (g)', value: 'fat' },
        { text: 'Carbs (g)', value: 'carbs' },
        { text: 'Protein (g)', value: 'protein' },
        { text: 'Iron (%)', value: 'iron' },
      ],
      desserts: [
        {
          name: 'Frozen Yogurt',
          calories: 159,
          fat: 6.0,
          carbs: 24,
          protein: 4.0,
          iron: '1%',
        },
        {
          name: 'Ice cream sandwich',
          calories: 237,
          fat: 9.0,
          carbs: 37,
          protein: 4.3,
          iron: '1%',
        },
        {
          name: 'Eclair',
          calories: 262,
          fat: 16.0,
          carbs: 23,
          protein: 6.0,
          iron: '7%',
        },
        {
          name: 'Cupcake',
          calories: 305,
          fat: 3.7,
          carbs: 67,
          protein: 4.3,
          iron: '8%',
        },
        {
          name: 'Gingerbread',
          calories: 356,
          fat: 16.0,
          carbs: 49,
          protein: 3.9,
          iron: '16%',
        },
        {
          name: 'Jelly bean',
          calories: 375,
          fat: 0.0,
          carbs: 94,
          protein: 0.0,
          iron: '0%',
        },
        {
          name: 'Lollipop',
          calories: 392,
          fat: 0.2,
          carbs: 98,
          protein: 0,
          iron: '2%',
        },
        {
          name: 'Honeycomb',
          calories: 408,
          fat: 3.2,
          carbs: 87,
          protein: 6.5,
          iron: '45%',
        },
        {
          name: 'Donut',
          calories: 452,
          fat: 25.0,
          carbs: 51,
          protein: 4.9,
          iron: '22%',
        },
        {
          name: 'KitKat',
          calories: 518,
          fat: 26.0,
          carbs: 65,
          protein: 7,
          iron: '6%',
        },
      ],
        }

    },
    mounted(){
       this.getStockHistory();

       this.getStyle();
    },

    methods: {
        getStockHistory(){

            let style_id = this.style_id;

            axios.get('stock-out-info',{
                params:{
                    styleId: this.style_id,
                    searchBy: this.searchKey,
                }
            })
            .then((response)=>{
                this.stockOutHistories = response.data.stockOut;
                this.stock_out_auth = response.data.stock_out_role
                 var style_name = document.getElementById("style_name_id");

                 if(style_name.options[ style_name.selectedIndex ].value!=''){
                    style_name =  style_name.options[style_name.selectedIndex ].innerHTML;
                    this.style_name = style_name;
                 }
                //  $("#datatable").DataTable();
            })
         },
         getStyle(){
            axios.get('get-style')
            .then((response)=>{
                this.styles = response.data;
            })
         }
    }
}
</script>

<style>

</style>
