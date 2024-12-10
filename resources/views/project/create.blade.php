@extends('layouts.admin')
@section('page-title')
    {{ __('Project Create') }}
@endsection
@push('css-page')
@endpush
@push('script-page')
@endpush
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('Project Create') }}</h5>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('project.index') }}">{{ __('Project') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Create') }}</li>
@endsection
@section('content')
    {{ Form::open(['url' => 'project', 'class' => 'mt-4']) }}
    <div class="card">
        <div class="card-body">
            @php
                $plansettings = App\Models\Utility::plansettings();
            @endphp
            <div class="row">
               
                <div class="form-group col-md-4">
                    {{ Form::label('title', __('Project Title'), ['class' => 'form-label']) }}
                    {{ Form::text('title', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Project Title')]) }}
                </div>
                
                <div class="form-group col-md-4">
                    {{ Form::label('category', __('Category'), ['class' => 'form-label']) }}
                    {{ Form::select('category', $categories, '', ['class' => 'form-control multi-select']) }}
                </div>
                
                <div class="form-group col-md-4">
                    {{ Form::label('developer', __('Developer Name'), ['class' => 'form-label']) }}
                    {{ Form::text('developer_name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Developer Name')]) }}
                </div>
                
                <div class="form-group col-md-4">
                    {{ Form::label('price', __('Starting Price'), ['class' => 'form-label']) }}
                    {{ Form::number('price', null, ['class' => 'form-control', 'required' => 'required', 'stage' => '0.01', 'placeholder' => __('Price')]) }}
                </div>
                
                <div class="form-group col-md-4">
                    {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
                    {{ Form::date('start_date', new \DateTime(), ['class' => 'form-control', 'required' => 'required']) }}
                </div>
               
                <div class="form-group col-md-4">
                    {{ Form::label('due_date', __('End Date'), ['class' => 'form-label']) }}
                    {{ Form::date('due_date', new \DateTime(), ['class' => 'form-control', 'required' => 'required']) }}
                </div>
              
                <div class="form-group col-md-4">
                    {{ Form::label('rera', __('Rera Number'), ['class' => 'form-label']) }}
                    {{ Form::text('rera_link', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Rera Number')]) }}
                </div>
                
                 <div class="form-group col-md-4">
                    {{ Form::label('unit', __('Unit No.'), ['class' => 'form-label']) }}
                    {{ Form::text('unit_no', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Unit No.')]) }}
                </div>
                
                <div class="form-group col-md-4">
                    {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                    {{ Form::select('status', $projectStatus, null, ['class' => 'form-control multi-select', 'required' => 'required']) }}
                </div>
                
                <div class="form-group col-md-12">
                    {{ Form::label('address', __('Address'), ['class' => 'form-label']) }}
                    {{ Form::textarea('address', null, ['class' => 'form-control', 'rows' => '2', 'placeholder' => __('Project Address')]) }}
                </div>
                
                <div class="form-group col-md-12">
                    {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
                    {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '2', 'placeholder' => __('Description')]) }}
                </div>
                
                <div class="modal-footer pr-0">
                    <input type="button" value="{{__('Close')}}" onclick="location.href = '{{route("project.index")}}';" class="btn btn-light">
                    {{ Form::submit(__('Create'), ['class' => 'btn  btn-primary']) }}
                </div>
                
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection

<script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
