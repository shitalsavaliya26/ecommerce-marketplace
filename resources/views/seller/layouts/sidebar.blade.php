<!-- BEGIN: Left Aside -->
<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
  <i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item  m-aside-left  m-aside-left--skin-dark ">
  <!-- BEGIN: Aside Menu -->
  <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-light" m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
    <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
      <li class="m-menu__item  @if (Request::is('seller')) m-menu__item--active  @else m-menu__item @endif ">
        <a href="{{ route('seller.dashboard') }}" class="m-menu__link ">
          <i class="m-menu__link-icon flaticon-line-graph"></i>
          <span class="m-menu__link-title">
            <span class="m-menu__link-wrap">
              <span class="m-menu__link-text">Dashboard</span>
            </span>
          </span>
        </a>
      </li>

      <li class="m-menu__item   @if (Request::is('*/products/create') || Request::is('*/products/edit/*') || Request::is('*/products')) m-menu__item--active  @else m-menu__item @endif ">
        <a href="{{ route('seller.products.index') }}" class="m-menu__link ">
          <i class="m-menu__link-icon flaticon-interface-3"></i>
          <span class="m-menu__link-title">
            <span class="m-menu__link-wrap">
              <span class="m-menu__link-text">Products</span>
            </span>
          </span>
        </a>
      </li>
      <li class="m-menu__item   @if (Request::is('*/orders') || Request::is('*/orders/*')) m-menu__item--active  @else m-menu__item @endif ">
        <a href="{{ route('seller.orders') }}" class="m-menu__link ">
          <i class="m-menu__link-icon flaticon-cart"></i>
          <span class="m-menu__link-title">
            <span class="m-menu__link-wrap">
              <span class="m-menu__link-text">My Orders</span>
            </span>
          </span>
        </a>
      </li>
      <li class="m-menu__item   @if (Request::is('*/withdrawals')) m-menu__item--active  @else m-menu__item @endif ">
        <a href="{{ route('seller.withdrawals') }}" class="m-menu__link ">
          <i class="m-menu__link-icon flaticon-clipboard"></i>
          <span class="m-menu__link-title">
            <span class="m-menu__link-wrap">
              <span class="m-menu__link-text">Withdraw History</span>
            </span>
          </span>
        </a>
      </li>
      <li class="m-menu__item @if (Request::is('*/vouchers/create') || Request::is('*/vouchers/*') || Request::is('*/vouchers')) m-menu__item--active  @else m-menu__item @endif ">
        <a href="{{ route('seller.vouchers.index') }}" class="m-menu__link ">
          <i class="m-menu__link-icon flaticon-interface-3"></i>
          <span class="m-menu__link-title">
            <span class="m-menu__link-wrap">
              <span class="m-menu__link-text">Vouchers</span>
            </span>
          </span>
        </a>
      </li>
      <li class="m-menu__item @if (Request::is('*/support_ticket') || Request::is('*/support_ticket/*')) m-menu__item--active  @else m-menu__item @endif ">
        <a href="{{ route('seller.support_ticket.index') }}" class="m-menu__link ">
          <i class="m-menu__link-icon flaticon-settings-1"></i>
          <span class="m-menu__link-title">
            <span class="m-menu__link-wrap">
              <span class="m-menu__link-text">Support</span>
            </span>
          </span>
        </a>
      </li>
      <li class="m-menu__item @if (Request::is('*/followers') || Request::is('*/followers/*')) m-menu__item--active  @else m-menu__item @endif ">
        <a href="{{ route('seller.followers.index') }}" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-interface-3"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">Followers List</span>
                </span>
            </span>
        </a>
      </li>
      <li class="m-menu__item @if (Request::is('*/report') || Request::is('*/report/*')) m-menu__item--active  @else m-menu__item @endif ">
        <a href="{{ route('seller.my_income.index') }}" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-interface-3"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">Report</span>
                </span>
            </span>
        </a>
      </li>
      <li class="m-menu__item @if (Request::is('*/shop-categories') || Request::is('*/shop-categories/*')) m-menu__item--active m-menu__item--open @else m-menu__item @endif  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
        <a href="javascript:;" class="m-menu__link m-menu__toggle">
            <i class="m-menu__link-icon flaticon-settings"></i>
            <span class="m-menu__link-text">Shop</span>
            <i class="m-menu__ver-arrow la la-angle-right"></i>
        </a>
        <div class="m-menu__submenu ">
            <span class="m-menu__arrow"></span>
            <ul class="m-menu__subnav">
                <li class="m-menu__item @if (Request::is('*/shop-categories') || Request::is('*/shop-categories/*')) m-menu__item--active  @else m-menu__item @endif ">
                    <a href="{{ route('seller.shop_categories.index') }}" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-title">
                            <span class="m-menu__link-wrap">
                                <span class="m-menu__link-text">Categories</span>
                            </span>
                        </span>
                    </a>
                </li>
                <li class="m-menu__item ">
                    <a href="{{ route('seller.shop-decorations.index') }}" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-title">
                            <span class="m-menu__link-wrap">
                                <span class="m-menu__link-text">Decoration</span>
                            </span>
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    </ul>
  </div>
                <!-- END: Aside Menu -->
