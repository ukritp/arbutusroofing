@extends('layouts.app')

@section('title', '| Company')

@section('stylesheets')
    {!! Html::style('css/sweetalert.css') !!}
    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('css/typeaheadjs.css') !!}
@endsection

@section('content')

<div class="row">
    <div class="col-md-11 col-md-offset-1">
        <div class="panel panel-default panel-mobile">
            <div class="panel-heading">ALL COMPANIES</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6 form-group-ajax">
                    {!! Form::open(array('route' => 'companies.search','method'=>'get', 'data-parsley-validate'=>'')) !!}
                    <div class="input-group">
                        <input type="text" name="keyword" id="keyword" class="form-control keyword" placeholder="Search" maxlegnth="255" required>
                        <input type="hidden" id="data-route" value="{{url('companies')}}">
                        <span class="input-group-btn">
                            <button class="btn btn-primary btn-md" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </span>
                    </div>
                    {!! Form::close() !!}
                    </div>
                </div>

                @if(!is_null(Request::get('keyword')))
                <br>
                <p><strong>Found: {{count($companies)}} Results for "{{Request::get('keyword')}}"</strong></p>
                @endif
            </div>
            <!-- Table -->
            <table class="table table-hover table-hover-blue mobile-table">
                <thead>
                    <th>Company</th>
                    <th>Label</th>
                    <th>Contact</th>
                    <th class="td-mobile">Phone</th>
                    <th>User</th>
                    <th class="text-right" style="width:15%;">Action</th>
                </thead>
                <tbody>
                    @forelse($companies as $index => $company)
                        <tr>
                            <td data-label="Company">{{$company->company_name}}</td>
                            <td data-label="Label">{{$company->label}}</td>
                            <td data-label="Contact">{{$company->first_name.' '.$company->last_name}}</td>
                            <td data-label="Phone" class="td-mobile">{{$company->formatPhone()}}</td>
                            <td data-label="User">{{$company->user->first_name}}</td>
                            <td data-label="Action" class="text-right">
                            {!! Html::linkRoute('companies.show', 'View', array($company->id), array('class'=>'btn btn-default btn-sm'))!!}
                            {!! Html::linkRoute('companies.edit', 'Edit', array($company->id), array('class'=>'btn btn-default btn-sm') ) !!}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center no-item">There are no companies</td>
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
