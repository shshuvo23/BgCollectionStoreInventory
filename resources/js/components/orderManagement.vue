<template>
     <div>
        <keep-alive>
        <form @submit.prevent="orderCreate()">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-3">
                    <label class=""><strong>Month <span class="text-danger">*</span></strong></label>
                    <input id="monthYear" type="monthYearOnly" class="form-control" />
                    <div>
                        <div v-if="'selectedMonth' in errors">
                            <span class="text-danger">
                                {{ errors.selectedMonth[0] }}
                            </span>
                        </div>
                    </div>
                </div>


                <!-- col -->
                <div class="col-lg-4 col-md-6 mb-3">
                    <label class=""><strong>Buyer Name <span class="text-danger">*</span></strong></label>
                    <select id="buyer" class="form-control" name="buyer" >
                        <option value="" selected disabled> --Select Buyer-- </option>
                        <option v-for="(buyer,index) in buyers" :key="index" :value="buyer.id" >
                              {{ buyer.buyer_name }}
                        </option>
                    </select>
                    <div>
                        <div v-if="'buyer' in errors">
                            <span class="text-danger">
                                {{ errors.buyer[0] }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- col -->

                <div class="col-lg-4 col-md-6 mb-3">
                    <label class=""><strong>Merchandiser <span class="text-danger">*</span></strong></label>
                        <input v-model="orders.merchandiser" type="text" class="form-control" placeholder="Merchandiser Name" />
                    <div>
                        <div v-if="'merchandiser' in errors">
                            <span class="text-danger">
                                {{ errors.merchandiser[0] }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <label class=""><strong>Fabrication <span class="text-danger">*</span></strong></label>
                        <input v-model="orders.fabrication" type="text" class="form-control" placeholder="Fabrication" />
                    <div>
                        <div v-if="'fabrication' in errors">
                            <span class="text-danger">
                                {{ errors.fabrication[0] }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <label class=""><strong>Order No <span class="text-danger">*</span></strong></label>
                        <input v-model="orders.order_no" type="text" class="form-control" placeholder="Order No" />
                    <div>
                        <div v-if="'order_no' in errors">
                            <span class="text-danger">
                                {{ errors.order_no[0] }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <label class=""><strong>Order Qty <span class="text-danger">*</span></strong></label>
                        <input v-model="orders.order_qty" @keyup="totalPrice()" type="number" min="1" class="form-control" placeholder="Order qty" />
                    <div>
                        <div v-if="'order_qty' in errors">
                            <span class="text-danger">
                                {{ errors.order_qty[0] }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <label class=""><strong>Unit Price <span class="text-danger">*</span></strong></label>
                    <div class="input-group ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input  v-model="orders.unit_price" @keyup="totalPrice()" type="number"  class="form-control"  step="0.001" placeholder="Unit price" />
                    </div>
                    <div>
                        <div v-if="'unit_price' in errors">
                            <span class="text-danger">
                                {{ errors.unit_price[0] }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6  mb-3">
                    <label class=""><strong>Total</strong></label>
                    <div class="input-group ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input :value="orders.total" readonly type="text" class="form-control" placeholder="0"/>
                    </div>
                    <div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6  mb-3">
                    <label class=""><strong>Status</strong></label>
                    <select id="status" class="form-control" name="status" >
                        <option value="" selected> --Select Status-- </option>
                        <option v-for="(status,index) in statuses" :key="index" :value="status.id" >
                              {{ status.status }}
                        </option>
                    </select>
                </div>
          </div>
               <input  type="submit" class="btn mt-3 btn-primary " value="Submit"/>
        </form>
    </keep-alive>
    </div>

</template>

<script>
import axios from 'axios';
export default {
 name: "orderManagement",
  data(){
    return {
        orders:{
            buyer:"",
            merchandiser:"",
            fabrication:"",
            order_no:"",
            order_qty:"",
            unit_price:"",
            status:"",
            total:"",
            selectedMonth:''
        },
        errors:[],
        buyers:[],
        statuses:[],

    }
  },
  mounted() {
         this.getData();
  },
  methods:{
         getData(){
            axios.get('get-data').then((res)=>{
            //    console.log(res.data.statuses);
                this.buyers = res.data.buyers,
                this.statuses = res.data.statuses
            })
         },
         orderCreate(){
                let buyer = $('#'+'buyer').val();
                let status = $('#'+'status').val();
                this.orders.selectedMonth = $('#'+'monthYear').val();
                this.orders.buyer = buyer;
                this.orders.status = status;


            axios.post('order-create',this.orders)
           .then((res)=>{
                console.log(res.data);
                if(res.data.isError){
                    this.errors = res.data.errors
                }else{
                    this.orders.fabrication = "";
                    this.orders.order_no = "";
                    this.orders.order_no = "";
                    this.orders.order_qty = "";
                    this.orders.unit_price = "";
                    this.orders.total= "";
                    this.orders.status= "";
                    const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: res.data.message
                        })

                        // this.orders = {}
                        // this.orders.job_no = res.data.oldData.job_no;
                        // this.orders.merchandiser = res.data.oldData.merchandiser;
                }

            })
         },

         totalPrice(){
             let total = this.orders.order_qty*this.orders.unit_price
             return this.orders.total = total.toFixed(2);
         }
    }
}
</script>

<style>

</style>
