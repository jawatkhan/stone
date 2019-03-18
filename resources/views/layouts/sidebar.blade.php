<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
            <div class="nano">
                <div class="nano-content">
                    <div class="logo"><a href="{{URL::to('/home')}}"><img id="imglogo" src="" alt="" style="width: 25px;height: 25px;border-radius: 50%;margin-right: 10px;margin-left:10px;"/> <span id="app_name"></span></a></div>
                    <ul>
                        <li class="label">@lang('general.main')</li>
                        <li class="active"><a href="{{URL::to('/home')}}"><i class="ti-home"></i>@lang('general.dashboard') </a>
                        </li>
                        <li class="label">@lang('general.seller-customer-part')</li>
                        @can('module')
                        <li class=""><a class="sidebar-sub-toggle"><i class="ti-layers"></i>@lang('general.buyer-information') <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                <li><a href="{{URL::to('/seller')}}">@lang('general.buyer-list')</a></li>
                                <li><a href="{{URL::to('/seller/create')}}">@lang('general.purchase-order')</a></li>
                                <li><a href="{{URL::to('/seller-get-amount-summary')}}">@lang('general.buyer-tally')</a></li>
                            </ul>
                        </li>
                        @endcan
                        <li class=""><a class="sidebar-sub-toggle"><i class="ti-layers"></i>@lang('general.customer-information') <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                <li><a href="{{URL::to('/customer')}}">@lang('general.customer-list')</a></li>
                                <li><a href="{{URL::to('/customer/create')}}">@lang('general.sales-order')</a></li>
                                <li><a href="{{URL::to('/customer-get-amount-summary')}}">@lang('general.customer-tally')</a></li>
                            </ul>
                        </li>
                        <li class="label">@lang('general.stock-part')</li>
                        <li class=""><a class="sidebar-sub-toggle"><i class="ti-briefcase"></i>@lang('general.stock') <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                <li><a href="{{URL::to('/stock-product')}}">@lang('general.stock-list')</a></li>
                            </ul>
                        </li>
                        <li><a href="{{URL::to('/category')}}"><i class="ti-home"></i>@lang('general.category-setting')</a></li>
                        <li class="label">@lang('general.extra-cost-part')</li>
                        <li class=""><a class="sidebar-sub-toggle"><i class="ti-briefcase"></i>@lang('general.owner-extra-cost') <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                <li><a href="{{URL::to('/owner-extra-cost')}}">@lang('general.extra-cost')</a></li>
                            </ul>
                        </li>
                        <li class="label">@lang('general.accounts-part')</li>
                        <li class=""><a class="sidebar-sub-toggle"><i class="ti-money"></i>@lang('general.accounts') <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                <li><a href="{{URL::to('/balance-recive')}}">@lang('general.payment-rec-form')</a></li>
                               <li><a href="{{URL::to('/get-invoice-wise-boucher')}}">@lang('general.voucher')</a></li>
                            </ul>
                        </li>
                        <li class="label">@lang('general.reports-part')</li>
                        <li class=""><a class="sidebar-sub-toggle"><i class="ti-flag-alt-2"></i>@lang('general.reports') <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                @can('module')
                                <li><a href="{{URL::to('/get-customer-wise-report')}}">@lang('general.invoice-wise-sales-report')</a></li>
                                <li><a href="{{URL::to('/get-seller-wise-report')}}">@lang('general.invoice-wise-purchase-report')</a></li>
                                <li><a href="{{URL::to('/get-extra-cost-report')}}">@lang('general.extra-cost-report')</a></li>
                                <li><a href="{{URL::to('/get-client-wise-report')}}">@lang('general.client-wise-report')</a></li>
                                <li><a href="{{URL::to('/get-profite-report')}}">@lang('general.profit-details')</a></li>
                                <li><a href="{{URL::to('/get-total-account-report')}}">@lang('general.total-accounts')</a></li>
                                @endcan
                                <li><a href="{{URL::to('/get-date-wise-report')}}">@lang('general.date-wise-report')</a></li>
                            </ul>
                        </li>
                        @can('module')
                        <li class="label">@lang('general.employer-part')</li>
                        <li class=""><a class="sidebar-sub-toggle"><i class="ti-user"></i>@lang('general.employer')<span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                <li><a href="{{URL::to('/employer-list')}}">@lang('general.employer-list')</a></li>
                                <li><a href="{{URL::to('/employer-salary')}}">@lang('general.employer-salary-payment')</a></li>
                            </ul>
                        </li>
                        <li class="label">@lang('general.organizations-part')</li>
                        <li class=""><a class="sidebar-sub-toggle"><i class="ti-location-pin"></i>@lang('general.organization')<span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                <li><a href="{{URL::to('/organization')}}">@lang('general.organization-list')</a></li>
                            </ul>
                        </li>
                       @if(Auth::user()->roles[0]->name == 'Administrator')
                        <li><a class="sidebar-sub-toggle"><i class="ti-target"></i>@lang('general.user-registration') <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                <li><a href="{{URL::to('user/register')}}">@lang('general.register')</a></li>
                                <li><a href="{{URL::to('user/list')}}">@lang('general.user-list')</a></li>
                                <!-- <li><a href="page-reset-password.html">Forgot password</a></li> -->
                            </ul>
                        </li>

                        @endif

                        @endcan
                    </ul>
                </div>
            </div>
        </div>
        <!-- /# sidebar -->