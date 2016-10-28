@extends('layouts.app')

@section('title', '| User')

@section('stylesheets')
    {!! Html::style('css/sweetalert.css') !!}
@endsection

@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">USER</div>

            <div class="panel-body">
                <p ><strong>ID:</strong> {{$user->id}}</p>
                <p ><strong>Name:</strong> {{$user->first_name.' '.$user->last_name}}</p>
                <p ><strong>Role:</strong> {{\Auth::user()->roles()->first()->name}}</p>
                <p ><strong>Status:</strong> {{($user->status)?'Enabled':'Disabled'}}</p>
                <p ><strong>Email:</strong> {{$user->email}}</p>
                <p ><strong>Address:</strong> {{$user->fullAddress()}}</p>
                <p ><strong>Phone:</strong> {{$user->formatPhone()}}</p>
            </div>
        </div>
        {!! Html::linkRoute('users.edit', 'Edit', array($user->id), array('class'=>'btn btn-primary btn-md btn-margin-right') ) !!}
        {!! Html::linkRoute('users.edit_password', 'Edit Password', array($user->id), array('class'=>'btn btn-primary btn-md btn-margin-right') ) !!}

        {!! Html::linkRoute('companies.create', 'Create Company', array($user->id), array('class'=>'btn btn-success btn-md btn-margin-right') ) !!}

        <a id="delete" class="btn btn-danger btn-md btn-margin-right" data-label="*All companies from this user will be deleted as well"><i class="glyphicon glyphicon-trash"></i> Delete</a>

        {!! Form::open(['route' => ['users.destroy',$user->id], 'method'=>'DELETE', 'id'=>'delete-form']) !!}
        {{-- {!! Form::submit('Delete', array('class' => 'btn btn-danger btn-md confirm-delete-modal', 'id'=>'delete'))!!} --}}
        {!! Form::close() !!}
    </div>
</div>

@endsection

@section('scripts')
    {!! Html::script('js/sweetalert.min.js') !!}
@endsection