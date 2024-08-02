<label for="{{$id ?? $name}}" class="form-label">
    {{$label ?? $name}}
    @if(isset($required))
        <span class="text-danger">*</span>
    @endif
</label>


@if($type == "autocomplete")
    <input  
        {{isset($disabled) ? "disabled" : ""}}
        {{isset($required) ? "required" : ""}}
        type="{{$type}}" id="{{$id}}" class="form-control" name="{{$id}}" value="{{$value ?? ''}}" >
    <input type="hidden" name="{{$input_hidden}}" id="{{$input_hidden}}" value="{{$value_hidden ?? ''}}" >
    
    
@elseif ($type !== "textarea")
    <input 
        name="{{$name}}" 
        type="{{$type ?? 'text'}}" 
        class="form-control {{$class ?? ''}}"
        id="{{$id ?? $name}}"
        value="{{$value ?? ''}}" 
        placeholder="{{$placeholder ?? ''}}"
        {{$type == "number" ? "step=0.01" : ""}}
        {{isset($disabled) ? "disabled" : ""}}
        {{isset($min) ? "min=".$min : ""}}
        {{isset($max) ? "max=".$max : ""}}
        {{isset($required) ? "required" : ""}}
    >
@else
    <textarea
        name="{{$name}}" 
        class="form-control {{$class ?? ''}}"
        id="{{$id ?? $name}}"
        placeholder="{{$placeholder ?? ''}}"
        {{isset($rows) ? "rows=".$rows : "rows=3"}}
        {{isset($required) ? "required" : ""}}
    >{{$value ?? ""}}</textarea>
@endif

@if(isset($valid_feedback))
    <div class="valid-feedback">
        {{$valid_feedback}}        
    </div>
@endif
@if(isset($invalid_feedback))
    <div class="invalid-feedback">
        {{$invalid_feedback}}        
    </div>
@endif
