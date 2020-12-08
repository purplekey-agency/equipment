@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Rent Equipment') }}</div>
                <div class="card-body">
                
                    <form action="/dashboard/equipment/rent/confirm" method="post">
                    
                        @csrf

                        <div class="form-group row">
                            <label for="barcode" class="col-md-4 col-form-label text-md-right">{{ __('Barcode number:') }}</label>

                            <div class="col-md-6">
                                <input id="barcode" type="number" class="form-control @error('barcode') is-invalid @enderror" name="barcode" value="{{ old('barcode') }}" required autocomplete="email" autofocus>
                            </div>
                        </div>

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

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
