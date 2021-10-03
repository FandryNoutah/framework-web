@extends('app')

@section('page-heading')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Deposits</h1>

        @if (!Auth::user()->is_admin)
            <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#createModal">
                <i class="fas fa-plus-circle fa-sm text-white-50"></i>
                Make deposit
            </button>
        @endif
    </div>
@endsection

@section('content')
    <div class="card shadow">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">{{ $deposits_title }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="datatable">
                    <thead>
                        <tr>
                            <th scope="col">N°</th>
                            @if (Auth::user()->is_admin)
                                <th>Account</th>
                            @endif
                            <th scope="col">Amount (Ariary)</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deposits as $deposit)
                            <tr>
                                <td scope="row">{{ $deposit->id }}</td>
                                @if (Auth::user()->is_admin)
                                    <td>{{ $deposit->user()->first()->lastname }} {{ $deposit->user()->first()->firstname }}</td>
                                @endif
                                <td scope="row">{{ $deposit->amount }}</td>
                                <td scope="row">{{ $deposit->created_at->SetTimeZone(new DateTimeZone('Indian/Antananarivo')) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if (!Auth::user()->is_admin)
        @include('include.create')
    @endif

@endsection

@section('script')

    @if (Auth::user()->is_admin)
        <script>
            $(function(){
                $('#datatable').DataTable({
                    "order": [[ 3, "desc" ]]
                });
            });
        </script>
    @else
        <script>
            $(function(){
                $('#datatable').DataTable({
                    "order": [[ 2, "desc" ]]
                });
            });
        </script>
    @endif

    @error('amount')
        <script>
            $(function(){
                $('#createModal').modal('show');
            });
        </script>
    @enderror
    @error('password')
        <script>
            $(function(){
                $('#createModal').modal('show');
            });
        </script>
    @enderror
@endsection
