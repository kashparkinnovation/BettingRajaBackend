@extends('app')
@section('content')
    <main class="mn-inner">
        <div class="row">
            <div class="col s12">
                <div class="page-title">Recharge Requests List</div>
            </div>
            <div class="col s12 m12 l12">
                <div class="card">
                    <div class="card-content">
                 

                        <table id="example" class="display responsive-table datatable-example">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Amount</th>
                                   
                                    <th>Action</th>

                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $count = 1;
                                    

                                @endphp

                                @foreach ($data as $dd)
                                    <tr>
                                        <td><?= $count++ ?></td>
                                        <td><?= $dd->name ?></td>
                                        <td><?= $dd->mobile ?></td>
                                        <td><?= $dd->amount ?></td>
                                      
                                        <td>
                                                @if($dd->status=='Pending')
                                       <a class="btn btn-success" href="{{ url('/UpdaterechargeReq?id='.$dd->id) }}">Verify Request</a>
                                       <a class="btn btn-danger"  style="background-color:red;" href="{{ url('/cancelrechargeReq?id='.$dd->id) }}">Cancel Request</a>
                                       @else
                                       {{$dd->status}}
                                       @endif
                                       
                                    </td> 
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection
