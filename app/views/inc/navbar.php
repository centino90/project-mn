<!-- This example requires Tailwind CSS v2.0+ -->
<div class="relative bg-white">
  <div class="container mx-auto px-5">
    <div class="flex justify-between items-center border-b-2 border-gray-100 py-6 md:justify-start md:space-x-10">
      <div class="flex justify-start lg:w-0 lg:flex-1">
        <a href="#">
          <span class="sr-only">Workflow</span>
          <img class="h-12 w-auto sm:h-16" src="<?php echo URLROOT; ?>/img/logo.jpg" alt="Davao Dental logo">
        </a>
      </div>
      <div class="-mr-2 -my-2 md:hidden">
        <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-expanded="false">
          <span class="sr-only">Open menu</span>
          <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>

      <div class="hidden md:flex items-center justify-end md:flex-1 lg:w-0">
        <?php if (isset($_SESSION['user_id'])) : ?>    
          <a href="<?php echo URLROOT; ?>/users/logout" class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-pink-500 hover:bg-pink-600">
            Sign out
          </a>
        <?php else : ?>
          <a href="<?php echo URLROOT; ?>/users/login" class="whitespace-nowrap text-base font-medium text-gray-500 hover:text-gray-900">
            Sign in
          </a>
          <a href="<?php echo URLROOT; ?>/users/register" class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-pink-500 hover:bg-pink-600">
            Sign up
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>