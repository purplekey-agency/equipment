@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                @if(Auth::user()->is_admin)
                <a href="/dashboard/users">
                    <div class="card-body">
                        {{ __('See all users') }}
                    </div>
                </a>
                <a href="/dashboard/equipment">
                    <div class="card-body">
                        {{ __('See all equipment') }}
                    </div>
                </a>
                <a href="/dashboard/statistics">
                    <div class="card-body">
                        {{ __('See statistics') }}
                    </div>
                </a>
                @endif
                @if(!Auth::user()->is_admin)
                <a href="/dashboard/equipment/rent">
                    <div class="card-body">
                        {{ __('Rent equipment') }}
                    </div>
                </a>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
