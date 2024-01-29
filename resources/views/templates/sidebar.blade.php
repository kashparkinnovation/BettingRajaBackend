<aside id="slide-out" class="side-nav white fixed">
    <div class="side-nav-wrapper">
        <div class="sidebar-profile">
            <div class="sidebar-profile-image">
                <img src="assets/images/profile-image.png" class="circle" alt="">
            </div>
            <div class="sidebar-profile-info">
                <a href="javascript:void(0);" class="account-settings-link">
                    <p>David Doe</p>
                    <span>david@gmail.com<i class="material-icons right">arrow_drop_down</i></span>
                </a>
            </div>
        </div>
        <div class="sidebar-account-settings">
            <ul>
                <li class="no-padding">
                    <a class="waves-effect waves-grey"><i class="material-icons">mail_outline</i>Inbox</a>
                </li>
                <li class="no-padding">
                    <a class="waves-effect waves-grey"><i class="material-icons">star_border</i>Starred<span
                            class="new badge">18</span></a>
                </li>
                <li class="no-padding">
                    <a class="waves-effect waves-grey"><i class="material-icons">done</i>Sent Mail</a>
                </li>
                <li class="no-padding">
                    <a class="waves-effect waves-grey"><i class="material-icons">history</i>History<span
                            class="new grey lighten-1 badge">3 new</span></a>
                </li>
                <li class="divider"></li>
                <li class="no-padding">
                    <a class="waves-effect waves-grey"><i class="material-icons">exit_to_app</i>Sign Out</a>
                </li>
            </ul>
        </div>
        <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
            <li class="no-padding"><a class="waves-effect waves-grey" href=""><i
                        class="material-icons">settings_input_svideo</i>Dashboard</a></li>
            <li class="no-padding">
                <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">grid_on</i>Users<i
                        class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="{{ url('/getUser') }}">User</a></li>
                    </ul>
                    <ul>
                        <li><a href="{{ url('/getBanner') }}">Banner</a></li>
                    </ul>
                </div>
            </li>
            <li class="no-padding">
                <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">grid_on</i>Software<i
                        class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                <div class="collapsible-body">

                    <ul>
                        <ul>
                            <li><a href="{{ url('/softwares') }}">Softwares</a></li>
                        </ul>
                        <ul>
                            <li><a href="{{ url('/software_sale') }}">Software Sales</a></li>
                        </ul>
                        <ul>
                            <li><a href="{{ url('/launch_softwares') }}">Software Launch</a></li>
                        </ul>

                </div>
            </li>
            <li class="no-padding">
                <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">grid_on</i>Message<i
                        class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                <div class="collapsible-body">

                    <ul>
                        <li><a href="{{ url('/messagelist') }}">Messages</a></li>
                    </ul>

                    <ul>
                        <li><a href="{{ url('/messagesales') }}">Message Sales</a></li>
                    </ul>
                </div>
            </li>
            <li class="no-padding">
                <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">grid_on</i>Wallet<i
                        class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                <div class="collapsible-body">

                    <ul>
                        <li><a href="{{ url('/wallet') }}">Wallet Transactions</a></li>
                    </ul>


                </div>
            </li>
        </ul>
        <div class="footer">
            <p class="copyright">Steelcoders ©</p>
            <a href="#!">Privacy</a> &amp; <a href="#!">Terms</a>
        </div>
    </div>
</aside>
