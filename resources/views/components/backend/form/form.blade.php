@props(['action' , 'method' => 'GET' , 'enctype'=> ''])

<form {{ $attributes->class(['x-form']) }} action="{{ $action }}" method="{{ $method }}" enctype="{{ $enctype }}">
    {{ $slot }}
</form>
