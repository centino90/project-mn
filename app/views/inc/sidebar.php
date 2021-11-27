<div class="sidebar">
  <nav class="sidebar-nav">
    <a href="<?php echo URLROOT ?>" class="sidebar-nav-item">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
      </svg>
      <span class="mx-4 font-medium">Home</span>
    </a>

    <!-- <?php if ($_SESSION['is_admin']) : ?>
      <a href="<?php echo URLROOT ?>/admins/" class="sidebar-nav-item <?php if ($data['current_route'] == 'index') : ?> active <?php endif; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
        </svg>
        <span class="mx-4 font-medium">Payment History</span>
      </a>
    <?php endif; ?>

    <?php if (!$_SESSION['is_admin']) : ?>
      <a href="<?php echo URLROOT ?>/members/licenseInfo" class="sidebar-nav-item <?php if ($data['current_route'] == 'licenseInfo') : ?> active <?php endif; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
        </svg>
        <span class="mx-4 font-medium">License information</span>
      </a>

      <a href="<?php echo URLROOT ?>/members/personalInfo" class="sidebar-nav-item <?php if ($data['current_route'] == 'personalInfo') : ?> active <?php endif; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
        </svg>
        <span class="mx-4 font-medium">Personal information</span>
      </a>

      <a href="<?php echo URLROOT ?>/members/clinicInfo" class="flex items-center lg:mt-5 py-3 px-4 lg:px-6 <?php if ($data['current_route'] == 'clinicInfo') : ?> active <?php endif; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="mx-4 font-medium">Clinic information</span>
      </a>
    <?php endif; ?> -->
  </nav>
</div>