<?php

    $users = \Auth::user();
    $profile = \App\Models\Utility::get_file('uploads/avatar/');
    $currantLang = $users->currentLanguage();
    $emailTemplate = App\Models\EmailTemplate::first();
    $logo = \App\Models\Utility::get_file('uploads/logo/');

    $company_logo = \App\Models\Utility::GetLogo();
    //  dd($company_logo);
?>

<?php if(isset($settings['cust_theme_bg']) && $settings['cust_theme_bg'] == 'on'): ?>
    <nav class="dash-sidebar light-sidebar transprent-bg">
    <?php else: ?>
        <nav class="dash-sidebar light-sidebar">
<?php endif; ?>
<div class="navbar-wrapper">
    <div class="m-header main-logo">
        <a href="#" class="b-brand">

            <?php if($settings['cust_darklayout'] == 'on'): ?>
                <img src="<?php echo e($logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-light.png') . '?timestamp=' . time()); ?>"
                    alt="" class="img-fluid" />
            <?php else: ?>
                <img src="<?php echo e($logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') . '?timestamp=' . time()); ?>"
                    alt="" class="img-fluid" />
            <?php endif; ?>

        </a>
    </div>
    <div class="navbar-content">
        <ul class="dash-navbar">
            <li class="dash-item">
                <a href="<?php echo e(route('dashboard')); ?>" class="dash-link"><span class="dash-micon"><i
                            class="ti ti-home"></i></span><span class="dash-mtext"><?php echo e(__('My Dashboard')); ?></span></a>
            </li>

            <?php if(\Auth::user()->type == 'super admin'): ?>
                <li class="dash-item">
                    <a href="<?php echo e(route('users.index')); ?>"
                        class="dash-link <?php echo e(Request::segment(1) == 'users' ? 'active' : ''); ?>">
                        <span class="dash-micon"><i class="ti ti-users"></i></span> <span
                            class="dash-mtext"><?php echo e(__('Company')); ?> </span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if(\Auth::user()->type == 'company'): ?>
                <li
                    class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'employee' || Request::segment(1) == 'client' || Request::segment(1) == 'userlogs' || Request::segment(1) == 'clientlogs' ? 'active dash-trigger' : ''); ?>">
                    <a class="dash-link " data-toggle="collapse" role="button"
                        aria-controls="navbar-getting-started"><span class="dash-micon"><i
                                class="ti ti-users"></i></span><span class="dash-mtext"><?php echo e(__('Team')); ?></span><span
                            class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                    <ul class="dash-submenu">
                        <li
                            class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'employee' || Request::segment(1) == 'userlogs' ? 'active ' : ''); ?>">
                            <a class="dash-link" href="<?php echo e(route('employee.index')); ?>"><?php echo e(__('Employee')); ?></span></a>

                        </li>
                        <li
                            class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'client' || Request::segment(1) == 'clientlogs' ? 'active' : ''); ?>">
                            <a class="dash-link" href="<?php echo e(route('client.index')); ?>"><?php echo e(__('Client')); ?></a>

                        </li>

                    </ul>
                </li>
            <?php elseif(\Auth::user()->type == 'employee'): ?>
                <li class="dash-item  <?php echo e(Request::segment(1) == 'employee' ? 'active ' : ''); ?>">
                    <a href="<?php echo e(route('employee.show', \Crypt::encrypt(\Auth::user()->id))); ?>" class="dash-link"><span
                            class="dash-micon"><i class="ti ti-accessible"></i></span><span
                            class="dash-mtext"><?php echo e(__('My Profile')); ?></span></a>

                </li>
            <?php elseif(\Auth::user()->type == 'client'): ?>
                <li class="dash-item <?php echo e(Request::segment(1) == 'client' ? 'active ' : ''); ?>">
                    <a href="<?php echo e(route('client.show', \Crypt::encrypt(\Auth::user()->id))); ?>" class="dash-link"><span
                            class="dash-micon"><i class="ti ti-home"></i></span><span
                            class="dash-mtext"><?php echo e(__('My Profile')); ?></span></a>

                </li>
            <?php endif; ?>

            <?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'employee'): ?>
                <li class="dash-item dash-hasmenu">
                    <a href="#!" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-hand-three-fingers"></i></span><span
                            class="dash-mtext"><?php echo e(__('HR')); ?></span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="dash-submenu">
                        <?php if(\Auth::user()->type == 'company'): ?>
                            <li class="dash-item dash-hasmenu">
                                <a class="dash-link" href="#"><?php echo e(__('Attendance')); ?><span class="dash-arrow"><i
                                            data-feather="chevron-right"></i></span></a>
                                <ul class="dash-submenu">
                                    <li class="dash-item">
                                        <a class="dash-link"
                                            href="<?php echo e(route('attendance.index')); ?>"><?php echo e(__('Attendance')); ?></a>
                                    </li>
                                    <li class="dash-item">
                                        <a class="dash-link"
                                            href="<?php echo e(route('bulk.attendance')); ?>"><?php echo e(__('Bulk Attendance')); ?></a>
                                    </li>
                                </ul>
                            </li>
                        <?php elseif(\Auth::user()->type == 'employee'): ?>
                            <li class="dash-item ">
                                <a class="dash-link" href="<?php echo e(route('attendance.index')); ?>"><?php echo e(__('Attendance')); ?></a>
                            </li>
                        <?php endif; ?>
                        <li class="dash-item ">
                            <a class="dash-link" href="<?php echo e(route('holiday.index')); ?>"><?php echo e(__('Holiday')); ?></a>
                        </li>
                        <li class="dash-item">
                            <a class="dash-link" href="<?php echo e(route('leave.index')); ?>"><?php echo e(__('Leave')); ?></a>
                        </li>
                        <li class="dash-item">
                            <a class="dash-link"
                                href="<?php echo e(!empty(\Auth::user()->getDefualtViewRouteByModule('meeting')) ? route(\Auth::user()->getDefualtViewRouteByModule('meeting')) : route('meeting.index')); ?>"><?php echo e(__('Meeting')); ?></a>
                        </li>
                        <li class="dash-item">
                            <a class="dash-link" href="<?php echo e(route('account-assets.index')); ?>"><?php echo e(__('Asset')); ?></a>
                        </li>
                        <li class="dash-item">
                            <a class="dash-link" href="<?php echo e(route('document-upload.index')); ?>"><?php echo e(__('Document')); ?></a>
                        </li>
                        <li class="dash-item">
                            <a class="dash-link"
                                href="<?php echo e(route('company-policy.index')); ?>"><?php echo e(__('Company Policy')); ?></a>
                        </li>
                       

                    </ul>
                </li>
            <?php endif; ?>

            <?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'employee' || \Auth::user()->type == 'client'): ?>
                <li
                    class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'lead' || Request::segment(1) == 'deal' || Request::segment(1) == 'estimate' || Request::segment(1) == 'form_builder' || Request::segment(1) == 'form_response' ? 'active dash-trigger' : ''); ?>">
                    <a href="#!" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-layout-2"></i></span><span
                            class="dash-mtext"><?php echo e(__('PreSale')); ?></span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="dash-submenu">
                        <?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'employee'): ?>
                            <li class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'lead' ? 'active' : ''); ?>">
                                <a class="dash-link"
                                    href="<?php echo e(route('lead.list')); ?>"><?php echo e(__('Lead')); ?></a>
                            </li>
                        <?php endif; ?>
                     </ul>
                </li>
            <?php endif; ?>
            
            
               <?php if(\Auth::user()->type == 'company'): ?>
                <li
                    class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'lead' || Request::segment(1) == 'deal' || Request::segment(1) == 'estimate' || Request::segment(1) == 'form_builder' || Request::segment(1) == 'form_response' ? 'active dash-trigger' : ''); ?>">
                    <a href="#!" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-layout-2"></i></span><span
                            class="dash-mtext"><?php echo e(__('Booking')); ?></span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="dash-submenu">
                        <?php if(\Auth::user()->type == 'company'): ?>
                            <li class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'lead' ? 'active' : ''); ?>">
                                <a class="dash-link"
                                    href="<?php echo e(route('bookings.index')); ?>"><?php echo e(__('list')); ?></a>
                            </li>
                        <?php endif; ?>
                     </ul>
                </li>
            <?php endif; ?>
            
            

            <?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'client' || \Auth::user()->type == 'employee'): ?>
                <li
                    class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'project' || Request::segment(1) == 'allTask' || Request::segment(1) == 'allTimesheet' ? 'active dash-trigger' : ''); ?>">
                    <a href="#!" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-list-check"></i></span><span
                            class="dash-mtext"><?php echo e(__('Project')); ?></span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="dash-submenu">
                        <li
                            class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'project' && Request::segment(2) != 'allTask' && Request::segment(2) != 'allTaskKanban' && Request::segment(2) != 'allTimesheet' ? 'active  dash-trigger' : ''); ?>">
                            <a class="dash-link" href="<?php echo e(route('project.index')); ?>"><?php echo e(__('All Project')); ?></a>
                        </li>
                      
                    </ul>
                </li>
            <?php endif; ?>
            </li>
          
         
            <?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'employee'): ?>
                <li class="dash-item">
                    <a href="<?php echo e(route('event.index')); ?>" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-calendar-event"></i></span><span
                            class="dash-mtext"><?php echo e(__('Event')); ?></span></a>
                </li>
            <?php endif; ?>

            <?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'client' || \Auth::user()->type == 'employee'): ?>
                <li class="dash-item">
                    <a href="<?php echo e(!empty(\Auth::user()->getDefualtViewRouteByModule('notice board')) ? route(\Auth::user()->getDefualtViewRouteByModule('notice board')) : route('noticeBoard.index')); ?>"
                        class="dash-link"><span class="dash-micon"><i class="ti ti-clipboard-list"></i></span><span
                            class="dash-mtext"><?php echo e(__('Notice Board')); ?></span></a>
                </li>
            <?php endif; ?>

         

            <?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'client' || \Auth::user()->type == 'employee'): ?>
                <li class="dash-item <?php echo e(request()->is('note*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('note.index')); ?>" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-note"></i></span><span
                            class="dash-mtext"><?php echo e(__('Note')); ?></span></a>
                </li>
            <?php endif; ?>

       


            <?php if(\Auth::user()->type == 'super admin'): ?>
                <li class="dash-item">
                    <a href="<?php echo e(route('plan_request.index')); ?>" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-git-pull-request"></i></span><span
                            class="dash-mtext"><?php echo e(__('Plan Request')); ?></span></a>
                </li>
            <?php endif; ?>
            
            <?php if(\Auth::user()->type == 'super admin'): ?>
                <li class="dash-item <?php echo e(Request::segment(1) == 'coupon' ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('coupon.index')); ?>" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-clipboard-check"></i></span><span
                            class="dash-mtext"><?php echo e(__('Coupon')); ?></span></a>
                </li>
            <?php endif; ?>

          


            <?php if(\Auth::user()->type == 'company'): ?>
                <li class="dash-item dash-hasmenu">
                    <a href="#!" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-circle-square"></i></span><span
                            class="dash-mtext"><?php echo e(__('Resources')); ?></span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="dash-submenu">
                        <li class="dash-item dash-hasmenu">
                            <a class="dash-link" href="#"><?php echo e(__('HR')); ?><span class="dash-arrow"><i
                                        data-feather="chevron-right"></i></span></a>
                            <ul class="dash-submenu">
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('department.index')); ?>"><?php echo e(__('Department')); ?></a>
                                </li>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('designation.index')); ?>"><?php echo e(__('Designation')); ?></a>
                                </li>
                            
                                </li>
                            </ul>
                        </li>
                        <li class="dash-item dash-hasmenu">
                            <a class="dash-link" href="#"><?php echo e(__('Leads')); ?><span class="dash-arrow"><i
                                        data-feather="chevron-right"></i></span></a>
                            <ul class="dash-submenu">
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('budget.list')); ?>"><?php echo e(__('Budget')); ?></a>
                                </li>
                              
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('source.index')); ?>"><?php echo e(__('Source')); ?></a>
                                </li>
                                 <li class="dash-item">
                                 <a class="dash-link" href="<?php echo e(route('category.index')); ?>"><?php echo e(__('Lead Category')); ?></a>
                                </li>
                              
                            </ul>
                        </li>
                       
                        
                       
                        
                    </ul>
                </li>
            <?php endif; ?>

        

            <?php if(\Auth::user()->type == 'super admin'): ?>
                <?php echo $__env->make('landingpage::menu.landingpage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <?php if(\Auth::user()->type == 'super admin' || \Auth::user()->type == 'company'): ?>
                <li class="dash-item">
                    <a href="#" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-settings"></i></span><span
                            class="dash-mtext"><?php echo e(__('Settings')); ?></span></a>
                </li>
            <?php endif; ?>

        </ul>
    </div>
</div>
</nav>
<!-- [ navigation menu ] end -->
<?php /**PATH /home/pspace/leadactpro.in/resources/views/partials/admin/menu.blade.php ENDPATH**/ ?>