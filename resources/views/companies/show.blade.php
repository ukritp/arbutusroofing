@extends('layouts.app')

@section('title', '| Company')

@section('stylesheets')
    {!! Html::style('css/sweetalert.css') !!}
@endsection

@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">COMPANY</div>

            <div class="panel-body">
                <p ><strong>ID:</strong> {{$company->id}}</p>
                <p ><strong>Company:</strong> {{$company->company_name}}</p>
                <p ><strong>Label:</strong> {{$company->label}}</p>
                <p ><strong>Contact:</strong> {{$company->first_name.' '.$company->last_name}}</p>
                <p ><strong>Address:</strong> {{$company->fullAddress()}}</p>
                <p ><strong>Phone:</strong> {{$company->formatPhone()}}</p>
            </div>

            <div class="panel-heading">USER</div>
            <div class="panel-body">
                <p ><strong>User:</strong> {{$company->user->first_name.' '.$company->user->last_name}}</p>
                <p ><strong>Email:</strong> {{$company->user->email}}</p>
                <p ><strong>Phone:</strong> {{$company->user->formatPhone()}}</p>
            </div>
        </div>
        {!! Html::linkRoute('companies.edit', 'Edit', array($company->id), array('class'=>'btn btn-primary btn-md btn-margin-right') ) !!}

        {!! Html::linkRoute('properties.create', 'Create Property', array($company->id), array('class'=>'btn btn-success btn-md btn-margin-right') ) !!}

        <a id="delete" class="btn btn-danger btn-md btn-margin-right" data-label="*All properties from this company will be deleted as well"><i class="glyphicon glyphicon-trash"></i> Delete</a>

        {!! Form::open(['route' => ['companies.destroy',$company->id], 'method'=>'DELETE', 'id'=>'delete-form']) !!}
        {{-- {!! Form::submit('Delete', array('class' => 'btn btn-danger btn-md confirm-delete-modal', 'id'=>'delete'))!!} --}}
        {!! Form::close() !!}
    </div>
</div>

@endsection

@section('scripts')
    {!! Html::script('js/sweetalert.min.js') !!}
@endsection