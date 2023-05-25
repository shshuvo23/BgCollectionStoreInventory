<table class="table table-hover table-responsive" id="mm_table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Style</th>
        <th scope="col">Accessories</th>
        <th scope="col">Unit</th>
        <th scope="col">Color</th>
        <th scope="col">Size</th>
        <th scope="col">Supplier</th>
        <th scope="col">Callan No</th>
        <th scope="col">MRR No</th>
        <th scope="col">Collected By</th>
        <th scope="col">Qty</th>
        <th scope="col">Date</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($stockInHistories as $mrr)
        <tr>
            <th scope="row">{{$loop->iteration}}</th>
            <td>{{$mrr->style_no}}</td>
            <td>{{$mrr->accessories_name}}</td>
            <td>{{$mrr->unit}}</td>
            <td>{{$mrr->color_name??'N/A'}}</td>
            <td>{{$mrr->size??'N/A'}}</td>
            <td>{{$mrr->supplier_name}}</td>
            <td>{{$mrr->callan_no}}</td>
            <td>{{$mrr->mrr_no}}</td>
            <td>{{$mrr->collected_by}}</td>
            <td>{{floatFormater($mrr->quantity)}}</td>
            <td>{{$mrr->received_date}}</td>
            <td><a href="{{route('mrr_view', Crypt::encrypt($mrr->id) )}}" class="btn btn-sm btn-primary">Edit</a></td>
        </tr>
        @endforeach

    </tbody>
  </table>
