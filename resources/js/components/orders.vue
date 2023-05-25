<template>
<div>
    <table class="table" style="color:#000">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Job No</th>
                <th scope="col">B. Name</th>
                <th scope="col">Merchan.</th>
                <th scope="col">Fabric.</th>
                <th scope="col">Or.No</th>
                <th scope="col">Or.Qty</th>
                <th scope="col">U.Price</th>
                <th scope="col">Total</th>
                <th scope="col">Status</th>
                <th scope="col" v-if="checkMr==1">Action</th>
              </tr>
            </thead>
            <tbody style="margin:0;padding:0">

            <template v-for="(item,index) in orders" :key="index">
                    <tr v-if="index==0">
                        <td colspan="11" height="22" align="center" style="font-weight:bold">{{ getMont(item.month) }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{incrementSerial()}}</th>
                        <td>{{ item.job_no }}</td>
                        <td>{{ item.buyer_name}}</td>
                        <td>{{ item.merchandiser }}</td>
                        <td>{{ item.fabrication }}</td>
                        <td>{{ item.order_no }}</td>
                        <td>{{ totalOrderQtyByMonth(item.order_qty) }}</td>
                        <td>${{ item.unit_price }}</td>
                        <td>${{ totalOrderAmountByMonth(item.total) }}</td>
                        <td>{{ item.status?item.status:"N/A" }}</td>
                        <td v-if="checkMr==1">
                            <a  style="color:black" @click="editModal(item.id)"><i class="fa fa-pencil-square" style="font-size:20px"></i></a> | <a  class="text-danger" @click="deleteData(item.id)"><i class="fa fa-trash" style="font-size:20px"></i></a>
                        </td>
                  </tr>
                <template v-if="(index == orders.length-1 || justMothAndYear(item.month)!=justMothAndYear(orders[index+1].month))">
                    <tr><td colspan="11" height="22"></td></tr>
                    <tr style="background:rgb(160 201 248)">
                            <td colspan="6" style="font-weight:bold;color:#000; text-align:left">Total</td>
                            <td style="font-weight:bold;color:#000">{{ printOrderTotal() }}</td>
                            <td></td>
                            <td><span style="font-weight:bold;color:#000">${{ printMonthlyTotal() }}</span></td>
                            <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td v-if="(index == orders.length-1)" align="center" colspan="11" height="22"><b></b></td>
                        <td v-else align="center" colspan="11" height="22"><b>{{ getMont(orders[index+1].month) }}</b></td>
                    </tr>
                </template>

            </template>

            <tr style="background:#d07236">
                <td colspan="6" style="font-weight:bold;color:#000; text-align:left">Grand Total</td>
                <td style="font-weight:bold;color:#000">{{ printGrandTotalQty() }}</td>
                <td></td>
                <td><span style="font-weight:bold;color:#000">${{ printGrandTotal() }}</span></td>
                <td colspan="2"></td>
            </tr>
                 <tr>
                   <td align="center" v-if=" orders.length<1" colspan="11" height="22"><b  class="text-danger">Orders Not Found..</b></td>
                </tr>
        </tbody>
            <tbody style="margin:0;padding:0">

            </tbody>
    </table>

         <!-- Modal content -->
         <Transition>
         <div class="custom-modal" id="successMessage" v-show="isShow">
            <div class="custom-modal-content mt-5 center">
                <div class="custom-modal-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="row my-2 modal-message">
                    <div class="col-md-12 col-sm-12">

                        <h5 class=" text-center">Update Order</h5>
                        <form>
                        <div class="row">
                            <div class="col-lg-4 col-md-6 mb-3 mt-3">
                                <label class="">Month <span class="text-danger">*</span></label>
                                <input id="monthYear" type="monthYearOnly" class="form-control" />
                                <div>
                                    <div v-if="'selectedMonth' in errors">
                                        <span class="text-danger">
                                            {{ errors.selectedMonth[0] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 mt-3">
                                <label>Buyer</label>
                                <select id="buyerSelect" style="width: 100%;" class="form-control buyer" name="buyer" >
                                    <option value="" selected disabled> --Select Buyer-- </option><br/>
                                    <option v-for="(buyer,index) in buyers" :key="index" :value="buyer.id" :selected="editForm.buyer == buyer.buyer_name">
                                        {{ buyer.buyer_name }}
                                    </option>
                                </select>
                                <div v-if="'buyer' in errors">
                                    <span class="text-danger">
                                        {{ errors.buyer[0] }}
                                    </span>
                               </div>
                            </div>
                            <div class="col-md-4 col-sm-12 mt-3">
                                <label>Merchandiser</label>
                                <input type="text" class="form-control" v-model="editForm.merchandiser" placeholder="merchandiser">
                                <div v-if="'merchandiser' in errors">
                                    <span class="text-danger">
                                        {{ errors.merchandiser[0] }}
                                    </span>
                               </div>
                            </div>
                            <div class="col-md-4 col-sm-12 mt-3">
                                <label>Fabrication</label>
                                <input type="text" class="form-control"   v-model="editForm.fabrication" placeholder="fabrication">
                                <div v-if="'fabrication' in errors">
                                    <span class="text-danger">
                                        {{ errors.fabrication[0] }}
                                    </span>
                               </div>
                            </div>
                            <div class="col-md-4 col-sm-12 mt-3">
                                <label>Order No</label>
                                <input type="text" class="form-control" v-model="editForm.order_no" placeholder="order no.">
                                <div v-if="'order_no' in errors">
                                    <span class="text-danger">
                                        {{ errors.order_no[0] }}
                                    </span>
                               </div>
                            </div>
                            <div class="col-md-4 col-sm-12 mt-3">
                                <label>Order Qty</label>
                                <input @keyup="totalPrice()" type="number" class="form-control"  v-model="editForm.order_qty" placeholder="order qry">
                                <div v-if="'order_qty' in errors">
                                    <span class="text-danger">
                                        {{ errors.order_qty[0] }}
                                    </span>
                               </div>
                            </div>
                            <div class="col-md-4 col-sm-12 mt-3">
                                <label >Unit Price</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input @keyup="totalPrice()" type="number" class="form-control" v-model="editForm.unit_price" step="0.001" placeholder="unit price">
                                    </div>
                                <div v-if="'unit_price' in errors">
                                    <span class="text-danger">
                                        {{ errors.unit_price[0] }}
                                    </span>
                               </div>
                            </div>
                            <div class="col-md-4 col-sm-12 mt-3">
                                <label>Total</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                    <input type="text" :value="editForm.total" class="form-control" id="exampleInputEmail1" readonly>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 mt-3">
                                <label>Status</label>
                                <select id="status" style="width: 100%;" class="form-control" name="buyer">
                                    <option value="" selected> --Select Status-- </option><br/>
                                    <option v-for="(status,index) in statuses" :key="index" :value="status.id" :selected="editForm.status == status.status">
                                        {{ status.status }}
                                    </option>
                                </select>
                                <div v-if="'status' in errors">
                                    <span class="text-danger">
                                        {{ errors.status[0] }}
                                    </span>
                               </div>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
                <div class="text-center mt-4 mt-3">
                    <button @click="modalHide()" class="btn btn-sm px-3 btn-primary">Cancel</button>
                    <button @click="updateOrder(editForm.id)" class="btn btn-sm px-3 btn-warning ml-2" >Update</button>
                </div>

            </div>
        </div>
</Transition>
</div>
</template>

<script>
var monthlyOrderAmount=0;
var totalOrderAmount=0;
var monthlyOrderQty=0;
var totalOrderQty=0;
var serial=1;
import axios from "axios";
import moment from 'moment';
export default {
  data(){
    return{
        isShow: false,
        checkMr:'',
        orders:[],
        editForm:{
            id:'',
            selectedMonth:'',
            job_no:'',
            buyer:'',
            merchandiser:'',
            fabrication:'',
            order_no:'',
            order_qty:'',
            unit_price:'',
            total:'',
            status:'',
        },
        errors:[],
        buyers:"",
        statuses:"",
    }
  },
 mounted(){
     this.getOrder();
    //  this.getData();
 },

 methods:{
    getData(){
        this.buyers = "";
        this.statuses = "";
            axios.get('get-data').then((res)=>{
                console.log(res.data.statuses);
                this.buyers = res.data.buyers,
                this.statuses = res.data.statuses
            })
         },
    getOrder(){
        axios.get('orders-list')
    .then((res)=>{
        this.orders = res.data.orders
        this.checkMr = res.data.checkMr
    })
    },

    editModal(id){
         axios.get('edit-order',{params:{id:id}})
         .then((res)=>{
            this.isShow = true;
            this.editForm.id = res.data.order.id;
            document.getElementById('monthYear').value=moment(res.data.order.month).format('MMMM-YYYY');
            this.editForm.job_no = res.data.order.job_no;
            this.editForm.buyer = res.data.order.buyer_name;
            this.editForm.merchandiser = res.data.order.merchandiser;
            this.editForm.fabrication = res.data.order.fabrication;
            this.editForm.order_no = res.data.order.order_no;
            this.editForm.order_qty = res.data.order.order_qty;
            this.editForm.unit_price = res.data.order.unit_price;
            this.editForm.total = res.data.order.total;
            this.editForm.status = res.data.order.status;
            this.getData();

         })


    },
    updateOrder(id){
        this.editForm.buyer = $('#'+'buyerSelect').val();
        this.editForm.status = $('#'+'status').val();
        this.editForm.selectedMonth = $('#'+'monthYear').val();
        axios.post("update-order", {
                params: {
                data: this.editForm,
                    id: id
                },
            })
         .then((res)=>{
             if(res.data.isError==true){
                this.errors = res.data.errors;
             }else{
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

                        this.getOrder();
                        this.isShow = false;
             }
         })
    },

    deleteData(id){
        axios.post("delete-order", {
                params: {
                    id: id
                },
            }).then((res)=>{
                if(res.data.success == true){
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
                        this.getOrder();
                }
            })
    },
    modalHide(){
        this.isShow = false;
    },

    totalPrice(){
             let total = this.editForm.order_qty*this.editForm.unit_price
             return this.editForm.total = total.toFixed(2);
         },


    justMothAndYear(date){

        return moment(date).format('MM-YYYY');
    },

    totalOrderAmountByMonth(total){
        monthlyOrderAmount = parseFloat(monthlyOrderAmount);
        total = parseFloat(total);
        monthlyOrderAmount+=total
        totalOrderAmount+=total
        return total;

    },

    printMonthlyTotal(){
        let tempTotal = parseFloat(monthlyOrderAmount);
        monthlyOrderAmount = 0
        return tempTotal;
    },
    printGrandTotal(){
        serial = 1;
        let tempTotal = parseFloat(totalOrderAmount);
        totalOrderAmount = 0;
        return tempTotal;
    },





    totalOrderQtyByMonth(totalQty){
        totalQty = parseInt(totalQty);
        monthlyOrderQty = parseInt(monthlyOrderQty);
         monthlyOrderQty+=totalQty;
         totalOrderQty+=totalQty;
         return totalQty;
    },
    printOrderTotal(){
        serial = 1;
        let tempTotalQty = parseInt(monthlyOrderQty);
        monthlyOrderQty = 0
        return tempTotalQty;
    },
    printGrandTotalQty(){
        let tempTotalQty = parseInt(totalOrderQty);
        totalOrderQty = 0;
        return tempTotalQty;
    },

    getMont(month){
        return moment(month).format('MMMM-YY');
    },
    incrementSerial(){
        return serial++;
    }

 }
}

</script>

<style scoped>
.modal-message{
    color: #000;
}

.custom-modal {
    position: fixed;
    z-index: 199;
    padding-top: 40px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0, 0, 0);
    background-color: rgba(0, 0, 0, 0.66);
}

.custom-modal-content {
    background-color:  #ffff;
    margin: auto;
    padding: 20px;
    border: 1px solid  #ffff;
    width: 80%;
    border-radius: 15px;
}
.center {
    margin: auto;
    width: 1000px;
}

.my-account-item {
    -webkit-box-shadow: 0px 0px 10px 0px rgba(114, 114, 114, 0.25);
    box-shadow: 0px 0px 10px 0px rgba(114, 114, 114, 0.25);
    /* height: 272px; */
    border-top: 2px solid #8547e2;
    position: relative;
    text-align: center;
    padding: 35px 10px 40px;
    -webkit-transition: all 0.4s ease;
    -o-transition: all 0.4s ease;
    transition: all 0.4s ease;
    cursor: pointer;
}


.text-center{
    text-align: center;
}
.my-account-item:before {
    left: 0;
}
.my-account-item:after {
    right: 0;
}
.custom-modal-icon{
    text-align:center;
    color: #46f2d4;
    font-size: 1.5cm;
}
.table {
    border: 1px solid #000000;
    border-top:0;
    border-right:0;
}
.table td, .table th {
    text-align: center;
    padding: 3px;
    vertical-align: top;
    border-top: 1px solid #000000;
    border-right: 1px solid #000000;
}


</style>
