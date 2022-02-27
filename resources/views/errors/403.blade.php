
@extends('backend.layout.main')

@section('page_title')
    داشبورد
@endsection
@section('body')

    <div class="post d-flex flex-column-fluid" id="kt_post">

        <div id="kt_content_container" class="container">

            <div class="row gy-5 gx-xl-8">
                <div class="col-xxl-4">
                    <div class="card card-xxl-stretch mb-xl-3">
                        <div class="card-header border-0">
                            <div class="lock"></div>
                            <div class="message">
                                <h1>این بخش قابل دسترس نیست</h1>
                                <p>{{ $exception->getMessage() }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>



@endsection

