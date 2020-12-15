@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-4">

    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="row">
                    <a href="/dashboard/users/add" class="py-3 mx-auto">
                        <div class="btn btn-primary">
                            {{ __('Add user') }}
                        </div>
                    </a>
                </div>
                <div class="card-header">{{ __('Users') }}</div>
                
                <div class="card-body">
                
                    <div class="row border-bottom bold">
                        <div class="col-4 py-3 border-left border-right">User Name</div>
                        <div class="col-4 py-3 border-right">User Email</div>
                        <div class="col-4 py-3 border-right">User equipment count</div>
                    </div>

                    @foreach($users as $user)

                        <a href="/dashboard/users/user/{{$user->id}}" class="hover">
                            <div class="row border-bottom">
                                <div class="col-4 border-left border-right">{{$user->name}} {{$user->last_name}}</div>
                                <div class="col-4 border-right">{{$user->email}}</div>
                                <div class="col-4 border-right">@foreach($user->getEquipmentList($user->id) as $eq) {{$eq}}, @endforeach</div>
                            </div>
                        </a>

                    @endforeach

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
