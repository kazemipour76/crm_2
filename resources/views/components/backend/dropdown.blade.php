@props(['icon' => 'fa fa-ellipsis-v'])

<div>
    <div class="btn-group dropleft">
        <button type="button" class="btn btn-secondary " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"   style="background-color:#d1cdff">
            <i class="{{ $icon }}" ></i>
        </button>
        <div class="dropdown-menu ">
           {{ $slot }}
        </div>
    </div>

</div>
