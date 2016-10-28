@extends('layouts.app')

@section('title', '| Work Order')

@section('stylesheets')
    {!! Html::style('css/sweetalert.css') !!}
@endsection

@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">WORK ORDER</div>

            <div class="panel-body">
                <p ><strong>Company:</strong> {{$workorder->property->company->company_name}}</p>
                <p ><strong>Property:</strong> {{$workorder->property->property_name}}</p>
                <p ><strong>Address:</strong> {{$workorder->property->fullAddress()}}</p>
                <hr>

                @if(count($workorder->images)!=0)
                    @include('uploadimages._imageslider')
                    <hr>
                @endif

                <p ><strong>ID:</strong> {{$workorder->id}}</p>
                <p ><strong>Work Order Number:</strong> {{$workorder->workorder_number}}</p>
                <p class="p-description" ><strong>Work Order Description:</strong><br> {{$workorder->description}}</p>
                <p ><strong>Tenant:</strong> {{$workorder->tenant_first_name.' '.$workorder->tenant_last_name}}</p>
                <p ><strong>Tenant Phone:</strong> {{$workorder->formatPhone()}}</p>

                @if(count($workorder->invoices)!=0)
                    <hr>
                    <div id="ajax-load">
                    @include('invoices._pdf')
                    </div>
                @endif
            </div>

            <div class="panel-heading">USER</div>
            <div class="panel-body">
                <p ><strong>User:</strong> {{$workorder->property->company->user->first_name.' '.$workorder->property->company->user->last_name}}</p>
                <p ><strong>Email:</strong> {{$workorder->property->company->user->email}}</p>
                <p ><strong>Phone:</strong> {{$workorder->property->company->user->formatPhone()}}</p>
            </div>
        </div>
        @set('user', \Auth::user()->roles()->first()->name)
        @if($user === 'Admin' || $user === 'Worker')
        {!! Html::linkRoute('workorders.edit', 'Edit', array($workorder->id), array('class'=>'btn btn-primary btn-md btn-margin-right') ) !!}

        {!! Html::linkRoute('uploadimages.create', 'Manage Images', array($workorder->id), array('class'=>'btn btn-success btn-md btn-margin-right') ) !!}

        {!! Html::linkRoute('invoices.create', 'Manage Invoice', array($workorder->id), array('class'=>'btn btn-success btn-md btn-margin-right') ) !!}

        <a id="delete" class="btn btn-danger btn-md btn-margin-right" data-label="*All related data from this work order will be deleted as well"><i class="glyphicon glyphicon-trash"></i> Delete</a>
        @endif
        {!! Form::open(['route' => ['workorders.destroy',$workorder->id], 'method'=>'DELETE', 'id'=>'delete-form']) !!}
        {{-- {!! Form::submit('Delete', array('class' => 'btn btn-danger btn-md confirm-delete-modal', 'id'=>'delete'))!!} --}}
        {!! Form::close() !!}
    </div>
</div>

@endsection

@section('scripts')
    {!! Html::script('js/sweetalert.min.js') !!}
@endsection