<template>
    <div class="br-section-wrapper mt-4">
        <div class="">
            <div class="d-flex justify-content-between mb-3">
                 <div>
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Stock Out</h6>
                 </div>

                <div>
                    <a :href="this.stockOutHistory" class="btn btn-sm btn-primary">Stock Out History</a>
                </div>
            </div>

        </div>
        <div></div>
        <form @submit.prevent="stockOutAcss()">

            <div class="row">
                <div class="col-lg-6 col-md-6 mb-3">
                    <label class=""><strong>Style Name</strong></label>
                    <select id="style_no" onchange="production()" class="form-control" name="style_id" >
                        <option value=""> --Select Style-- </option>
                        <option v-for="(style,index) in styles" :key="index" :value="style.id" >
                            {{ style.style_no+'('+style.order_no+' '+','+' '+style.buyer_name+')'+' '+style.created_at_format }}
                        </option>
                    </select>
                    <div>
                        <div v-if="'style_id' in errors">
                            <span class="text-danger">
                                {{ errors.style_id[0] }}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- col -->

                <div class="col-lg-6 col-md-6 mb-3">
                    <label class=""><strong>Receiver Name</strong></label>
                    <select id="receiver" class="form-control" name="receiver" >
                        <option value="" selected disabled> --Receiver Name-- </option>
                        <option v-for="(receiver,index) in receivers" :key="index" :value="receiver.id" >
                              {{ receiver.receiver_name }}
                        </option>
                    </select>
                    <div v-if="'receiver_id' in errors">
                        <span class="text-danger">
                            {{ errors.receiver_id[0] }}
                        </span>
                    </div>
                </div>
                <!-- col -->

                <div class="col-lg-6">
                    <label class=""><strong>Line No</strong></label>
                    <input v-model="stockOutData.line_number" type="text" class="form-control" placeholder="Line number" />
                    <div v-if="'line_number' in errors">
                        <span class="text-danger">
                            {{ errors.line_number[0] }}
                        </span>
                    </div>
                </div>

                <div class="col-lg-6">
                    <label class=""><strong>Stock Out Date</strong></label>
                    <input v-model="stockOutData.date" type="date" class="form-control" />
                    <div v-if="'date' in errors">
                        <span class="text-danger">
                            {{ errors.date[0] }}
                        </span>
                    </div>
                </div>
               </div>
                <Transition>
                    <div class="row mt-4">
                    <div class="col">
                        <div class="table-responsive p-3">
                           <div class="float-right">
                            <!-- <input data-role="tagsinput" type="text"  v-model="searchKey" @keyup="getAccessoriesList()" class="form-control" placeholder="Search"> -->

                            <div class='tag-input'>
                                    <div v-for='(tag, index) in tags' :key='tag' class='tag-input__tag'>
                                     <span @click='removeTag(index)'>x</span>
                                    {{ tag }}
                                    </div>
                                    <input
                                        type='text'
                                        placeholder="Enter search tag"
                                        class='tag-input__text'
                                        :onchange='addTag'
                                        @keydown.enter='addTag'
                                        @keydown.,='addTag'
                                        @keydown.delete='removeLastTag'
                                    />
                                </div>
                           </div>

                            <table class="table table-hover mg-b-0" id="datatable">
                                <div class="input-group mb-3">

                            </div>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Acc. Name</th>
                                        <th>Unit</th>
                                        <th>Size</th>
                                        <th>Color</th>
                                        <th>Stock Qty</th>
                                        <th>Bar/Ean</th>
                                        <th>Consumption</th>
                                        <th>R.Q</th>
                                        <th>Stock Out QTY</th>
                                    </tr>
                                </thead>
                                <tbody v-if="accessories.length > 0">
                                    <tr  v-for="( accessory, index ) in accessories" :key="index">

                                            <th scope="row">{{ index + 1 }}</th>


                                        <td>
                                            {{ accessory.accessories_name }}
                                        </td>
                                        <td>{{ accessory.unit?accessory.unit:'N/A' }}</td>
                                        <td>{{ accessory.size?accessory.size:'N/A' }}</td>
                                        <td >{{ accessory.color_name?accessory.color_name:'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-warning">{{ accessory.stock_quantity }}</span>
                                        </td>
                                        <td ><span>{{ accessory.bar_or_ean_code?accessory.bar_or_ean_code:'N/A' }}</span></td>
                                        <td >
                                            <span
                                            :class="consumptionColor(accessory.consumption)">{{ accessory.consumption  }}</span>
                                        </td>
                                        <td>
                                            {{ accessory.requered_quantity }}
                                        </td>
                                        <!-- <td>{{ accessory.inventory_id }}</td> -->
                                        <!-- <input  v-model="accessory.inventory_id" type="text"/> -->
                                        <td>
                                            <input  :value="myMap[accessory.inventory_id]" :id="accessory.inventory_id" @change="getInventoryId( accessory.inventory_id )" placeholder="Quantity" type="number" min="1" class="form-control" />
                                            <div  v-if=" accessory.inventory_id in errors " >
                                                <span class="text-danger"> {{ errors[ accessory.inventory_id ]}}
                                                </span>
                                            </div>
                                        </td>

                                    </tr>

                                </tbody>

                                <tbody v-else>
                                    <Transition>
                                    <tr>
                                        <td colspan="9" class="text-center text-danger">Woops! Data Not Found</td>
                                    </tr>
                                  </Transition>
                                </tbody>

                            </table>
                        </div>
                          <input v-if="isBtn" type="submit" class="btn mt-3 btn-primary " value="Stock Out"/>
                    </div>
                </div>

            </Transition>

            <Transition>
               <div id="stockOuts">

               </div>
            </Transition>
        </form>
    </div>
    <div class="row">
               <div class="col">
                    <select id="styleSeeder"
                        v-model="stockOutData.style_id"
                        v-on:change="getAccessoriesList()"
                        class="form-control"
                        name="style_id"

                    hidden>
                        <option value="" selected disabled hidden>
                            --Select Style--
                        </option>
                        <option v-for="(style, index) in styles" :key="index" :value="style.id">
                            {{ style.style_no }}
                        </option>
                    </select>

               </div>
           </div>
</template>


<script>
 var map = {};
import axios from "axios";
import moment from 'moment';
export default {
    data() {
        return {
            myMap:[],
            isSuccess: false,
            carry:false,
            message: "",
            error: false,
            errors: [],
            styles: [],
            accessories: [],
            receivers: [],
            size_name: [],
            color_name: [],
            stockOutData: {
                style_id: "",
                receiver_id: "",
                line_number: "",
                date: "",
            },
            isBtn: false,
            stockOutHistory:"stock-out-history",
            consumptionColorSet: "",
            stockOutInfos: [],
            printUrl:"print-stockout-info",
            downLoadUrl:"download-stockout-info",
            searchKey:'',
            tags: []
        };
    },



    mounted() {
        this.getData();
        this.consumptionColor();

    },
    methods: {
        getData() {
            axios
                .get("get-data", {})
                .then((res) => {

                        this.styles = res.data.styles
                        this.receivers = res.data.receivers
                })
                .catch((error) => {});
        },

        getAccessoriesList(){

           axios
            .get("get-accessories", {
                params: {
                    style_id: this.stockOutData.style_id,
                    tags: this.tags
                },
            }).then((res) => {
                //  if(res.data.tags)this.tags = res.data.tags;
                this.myMap = map;
                this.accessories = res.data.stockAccessories;
                console.log(res.data.stockAccessories);
                if(this.accessories.length>0){
                    this.isBtn = true;
                }
                this.consumptionColor();
            }).catch((error) => {});
        },

        stockOutAcss() {
            let receiver = $('#'+'receiver').val();
            this.stockOutData.receiver_id = receiver;

            this.errors = {};
            axios.post("accessories-out", {
                    params: {
                        data: this.stockOutData,
                        quantity: map,
                    },
                })
                .then((res) => {
                    console.log(res.data);
                    if (res.data.isError == true) {
                        if (res.data.error_type == "validation_error") {
                            this.errors = res.data.errors;
                        }
                        if (res.data.error_type == "quantityErrors") {
                            this.errors = res.data.quantityErr;
                        }


                    } else {

                        this.isSuccess = true;
                        this.message = res.data.isSuccess;
                       var stockOuts =  document.getElementById('stockOuts')
                         stockOuts.innerHTML = res.data.stockOuts;
                        for (const key in map) {
                            $("#" + key).val("");
                        }
                        map = {};
                        this.getAccessoriesList();


                        if(res.data.isSuccess == true){
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
                            title: "Stock Out Success"
                        })
                        }else{
                            Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: "Woops! You don't stock out any accessories",

                            })
                        }


                    }
                })
                .catch((e) => {});
        },

        getInventoryId(id) {

            if($("#" + id).val() != null && $("#" + id).val() != "") {
                map[id] = $("#" + id).val();
            } else {
                map[id] = 0;
            }

            var tmpMap = map;
            map = {};
            for (const key in tmpMap) {
                if(tmpMap[key] != 0){
                    map[key] = tmpMap[key];
                }
            }

        },

        consumptionColor(consumption){
               if(consumption==1){
                 return 'badge bg-info';
               }else if(consumption==2){
                  return 'badge bg-warning';
               }else if(consumption==3){
                 return 'badge bg-primary';
               }else if(consumption==4){
                 return 'badge bg-success';
               }else if(consumption==5){
                 return 'badge bg-secondary';
               }else{
                 return 'badge bg-danger';
               }
        },

        getHumanDate(date){
            return moment(date, 'YYYY-MM-DD').format('DD/MM/YYYY');
        },

        justMothAndDate(date){
            return moment(date).format('MMM-DD');
        },

        addTag (event) {

             if(event.code == "Comma" || event.code == "Enter" || event.type=="change"){
                event.preventDefault()
                var val = event.target.value.trim()
                if (val.length > 0) {
                        if(this.tags.length <= 2){
                            this.tags.push(val)
                            event.target.value = ''
                        }else{
                            event.target.value = ''
                        }
                       this.getAccessoriesList();

                }

             }

            },

        removeTag (index) {
            this.tags.splice(index, 1);
            this.getAccessoriesList();


        },
        removeLastTag(event) {
            if (event.target.value.length === 0) {
                this.removeTag(this.tags.length - 1);
                this.getAccessoriesList();

            }
      }



    },
};
</script>



<style scoped>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}

.tag-input {
  width: 100%;
  border: 1px solid rgb(204, 200, 200);
  font-size: 0.9em;
  height: 45px;
  box-sizing: border-box;
  padding: 0 10px;
}

.tag-input__tag {
  height: 30px;
  float: left;
  margin-right: 10px;
  background-color: #00b297;
  margin-top: 10px;
  line-height: 30px;
  padding: 0 5px;
  border-radius: 5px;
  color: white
}

.tag-input__tag > span {
  cursor: pointer;
  opacity: 0.75;
}

.tag-input__text {
  border: none;
  outline: none;
  font-size:12px;
  line-height: 45px;
  background: none;
}
</style>


