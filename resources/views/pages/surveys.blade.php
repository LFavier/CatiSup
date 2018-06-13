@extends('layouts.app')

@section('content')
<div class="container" id="app">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>@lang('surveys.active_surveys')</h3></div>

                <div class="panel-body">
                    <table class="col-md-12 table">
                        <tr class="table-header">
                            <th>@lang('surveys.id')</th>
                            <th>@lang('surveys.title')</th>
                        </tr>
                        
                        @forelse($surveys as $survey)
                            @if ($survey['active']=='Y')
                                <tr>
                                    <td><a href="{{route('survey', $survey['sid'])}}">{{$survey['sid']}}</a></td>
                                    <td><a href="{{route('survey', $survey['sid'])}}">{{$survey['surveyls_title']}}</a></td>
                                </tr>
                            @endif
                        @empty
                            <tr><td>@lang('surveys.nosurveys')</td><td></td></tr>
                        @endforelse
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
