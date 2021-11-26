<!-- This example requires Tailwind CSS v2.0+ -->
<div class="lg:w-64 flex-shrink-0 lg:h-screen sm:rounded-lg bg-white overflow-hidden border-r border-b mb-8 lg:mb-0">
  <div class="p-4 bg-gradient-to-r from-primary-400 to-primary-600 text-lg font-medium text-white">
    <b>[<?php echo $_SESSION['is_admin'] == true ? 'Admin' : 'Member'; ?>] -</b>
    <?php echo $_SESSION['user_name']; ?>
  </div>

  <nav>
    <?php if ($_SESSION['is_admin']) : ?>
      <a href="<?php echo URLROOT ?>/admins/" class="flex items-center lg:mt-5 w-full py-3 px-4 lg:px-6 <?php if ($data['current_route'] == 'index') : ?> bg-secondary-200 text-primary-700 border-r-4 border-primary-700 <?php else : ?> text-secondary-600 border-r-4 border-white hover:bg-secondary-200 hover:text-secondary-700 hover:border-secondary-700 <?php endif; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
        </svg>
        <span class="mx-4 font-medium">Payment History</span>
      </a>
    <?php endif; ?>

    <?php if (!$_SESSION['is_admin']) : ?>
      <a href="<?php echo URLROOT ?>/members/licenseInfo" class="flex items-center lg:mt-5 w-full py-3 px-4 lg:px-6 <?php if ($data['current_route'] == 'licenseInfo') : ?> bg-secondary-200 text-primary-700 border-r-4 border-primary-700 <?php else : ?> text-secondary-600 border-r-4 border-white hover:bg-secondary-200 hover:text-secondary-700 hover:border-secondary-700 <?php endif; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
        </svg>
        <span class="mx-4 font-medium">License information</span>
      </a>

      <a href="<?php echo URLROOT ?>/members/personalInfo" class="flex items-center lg:mt-5 w-full py-3 px-4 lg:px-6 <?php if ($data['current_route'] == 'personalInfo') : ?> bg-secondary-200 text-primary-700 border-r-4 border-primary-700 <?php else : ?> text-secondary-600 border-r-4 border-white hover:bg-secondary-200 hover:text-secondary-700 hover:border-secondary-700 <?php endif; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
        </svg>
        <span class="mx-4 font-medium">Personal information</span>
      </a>

      <a href="<?php echo URLROOT ?>/members/clinicInfo" class="flex items-center lg:mt-5 py-3 px-4 lg:px-6 <?php if ($data['current_route'] == 'clinicInfo') : ?> bg-secondary-200 text-primary-700 border-r-4 border-primary-700 <?php else : ?> text-secondary-600 border-r-4 border-white hover:bg-secondary-200 hover:text-secondary-700 hover:border-secondary-700 <?php endif; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="mx-4 font-medium">Clinic information</span>
      </a>
    <?php endif; ?>
  </nav>
</div>