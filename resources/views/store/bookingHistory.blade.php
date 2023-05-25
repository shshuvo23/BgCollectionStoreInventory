@extends('layouts.app')
@section('css')

@endsection
@section('content')
    <div class="br-pagebody mg-t-5 pd-x-30">



    <div class="row row-sm">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-teal rounded overflow-hidden">
                <div class="pd-25 d-flex align-items-center">
                    <i class="ion ion-earth tx-60 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Total
                            Boking</p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">1,975,224</p>
                        <span class="tx-11 tx-roboto tx-white-6">24% higher yesterday</span>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
            <div class="bg-danger rounded overflow-hidden">
                <div class="pd-25 d-flex align-items-center">
                    <i class="ion ion-bag tx-60 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Today Sales
                        </p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">$329,291</p>
                        <span class="tx-11 tx-roboto tx-white-6">$390,212 before tax</span>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
            <div class="bg-primary rounded overflow-hidden">
                <div class="pd-25 d-flex align-items-center">
                    <i class="ion ion-monitor tx-60 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">% Unique
                            Visits</p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">54.45%</p>
                        <span class="tx-11 tx-roboto tx-white-6">23% average duration</span>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
            <div class="bg-br-primary rounded overflow-hidden">
                <div class="pd-25 d-flex align-items-center">
                    <i class="ion ion-clock tx-60 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Bounce Rate
                        </p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">32.16%</p>
                        <span class="tx-11 tx-roboto tx-white-6">65.45% on average time</span>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
    </div><!-- row -->

    <div class="br-section-wrapper mt-5">
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Booking History</h6>
        {{-- <p class="mg-b-25 mg-lg-b-50">Store Stock In Entry form</p> --}}
        <div id="stock_in_section">
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Style No</th>
                    <th scope="col">Accessories Name</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Color Name</th>
                    <th scope="col">Size</th>
                    <th scope="col">Garments Quantity</th>
                    <th scope="col">Requered Quantity</th>
                    <th scope="col">Date</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($bookingHistories as $bookingHistory)
                    <tr >
                        <th scope="row">{{$loop->index+1}}</th>
                        <td>{{$bookingHistory->style_no}}</td>
                        <td>{{$bookingHistory->accessories_name}}</td>
                        <td>{{$bookingHistory->unit}}</td>
                        <td>{{$bookingHistory->color_name}}</td>
                        <td>{{$bookingHistory->size}}</td>
                        <td>{{$bookingHistory->garments_quantity}}</td>
                        <td>{{$bookingHistory->requered_quantity}}</td>
                        <td>{{$bookingHistory->created_at}}</td>
                        <td>...</td>
                      </tr>
                    @endforeach

                </tbody>
              </table>

        </div>
    </div>

    <div class="br-section-wrapper mt-5">
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Stock In History</h6>
        {{-- <p class="mg-b-25 mg-lg-b-50">Store Stock In Entry form</p> --}}
        <div id="stock_in_section">
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Style No</th>
                    <th scope="col">Accessories Name</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Color Name</th>
                    <th scope="col">Size</th>
                    <th scope="col">Supplier Name</th>
                    <th scope="col">Callan No</th>
                    <th scope="col">MRR No</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Collected By</th>
                    <th scope="col">Date</th>
                    <th scope="col">Actions</th>

                  </tr>
                </thead>
                <tbody>
                    @foreach ($stockInHistories as $stockInHistory)
                    <tr >
                        <th scope="row">{{$loop->index+1}}</th>
                        <td>{{$stockInHistory->style_no}}</td>
                        <td>{{$stockInHistory->accessories_name}}</td>
                        <td>{{$stockInHistory->unit}}</td>
                        <td>{{$stockInHistory->color_name}}</td>
                        <td>{{$stockInHistory->size}}</td>
                        <td>{{$stockInHistory->supplier_name}}</td>
                        <td>{{$stockInHistory->callan_no}}</td>
                        <td>{{$stockInHistory->mrr_no}}</td>
                        <td>{{$stockInHistory->quantity}}</td>
                        <td>{{$stockInHistory->collected_by}}</td>
                        <td>{{$stockInHistory->received_date}}</td>

                        <td>...</td>
                      </tr>
                    @endforeach

                </tbody>
              </table>

        </div>
    </div>

    <div class="br-section-wrapper mt-5">
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Stock Out History</h6>
        {{-- <p class="mg-b-25 mg-lg-b-50">Store Stock In Entry form</p> --}}
        <div id="stock_in_section">
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Style No</th>
                    <th scope="col">Accessories Name</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Color Name</th>
                    <th scope="col">Size</th>
                    <th scope="col">Receiver Name</th>
                    <th scope="col">Line_no</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Date</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($stockOutHistories as $stockOutHistory)
                    <tr >
                        <th scope="row">{{$loop->index+1}}</th>
                        <td>{{$stockOutHistory->style_no}}</td>
                        <td>{{$stockOutHistory->accessories_name}}</td>
                        <td>{{$stockOutHistory->unit}}</td>
                        <td>{{$stockOutHistory->color_name}}</td>
                        <td>{{$stockOutHistory->size}}</td>
                        <td>{{$stockOutHistory->receiver_name}}</td>
                        <td>{{$stockOutHistory->line_no}}</td>
                        <td>{{$stockOutHistory->quantity}}</td>
                        <td>{{$stockOutHistory->stock_out_date}}</td>
                        <td>...</td>
                      </tr>
                    @endforeach

                </tbody>
              </table>

        </div>
    </div>


    </div>
@endsection

@section('js')

@endsection
