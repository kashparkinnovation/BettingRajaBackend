@extends('app')
@section('content')
    <main class="mn-inner">
        <div class="row">
            <div class="col s10">
                <div class="page-title">Roulette Game</div>
            </div>
            <div class="col s2">
                <button class="btn btn-primary" onclick="$('#manage_game').css('display', 'block');">Manage Game</button>
            </div>
            <div id="manage_game" style="display: none" class="col s12 m12 l12">
                <div class="card">
                    <div class="card-content">

                        <!-- Modal Structure -->
                        <form action="{{ url('/update_roulette_game') }}" method="post" class="form">

                            <h4>Roulette Game</h4>
                            <div class="row">

                                @csrf
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="win_percent">Maximum Payout Percentage </label>
                                        <input type="number" value="{{ $data->win_percent }}" name="win_percent"
                                            id="win_percent" class="form form-control">
                                    </div>
                                </div>
                            
                                <div class="col-6">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary ">Update</button>

                                    </div>
                                </div>
                            </div>
                        </form>
                        <br>
                        <button type="button" class="btn btn-default" style="background-color:rgb(251, 71, 71);"
                            onclick="$('#manage_game').css('display', 'none');">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <h2>
            Orders
        </h2>
        <table id="example" class="display responsive-table datatable-example">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Mobile</th>
                    <th>Session Code</th>
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
                        <td>{{ $order->session_code }}</td>
                        <td>{{ $order->bid_amount }}</td>
                        <td>{{ $order->final_amount }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->playing_datetime }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
@endsection
