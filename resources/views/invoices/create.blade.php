@extends('layouts.app')

@section('title', '| Create Invoice')

@section('stylesheets')
    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('css/sweetalert.css') !!}
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker.min.css')!!}
@endsection

@section('content')

<div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>Invoice</h1>
            <hr>

            <p ><strong>Property:</strong> {{$workorder->property->property_name}}</p>
            <p ><strong>Address:</strong> {{$workorder->property->fullAddress()}}</p>
            <p ><strong>Work Order Number:</strong> {{$workorder->workorder_number}}</p>
            <p ><strong>Work Order Description:</strong><br> {{$workorder->description}}</p>
            <hr>

            @if(count($workorder->invoices)!=0)
                <div id="ajax-load">
                @include('invoices._pdf')
                </div>
                <hr>
            @endif

            {!! Form::open(array('route' => 'invoices.store', 'data-parsley-validate'=>'', 'enctype' => 'multipart/form-data' )) !!}

                <fieldset class="form-group required">
                {{ Form::label('invoiced_at', 'Date: (YYYY-MM-DD)', array('class'=>'control-label'))  }}
                {{ Form::text('invoiced_at',null, array('class' => 'form-control', 'required'=>'',  'maxlength'=>'255'))}}
                </fieldset>

                <fieldset class="form-group">
                {{ Form::label('description', 'Description:') }}
                {{ Form::textarea('description',null, array('class' => 'form-control'))}}
                </fieldset>

                <fieldset class="form-group required">
                {{ Form::label('files', 'Attach PDF: max size 2MB', array('class'=>'control-label'))  }}
                {{ Form::file('files[]', array( 'required'=>'','multiple'=>true))}}
                </fieldset>

                {{ Form::hidden('workorder_id', $workorder->id) }}

                <hr>

                <div class="row form-group">
                    <div class="col-md-6">
                        <fieldset class="form-group">
                        <button type="submit" class="btn btn-success btn-lg btn-block">
                            <i class="glyphicon glyphicon-cloud-upload"></i> Create invoice
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
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js')!!}
    <script language="javascript">
    $(document).ready(function() {
        $('#invoiced_at').datepicker({
            ignoreReadonly: true,
            todayHighlight:true,
            format: 'yyyy-mm-dd'
        });
    });
    </script>
@endsection