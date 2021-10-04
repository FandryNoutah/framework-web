@extends('app')

@section('page-heading')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><a href="{{ route('loan-index') }}">Loans</a> / Details</h1>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col mb-4">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Loan Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0 text-dark">Account</p>
                        </div>
                        <div class="col-sm-9">
                            @if (Auth::user()->is_admin)
                                <p class="mb-0"><a href="{{ route('user-show', ['id_user' => $user->id]) }}">{{ $user->firstname }} {{ $user->lastname }}</a></p>
                            @else
                                <p class="mb-0">{{ $user->firstname }} {{ $user->lastname }}</p>
                            @endif
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0 text-dark">Amount</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="mb-0">{{ $loan->amount }} Ariary</p>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0 text-dark">Description</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="mb-0">{{ $loan->description }}</p>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0 text-dark">Date</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="mb-0">{{ $loan->created_at->setTimeZone(new DateTimeZone('Indian/Antananarivo')) }}</p>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0 text-dark">Status</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="mb-0">
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
                            </p>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0 text-dark">Attachment</p>
                        </div>
                        <div class="col-sm-9">
                            @if ($loan->attachment != null)
                                <a href="{{ route('loan-attachment', ['id_loan' => $loan->id]) }}">Download attachment</a>
                            @else
                                <p class="mb-0">Not provided</p>
                            @endif
                        </div>
                    </div>
                    <hr>

                    @if (Auth::user()->is_admin && $loan->status == "Waiting")
                        <a href="{{ route('loan-confirm', ['id_loan' => $loan->id]) }}" class="btn btn-primary float-right mx-1" id="confirm_button">Confirm</a>
                        <a href="{{ route('loan-reject', ['id_loan' => $loan->id]) }}" class="btn btn-danger float-right" id="reject_button">Reject</a>
                    @endif
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
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="confirmation_text"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmButton">Confirm</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function(){
            $('#confirm_button').click(function(event){
                event.preventDefault();

                let href = this.href;
                $('#confirmation_text').text("Are you sure to confirm this loan?");
                $('#confirmButton').text("Confirm");
                $('#confirmationModal').modal('show');

                $('#confirmButton').click(function(){
                    window.location = href;
                });
            });

            $('#reject_button').click(function(event){
                event.preventDefault();

                let href = this.href;
                $('#confirmation_text').text("Are you sure to reject this loan?");
                $('#confirmButton').text("Reject");
                $('#confirmationModal').modal('show');

                $('#confirmButton').click(function(){
                    window.location = href;
                });
            });

        });
    </script>
@endsection
