@extends('app')
@section('content')
    <main class="mn-inner">
        <div class="row">
            <div class="col s10">
                <div class="page-title">Dice Game</div>
            </div>
        </div>
  
        <h2>
            Orders
        </h2>
        <table id="example" class="display responsive-table datatable-example">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Mobile</th>
                    <th>Order Amount</th>
                    <th>Final Amount</th>
                    <th>Status</th>
                    <th>Play DateTime</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $count = 1;
                @endphp

                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $count++ }} </td>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->mobile }}</td>
                        <td>{{ $order->amount }}</td>
                        <td>{{ $order->final_amount }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->playing_datetime }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
@endsection
