<aside id="slide-out" class="side-nav white fixed">
    <div class="side-nav-wrapper">
        <div class="sidebar-profile">

            <div class="sidebar-profile-info">
                <a href="javascript:void(0);" class="account-settings-link">
                    <p>Betting Raja</p>

                </a>
            </div>
        </div>

        <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
            <li class="no-padding"><a class="waves-effect waves-grey" href="{{ url('/dashboard') }}"><i
                        class="material-icons">settings_input_svideo</i>Dashboard</a></li>
            <li class="no-padding"><a class="waves-effect waves-grey" href="{{ url('/getUser') }}"><i
                        class="material-icons">settings_input_svideo</i>Users</a></li>
            <li class="no-padding"><a class="waves-effect waves-grey" href="{{ url('/rechargeReq') }}"><i
                        class="material-icons">settings_input_svideo</i>Recharge Requests <span
                        class="badge red lighten-1" id="recharge_req_count"
                        style="border-radius: 100%;color: white;inset-inline-end: auto;margin-left: 5px;">0</span></a>
            </li>
            <li class="no-padding"><a class="waves-effect waves-grey" href="{{ url('/withdrawReq') }}"><i
                        class="material-icons">settings_input_svideo</i>Withdraw Requests <span
                        class="badge red lighten-1" id="withdraw_req_count"
                        style="border-radius: 100%;color: white;inset-inline-end: auto;margin-left: 5px;">0</span></a>
            </li>
            <li class="no-padding"><a class="waves-effect waves-grey" href="{{ url('/slot_game') }}"><i
                        class="material-icons">settings_input_svideo</i>Slot Machine</a></li>
            <li class="no-padding"><a class="waves-effect waves-grey" href="{{ url('/dice_game') }}"><i
                        class="material-icons">settings_input_svideo</i>Dice Game</a></li>
            <li class="no-padding"><a class="waves-effect waves-grey" href="{{ url('/jhatkaGame') }}"><i
                        class="material-icons">settings_input_svideo</i>Jhatka</a></li>
            <li class="no-padding"><a class="waves-effect waves-grey" href="{{ url('/rouletteGame') }}"><i
                        class="material-icons">settings_input_svideo</i>Roulette Wheel</a></li>
            <li class="no-padding"><a class="waves-effect waves-grey" href="{{ url('/vendors') }}"><i
                        class="material-icons">settings_input_svideo</i>Vendors</a></li>

        </ul>
        <div class="footer">
            <a href="{{ '/logout' }}">Logout ></a>
            <p class="copyright">Betting Raja ©</p>

        </div>
    </div>
</aside>
