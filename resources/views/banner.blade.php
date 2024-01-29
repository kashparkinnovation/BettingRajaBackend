@extends('app')
@section('content')
    <main class="mn-inner">
        <div class="row">
            <div class="col s12">
                <div class="page-title">launch_software List</div>
            </div>
            <div class="col s12 m12 l12">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">launch_software</span>
                        <!-- Modal Structure -->
                        <a class="waves-effect waves-grey btn primary right modal-trigger" href="#addnewlaunchsoftware">Add
                            New
                            Software</a>
                        <div id="addnewlaunchsoftware" class="modal"
                            style="z-index: 1003; display: none; opacity: 0; transform: scaleX(0.7); top: 250.516304347826px;">
                            <form action="{{ url('/insert_Banner') }}" method="post" class="form"
                                enctype="multipart/form-data">


                                <div class="modal-content">
                                    <h4>Banner</h4>
                                    @csrf
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <img height="200" width="200" id="image"
                                                src="{{ asset('/images/noprofile.jpg') }}" class="rounded-circle img-raised">
                                            <input type="file" accept="Image/*" name="image"
                                                onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0])">
                                        </div>
                                    </div>

                                </div>


                                <div class="modal-footer">
                                    <a class="modal-action modal-close waves-effect waves-blue btn-flat ">Cancel</a>
                                    <button type="submit"
                                        class="modal-action waves-effect waves-blue btn-flat ">Save</button>
                                </div>
                            </form>
                        </div>

                        <table id="example" class="display responsive-table datatable-example">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                   

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                @endphp

                                @foreach ($data as $data)
                                    <tr>
                                        <td>{{ $count++}} </td>
                                        <td>
                                            <img class="rounded avatar" style="max-height: 40px;"
                                                src="{{ asset('/' . $data->image) }}" alt="im">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

