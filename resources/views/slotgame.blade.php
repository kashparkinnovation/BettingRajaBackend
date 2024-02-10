@extends('app')
@section('content')
    <main class="mn-inner">
        <div class="row">
            <div class="col s10">
                <div class="page-title">Slot Game</div>
            </div>
            <div class="col s2">
                <button class="btn btn-primary" onclick="$('#manage_game').css('display', 'block');">Manage Game</button>
            </div>
            <div id="manage_game" style="display: none" class="col s12 m12 l12">
                <div class="card">
                    <div class="card-content">

                        <!-- Modal Structure -->
                        <form action="{{ url('/update_slot_game') }}" method="post" class="form">

                            <h4>Slot Game</h4>
                            <div class="row">

                                @csrf
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="one_chance">Single No. Win Chance </label>
                                        <input type="number" value="{{ $data->single_number_chance }}" name="one_chance"
                                            id="one_chance" class="form form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="two_chance">Double No. Win Chance </label>
                                        <input type="number" value="{{ $data->double_number_chance }}" name="two_chance"
                                            id="two_chance" class="form form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="three_chance">JACKPOT (Three No. Win Chance) </label>
                                        <input type="number" value="{{ $data->jackpot_number_chance }}" name="three_chance"
                                            id="three_chance" class="form form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="lose_chance">Lose Chance </label>
                                        <input type="number" value="{{ $data->loosing_number_chance }}" name="lose_chance"
                                            id="lose_chance" class="form form-control">
                                    </div>
                                </div>

                            </div>



                            <button type="submit" class="btn btn-primary ">Update</button>

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
