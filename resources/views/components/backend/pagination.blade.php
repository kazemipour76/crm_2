@props([
    'models',
    'formId',
])
<div class="d-flex justify-content-center justify-content-between">
    <div>
        {!! $models->links('backend.layout.base.paginate') !!}
    </div>
    <div>
        <x-backend.form.form-group isInline="true" title="تعداد نمایش :">
            <select class="form-control px-15" name="perPage" form="{{ $formId }}" onchange="this.form.submit()">
                <option value="5" @if( old('perPage') == 5 || empty(old('perPage'))) selected @endif>5</option>
                <option value="25"  @if( old('perPage') == 25) selected @endif>25</option>
                <option value="50" @if( old('perPage') == 50) selected @endif>50</option>
                <option value="100" @if( old('perPage') == 100) selected @endif>100</option>
                <option value="250"@if( old('perPage') == 250) selected @endif>250</option>
            </select>
        </x-backend.form.form-group>
    </div>
</div>
