<!--begin::Header-->
<div id="kt_header" class="header header-fixed">

    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <div></div>

        <!--begin::Topbar-->
        <div class="topbar">

            <!--begin::Quick Actions-->
            <div class="dropdown">
                <!--begin::Toggle-->
                <div class="topbar-item">
                    <a href="{{ \App\Utilities\Url::admin('crm/chartReports') }}">

                    <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1">
											<span class="svg-icon svg-icon-xl svg-icon-primary">

												<!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
												<svg xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                     height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24"/>
														<rect fill="#000000" opacity="0.3" x="13" y="4" width="3"
                                                              height="16" rx="1.5"/>
														<rect fill="#000000" x="8" y="9" width="3" height="11"
                                                              rx="1.5"/>
														<rect fill="#000000" x="18" y="11" width="3" height="9"
                                                              rx="1.5"/>
														<rect fill="#000000" x="3" y="13" width="3" height="7"
                                                              rx="1.5"/>
													</g>
												</svg>

                                                <!--end::Svg Icon-->
											</span>
                    </div>
                    </a>

                </div>
                <!--end::Toggle-->

                <!--begin::Dropdown-->
                <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">

                    <!--[html-partial:include:{"file":"partials/_extras/dropdown/quick-actions.html"}]/-->
                </div>

                <!--end::Dropdown-->
            </div>

            <!--end::Quick Actions-->


        {{--								<div class="topbar-item">--}}
        {{--									<div class="btn btn-icon btn-clean btn-lg mr-1" id="kt_quick_panel_toggle">--}}
        {{--										<span class="svg-icon svg-icon-xl svg-icon-primary">--}}

        {{--											<!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->--}}
        {{--											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">--}}
        {{--												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">--}}
        {{--													<rect x="0" y="0" width="24" height="24" />--}}
        {{--													<rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5" />--}}
        {{--													<path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3" />--}}
        {{--												</g>--}}
        {{--											</svg>--}}

        {{--											<!--end::Svg Icon-->--}}
        {{--										</span>--}}
        {{--									</div>--}}
        {{--								</div>--}}

        <!--end::Quick panel-->

            <!--begin::User-->
            <div class="topbar-item">
                <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2"
                     id="kt_quick_user_toggle">
                    <span
                        class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{ Auth::user()->name }}</span>
                    <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
											<span class="symbol-label font-size-h5 font-weight-bold">
                                                @if(Auth::user()->name_image==null)
                                                    <div class="symbol-label">{{ mb_substr(Auth::user()->name, 0, 1, 'utf-8')}}</div>
                                                @else
                                                    <img  class="symbol-label font-size-h5 font-weight-bold" src="{{URL::asset('/imageUser/'.Auth::user()->name_image)}}">
                                                @endif
                                            </span>
										</span>
                </div>
            </div>

            <!--end::User-->
        </div>

        <!--end::Topbar-->
    </div>

    <!--end::Container-->
</div>

<!--end::Header-->
