@props([
'name',
'checked' => false,
'title' => null,
'value' => null,
'id' => null,
'checked' => false

])

<div class="form-group">
    <div class="checkbox-list">
        <label class="checkbox ">
            <input class="check" value="{{ $value }}" id="{{ $id }}" type="checkbox" name="{{ $name }}"
                {{$checked}} />
            <span></span>
            {{ $title }}
        </label>
    </div>
</div>
