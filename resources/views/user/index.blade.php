@extends('app')

@section('page-heading')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Users</h1>
    </div>
@endsection

@section('content')
    <div class="card shadow">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">All users</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="datatable">
                    <thead>
                        <tr>
                            <th scope="col">N°</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Creation date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{ $user->id }}</th>
                                <td>{{ $user->lastname }} {{ $user->firstname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->setTimeZone(new DateTimeZone('Indian/Antananarivo')) }}</td>
                                <td>@if ($user->active)<span class="badge badge-pill badge-success">Active</span>@else<span class="badge badge-pill badge-danger">Inactive</span>@endif</td>
                                <td>
                                    <a href="{{ route('user-show', ['id_user' => $user->id]) }}" class="text-secondary fs-5"><i class="fa fa-info-circle"></i></a>
                                    <a href="{{ route('user-destroy', ['id_user' => $user->id]) }}" class="text-danger delete-button fs-5"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('include.deleteModal')
@endsection

@section('script')
    <script>
        $(function(){
            $('#datatable').DataTable({
                "order": [[ 3, "desc" ]]
            });

            $('.delete-button').click(function(event){
                event.preventDefault();

                let href = this.href;
                console.log(href);
                $('#deleteModalContent').text('Are you sure to delete this user?');
                $('#deleteModal').modal('show');

                $('#deleteButton').click(function(){
                    window.location = href;
                });

            });
        });
    </script>
@endsection
