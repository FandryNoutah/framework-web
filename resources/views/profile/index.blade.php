@extends('app')

@section('page-heading')
    <!-- Page Heading -->
    <h1 class="h3 mb-1 text-gray-800">Profile</h1>
    <p class="mb-4">You need to fill all your profile's informations so that the administrator can activate your account as soon as possible and to be able to take profit of all functionnalities.</p>
@endsection

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Profile Information</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('profile-update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <h4>Contact Information</h4>
                <hr>
                <div class="mb-3 text-center">
                    <img class="rounded-circle" style="min-width: 100px; max-width: 200px;" src="{{ asset(Auth::user()->image) }}">
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-4 mb-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image">
                            <label class="custom-file-label" for="image">Choose image</label>
                        </div>
                        @error('image')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="firstname">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" value="{{ Auth::user()->firstname }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="lastname">Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" placeholder="Last Name" value="{{ Auth::user()->lastname }}">
                        @error('lastname')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email Address" value="{{ Auth::user()->email }}">
                        @error('email')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="phone">Phone <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Phone number (034xx, 033xx, 032xx)" value="{{ Auth::user()->phone }}">
                        @error('phone')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="birth">Birth date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('birth') is-invalid @enderror" id="birth" name="birth" placeholder="Your birth date" value="{{ Auth::user()->birth }}">
                        @error('birth')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="gender">Gender <span class="text-danger">*</span></label>
                        <select name="gender" id="gender" class="custom-select @error('gender') is-invalid @enderror">
                            <option value="Male" @if (Auth::user()->gender == "Male") selected @endif>Male</option>
                            <option value="Female" @if (Auth::user()->gender == "Female") selected @endif>Female</option>
                        </select>
                        @error('gender')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="marital_status">Marital status <span class="text-danger">*</span></label>
                        <select name="marital_status" id="marital_status" class="custom-select @error('marital_status') is-invalid @enderror" value="{{ Auth::user()->marital_status }}">
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Other">Other</option>
                        </select>
                        @error('marital_status')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="identity">Identity image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control pt-1 @error('identity') is-invalid @enderror" id="identity" name="identity" accept="image/*">
                        @error('identity')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="city">City <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" placeholder="Your city" value="{{ Auth::user()->city }}">
                        @error('city')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="state">State <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" placeholder="State" value="{{ Auth::user()->state }}">
                        @error('state')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="postal_code">Zip / Postal code <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('postal_code') is-invalid @enderror" id="postal_code" name="postal_code" placeholder="Postal code" value="{{ Auth::user()->postal_code }}">
                        @error('postal_code')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-5">
                    <label class="form-label" for="address">Address <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" cols="30" rows="3" placeholder="Your address">{{ Auth::user()->address }}</textarea>
                    @error('address')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <hr>

                <h4>Employment Information</h4>
                <hr>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="occupation" class="form-label">Occupation <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('occupation') is-invalid @enderror" name="occupation" id="occupation" placeholder="Your occupation, function" value="{{ Auth::user()->occupation }}">
                        @error('occupation')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="occupation_place" class="form-label">Occupation place <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('occupation_place') is-invalid @enderror" name="occupation_place" id="occupation_place" placeholder="Your occupation location, society ..." value="{{ Auth::user()->occupation_place }}">
                        @error('occupation_place')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="occupation_duration" class="form-label">Occupation duration <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('occupation_duration') is-invalid @enderror" name="occupation_duration" id="occupation_duration" placeholder="1 month or 2 years ..." value="{{ Auth::user()->occupation_duration }}">
                        @error('occupation_duration')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="monthly_income" class="form-label">Monthly income <span class="text-danger">*</span></label>

                        <div class="input-group">
                            <input type="number" step="any" class="form-control @error('monthly_income') is-invalid @enderror" name="monthly_income" id="monthly_income" placeholder="Your monthly income" aria-describedby="income_unity">
                            <div class="input-group-append">
                                <span class="input-group-text" id="income_unity">Ariary</span>
                            </div>
                        </div>
                        @error('monthly_income')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <p class="mb-0 small text-danger">Note: Fields with (*) are required.</p>
                <button type="submit" class="btn btn-primary float-right">Save changes</button>
            </form>
        </div>
    </div>
@endsection
