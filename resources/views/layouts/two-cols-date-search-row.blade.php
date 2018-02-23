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
        <label class="col-md-3 control-label" for="input-{{ $stringFormat }}">
          {{ $field['label'] }}
        </label>
        <div class="col-md-7">
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" id="input-{{ $stringFormat }}" name="{{ $key }}"
                  value="{{ $field['value'] }}" class="form-control pull-right" required
                  placeholder="{{ isset($field['placeholder']) ? $field['placeholder'] : $field['label'] }}" />
            </div>
        </div>
      </div>
    </div>
  @php
    $index++;
  @endphp
  @endforeach
</div>
