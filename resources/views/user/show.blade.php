@extends('user.app')

@section('information-title')
    <div class="d-flex">
        <h6 class="m-0 mr-auto font-weight-bold text-primary">Account details</h6>
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="active" name="active" @if ($user->active) checked @endif>
            <label class="custom-control-label" for="active">Active</label>
        </div>
    </div>
@endsection

@section('information-content')
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4">
                <div class="row mx-0">
                    <div class="card shadow-sm mb-4 w-100">
                        <div class="card-body text-center">
                            <a href="javascript:void(0)"><img src="{{ asset($user->image) }}" alt="profile_image" class="rounded-circle img-fluid mini-image" title="View photo" style="min-width: 100px; max-width: 150px;"></a>
                            <h5 class="mt-3 text-dark">{{ $user->firstname }} {{ $user->lastname }}</h5>
                            <p class="mb-1">{{ $user->birth }}</p>
                            <p class="mb-0">{{ $user->gender }}</p>
                            @if ($user->active)<span class="badge badge-pill badge-success">Active</span>@else<span class="badge badge-pill badge-danger">Inactive</span>@endif
                        </div>
                    </div>
                </div>
                @if ($user->identity != "")
                    <div class="row mx-0">
                        <div class="card shadow-sm mb-4 w-100">
                            <div class="card-body text-center">
                                <p>Identity Image</p>
                                <a href="javascript:void(0)"><img src="{{ asset($user->identity) }}" alt="identity_image" class="mini-image" title="View photo" style="min-width: 100px; max-width: 200px;"></a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0 text-dark">Full Name</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-0">{{ $user->firstname }} {{ $user->lastname }}</p>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0 text-dark">Email</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-0">{{ $user->email }}</p>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0 text-dark">Phone</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-0">{{ $user->phone }}</p>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0 text-dark">Address</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-0">{{ $user->address }}</p>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0 text-dark">Marital Status</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-0">{{ $user->marital_status }}</p>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0 text-dark">From</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-0">{{ $user->city }}, {{ $user->state }}, {{ $user->postal_code }}</p>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0 text-dark">Occupation</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-0">{{ $user->occupation }} at {{ $user->occupation_place }} for {{ $user->occupation_duration }}</p>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0 text-dark">Monthly income</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-0">{{ $user->monthly_income }} Ariary</p>
                            </div>
                        </div>
                        <hr>

                    </div>
                </div>
            </div>
        </div>
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
                    <button type="button" class="btn btn-secondary" id="cancelButton">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmButton">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    @include('user.image')
@endsection

@section('information-script')
    <script>
        $(function(){
            $('.mini-image').click(function(event){
                event.preventDefault();

                var src = this.src;

                $('#image_container').attr('src', src);
                $('#imageModal').modal('show');
            });

            $('#imageModal').on('hidden.bs.modal', function(){
                $('#image_container').attr('src', null);
            });

            /* Sending activation status */
            var active = $('#active').is(':checked');

            $('#active').click(function(e){
                e.preventDefault();

                if(active){
                    $('#confirmation_text').text("Are you sure to deactivate this account?");
                    var data = 1;
                }else{
                    $('#confirmation_text').text("Are you sure to activate this account?");
                    var data = 0;
                }

                $('#confirmationModal').modal('show');

                $('#confirmButton').click(function(e){
                    e.preventDefault();

                    $.ajax({
                        type: "POST",
                        url: "{{ route('user-switch', ['id_user' => $user->id]) }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            active: data,
                        },
                        dataType: "JSON",
                        success: function(response){
                            if (response.finished) {
                                window.location.reload();
                            }
                        },
                        error: function(){
                            alert("An error has occured while processing data! Please, try again later.");
                        }
                    });
                });

                $('#cancelButton').click(function(){
                    e.preventDefault();

                    $('#confirmationModal').modal('hide');

                    $('#active').prop('checked', activeStatus);
                });

            });

        });
    </script>
@endsection
