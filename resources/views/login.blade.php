<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Title -->
    <title>Betting Raja</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta charset="UTF-8">
    <meta name="description" content="Betting Raja" />
    <meta name="keywords" content="Betting Raja" />
    <meta name="author" content="Betting Raja" />

    <!-- Styles -->
    <link type="text/css" rel="stylesheet" href="{{ asset('plugins/materialize/css/materialize.min.css') }}" />
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('/plugins/material-preloader/css/materialPreloader.min.css') }}" rel="stylesheet">


    <link href="{{ asset('/plugins/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">

    <!-- Theme Styles -->
    <link href="{{ asset('/css/alpha.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/swal2.css') }}" rel="stylesheet" type="text/css" />



    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
     
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="http://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="http://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
    </head>
    <body class="signin-page">
        <div class="loader-bg"></div>
        <div class="loader">
            <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                    </div><div class="circle-clipper right">
                    <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                    </div><div class="circle-clipper right">
                    <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-yellow">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                    </div><div class="circle-clipper right">
                    <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                    </div><div class="circle-clipper right">
                    <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mn-content valign-wrapper">
            <main class="mn-inner container">
                <div class="valign">
                      <div class="row">
                          <div class="col s12 m6 l4 offset-l4 offset-m3">
                              <div class="card white darken-1">
                                  <div class="card-content ">
                                      <span class="card-title">Sign In</span>
                                       <div class="row">
                                        @isset($errorcode)
                                             <strong>Opps!</strong> {{$errorcode}}
                                    
                            
                                       @endisset

                                           <form class="col s12" action="{{url('/loginf')}}" method="post">
                                            @csrf
                                               <div class="input-field col s12">
                                                   <input id="username" type="text" name="username" class="validate">
                                                   <label for="username">Username</label>
                                               </div>
                                               <div class="input-field col s12">
                                                   <input id="password" type="password" name="password" class="validate">
                                                   <label for="password">Password</label>
                                               </div>
                                               <div class="col s12 right-align m-t-sm">

                                                   <button type="submit" class="waves-effect waves-light btn teal">sign in</button>
                                               </div>
                                           </form>
                                      </div>
                                  </div>
                              </div>
                          </div>
                    </div>
                </div>
            </main>
        </div>
        <div class="left-sidebar-hover"></div>
        <!-- Javascripts -->
        <script src="{{asset('/plugins/jquery/jquery-2.2.0.min.js')}}"></script>
        <script src="{{asset('/plugins/materialize/js/materialize.min.js')}}"></script>
        <script src="{{asset('/plugins/material-preloader/js/materialPreloader.min.js')}}"></script>
        <script src="{{asset('/plugins/jquery-blockui/jquery.blockui.js')}}"></script>
        <script src="{{asset('/js/alpha.min.js')}}"></script>
        <script src="{{asset('/plugins/datatables/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('/js/pages/table-data.js')}}"></script>
        <script src="{{asset('/js/swal2.js')}}"></script>
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    </body></html>