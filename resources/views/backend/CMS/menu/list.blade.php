@extends('backend.layout.main')
@section('body')

    <x-backend.card no-padding="true" title="لیست منو" color="2" collapseid="#collapse-btn-2"
                    idcollapse="collapse-btn-2" icon="fa-bars">

        <x-slot name="nav">
            <a href="{{\App\Utilities\Url::admin('cms/menu/create') }}"
               class="btn btn-outline-success mx-1">
                <x-backend.icon class="fa-plus"/>
                ایجاد
            </a>
        </x-slot>
        <style>

        </style>

    <div id="kt_tree_5" class="tree-demo">
    </div>


    </x-backend.card>


@endsection

@push('script')
    <script src="{{ asset('assets/plugins/custom/jstree/jstree.bundle.js') }}"></script>
        <script>
            $("#kt_tree_5").jstree({
                "core": {
                    "themes": {
                        "responsive": false
                    },
                    "check_callback": true,

                    "data":JSON.parse('{!! $treeView->toJson() !!}'),

            },

                "types": {
                    "default": {
                        "icon": "fa fa-folder text-danger"
                    },
                    "file": {
                        "icon": "fa fa-file  text-success"
                    }
                },
                "state": {
                    "key": "demo2"
                },
                "plugins": ["dnd","contextmenu", "state", "types"]
            });
        </script>
@endpush
@push('style')
    <link href="{{ asset('assets/plugins/custom/jstree/jstree.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endpush

