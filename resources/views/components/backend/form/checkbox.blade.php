@props([
    'name',
     'checked' => false,
      'title' => 'title',
      'value' => null,
     ])

<div class="form-group">
    <div class="checkbox-list">
        <label class="checkbox ">
            <input class="check" value="{{ $value }}" type="checkbox" name="{{ $name }}" @if($checked) checked @endif/>
            <span></span>
        </label>
    </div>
</div>
