@extends('layouts.app')

@section('title', '| Property')

@section('stylesheets')
    {!! Html::style('css/sweetalert.css') !!}
    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('css/typeaheadjs.css') !!}
@endsection

@section('content')

<div class="row">
    <div class="col-md-11 col-md-offset-1">
        <div class="panel panel-default panel-mobile">
            <div class="panel-heading">ALL PROPERTIES</div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-6 form-group-ajax">
                    {!! Form::open(array('route' => 'properties.search','method'=>'get', 'data-parsley-validate'=>'')) !!}
                    <div class="input-group">
                        <input type="text" name="keyword" id="keyword" class="form-control keyword" placeholder="Search" maxlegnth="255" required>
                        <input type="hidden" id="data-route" value="{{url('properties')}}">
                        <span class="input-group-btn">
                            <button class="btn btn-primary btn-md" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </span>
                    </div>
                    {!! Form::close() !!}
                    </div>
                </div>

                @if(!is_null(Request::get('keyword')))
                <br>
                <p><strong>Found: {{count($properties)}} Results for "{{Request::get('keyword')}}"</strong></p>
                @endif
            </div>

            <!-- Table -->
            <table class="table table-hover table-hover-blue mobile-table">
                <thead>
                    {{-- <th>Company</th> --}}
                    <th>Property</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th class="td-mobile"  style="width:15%;">Phone</th>
                    <th class="text-right" style="width:15%;">Action</th>
                </thead>
                <tbody>
                    @forelse($properties as $index => $property)
                        <tr>
                            {{-- <td data-label="Company">{{$property->company->company_name}}</td> --}}
                            <td data-label="Property">{{$property->property_name}}</td>
                            <td data-label="Contact">{{$property->first_name.' '.$property->last_name}}</td>
                            <td data-label="Address">{{$property->address.', '.$property->city}}</td>
                            <td data-label="Phone" class="td-mobile">{{$property->formatPhone()}}</td>
                            <td data-label="Action" class="text-right">
                            {!! Html::linkRoute('properties.show', 'View', array($property->id), array('class'=>'btn btn-default btn-sm'))!!}
                            {!! Html::linkRoute('properties.edit', 'Edit', array($property->id), array('class'=>'btn btn-default btn-sm') ) !!}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center no-item">There are no properties</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    {!! Html::script('js/sweetalert.min.js') !!}
    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js')!!}
    {!! Html::script('js/app.typeahead.js') !!}
    @include('sweet::alert')
@endsection
