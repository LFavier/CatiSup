{{ Form::open(['route' => ['fileImport',$survey_info['sid']], 'files' => 'true','enctype'=>'multipart/form-data', 'class'=>'martop3']) }}
    {{ csrf_field() }}
    {{ Form::file('participants',["required" => "required"]) }}
    {{ Form::submit(__('general.submit'),["class" => "martop3"]) }}
{{ Form::close() }}

@if(session('import_status'))
    <div class="alert alert-success martop2">
        {{ session('import_status') }}
    </div>
@endif