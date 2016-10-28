@extends('layouts.app')

@section('title', '| Company')

@section('stylesheets')
    {!! Html::style('css/sweetalert.css') !!}
@endsection

@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>COMPANY</strong></div>

            <div class="panel-body">
               {{--  <p ><strong>ID:</strong> {{$company->id}}</p> --}}
                <p ><strong>Company:</strong> {{$company->company_name}}</p>
                <p ><strong>Label:</strong> {{$company->label}}</p>
                <p ><strong>Contact:</strong> {{$company->first_name.' '.$company->last_name}}</p>
                <p ><strong>Address:</strong> {{$company->fullAddress()}}</p>
                <p ><strong>Phone:</strong> {{$company->formatPhone()}}</p>
            </div>


            @forelse($company->properties as $index => $property)
            <div class="panel-heading"><strong>Property # {{$index+1}}</strong></div>

                <div class="panel-body">
                    <p ><strong>Property:</strong> {{$property->property_name}}</p>
                    <p ><strong>Contact:</strong> {{$property->first_name.' '.$property->last_name}}</p>
                    <p ><strong>Address:</strong> {{$property->fullAddress()}}</p>
                    <p ><strong>Phone:</strong> {{$property->formatPhone()}}</p>

                    <!-- Table -->
                    <table class="table table-bordered table-condensed table-hover table-hover-blue mobile-table">
                        <thead>
                            <th style="width:5%;">#</th>
                            <th>Work Order #</th>
                            <th>Tenant</th>
                            <th>Phone #</th>
                            <th class="text-right" style="width:10%;">Action</th>
                        </thead>
                        <tbody>
                            @forelse($property->workorders as $index => $workorder)
                                <tr>
                                    <td data-label="#">{{$index+1}}</td>
                                    <td data-label="Work Order #">{{(!empty($workorder->workorder_number))?$workorder->workorder_number:'-'}}</td>
                                    <td data-label="Tenant">{{$workorder->tenant_first_name.' '.$workorder->tenant_last_name}}</td>
                                    <td data-label="Phone #">{{$workorder->formatPhone()}}</td>
                                    <td data-label="Action" class="text-right">
                                    {!! Html::linkRoute('workorders.show', 'View', array($workorder->id), array('class'=>'btn btn-default btn-sm'))!!}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center no-item">There are no work orders</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>



            @empty
            @endforelse
        </div>
    </div>
</div>

@endsection

@section('scripts')
    {!! Html::script('js/sweetalert.min.js') !!}
@endsection