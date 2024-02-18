@extends('app')
@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="middle-content">
            <div class="row no-m-t no-m-b">
                
                <h4>Balance & Requests</h4>
                <div class="col s12 m12 l4">
                    <div class="card stats-card">
                        <div class="card-content">
                            <div class="card-options">
                                <ul>
                                    <li class="red-text"><span class="badge red lighten-1">Urgent</span></li>
                                </ul>
                            </div>
                            <span class="card-title">Recharge Request</span>
                            <span class="stats-counter"><span class="counter">{{$data['recharge_req']}}</span><small>Pending</small></span>
                        </div>
                        <div id="sparkline-bar"></div>
                    </div>
                </div>

                <div class="col s12 m12 l4">
                    <div class="card stats-card">
                        <div class="card-content">
                            <div class="card-options">
                                <ul>
                                    <li class="red-text"><span class="badge red lighten-1">Urgent</span></li>
                                </ul>
                            </div>
                            <span class="card-title">Withdraw Request</span>
                            <span class="stats-counter"><span class="counter">{{$data['withdraw_req']}}</span><small>Pending</small></span>
                        </div>
                        <div id="sparkline-bar"></div>
                    </div>
                </div>

                <div class="col s12 m12 l4">
                    <div class="card stats-card">
                        <div class="card-content">
                            <div class="card-options">
                                <ul>
                                    <li class="red-text"><span class="badge green lighten-1">Margin</span></li>
                                </ul>
                            </div>
                            <span class="card-title">Current Balance In Company</span>
                            <span class="stats-counter">₹<span class="counter">{{$data['current_balance']}}</span><small>Total</small></span>
                        </div>
                        <div id="sparkline-bar"></div>
                    </div>
                </div>
                <h4>Dice Game</h4>
                <div class="col s12 m12 l4">
                    <div class="card stats-card">
                        <div class="card-content">
                            <div class="card-options">
                                <ul>
                                    <li class="red-text"><span class="badge cyan lighten-1">Orders</span></li>
                                </ul>
                            </div>
                            <span class="card-title">Total Orders Of Today</span>
                            <span class="stats-counter"><span class="counter">{{$data['dice_game_orders']}}</span><small>Total</small></span>
                        </div>
                        <div id="sparkline-bar"></div>
                    </div>
                </div>
                <div class="col s12 m12 l4">
                    <div class="card stats-card">
                        <div class="card-content">
                            <div class="card-options">
                                <ul>
                                    <li class="red-text"><span class="badge red lighten-1">Wins</span></li>
                                </ul>
                            </div>
                            <span class="card-title">Total Wins Of Today</span>
                            <span class="stats-counter">₹<span class="counter">{{$data['dice_game_win_amount']}}</span><small>Final Amount -> Bid + Win </small></span>
                        </div>
                        <div id="sparkline-bar"></div>
                    </div>
                </div>
                <div class="col s12 m12 l4">
                    <div class="card stats-card">
                        <div class="card-content">
                            <div class="card-options">
                                <ul>
                                    <li class="red-text"><span class="badge green lighten-1">Loss</span></li>
                                </ul>
                            </div>
                            <span class="card-title">Total Loss Of Today</span>
                            <span class="stats-counter">₹<span class="counter">{{$data['dice_game_lose_amount']}}</span><small>Final Amount -> Bid Amount</small></span>
                        </div>
                        <div id="sparkline-bar"></div>
                    </div>
                </div>
                <h4>Slot Game</h4>
                <div class="col s12 m12 l4">
                    <div class="card stats-card">
                        <div class="card-content">
                            <div class="card-options">
                                <ul>
                                    <li class="red-text"><span class="badge cyan lighten-1">Orders</span></li>
                                </ul>
                            </div>
                            <span class="card-title">Total Orders Of Today</span>
                            <span class="stats-counter"><span class="counter">{{$data['slot_game_orders']}}</span><small>Total</small></span>
                        </div>
                        <div id="sparkline-bar"></div>
                    </div>
                </div>
                <div class="col s12 m12 l4">
                    <div class="card stats-card">
                        <div class="card-content">
                            <div class="card-options">
                                <ul>
                                    <li class="red-text"><span class="badge red lighten-1">Wins</span></li>
                                </ul>
                            </div>
                            <span class="card-title">Total Wins Of Today</span>
                            <span class="stats-counter">₹<span class="counter">{{$data['slot_game_win_amount']}}</span><small>Final Amount -> Bid + Win </small></span>
                        </div>
                        <div id="sparkline-bar"></div>
                    </div>
                </div>
                <div class="col s12 m12 l4">
                    <div class="card stats-card">
                        <div class="card-content">
                            <div class="card-options">
                                <ul>
                                    <li class="red-text"><span class="badge green lighten-1">Loss</span></li>
                                </ul>
                            </div>
                            <span class="card-title">Total Loss Of Today</span>
                            <span class="stats-counter">₹<span class="counter">{{$data['slot_game_lose_amount']}}</span><small>Final Amount -> Bid Amount</small></span>
                        </div>
                        <div id="sparkline-bar"></div>
                    </div>
                </div>
                <h4>Jhatka Game</h4>
                <div class="col s12 m12 l4">
                    <div class="card stats-card">
                        <div class="card-content">
                            <div class="card-options">
                                <ul>
                                    <li class="red-text"><span class="badge cyan lighten-1">Orders</span></li>
                                </ul>
                            </div>
                            <span class="card-title">Total Orders Of Today</span>
                            <span class="stats-counter"><span class="counter">{{$data['jhatka_orders']}}</span><small>Total</small></span>
                        </div>
                        <div id="sparkline-bar"></div>
                    </div>
                </div>
                <div class="col s12 m12 l4">
                    <div class="card stats-card">
                        <div class="card-content">
                            <div class="card-options">
                                <ul>
                                    <li class="red-text"><span class="badge red lighten-1">Wins</span></li>
                                </ul>
                            </div>
                            <span class="card-title">Total Wins Of Today</span>
                            <span class="stats-counter">₹<span class="counter">{{$data['jhatka_orders_win_amount']}}</span><small>Final Amount -> Bid + Win </small></span>
                        </div>
                        <div id="sparkline-bar"></div>
                    </div>
                </div>
                <div class="col s12 m12 l4">
                    <div class="card stats-card">
                        <div class="card-content">
                            <div class="card-options">
                                <ul>
                                    <li class="red-text"><span class="badge green lighten-1">Loss</span></li>
                                </ul>
                            </div>
                            <span class="card-title">Total Loss Of Today</span>
                            <span class="stats-counter">₹<span class="counter">{{$data['jhatka_orders_lose_amount']}}</span><small>Final Amount -> Bid Amount</small></span>
                        </div>
                        <div id="sparkline-bar"></div>
                    </div>
                </div>
                <h4>Roulette Wheel Game</h4>
                <div class="col s12 m12 l4">
                    <div class="card stats-card">
                        <div class="card-content">
                            <div class="card-options">
                                <ul>
                                    <li class="red-text"><span class="badge cyan lighten-1">Orders</span></li>
                                </ul>
                            </div>
                            <span class="card-title">Total Orders Of Today</span>
                            <span class="stats-counter"><span class="counter">{{$data['dice_game_orders']}}</span><small>Total</small></span>
                        </div>
                        <div id="sparkline-bar"></div>
                    </div>
                </div>
                <div class="col s12 m12 l4">
                    <div class="card stats-card">
                        <div class="card-content">
                            <div class="card-options">
                                <ul>
                                    <li class="red-text"><span class="badge red lighten-1">Wins</span></li>
                                </ul>
                            </div>
                            <span class="card-title">Total Wins Of Today</span>
                            <span class="stats-counter">₹<span class="counter">{{$data['dice_game_win_amount']}}</span><small>Final Amount -> Bid + Win </small></span>
                        </div>
                        <div id="sparkline-bar"></div>
                    </div>
                </div>
                <div class="col s12 m12 l4">
                    <div class="card stats-card">
                        <div class="card-content">
                            <div class="card-options">
                                <ul>
                                    <li class="red-text"><span class="badge green lighten-1">Loss</span></li>
                                </ul>
                            </div>
                            <span class="card-title">Total Loss Of Today</span>
                            <span class="stats-counter">₹<span class="counter">{{$data['dice_game_lose_amount']}}</span><small>Final Amount -> Bid Amount</small></span>
                        </div>
                        <div id="sparkline-bar"></div>
                    </div>
                </div>
            </div>

        </div>


        </div>
    </main>
@endsection
