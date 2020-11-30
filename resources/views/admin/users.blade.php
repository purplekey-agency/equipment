@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-4">
        <a href="/dashboard/users/add">
            <div class="btn btn-primary">
                {{ __('Add user') }}
            </div>
        </a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Users') }}</div>
                
            </div>
        </div>
    </div>
</div>
@endsection
