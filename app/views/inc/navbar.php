<!-- This example requires Tailwind CSS v2.0+ -->
<div class="bg-white">
  <div class="container mx-auto px-5">
    <div class="flex flex-wrap justify-between items-center border-b border-secondary-100 py-6 md:justify-start md:space-x-10">
      <div class="flex justify-start md:w-0 md:flex-1">
        <a href="<?php echo URLROOT; ?>/" class="font-semibold text-secondary-400">
          <img class="h-12 w-auto mx-auto sm:h-16" src="<?php echo URLROOT; ?>/img/PDO-DCC.jpg" alt="PDO-DCC logo">
          <?php echo SITENAME ?>
        </a>
      </div>

      <ul class="flex items-center justify-end">
        <?php if (isset($_SESSION['user_id'])) : ?>
          <a href="<?php echo URLROOT; ?>/users/logout" class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary-400 hover:bg-primary-500">
            Sign out
          </a>
        <?php else : ?>
          <a href="<?php echo URLROOT; ?>/users/login" class="whitespace-nowrap text-base font-medium text-secondary-500 hover:text-secondary-900">
            Sign in
          </a>
          <a href="<?php echo URLROOT; ?>/users/register" class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary-400 hover:bg-primary-500">
            Sign up
          </a>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</div>