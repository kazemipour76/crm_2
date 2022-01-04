$(document).ready(function () {

    $('.select2').select2({ width: '100%' });

    $('.x-confirm').on('click', function (e) {
        e.preventDefault();
        var $modal = $('#model');
        var $source = $(this);
        var description = $(this).data('description');
        var title = $(this).data('title');

        $modal.find('.modal-body').first().text(description);
        $modal.find('.modal-title').first().text(title);

        $modal.find('.btn-confirm').first().click(function () {
            var id = $(this).data('targetid');
            $('#' + id).removeAttr('onclick');
            if( $source.attr('href')?.length > 0)
            {
                location.href = $source.attr('href');
            }
            else if($source.attr('type') === 'submit')
            {
                var $form = $source.parents('.x-form').first();
                $form.append('<input type="hidden" name="action" value="' + $source.attr('value') + '" />' );
                $form.submit();

            }
            $modal.modal('hide');
        });


        $modal.modal('show');
    });
});
