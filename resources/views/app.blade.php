@include('templates.header')
@yield('style')
</head>
<body>
    @include('templates.loader')

    <div class="mn-content fixed-sidebar">

        @include('templates.topbar')
        @include('templates.searchresult')


        @include('templates.sidebar')

      
                    @yield('content')
          
    </div>
    @include('templates.footer')
    @yield('scripts')
</body>
</html>
