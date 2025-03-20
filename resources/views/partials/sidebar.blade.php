      <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

          <!-- Sidebar - Brand -->
          <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
              <div class="sidebar-brand-icon rotate-n-15">
                  {{-- <i class="fas fa-laugh-wink"></i> --}}
                  <img src="{{ asset('assets/icons/eLogic-icon-2.svg') }}" alt="Home Icon" width="30" height="30">
              </div>
              <div class="sidebar-brand-text mx-3">Energy Logic</div>
          </a>

          <!-- Divider -->
          <hr class="sidebar-divider my-0">

          <!-- Nav Item - Dashboard -->
          <li class="nav-item active">
              <a class="nav-link" href="/">
                  <i class="fas fa-fw fa-tachometer-alt"></i>
                  <span>Dashboard</span></a>
          </li>

          <!-- Divider -->
          <hr class="sidebar-divider">

          <!-- Heading -->
          <div class="sidebar-heading">
              Interface
          </div>

          <!-- Nav Item - Appliances -->
          <li class="nav-item">
            <a class="nav-link" href="{{ route('appliances.index') }}">
                <i class="fas fa-fw fa-microchip"></i>
                <span>Appliances</span></a>
          </li>

          <!-- Nav Item - Cost Analysis -->
          <li class="nav-item">
            <a class="nav-link" href="/costa">
                <i class="fas fa-fw fa-chart-line"></i>
                <span>Cost Analysis</span></a>
          </li>

          <!-- Divider -->
          <hr class="sidebar-divider">

          <!-- Heading -->
          <div class="sidebar-heading">
              Utilities
          </div>
            <!-- Nav Item - Charts -->
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fas fa-bell fa-fw"></i>
              <span>Notifications</span></a>
          </li>
          <hr class="sidebar-divider d-none d-md-block">

          <!-- Sidebar Toggler (Sidebar) -->
          <div class="text-center d-none d-md-inline">
              <button class="rounded-circle border-0" id="sidebarToggle"></button>
          </div>
      </ul>
      <!-- End of Sidebar -->