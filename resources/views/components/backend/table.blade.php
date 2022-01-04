<table class="table table-striped  table-info  table-bordered table-hover ">

    {{ $slot }}
</table>

@push('style')
<style>
    .table-info, .table-info > th, .table-info > td{
        background-color: #f4fbff;
    }

    .table-striped tbody tr:nth-of-type(odd){
        background-color: #ffffff;
    }
    .table-info tr:hover > td{
        background-color: #f8f2fd !important;
    }



    .table-info th, .table-info td, .table-info thead th, .table-info tbody + tbody{
        border-color: #eae2f9 !important;
    }

</style>

@endpush

