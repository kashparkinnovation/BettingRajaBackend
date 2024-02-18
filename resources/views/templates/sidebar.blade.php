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
                        class="material-icons">settings_input_svideo</i>Recharge Requests</a></li>
            <li class="no-padding"><a class="waves-effect waves-grey" href="{{ url('/withdrawReq') }}"><i
                        class="material-icons">settings_input_svideo</i>Withdraw Requests</a></li>
            <li class="no-padding"><a class="waves-effect waves-grey" href="{{ url('/slot_game') }}"><i
                        class="material-icons">settings_input_svideo</i>Slot Machine</a></li>
            <li class="no-padding"><a class="waves-effect waves-grey" href="{{ url('/dice_game') }}"><i
                        class="material-icons">settings_input_svideo</i>Dice Game</a></li>
            <li class="no-padding"><a class="waves-effect waves-grey" href="{{url('/jhatkaGame')}}"><i
                        class="material-icons">settings_input_svideo</i>Jhatka</a></li>
            <li class="no-padding"><a class="waves-effect waves-grey" href=""><i
                        class="material-icons">settings_input_svideo</i>Roulette Wheel</a></li>

        </ul>
        <div class="footer">
            <a href="{{ '/logout' }}">Logout ></a>
            <p class="copyright">Betting Raja ©</p>

        </div>
    </div>
</aside>
