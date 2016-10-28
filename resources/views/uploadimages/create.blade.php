@extends('layouts.app')

@section('title', '| Upload Images')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('css/sweetalert.css') !!}
@endsection

@section('content')

<div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>Upload Images</h1>
            <hr>

            <p ><strong>Property:</strong> {{$workorder->property->property_name}}</p>
            <p ><strong>Address:</strong> {{$workorder->property->fullAddress()}}</p>
            <p ><strong>Work Order Number:</strong> {{$workorder->workorder_number}}</p>
            <p ><strong>Work Order Description:</strong><br> {{$workorder->description}}</p>
            <hr>

            @if(count($workorder->images)!=0)
                <div id="ajax-load">
                @include('uploadimages._imagethumbnail')
                </div>
                <hr>
            @endif

            {!! Form::open(array('route' => 'uploadimages.store', 'data-parsley-validate'=>'', 'enctype' => 'multipart/form-data' )) !!}

                <fieldset class="form-group required">
                {{ Form::label('images', 'Image Input: max size 2MB (jpeg, png, jpg, gif and svg)', array('class'=>'control-label'))  }}
                {{ Form::file('images[]', array( 'required'=>'','multiple'=>true))}}
                </fieldset>

                <fieldset class="form-group">
                {{ Form::label('description', 'Description:') }}
                {{ Form::textarea('description',null, array('class' => 'form-control'))}}
                </fieldset>

                {{ Form::hidden('workorder_id', $workorder->id) }}

                <hr>

                <div class="row form-group">
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        <button type="submit" class="btn btn-success btn-lg btn-block">
                            <i class="glyphicon glyphicon-cloud-upload"></i> Upload Image
                        </button>
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        <a href="{{url()->previous()}}" class="btn btn-danger btn-lg btn-block"><i class="glyphicon glyphicon-remove"></i> Cancel</a>
                        </fieldset>
                    </div>
                </div>

            {!! Form::close() !!}

        </div>
    </div> <!-- /.row -->

@endsection

@section('scripts')
    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('js/sweetalert.min.js') !!}
@endsection