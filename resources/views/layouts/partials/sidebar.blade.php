@php
    $company = \App\Models\Company::get();
@endphp
<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto"><a class="" href="{{route('user.home')}}"><!--<span class="brand-logo">
                         <svg viewbox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="24">
                            <defs>
                                <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
                                    <stop stop-color="#000000" offset="0%"></stop>
                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
                                </lineargradient>
                                <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%" y2="100%">
                                    <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
                                </lineargradient>
                            </defs>
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                                    <g id="Group" transform="translate(400.000000, 178.000000)">
                                        <path class="text-primary" id="Path" d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z" style="fill:currentColor"></path>
                                        <path id="Path1" d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z" fill="url(#linearGradient-1)" opacity="0.2"></path>
                                        <polygon id="Path-2" fill="#000000" opacity="0.049999997" points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"></polygon>
                                        <polygon id="Path-21" fill="#000000" opacity="0.099999994" points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"></polygon>
                                        <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994" points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                                    </g>
                                </g>
                            </g>
                        </svg></span> -->
                    <!-- <h2 class="brand-text">Tune-Up Scheduling</h2> -->
                    <img style="height:65px;width:165px;" src="{{ asset('images/theme/pages/login-v2.png') }}">
                </a></li>
            <!-- <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li> -->
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item {{request()->is('/')?'active':''}}">
                <a class="d-flex align-items-center" href="{{ route('user.home') }}"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Dashboards</span></a>
            </li>
            @if(auth::user()->role == 1)
                <li class=" navigation-header">User Management<i data-feather="more-horizontal"></i></li>
                <!-- <li class=" nav-item"><a class="d-flex align-items-center" href="app-email.html"><i data-feather="mail"></i><span class="menu-title text-truncate" data-i18n="Email">Email</span></a>
                </li> -->
                
                <li class=" nav-item {{request()->is('users') || request()->is('users/*')?'active':''}}"><a class="d-flex align-items-center" href="{{route('users.index')}}"><i data-feather="file-text"></i><span class="menu-title text-truncate" data-i18n="Invoice">Users</span></a>
                
                </li>

                
                
                </li>

                <li class=" navigation-header">Company Management<i data-feather="more-horizontal"></i></li>
                <!-- <li class=" nav-item"><a class="d-flex align-items-center" href="app-email.html"><i data-feather="mail"></i><span class="menu-title text-truncate" data-i18n="Email">Email</span></a>
                </li> -->
                
                <li class=" nav-item {{request()->is('company') || request()->is('company/*')?'active':''}}"><a class="d-flex align-items-center" href="{{route('company.index')}}"><i data-feather="file-text"></i><span class="menu-title text-truncate" data-i18n="Invoice">Company</span></a>
                
                </li>

                <li class=" navigation-header">Slot Management<i data-feather="more-horizontal"></i></li>
                
                <li class=" nav-item {{request()->is('time_slot') ?'active':''}}"><a class="d-flex align-items-center" href="{{route('time_slot.index')}}"><i data-feather="file-text"></i><span class="menu-title text-truncate" data-i18n="Invoice">Slots</span></a>

                <li class=" nav-item {{request()->is('archieve_time_slot') ?'active':''}}"><a class="d-flex align-items-center" href="{{route('time_slot.archieveSlots')}}"><i data-feather="file-text"></i><span class="menu-title text-truncate" data-i18n="Invoice">Archieve Slots</span></a>
                
                </li>
                
                </li>
                

                <li class=" navigation-header">Booking Management<i data-feather="more-horizontal"></i></li>
                
                <li class=" nav-item {{request()->is('booking') || request()->is('booking/*')?'active open':''}}"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i><span class="menu-title text-truncate" data-i18n="Invoice">Booking</span></a>
                    <ul class="menu-content">
                    @foreach($company as $key => $value)
                            <li class="{{request()->is('booking') || request()->is('booking/$value->id')?'active ':''}}"><a class="d-flex align-items-center" href="{{route('booking.index',$value->id)}}"><i data-feather="circle"></i><span class="menu-item" style="white-space: break-spaces;" data-i18n="Roles">{{$value->name}}</span></a>
                                    </li>
                        @endforeach
                            
                        </ul>
                </li>

                <li class=" navigation-header">Sheet Management<i data-feather="more-horizontal"></i></li>
                
                <li class=" nav-item {{request()->is('exportIndex') || request()->is('exportIndex/*')?'active':''}}"><a class="d-flex align-items-center" href="{{route('exportIndex')}}"><i data-feather="file-text"></i><span class="menu-title text-truncate" data-i18n="Invoice">Download Sheet</span></a>
                
                </li>

            @else
            
                <li class=" navigation-header">Slot Management<i data-feather="more-horizontal"></i></li>
                
                <li class=" nav-item {{ request()->is('booking', 'booking/add*') ?'active open':''}}"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i><span class="menu-title text-truncate" data-i18n="Invoice">Book Slots</span></a>
                    <ul class="menu-content">
                        @foreach($company as $key => $value)
                            <li class="{{request()->is('booking') || request()->is('booking/add/$value->id')?'active ':''}}"><a class="d-flex align-items-center" href="{{route('booking.add',$value->id)}}"><i data-feather="circle"></i><span class="menu-item"  style="white-space: break-spaces;" data-i18n="Roles">{{$value->name}}</span></a>
                                    </li>
                        @endforeach
                               
                            </ul>
                </li>

                <li class=" navigation-header">Booking Management<i data-feather="more-horizontal"></i></li>
                
                <li class=" nav-item {{request()->is('booking/csr', 'booking/csr/*')?'active open':''}}"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i><span class="menu-title text-truncate" data-i18n="Invoice">Booking</span></a>
                    <ul class="menu-content">
                    @foreach($company as $key => $value)
                            <li class="{{request()->is('booking/csr') || request()->is('booking/csr/$value->id')?'active ':''}}"><a class="d-flex align-items-center" href="{{route('csr.booking.index',$value->id)}}"><i data-feather="circle"></i><span style="white-space: break-spaces;" class="menu-item" data-i18n="Roles">{{$value->name}}</span></a>
                                    </li>
                        @endforeach
                            
                        </ul>
                </li>
            @endif    

            <!--<li class=" nav-item {{request()->is('role') || request()->is('role/*')?'active':''}}"><a class="d-flex align-items-center" href="{{route('role.index')}}"><i data-feather="grid"></i><span class="menu-title text-truncate" data-i18n="Kanban">Roles</span></a>-->
            <!--    </li>-->
            <!-- <li class=" nav-item"><a class="d-flex align-items-center" href="app-file-manager.html"><i data-feather="save"></i><span class="menu-title text-truncate" data-i18n="File Manager">File Manager</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="shield"></i><span class="menu-title text-truncate" data-i18n="Roles &amp; Permission">Roles &amp; Permission</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="app-access-roles.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Roles">Roles</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="app-access-permission.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Permission">Permission</span></a>
                    </li>
                </ul>
            </li> -->
            
        </ul>
    </div>
</div>
<!-- END: Main Menu