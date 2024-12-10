@php

    $users = \Auth::user();
    $profile = \App\Models\Utility::get_file('uploads/avatar/');
    $currantLang = $users->currentLanguage();
    $emailTemplate = App\Models\EmailTemplate::first();
    $logo = \App\Models\Utility::get_file('uploads/logo/');

    $company_logo = \App\Models\Utility::GetLogo();
    //  dd($company_logo);
@endphp

@if (isset($settings['cust_theme_bg']) && $settings['cust_theme_bg'] == 'on')
    <nav class="dash-sidebar light-sidebar transprent-bg">
    @else
        <nav class="dash-sidebar light-sidebar">
@endif
<div class="navbar-wrapper">
    <div class="m-header main-logo">
        <a href="#" class="b-brand">

            @if ($settings['cust_darklayout'] == 'on')
                <img src="{{ $logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-light.png') . '?timestamp=' . time() }}"
                    alt="" class="img-fluid" />
            @else
                <img src="{{ $logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') . '?timestamp=' . time() }}"
                    alt="" class="img-fluid" />
            @endif

        </a>
    </div>
    <div class="navbar-content">
        <ul class="dash-navbar">
            <li class="dash-item">
                <a href="{{ route('dashboard') }}" class="dash-link"><span class="dash-micon"><i
                            class="ti ti-home"></i></span><span class="dash-mtext">{{ __('My Dashboard') }}</span></a>
            </li>

            @if (\Auth::user()->type == 'super admin')
                <li class="dash-item">
                    <a href="{{ route('users.index') }}"
                        class="dash-link {{ Request::segment(1) == 'users' ? 'active' : '' }}">
                        <span class="dash-micon"><i class="ti ti-users"></i></span> <span
                            class="dash-mtext">{{ __('Company') }} </span>
                    </a>
                </li>
            @endif

            @if (\Auth::user()->type == 'company')
                <li
                    class="dash-item dash-hasmenu {{ Request::segment(1) == 'employee' || Request::segment(1) == 'client' || Request::segment(1) == 'userlogs' || Request::segment(1) == 'clientlogs' ? 'active dash-trigger' : '' }}">
                    <a class="dash-link " data-toggle="collapse" role="button"
                        aria-controls="navbar-getting-started"><span class="dash-micon"><i
                                class="ti ti-users"></i></span><span class="dash-mtext">{{ __('Team') }}</span><span
                            class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                    <ul class="dash-submenu">
                        <li
                            class="dash-item dash-hasmenu {{ Request::segment(1) == 'employee' || Request::segment(1) == 'userlogs' ? 'active ' : '' }}">
                            <a class="dash-link" href="{{ route('employee.index') }}">{{ __('Employee') }}</span></a>

                        </li>
                        <li
                            class="dash-item dash-hasmenu {{ Request::segment(1) == 'client' || Request::segment(1) == 'clientlogs' ? 'active' : '' }}">
                            <a class="dash-link" href="{{ route('client.index') }}">{{ __('Client') }}</a>

                        </li>

                    </ul>
                </li>
            @elseif(\Auth::user()->type == 'employee')
                <li class="dash-item  {{ Request::segment(1) == 'employee' ? 'active ' : '' }}">
                    <a href="{{ route('employee.show', \Crypt::encrypt(\Auth::user()->id)) }}" class="dash-link"><span
                            class="dash-micon"><i class="ti ti-accessible"></i></span><span
                            class="dash-mtext">{{ __('My Profile') }}</span></a>

                </li>
            @elseif(\Auth::user()->type == 'client')
                <li class="dash-item {{ Request::segment(1) == 'client' ? 'active ' : '' }}">
                    <a href="{{ route('client.show', \Crypt::encrypt(\Auth::user()->id)) }}" class="dash-link"><span
                            class="dash-micon"><i class="ti ti-home"></i></span><span
                            class="dash-mtext">{{ __('My Profile') }}</span></a>

                </li>
            @endif

            @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'employee')
                <li class="dash-item dash-hasmenu">
                    <a href="#!" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-hand-three-fingers"></i></span><span
                            class="dash-mtext">{{ __('HR') }}</span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="dash-submenu">
                        @if (\Auth::user()->type == 'company')
                            <li class="dash-item dash-hasmenu">
                                <a class="dash-link" href="#">{{ __('Attendance') }}<span class="dash-arrow"><i
                                            data-feather="chevron-right"></i></span></a>
                                <ul class="dash-submenu">
                                    <li class="dash-item">
                                        <a class="dash-link"
                                            href="{{ route('attendance.index') }}">{{ __('Attendance') }}</a>
                                    </li>
                                    <li class="dash-item">
                                        <a class="dash-link"
                                            href="{{ route('bulk.attendance') }}">{{ __('Bulk Attendance') }}</a>
                                    </li>
                                </ul>
                            </li>
                        @elseif(\Auth::user()->type == 'employee')
                            <li class="dash-item ">
                                <a class="dash-link" href="{{ route('attendance.index') }}">{{ __('Attendance') }}</a>
                            </li>
                        @endif
                        <li class="dash-item ">
                            <a class="dash-link" href="{{ route('holiday.index') }}">{{ __('Holiday') }}</a>
                        </li>
                        <li class="dash-item">
                            <a class="dash-link" href="{{ route('leave.index') }}">{{ __('Leave') }}</a>
                        </li>
                        <li class="dash-item">
                            <a class="dash-link"
                                href="{{ !empty(\Auth::user()->getDefualtViewRouteByModule('meeting')) ? route(\Auth::user()->getDefualtViewRouteByModule('meeting')) : route('meeting.index') }}">{{ __('Meeting') }}</a>
                        </li>
                        <li class="dash-item">
                            <a class="dash-link" href="{{ route('account-assets.index') }}">{{ __('Asset') }}</a>
                        </li>
                        <li class="dash-item">
                            <a class="dash-link" href="{{ route('document-upload.index') }}">{{ __('Document') }}</a>
                        </li>
                        <li class="dash-item">
                            <a class="dash-link"
                                href="{{ route('company-policy.index') }}">{{ __('Company Policy') }}</a>
                        </li>
                       

                    </ul>
                </li>
            @endif

            @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'employee' || \Auth::user()->type == 'client')
                <li
                    class="dash-item dash-hasmenu {{ Request::segment(1) == 'lead' || Request::segment(1) == 'deal' || Request::segment(1) == 'estimate' || Request::segment(1) == 'form_builder' || Request::segment(1) == 'form_response' ? 'active dash-trigger' : '' }}">
                    <a href="#!" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-layout-2"></i></span><span
                            class="dash-mtext">{{ __('PreSale') }}</span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="dash-submenu">
                        @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'employee')
                            <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'lead' ? 'active' : '' }}">
                                <a class="dash-link"
                                    href="{{ route('lead.list') }}">{{ __('Lead') }}</a>
                            </li>
                        @endif
                     </ul>
                </li>
            @endif
            
            
               @if (\Auth::user()->type == 'company')
                <li
                    class="dash-item dash-hasmenu {{ Request::segment(1) == 'lead' || Request::segment(1) == 'deal' || Request::segment(1) == 'estimate' || Request::segment(1) == 'form_builder' || Request::segment(1) == 'form_response' ? 'active dash-trigger' : '' }}">
                    <a href="#!" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-layout-2"></i></span><span
                            class="dash-mtext">{{ __('Booking') }}</span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="dash-submenu">
                        @if (\Auth::user()->type == 'company')
                            <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'lead' ? 'active' : '' }}">
                                <a class="dash-link"
                                    href="{{ route('bookings.index') }}">{{ __('list') }}</a>
                            </li>
                        @endif
                     </ul>
                </li>
            @endif
            
            

            @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'client' || \Auth::user()->type == 'employee')
                <li
                    class="dash-item dash-hasmenu {{ Request::segment(1) == 'project' || Request::segment(1) == 'allTask' || Request::segment(1) == 'allTimesheet' ? 'active dash-trigger' : '' }}">
                    <a href="#!" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-list-check"></i></span><span
                            class="dash-mtext">{{ __('Project') }}</span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="dash-submenu">
                        <li
                            class="dash-item dash-hasmenu {{ Request::segment(1) == 'project' && Request::segment(2) != 'allTask' && Request::segment(2) != 'allTaskKanban' && Request::segment(2) != 'allTimesheet' ? 'active  dash-trigger' : '' }}">
                            <a class="dash-link" href="{{ route('project.index') }}">{{ __('All Project') }}</a>
                        </li>
                      
                    </ul>
                </li>
            @endif
            </li>
          
         
            @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'employee')
                <li class="dash-item">
                    <a href="{{ route('event.index') }}" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-calendar-event"></i></span><span
                            class="dash-mtext">{{ __('Event') }}</span></a>
                </li>
            @endif

            @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'client' || \Auth::user()->type == 'employee')
                <li class="dash-item">
                    <a href="{{ !empty(\Auth::user()->getDefualtViewRouteByModule('notice board')) ? route(\Auth::user()->getDefualtViewRouteByModule('notice board')) : route('noticeBoard.index') }}"
                        class="dash-link"><span class="dash-micon"><i class="ti ti-clipboard-list"></i></span><span
                            class="dash-mtext">{{ __('Notice Board') }}</span></a>
                </li>
            @endif

         

            @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'client' || \Auth::user()->type == 'employee')
                <li class="dash-item {{ request()->is('note*') ? 'active' : '' }}">
                    <a href="{{ route('note.index') }}" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-note"></i></span><span
                            class="dash-mtext">{{ __('Note') }}</span></a>
                </li>
            @endif

       


            @if (\Auth::user()->type == 'super admin')
                <li class="dash-item">
                    <a href="{{ route('plan_request.index') }}" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-git-pull-request"></i></span><span
                            class="dash-mtext">{{ __('Plan Request') }}</span></a>
                </li>
            @endif
            
            @if (\Auth::user()->type == 'super admin')
                <li class="dash-item {{ Request::segment(1) == 'coupon' ? 'active' : '' }}">
                    <a href="{{ route('coupon.index') }}" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-clipboard-check"></i></span><span
                            class="dash-mtext">{{ __('Coupon') }}</span></a>
                </li>
            @endif

          


            @if (\Auth::user()->type == 'company')
                <li class="dash-item dash-hasmenu">
                    <a href="#!" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-circle-square"></i></span><span
                            class="dash-mtext">{{ __('Resources') }}</span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="dash-submenu">
                        <li class="dash-item dash-hasmenu">
                            <a class="dash-link" href="#">{{ __('HR') }}<span class="dash-arrow"><i
                                        data-feather="chevron-right"></i></span></a>
                            <ul class="dash-submenu">
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="{{ route('department.index') }}">{{ __('Department') }}</a>
                                </li>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="{{ route('designation.index') }}">{{ __('Designation') }}</a>
                                </li>
                            
                                </li>
                            </ul>
                        </li>
                        <li class="dash-item dash-hasmenu">
                            <a class="dash-link" href="#">{{ __('Leads') }}<span class="dash-arrow"><i
                                        data-feather="chevron-right"></i></span></a>
                            <ul class="dash-submenu">
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="{{ route('budget.list') }}">{{ __('Budget') }}</a>
                                </li>
                              
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="{{ route('source.index') }}">{{ __('Source') }}</a>
                                </li>
                                 <li class="dash-item">
                                 <a class="dash-link" href="{{ route('category.index') }}">{{ __('Lead Category') }}</a>
                                </li>
                              
                            </ul>
                        </li>
                       
                        
                       
                        
                    </ul>
                </li>
            @endif

        

            @if (\Auth::user()->type == 'super admin')
                @include('landingpage::menu.landingpage')
            @endif

            @if (\Auth::user()->type == 'super admin' || \Auth::user()->type == 'company')
                <li class="dash-item">
                    <a href="#" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-settings"></i></span><span
                            class="dash-mtext">{{ __('Settings') }}</span></a>
                </li>
            @endif

        </ul>
    </div>
</div>
</nav>
<!-- [ navigation menu ] end -->
