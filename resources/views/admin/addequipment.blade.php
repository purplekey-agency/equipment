@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                @if(Session::has('success'))
                <div class="alert alert-success" role="alert">
                    {{Session::get('success')}}
                </div>
                @endif

                @if(Session::has('error'))
                <div class="alert alert-danger" role="alert">
                    {{Session::get('error')}}
                </div>
                @endif
                <div class="card-header">{{ __('Add user') }}</div>
                <div class="card-body">
                    <form action="/dashboard/equipment/addequipment" method="post">
                        @csrf
                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Equipment type') }}</label>

                            <div class="col-md-6">
                                <select id="type" name="type" class="form-control @error('name') is-invalid @enderror" value="{{ old('type') }}" required autofocus>
                                    <option value="" default selected>Choose equipment type</option>
                                    <option value="Monitor">Monitor</option>
                                    <option value="Keyboard">Keyboard</option>
                                    <option value="Mouse">Mouse</option>
                                    <option value="Pen">Pen</option>
                                    <option value="Holder">Holder</option>
                                    <option value="Headphones">Headphones</option>
                                    <option value="Matica">Matica</option>
                                    <option value="Laptop">Laptop</option>
                                    <option value="Mac Apple">Mac Apple</option>
                                    <option value="Lamp">Lamp</option>
                                    <option value="Phone">Phone</option>
                                    <option value="TV">TV</option>
                                    <option value="0">Undefined</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row hidden" id="equipment_name_container">
                            <label for="equipment_name" class="col-md-4 col-form-label text-md-right">{{ __('Equipment name') }}</label>

                            <div class="col-md-6">
                                <input id="equipment_name" type="text" class="form-control @error('equipment_name') is-invalid @enderror" name="equipment_name" value="{{ old('equipment_name') }}" autocomplete="name" autofocus>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="rentable" class="col-md-4 col-form-label text-md-right">{{ __('Equipment rentable?') }}</label>

    
                            <div class="col-md-6">
                                <select id="rentable" name="rentable" class="form-control @error('rentable') is-invalid @enderror" value="{{ old('rentable') }}" required autofocus>
                                    <option value="" default selected>Please select one:</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                        </div>

                        <div class="form-group row hidden" id="nonrentabile_user_container">
                            <label for="nonrentabile_user" class="col-md-4 col-form-label text-md-right">{{ __('Current user') }}</label>


                            <div class="col-md-6">
                                <select id="nonrentabile_user" name="nonrentabile_user" class="form-control @error('nonrentabile_user') is-invalid @enderror" value="{{ old('rentable') }}" autofocus>
                                    <option value="" default selected>Please select current user:</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}} {{$user->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add Equipment') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
