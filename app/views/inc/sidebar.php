<div class="sidebar">
  <div class="sidebar-header">
    [<?php echo $_SESSION['role']; ?>]
    <?php echo $_SESSION['user_name']; ?>
  </div>

  <nav class="sidebar-nav">
    <a href="<?php echo URLROOT ?>/profiles/userInfo" class="sidebar-nav-item <?php if ($data['current_route'] == 'userInfo') : ?>active <?php endif; ?>">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
      </svg>
      <span class="sidebar-nav-item-label">User profile</span>
    </a>

    <?php if (isAdmin() || isSuperAdmin()) : ?>
      <a href="<?php echo URLROOT ?>/admins/accounts" class="sidebar-nav-item <?php if (in_array($data['current_route'], ['accounts', 'viewAccount'])) : ?> active <?php endif; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        <span class="mx-4 font-medium">Accounts</span>
      </a>

      <!-- <a href="<?php echo URLROOT ?>/admins/memberList" class="sidebar-nav-item <?php if ($data['current_route'] == 'memberList') : ?> active <?php endif; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <span class="mx-4 font-medium">List of members</span>
      </a> -->

      <a href="<?php echo URLROOT ?>/admins/report" class="sidebar-nav-item <?php if ($data['current_route'] == 'report') : ?> active <?php endif; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <span class="mx-4 font-medium">Report</span>
      </a>
    <?php endif; ?>

    <?php if (isSuperAdmin()) : ?>
      <a href="<?php echo URLROOT ?>/admins/activities" class="sidebar-nav-item <?php if ($data['current_route'] == 'activities') : ?> active <?php endif; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        <span class="mx-4 font-medium">Activity log</span>
      </a>
    <?php endif; ?>

    <?php if (!isSuperAdmin()) : ?>
      <a href="<?php echo URLROOT ?>/profiles/paymentHistory" class="sidebar-nav-item <?php if ($data['current_route'] == 'paymentHistory') : ?> active <?php endif; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
        </svg>
        <span class="mx-4 font-medium">My payment history</span>
      </a>

      <a href="<?php echo URLROOT ?>/profiles/personalInfo" class="sidebar-nav-item <?php if ($data['current_route'] == 'personalInfo') : ?> active <?php endif ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
        </svg>
        <span class="sidebar-nav-item-label">Personal information</span>
      </a>

      <a href="<?php echo URLROOT ?>/profiles/licenseInfo" class="sidebar-nav-item <?php if ($data['current_route'] == 'licenseInfo') : ?> active <?php endif ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
        </svg>
        <span class="sidebar-nav-item-label">License information</span>
      </a>

      <a href="<?php echo URLROOT ?>/profiles/clinicInfo" class="sidebar-nav-item <?php if ($data['current_route'] == 'clinicInfo') : ?> active <?php endif ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="sidebar-nav-item-label">Clinic information</span>
      </a>

      <a href="<?php echo URLROOT ?>/profiles/emergencyInfo" class="sidebar-nav-item <?php if ($data['current_route'] == 'emergencyInfo') : ?> active <?php endif ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01" />
        </svg>
        <span class="sidebar-nav-item-label">Emergency information</span>
      </a>

    <?php endif ?>
  </nav>
</div>