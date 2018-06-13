@extends('layouts.app')

@section('content')
<script>
    window.onload = function() {
        var deleteButtons = document.querySelectorAll('.delete');
    
        for (var i = 0; i < deleteButtons.length; i++) {
            deleteButtons[i].addEventListener('click', function(event) {
                event.preventDefault();

                var choice = confirm(this.getAttribute('data-confirm'));
                if (choice) {
                  this.parentElement.submit();
                }
            });
        };
    };
</script>
<div class="container" id="app">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>@lang('surveyors.surveyors')</h3></div>

                <div class="panel-body">
                    <table class="col-md-12 table">
                        <tr class="table-header">
                            <th>@lang('surveyors.name')</th>
                            <th>@lang('surveyors.landline')</th>
                            <th>@lang('surveyors.cellphone')</th>
                            <th>@lang('surveyors.email')</th>
                            <th>@lang('surveyors.delete')</th>
                        </tr>
                        @foreach($surveyors as $surveyor)
                        <tr>
                            <td>{{$surveyor->name}}</td>
                            <td>{{$surveyor->landline}}</td>
                            <td>{{$surveyor->cellphone}}</td>
                            <td>{{$surveyor->email}}</td>
                            <td>{{Form::open(['method' => 'DELETE', 'route' => ['delete_surveyor', $surveyor->id]])}}
                                {{Form::button('<i class="glyphicon glyphicon-trash"></i>', array('type' => 'submit', 'class' => 'specialButton delete', 'data-confirm' => __('surveyors.confirm_delete')))}}
                                {{ csrf_field() }}
                                {{Form::close()}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
