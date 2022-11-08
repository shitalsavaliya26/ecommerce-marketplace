<!-- BEGIN: Header -->
        <header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
            <div class="m-container m-container--fluid m-container--full-height">
                <div class="m-stack m-stack--ver m-stack--desktop">
                    <!-- BEGIN: Brand -->
                    <div class="m-stack__item m-brand  m-brand--skin-dark ">
                        <div class="m-stack m-stack--ver m-stack--general">
                            <div class="m-stack__item m-stack__item--middle m-brand__logo">
                                <a href="{{ route('seller.dashboard') }}" class="m-brand__logo-wrapper">
                                    <!-- <img alt="" src="{{ asset('assets/images/Logo.png') }}"  width="75" height="50"/> -->
                                    <div class="mainheader-font">Maxshop</div>
                                </a>
                            </div>
                            <div class="m-stack__item m-stack__item--middle m-brand__tools">
                                <!-- BEGIN: Left Aside Minimize Toggle -->
                                <a href="javascript:;" id="m_aside_left_minimize_toggle"
                                class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block">
                                <span></span>
                            </a>
                            <!-- END -->
                            <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                            <a href="javascript:;" id="m_aside_left_offcanvas_toggle"
                            class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->
                        <!-- BEGIN: Responsive Header Menu Toggler -->
                        <a id="m_aside_header_menu_mobile_toggle" href="javascript:;"
                        class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                        <span></span>
                    </a>
                    <!-- END -->
                    <!-- BEGIN: Topbar Toggler -->
                    <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;"
                    class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                    <i class="flaticon-more"></i>
                </a>
                <!-- BEGIN: Topbar Toggler -->
            </div>
        </div>
    </div>
    <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
        <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark "
        id="m_aside_header_menu_mobile_close_btn">
        <i class="la la-close"></i>
    </button>
    <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas
    m-header-menu--skin-dark m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark
    m-aside-header-menu-mobile--submenu-skin-dark ">
    <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"
        m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true">
        <a href="javascript:;" class="m-menu__link m-menu__toggle">
            <span class="m-menu__link-text">Welcome {{ $user->name }}!</span>
        </a>
    </li>
     <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel pull-right"
        m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true">
        <label class="m-menu__link  pull-right">
            <span class="m-menu__link-text"><strong>Account Balance: RM {{ round($user->comission_balance,2) }}</strong></span>
        </label>
    </li>
</ul>
</div>

<!-- BEGIN: Topbar -->
<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid">
    <div class="m-stack__item m-topbar__nav-wrapper">
        <ul class="m-topbar__nav m-nav m-nav--inline">
            @if (!Auth::guest())
            <li class="m-nav__item m-topbar__languages m-dropdown m-dropdown--small m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-right m-dropdown--mobile-full-width" m-dropdown-toggle="click">
                <a href="#" class="m-nav__link m-dropdown__toggle">
                    <span class="m-nav__link-icon">
                        <i class="flaticon-grid-menu"></i>
                    </span>
                </a>
                <div class="m-dropdown__wrapper" style="z-index: 101;">
                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust" style="left: auto; right: 12.5px;"></span>
                    <div class="m-dropdown__inner">
                        <div class="m-dropdown__header m--align-center" style="background: url(/app/media/img/misc/user_profile_bg.jpg); background-size: cover;">
                            <div class="m-card-user m-card-user--skin-dark">
                                <div class="m-card-user__pic">
                                    <img src="./assets/app/media/img/users/user4.jpg" class="m--img-rounded m--marginless" alt="">
                                    <!-- <span class="m-type m-type--lg m--bg-danger"><span class="m--font-light">S<span><span> -->
                                    </div>
                                    <div class="m-card-user__details">
                                        <span class="m-card-user__name m--font-weight-500">
                                            {{ $user->name }}
                                        </span>
                                        <a href="#" class="m-card-user__email m--font-weight-300 m-link">
                                            @if ($user->role_id != 1)
                                            ( {{ $user->referal_code }} )
                                            @endif
                                        </a>
                                        <a href="#" class="m-card-user__email m--font-weight-300 m-link"> {{ $user->email }} </a>
                                    </div>
                                </div>
                            </div>
                            <div class="m-dropdown__body">
                                <div class="m-dropdown__content">
                                    <ul class="m-nav m-nav--skin-dark">
                                        <li class="m-nav__section m--hide">
                                            <span class="m-nav__section-text">Section</span>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="{{ route('seller.profile') }}" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                <span class="m-nav__link-title">
                                                    <span class="m-nav__link-wrap">
                                                        <span class="m-nav__link-text">My Profile</span>
                                                        <span class="m-nav__link-badge"></span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="#" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
                                            Logout
                                        </a>
                                    </li>
                                    <form id="logout-form" action="{{ route('seller.logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            @endif
        </ul>
    </div>
</div>
</div>
</div>
</div>
</header>
<!-- END: Header -->