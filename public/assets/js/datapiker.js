$(function () {
    $("#checkAll").click(function () {
        $(".check").prop('checked', $(this).prop('checked'));
    });
});
jalaliDatepicker.startWatch();
