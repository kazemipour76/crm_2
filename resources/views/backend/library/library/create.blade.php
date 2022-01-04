@extends('backend.layout.main')
@section('body')
    <x-backend.form.form action="{{ \App\Utilities\Url::admin('library/library/handler') }}" method="post">
        @csrf
        <x-backend.card title="آپلود فایل" icon="fa-upload">
            <div class="row">

                <div class="col-lg-12">
                    <x-backend.form.form-group title="">
                        <div class="dropzone dropzone-multi w-100" id="kt_dropzone_5">
                            <div class="dropzone-panel mb-lg-0 mb-2">
                                <div class="dropzone dropzone-select dropzone-default dropzone-primary py-30">
                                       <h3>
                                            فایل ها را برای اپلود اینجا بیندازید
                                       </h3>
                                </div>

{{--                                <a class="dropzone-select btn btn-light-primary font-weight-bold btn-sm">Attach files</a>--}}
                            </div>
                            <div class="dropzone-items ">
                                <div class="dropzone-item" style="display:none">
                                    <div class="px-5">
                                       <img data-dz-thumbnail/>
                                    </div>
                                    <div class="dropzone-file">
                                        <div class="dropzone-filename" title="some_image_file_name.jpg">
                                            <span data-dz-name="">some_image_file_name.jpg</span>
                                            <strong>(
                                                <span data-dz-size="">340kb</span>)</strong>
                                        </div>
                                        <div class="dropzone-error" data-dz-errormessage=""></div>
                                    </div>
                                    <div class="dropzone-progress" style="width: 230px !important;">
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info"  role="progressbar" aria-valuemin="0"
                                                 aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress=""></div>
                                        </div>
                                    </div>
                                    <div class="dropzone-toolbar">
                                      <a class="btn btn-light btn-edit" href="#" target="_blank" style="opacity: 0">ویرایش</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </x-backend.form.form-group>
                </div>


            </div>


        </x-backend.card>
    </x-backend.form.form>

@endsection


@push('script')
    <script>
        $(function () {
            // set the dropzone container id
            var id = '#kt_dropzone_5';

            // set the preview element template
            var previewNode = $(id + " .dropzone-item");
            previewNode.id = "";
            var previewTemplate = previewNode.parent('.dropzone-items').html();
            previewNode.remove();

            var myDropzone5 = new Dropzone(id, { // Make the whole body a dropzone
                url: "{{\App\Utilities\Url::admin('library/library/create') }}", // Set the url for your upload script location
                parallelUploads: 5,
                maxFilesize: 1000, // Max filesize in MB
                previewTemplate: previewTemplate,
                previewsContainer: id + " .dropzone-items", // Define the container to display the previews
                clickable: id + " .dropzone-select" // Define the element that should be used as click trigger to select files.
            });

            myDropzone5.on("addedfile", function(file) {
                // Hookup the start button
                $(document).find( id + ' .dropzone-item').css('display', '');
            });

            // Update the total progress bar
            myDropzone5.on("totaluploadprogress", function(progress) {
                $( id + " .progress-bar").css('width', progress + "%");
            });

            myDropzone5.on("sending", function(file) {
                // Show the total progress bar when upload starts
                $( id + " .progress-bar").css('opacity', "1");
            });

            // Hide the total progress bar when nothing's uploading anymore
            myDropzone5.on("complete", function(progress) {
                var thisProgressBar = id + " .dz-complete";
                setTimeout(function(){
                    $( thisProgressBar + " .progress-bar, " + thisProgressBar + " .progress").removeClass('progress-bar-animated');
                    $( thisProgressBar + " .progress-bar, " + thisProgressBar + " .progress").removeClass('bg-info');
                    $( thisProgressBar + " .progress-bar, " + thisProgressBar + " .progress").addClass('bg-success');
                }, 300)
            });

            myDropzone5.on("success", function(o, response) {

                if(response.errors)
                {
                    var errorHtml = '';
                    for(var key in response.errors)
                    {
                        for (var item of response.errors[key])
                        {
                            errorHtml += "<p class='text-danger'>" +  item + "</p>";
                        }
                    }
                    $(o.previewElement).find('.dropzone-progress').first().html(errorHtml);
                    $(o.previewElement).css('background-color','#ffecec');
                }
                else
                {
                    setTimeout(function() {
                        $(o.previewElement).find('.dropzone-toolbar .btn-edit').first().attr('href', "{{\App\Utilities\Url::admin('library/library') }}/" + response.id + '/edit');
                        $(o.previewElement).find('.dropzone-toolbar .btn-edit').first().css('opacity', 1);
                    }, 300);
                }

            });
        });
    </script>
@endpush
