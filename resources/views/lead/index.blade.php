@extends('layouts.admin')

@push('pre-purpose-css-page')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/dragula.min.css') }}">
@endpush
@push('pre-purpose-script-page')
    @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'employee')
        <script src="{{ asset('assets/js/plugins/dragula.min.js') }}"></script>
         @if ($pipeline)
            <script>
                ! function(a) {
                    "use strict";
                    var t = function() {
                        this.$body = a("body")
                    };
                    t.prototype.init = function() {
                        a('[data-plugin="dragula"]').each(function() {
                            var t = a(this).data("containers"),
                                n = [];
                            if (t)
                                for (var i = 0; i < t.length; i++) n.push(a("#" + t[i])[0]);
                            else n = [a(this)[0]];
                            var r = a(this).data("handleclass");
                            r ? dragula(n, {
                                moves: function(a, t, n) {
                                    return n.classList.contains(r)
                                }
                            }) : dragula(n).on('drop', function(el, target, source, sibling) {

                                var order = [];
                                $("#" + target.id + " > div").each(function() {
                                    order[$(this).index()] = $(this).attr('data-id');
                                });

                                var id = $(el).attr('data-id');

                                var old_status = $("#" + source.id).data('status');
                                var new_status = $("#" + target.id).data('status');
                                var stage_id = $(target).attr('data-id');
                                var pipeline_id = '1';

                                $("#" + source.id).parent().find('.count').text($("#" + source.id + " > div")
                                    .length);
                                $("#" + target.id).parent().find('.count').text($("#" + target.id + " > div")
                                    .length);

                                $.ajax({
                                    url: '{{ route('lead.order') }}',
                                    type: 'POST',
                                    data: {
                                        lead_id: id,
                                        stage_id: stage_id,
                                        order: order,
                                        new_status: new_status,
                                        old_status: old_status,
                                        pipeline_id: pipeline_id,
                                        "_token": $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function(data) {
                                        toastrs('Success', 'Task successfully updated', 'success');
                                    },
                                    error: function(data) {
                                        data = data.responseJSON;
                                        toastrs('{{ __('Error') }}', data.error, 'error')
                                    }
                                });
                            });
                        })
                    }, a.Dragula = new t, a.Dragula.Constructor = t
                }(window.jQuery),
                function(a) {
                    "use strict";

                    a.Dragula.init()

                }(window.jQuery);
            </script>
        @endif
    @endif
@endpush
@section('page-title')
    {{ __('Lead') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Lead') }}</li>
@endsection
@section('action-btn')
    @if (\Auth::user()->type == 'company')
        @if ($pipeline)
            <div class="btn-group">
                <button class="btn btn-sm btn-primary btn-icon m-1 dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    {{ $pipeline->name }}
                </button>
                <div class="dropdown-menu">
                    @foreach ($pipelines as $pipe)
                        <a class="dropdown-item pipeline_id" data-id="{{ $pipe->id }}"
                            href="#">{{ $pipe->name }}</a>
                    @endforeach
                </div>
            </div>
        @endif
    @endif

    <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="modal" data-bs-target="#exampleModal"
    data-url="{{ route('lead.file.import') }}" data-bs-whatever="{{ __('Import CSV file') }}"> <span
        class="text-white">
        <i class="ti ti-file-import" data-bs-toggle="tooltip"
            data-bs-original-title="{{ __('Import item CSV file') }}"></i>
    </a>
   
    <a href="{{ route('lead.grid') }}" class="btn btn-sm btn-primary btn-icon m-1">
        <i class="ti ti-layout-grid text-white" data-bs-toggle="tooltip" data-bs-original-title="{{ __('List View') }}">
        </i>
    </a>

    @if (\Auth::user()->type == 'company')
        <a href="lead/create" class="btn btn-sm btn-primary btn-icon m-1" data-bs-whatever="{{ __('Create New Lead') }}"
            data-bs-original-title="{{ __('Create New Lead') }}">
            <i data-bs-toggle="tooltip" title="{{ __('Create') }}" class="ti ti-plus text-white"></i>
        </a>
    @endif

@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            @if ($pipeline)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            @foreach ($pipeline->leadStages as $lead_stage)
                                <th>{{ $lead_stage->name }} ({{ count($lead_stage->lead()) }})</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($pipeline->leadStages as $lead_stage)
                                <td>
                                    @foreach ($lead_stage->lead() as $lead)
                                        <div class="card mb-2" data-id="{{ $lead->id }}">
                                            <div class="pt-3 ps-3">
                                                @if ($lead->labels())
                                                    @foreach ($lead->labels() as $label)
                                                        <span class="badge rounded-pill bg-{{ $label->color }} ml-1">{{ $label->name }}</span>
                                                    @endforeach
                                                @endif
                                                <h5>
                                                    <a href="{{ route('lead.show', \Crypt::encrypt($lead->id)) }}"
                                                        data-bs-whatever="{{ __('View Lead Details') }}">{{ $lead->name }}</a>
                                                </h5>
                                                <p class="text-muted text-sm">{{ $lead->subject }}</p>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <ul class="list-inline mb-0">
                                                        <li class="list-inline-item"><i class="f-16 text-primary ti ti-message-2"></i>{{ \Auth::user()->dateFormat($lead->date) }}</li>
                                                    </ul>
                                                    <div class="user-group">
                                                        @foreach ($lead->users as $user)
                                                            <a href="#" class="avatar rounded-circle avatar-sm" data-toggle="tooltip" title="{{ $user->name }}">
                                                                <img @if ($user->avatar) src="{{ asset('/storage/uploads/avatar/' . $user->avatar) }}" @else avatar="{{ $user->name }}" @endif>
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            @else
                <div class="col-md-12 text-center">
                    <h4>{{ __('No data available') }}</h4>
                </div>
            @endif
        </div>
    </div>
@endsection
