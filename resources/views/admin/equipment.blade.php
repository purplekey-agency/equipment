@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <a href="/dashboard/equipment/add" class="py-3 mx-auto">
                    <div class="btn btn-primary">
                        {{ __('Add equipment') }}
                    </div>
                </a>
                <div class="card-header">{{ __('Non Rentabile Equipment') }}</div>
                <div class="card-body">
                
                    <div class="row border-bottom bold">
                        <div class="col-2 py-3 border-left border-right">Equipment ID</div>
                        <div class="col-3 py-3 border-right">Equipment name</div>
                        <div class="col-3 py-3 border-right">Status</div>
                        <div class="col-2 py-3 border-right">User</div>
                        <div class="col-2 py-3 border-right">Action</div>
                    </div>

                    @foreach($equipment as $eq)

                        @if(!$eq->equipment_rentable)
                        
                            <div class="row border-bottom">
                                
                                    <div class="col-2 border-left border-right">{{$eq->id}}</div>
                                    <div class="col-3 border-right">{{$eq->equipment_name}}</div>
                                    <div class="col-3 border-right">In use</div></a>
                                    <div class="col-2 border-right">{{$eq->getUserName($eq->equipment_user)}}</div></a>
                                
                                <div class="col-2 border-right">
                                    <a href="javascript:void(0)" onclick="printLabel({{$eq->id}})" title="Print Label">
                                        <i class="fa fa-print" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        
                        @endif

                    @endforeach

                </div>
                <div class="card-header">{{ __('Rentabile Equipment') }}</div>
                <div class="card-body">
                
                    <div class="row bold">
                        <div class="col-2 py-3 border-left border-right">Equipment ID</div>
                        <div class="col-3 py-3 border-right">Equipment name</div>
                        <div class="col-3 py-3 border-right">Status</div>
                        <div class="col-2 py-3 border-right">User rented</div>
                        <div class="col-2 py-3 border-right">Action</div>
                    </div>

                    @foreach($equipment as $eq)

                        @if($eq->equipment_rentable)
                        <div class="row border-bottom">
                                
                                <div class="col-2 border-left border-right">{{$eq->id}}</div>
                                <div class="col-3 border-right">{{$eq->equipment_name}}</div>
                                <div class="col-3 border-right">In use</div></a>
                                <div class="col-2 border-right">{{$eq->getUserName($eq->equipment_user)}}</div></a>
                            
                            <div class="col-2 border-right">
                                <a href="" title="Print ID">
                                    <i class="fa fa-print" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                        @endif

                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>

<form action="/dashboard/equipment/print" id="print_label_form" method="post">

    @csrf

    <input type="hidden" id="print_label_equipment_id" name="print_label_equipment">
    <input type="submit" id="print_label_submit_btn" value="Submit">

</form>
@endsection
