@extends('app')

@section('page-heading')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><a href="{{ route('user-index') }}">Users</a> / Show</h1>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Manage account</h6>
                </div>
                <div class="card-body p-2 list-group list-group-flush">
                    <a href="{{ route('user-show', ['id_user' => $user->id]) }}" class="list-group-item list-group-item-action @if (request()->segment(2) == $user->id && request()->segment(3) == "") active rounded @else text-primary @endif"><i class="fa fa-info-circle me-2"></i> Information</a>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card shadow">
                <div class="card-header">
                    @yield('information-title')
                </div>

                @yield('information-content')
            </div>
        </div>
    </div>
@endsection

@section('script')
    @yield('information-script')
@endsection
