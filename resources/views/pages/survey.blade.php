@extends('layouts.app')

@section('content')
<div class="container" id="app">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">


            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>
                        @lang('surveys.settings'){{$survey_info['surveyls_title']}}
                        <span class="pull-right">@lang('surveys.id') : {{$survey_info['sid']}}</span>
                    </h3>
                </div>

                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#import">@lang('surveys.import')</a></li>
                        <li><a data-toggle="tab" href="#pers">@lang('surveys.personalization')</a></li>
                        <li><a data-toggle="tab" href="#assig">@lang('surveys.surveyor_assignment')</a></li>
                        <li><a data-toggle="tab" href="#expor">@lang('surveys.export')</a></li>
                        <li><a data-toggle="tab" href="#delet">@lang('surveys.delete')</a></li>
                        <li><a data-toggle="tab" href="#prog">@lang('surveys.survey_progress')</a></li>
                    </ul>
                    
                    <div class="tab-content">
                        
                        <div id="import" class="tab-pane fade in active">
                            @include('includes.import')
                        </div>
                        
                        <div id="pers" class="tab-pane fade">
                            @include('includes.custom')
                        </div>
                        
                        <div id="assig" class="tab-pane fade">
                            assign
                        </div>
                        
                        <div id="expor" class="tab-pane fade">
                            export
                        </div>
                        
                        <div id="delet" class="tab-pane fade">
                            delet
                        </div>
                        
                        <div id="prog" class="tab-pane fade">
                            prog
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection