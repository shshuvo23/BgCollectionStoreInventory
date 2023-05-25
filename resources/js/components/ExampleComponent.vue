<template>
    <div>
      <h2>Implement jQuery DataTable in Vue Js</h2>
      <table class="table" id="datatable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Product Title</th>
            <!-- <th>Product Price</th>
            <th>Created On</th> -->
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in products" :key="item.id">
            <td>{{ item.id }}</td>
            <td>{{ item.style_no }}</td>
            <!-- <td>{{ item.product_price }}</td>
            <td>{{ item.created_at }}</td> -->
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  <script>

  export default {
    mounted() {
      axios.get("out/get-style").then((response) => {
        this.products = response.data;
        $("#datatable").DataTable();
      });
    },
    data: function () {
      return {
        products: [],
      };
    },
  };
  </script>
