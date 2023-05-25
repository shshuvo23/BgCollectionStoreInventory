<template>
    <div class="br-section-wrapper mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th  scope="col">#SL</th>
                                <th  scope="col">Receiver Name</th>
                                <th  scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                             <tr v-for="(item,index) in receivers.data" :key="item.id">
                                <td scope="row">{{ (index+1)+(pageNumber-1)*10 }}</td>
                                <td>
                                    <input type="text" :id="item.id" class="form-control input-readonly" :value="item.receiver_name" readonly>
                                </td>
                                <td>
                                    <a v-on:click="editedData(item.id )" :id="item.id+'edit'"       class="text-white btn btn-primary">Edit</a>
                                </td>
                                <!-- <td>
                                    <a :href="(rcvDel+'/'+encrypt(item.id))" class="text-white btn btn-primary">Delete</a>
                                </td> -->
                            </tr>
                            <tr v-if="this.receivers.data < 1">
                              <td colspan="3"> <p class="text-center text-danger">No receivers found</p></td>
                            </tr>
                        </tbody>
                    </table>

                    <paginate :data="receivers" @pagination-change-page="getData" ></paginate>
                </div>
            </div>
            <div class="col-md-4 mt-2">

            </div>
        </div>
    </div>
</template>

    <script>
    import CryptoJs from 'crypto-js';
    import axios from "axios";
    export default {
        name: "index",

        data() {
            return {
              pageNumber:"",
              editReceiverForm:false,
              editReceivers:"",
              receivers:[],
              message:"",
              rcvDel:'del-recv'
            }
        },

        created(){


        },

        mounted() {
           this.getData();
           this.encrypt();
        },

        methods: {
    getData(page = 1){
        // alert(page);
        this.pageNumber = page;
        axios.get('get-receivers?page='+page,{
        })
        .then((response)=>{
            console.log(response.data)
            this.receivers = response.data;
            // this.message =  res.data.isSuccess;


        })
        .catch(error=>{});
     },
     editedData(id){
         let editbutton = id+'edit';
         let updatebutton = id+'update';

        if ($('#'+editbutton).length > 0){
            $('#'+id).prop('readonly', false);
            $('#'+id).removeClass('input-readonly');
            $('#'+editbutton).text('Update');
            $('#'+editbutton).attr('id',updatebutton);
        }
        else if ($('#'+updatebutton).length > 0){
            $('#'+id).prop('readonly', true);
            $('#'+id).addClass('input-readonly');
            $('#'+updatebutton).text('Edit');
            $('#'+updatebutton).attr('id',editbutton);

            this.editReceivers = $('#'+id).val();
            this.updateReceiver(id);
        }




        // axios.get('receiver/edit/'+id).then((res)=>{

           // this.editReceiverForm = true;
           // this.editReceivers = res.data;
         //})
        // .catch((error)=>{});
     },

     updateReceiver(id){
           axios.post('receiver/update/'+id,{
            params:{name: this.editReceivers}
           }).then((res)=>{
              //console.log(res.data);
              //this.getData();
              //this.editReceiverForm = false;
           })
     },
     deleteProduct(id){
            axios.post('delete-receiver',{
                params:{
                    id: id,
                }
            }).then((res)=>{
                console.log(res.data);
                // this.isSuccess = true,
                // this.message = res.data.isSuccess;
                //this.getData();
                this.editReceivers ="";
            }).catch((err)=>{
            })
        },
        encrypt(id){
            let digest = '1';
            let hash = CryptoJs.MD5(digest);
            return hash = hash.toString(CryptoJs.enc.Base64);
            }

        },
    }
    </script>

<style>
.v-enter-active,
.v-leave-active {
    transition: opacity 1s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
.pagination .page-item .page-link {
    color: #000000,    #00b297;
    padding: 4px 0;
    width: 30px;
    height: 25px;
    text-align: center;

}

.pagination .active .page-link, .pagination .active .page-link:hover, .pagination .active .page-link:focus {
    color: #fff;
    background-color: #00b297;
    border-color: transparent;
}
.form-control:disabled, .dataTables_filter input:disabled, .form-control[readonly], .dataTables_filter input[readonly] {
    background-color: #fff;
}
</style>

