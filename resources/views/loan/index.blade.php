@extends('app')

@section('page-heading')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Loans</h1>

        @if (!Auth::user()->is_admin)
            <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#createModal">
                <i class="fas fa-plus-circle fa-sm text-white-50"></i>
                Apply for a loan
            </button>
        @endif
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="mb-4 @if (!Auth::user()->is_admin) col-md-8 @else col-md-12 @endif">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $loans_title }}</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="datatable">
                            <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    @if (Auth::user()->is_admin)
                                        <th scope="col">Account</th>
                                    @endif
                                    <th scope="col">Amount (Ariary)</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loans as $loan)
                                    <tr>
                                        <td>{{ $loan->created_at->setTimeZone(new DateTimeZone('Indian/Antananarivo')) }}</td>
                                        @if (Auth::user()->is_admin)
                                            <td>{{ $loan->user()->first()->firstname }} {{ $loan->user()->first()->lastname }}</td>
                                        @endif
                                        <td>{{ $loan->amount }}</td>
                                        <td>
                                            <span class="badge badge-pill
                                            @switch($loan->status)
                                                @case("Waiting")
                                                    badge-secondary
                                                    @break

                                                @case("Unpaid")
                                                    badge-primary
                                                    @break

                                                @case("Paid")
                                                    badge-success
                                                    @break

                                                @case("Rejected")
                                                    badge-danger
                                                    @break
                                            @endswitch">{{ $loan->status }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('loan-show', ['id_loan' => $loan->id]) }}" class="btn btn-secondary btn-sm">Details <i class="fas fa-chevron-circle-right"></i></a>
                                            {{-- <a href="{{ route('loan-destroy', ['id_user' => $user->id]) }}" class="text-danger delete-button fs-5"><i class="fa fa-trash"></i></a> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @if (!Auth::user()->is_admin)
            <div class="col-md-4 mb-4">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Notes & Instructions</h6>
                    </div>
                    <div class="card-body">
                        <p>I authorize prospective Credit Grantors/Lending/Leasing Companies to obtain personal and credit information about me from my employer and credit bureau, or credit reporting agency, any person who has or may have any financial dealing with me, or from any references I have provided. This information, as well as that provided by me in the application, will be referred to in connection with this lease and any other relationships we may establish from time to time. Any personal and credit information obtained may be disclosed from time to time to other lenders, credit bureaus or other credit reporting agencies.</p>
                        <hr>
                        <p>I hereby agree that the information given is true, accurate and complete as of the date of this application submission.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @include('loan.create')
@endsection

@section('script')
    <script>
        $(function(){
            $('#datatable').DataTable({
                "order": [[ 0, "desc" ]]
            });
        });
    </script>

    @error('attachment')
        <script>
            $(function(){
                $('#createModal').modal('show');
            });
        </script>
    @enderror
    @error('amount')
        <script>
            $(function(){
                $('#createModal').modal('show');
            });
        </script>
    @enderror
    @error('description')
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
