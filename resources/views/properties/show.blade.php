@extends('layouts.app')

@section('title', '| Property')

@section('stylesheets')
    {!! Html::style('css/sweetalert.css') !!}
@endsection

@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">PROPERTY</div>

            <div class="panel-body">
                <p ><strong>Company:</strong> {{$property->company->company_name}}</p>
                <hr>
                <p ><strong>ID:</strong> {{$property->id}}</p>
                <p ><strong>Property:</strong> {{$property->property_name}}</p>
                <p ><strong>Contact:</strong> {{$property->first_name.' '.$property->last_name}}</p>
                <p ><strong>Address:</strong> {{$property->fullAddress()}}</p>
                <p ><strong>Phone:</strong> {{$property->formatPhone()}}</p>
            </div>

            <div class="panel-heading">USER</div>
            <div class="panel-body">
                <p ><strong>User:</strong> {{$property->company->user->first_name.' '.$property->company->user->last_name}}</p>
                <p ><strong>Email:</strong> {{$property->company->user->email}}</p>
                <p ><strong>Phone:</strong> {{$property->company->user->formatPhone()}}</p>
            </div>
        </div>
        {!! Html::linkRoute('properties.edit', 'Edit', array($property->id), array('class'=>'btn btn-primary btn-md btn-margin-right') ) !!}

        {!! Html::linkRoute('workorders.create', 'Create Work Order', array($property->id), array('class'=>'btn btn-success btn-md btn-margin-right') ) !!}

        <a id="delete" class="btn btn-danger btn-md btn-margin-right" data-label="*All work orders from this property will be deleted as well"><i class="glyphicon glyphicon-trash"></i> Delete</a>

        {!! Form::open(['route' => ['properties.destroy',$property->id], 'method'=>'DELETE', 'id'=>'delete-form']) !!}
        {{-- {!! Form::submit('Delete', array('class' => 'btn btn-danger btn-md confirm-delete-modal', 'id'=>'delete'))!!} --}}
        {!! Form::close() !!}
    </div>
</div>

@endsection

@section('scripts')
    {!! Html::script('js/sweetalert.min.js') !!}
@endsection