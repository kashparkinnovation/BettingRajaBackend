@extends('app')
@section('content')
    <main class="mn-inner">
        <div class="row">
            <div class="col s10">
                <div class="page-title">Vendors</div>
            </div>
            <div class="col s2">
                <button class="btn btn-primary" onclick="$('#add_vendor').css('display', 'block');">Add Vendor</button>
            </div>
            <div id="add_vendor" style="display: none" class="col s12 m12 l12">
                <div class="card">
                    <div class="card-content">

                        <!-- Modal Structure -->
                        <form action="{{ url('/add_new_vendor') }}" method="post" class="form">

                            <h4>Vendor</h4>
                            <div class="row">

                                @csrf
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="one_chance">Name </label>
                                        <input type="text"  name="name"
                                            class="form form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="two_chance">Mobile </label>
                                        <input type="number"  name="mobile"
                                             class="form form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="three_chance">Username </label>
                                        <input type="text" name="username"
                                             class="form form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="lose_chance">Password </label>
                                        <input type="text"  name="password"
                                            class="form form-control">
                                    </div>
                                </div>

                            </div>



                            <button type="submit" class="btn btn-primary ">Submit</button>

                        </form>
                        <br>

                        <button type="button" class="btn btn-default" style="background-color:rgb(251, 71, 71);"
                            onclick="$('#add_vendor').css('display', 'none');">Close</button>



                    </div>
                </div>
            </div>
        </div>
        <br>
        <h2>
            Vendors
        </h2>
        <table id="example" class="display responsive-table datatable-example">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Vendor Code</th>                    
                    <th>Mobile</th>
                    <th>Login Cred</th>                
                    <th>Status</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $count = 1;
                @endphp
@foreach($data as $dd)
<tr>
    <td>
        {{$count++}}
    </td>
    <td>{{$dd->name}}</td>
    <td>{{$dd->vendor_code}}</td>
    <td>{{$dd->mobile}}</td>
    <td>{{$dd->username}}<br>{{$dd->password}}</td>
    <td>{{$dd->status}}</td>
    <td></td>
</tr>
@endforeach
            </tbody>
        </table>
    </main>
@endsection
