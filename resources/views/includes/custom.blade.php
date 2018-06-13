@if($customization)
    {{ Form::model($customization, ['route' => ['customization',$survey_info['sid']], 'class'=>'martop3']) }}
        {{ csrf_field() }}
        {{ Form::label('description', __('general.description')) }}
        <p>
            {{ Form::textarea('description') }}
        </p>
        <p>
            @lang('general.show_info')
        </p>
        <ul>
            @for ($i = 1; $i < 10; $i++)
                <li>
                {{ Form::label('var'.$i, __('general.line') . $i) }}
                {{ Form::select('var'.$i, $customization->getAddAttrArray(), null/*, ['placeholder' => __('general.select_attr')]*/) }}
                </li>
            @endfor
        </ul>
            {{ Form::submit(__('general.submit'),["class" => "martop3"]) }}

    {{ Form::close() }}
@else
    <div class="martop3">
        @lang('general.no_import')
    </div>
@endif
@if(session('custom_status'))
    <div class="alert alert-success martop2">
        {{ session('custom_status') }}
    </div>
@endif