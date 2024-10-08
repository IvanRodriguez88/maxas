<div class="d-flex input-container">
    <span class="input-group-text">
        {{$label ?? $name}}
        @if(isset($required))
            <b class="text-danger">*</b>
        @endif
    </span>
    <div class="w-100">
        <input 
        {{isset($disabled) ? "disabled" : ""}}
        {{isset($required) ? "required" : ""}}
        {{isset($readonly) ? "readonly" : ""}}
        
        type="{{$type}}" id="{{$id}}" class="form-control" name="{{$id}}" value="{{$value ?? ''}}" >
        @if ($type == "autocomplete")
            <input type="hidden" name="{{$input_hidden}}" id="{{$input_hidden}}" value="{{$value_hidden ?? ''}}" >
        @endif
    </div>
</div>