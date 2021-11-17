<!-- This example requires Tailwind CSS v2.0+ -->
<div class="lg:w-64 flex-shrink-0 lg:h-screen rounded-lg bg-white overflow-hidden border-r border-b">
  <div class="flex items-center gap-3 px-8 bg-gradient-to-r from-pink-400 to-pink-600 text-lg font-medium text-white py-4">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
      <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
    </svg>
    <?php echo $_SESSION['user_name']; ?>
  </div>

  <nav class="lg:mt-10">
    <a href="<?php echo URLROOT ?>/pages/" class="flex items-center w-full py-2 px-8 <?php if ($data['current_route'] == 'index') : ?> bg-gray-200 text-indigo-700 border-r-4 border-indigo-700 <?php else : ?> text-gray-600 border-r-4 border-white hover:bg-gray-200 hover:text-gray-700 hover:border-gray-700 <?php endif; ?>">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
      </svg>
      <span class="mx-4 font-medium">Payment History</span>
    </a>

    <a href="<?php echo URLROOT ?>/pages/licenseInfo" class="flex items-center lg:mt-5 w-full py-2 px-8 <?php if ($data['current_route'] == 'licenseInfo') : ?> bg-gray-200 text-indigo-700 border-r-4 border-indigo-700 <?php else : ?> text-gray-600 border-r-4 border-white hover:bg-gray-200 hover:text-gray-700 hover:border-gray-700 <?php endif; ?>">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path d="M12 14l9-5-9-5-9 5 9 5z" />
        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
      </svg>

      <span class="mx-4 font-medium">License information</span>
    </a>

    <a href="<?php echo URLROOT ?>/pages/personalInfo" class="flex items-center lg:mt-5 w-full py-2 px-8 <?php if ($data['current_route'] == 'personalInfo') : ?> bg-gray-200 text-indigo-700 border-r-4 border-indigo-700 <?php else : ?> text-gray-600 border-r-4 border-white hover:bg-gray-200 hover:text-gray-700 hover:border-gray-700 <?php endif; ?>">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
      </svg>

      <span class="mx-4 font-medium">Personal information</span>
    </a>

    <a href="<?php echo URLROOT ?>/pages/clinicInfo" class="flex items-center lg:mt-5 py-2 px-8 <?php if ($data['current_route'] == 'clinicInfo') : ?> bg-gray-200 text-indigo-700 border-r-4 border-indigo-700 <?php else : ?> text-gray-600 border-r-4 border-white hover:bg-gray-200 hover:text-gray-700 hover:border-gray-700 <?php endif; ?>">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>

      <span class="mx-4 font-medium">Clinic information</span>
    </a>
  </nav>
</div>