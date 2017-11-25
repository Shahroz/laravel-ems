<div class="row">
  @php
    $index = 0;
  @endphp
  @foreach ($fields as $key => $field)
    <div class="col-md-6">
      <div class="form-group">
          @php
            $stringFormat =  strtolower(str_replace('_', '-', $key));
          @endphp
          <label for="input-{{ $stringFormat }}" class="col-sm-3 control-label">
            {{ $field['label'] }}
          </label>
          <div class="col-sm-9">
            <input id="input-{{ $stringFormat }}" type="text" name="{{ $stringFormat }}" 
              value="{{ $field['value'] }}" class="form-control" 
              placeholder="{{ isset($field['placeholder']) ? $field['placeholder'] : $field['label'] }}" />
          </div>
      </div>
    </div>
  @php
    $index++;
  @endphp
  @endforeach
</div>
