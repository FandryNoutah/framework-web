@extends('errors.app')

@section('navbar')
    @include('include.navbar')
@endsection

@section('content')
    <!-- 404 Error Text -->
    <div class="text-center">
        <div class="error mx-auto" data-text="403">403</div>
        <p class="lead text-gray-800 mb-5">Access Forbidden</p>
        <p class="text-gray-500 mb-0">You are not authorized to access this page</p>
        <a href="javascript:history.back()">&larr; Back</a>
    </div>
@endsection
