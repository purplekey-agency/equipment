@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="row">
                    <a href="/dashboard/equipment/add" class="py-3 mx-auto">
                        <div class="btn btn-primary">
                            {{ __('Add equipment') }}
                        </div>
                    </a>
                    <a href="javascript:void(0)" onclick="printBulkLabel()" title="Print Label" class="py-3 mx-auto">
                        <div class="btn btn-primary">
                            {{ __('Print all labels') }}
                        </div>
                    </a>
                    <a href="/dashboard/equipment/add" class="py-3 mx-auto">
                        <div class="btn btn-primary">
                            {{ __('Print report') }}
                        </div>
                    </a>
                </div>
                <div class="row">
                    <a href="/dashboard/equipment/rent" class="py-3 mx-auto">
                        <div class="btn btn-primary">
                            {{ __('Rent equipment') }}
                        </div>
                    </a>
                    <a href="/dashboard/equipment/return" class="py-3 mx-auto">
                        <div class="btn btn-primary">
                            {{ __('Return equipment') }}
                        </div>
                    </a>
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

                @if(Session::has('pdf') && Session::get('pdf'))
                    <script>window.open('/all.pdf', '_blank')</script>
                @endif

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
                                    <a href="javascript:void(0)" onclick="editUser({{$eq->id}})" title="Change User">
                                        <i class="fas fa-edit" aria-hidden="true"></i>
                                    </a>
                                    <a href="javascript:void(0)" onclick="deleteEquipment({{$eq->id}})" title="Delete equipment">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        
                        @endif

                    @endforeach

                </div>
                <div class="card-header">{{ __('Rentabile Equipment') }}</div>
                <div class="card-body">
                
                    <div class="row border-bottom bold">
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
                                <div class="col-3 border-right @if($eq->getRentStatus($eq->id) === 'Rented') red @else green @endif">{{$eq->getRentStatus($eq->id)}}</div></a>
                                <div class="col-2 border-right">{{$eq->getUserRentedName($eq->id)}}</div></a>
                            
                            <div class="col-2 border-right">
                                <a href="javascript:void(0)" onclick="printLabel({{$eq->id}})" title="Print Label">
                                    <i class="fa fa-print" aria-hidden="true"></i>
                                </a>
                                <a href="javascript:void(0)" onclick="deleteEquipment({{$eq->id}})" title="Delete equipment">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
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

<form action="/dashboard/equipment/delete" id="delete_equipment_form" method="post">

    @csrf

    <input type="hidden" id="delete_equipment_id" name="delete_equipment_id">
    <input type="submit" id="delete_submit_btn" value="Submit">

</form>

<form action="/dashboard/equipment/printbulk" id="print_bulk_label_form" method="post">

    @csrf
    <input type="submit" id="print_bulk_label_submit_btn" value="Submit">

</form>

@endsection
