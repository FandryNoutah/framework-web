@extends('errors.app')

@section('navbar')
    @include('include.navbar')
@endsection

@section('content')
    <div class="text-center">
        <div class="error text-center mx-auto" data-text="402">402</div>
        <p class="lead text-gray-800 mb-5">Your account is not activated</p>
        <p class="text-gray-500 mb-0">You cannot access your account now because it is deactivated by our administrator. Please wait for activation or contact our manager.</p>
        <p class="text-gray-500 mb-0">If you haven't fill all your profile's data, you need to complete them so that our administrator can activate your account.</p>

    </div>
@endsection
