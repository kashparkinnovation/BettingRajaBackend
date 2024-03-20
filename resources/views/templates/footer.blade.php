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
<script>

$(document).ready(function() {
    function fetchData() {
      $.ajax({
        url: "{{url('/fetch_rec_with_req_count')}}",
        method: 'GET',
        success: function(response) {
            resp = JSON.parse(response);
            $('#recharge_req_count').html(resp.rech);
            $('#withdraw_req_count').html(resp.with);
          console.log('Data:', response);
        },
        error: function(xhr, status, error) {
          console.error('Error fetching data:', error);
        }
      });
    }
    fetchData();
    setInterval(fetchData, 30000); // 30 seconds in milliseconds
  });

</script>