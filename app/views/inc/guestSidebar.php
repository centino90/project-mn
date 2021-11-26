<!-- This example requires Tailwind CSS v2.0+ -->
<div class="lg:w-64 flex-shrink-0 lg:h-screen sm:rounded-lg sm:rounded-b-none bg-white overflow-hidden border-r mb-8 lg:mb-0">
    <div class="p-4 bg-gradient-to-r from-primary-400 to-primary-600 text-lg font-medium text-white">
        <b>Navigation</b>
    </div>

    <nav>
        <a href="<?php echo URLROOT ?>/" class="flex items-center lg:mt-5 w-full py-3 px-4 lg:px-6 text-secondary-600 border-r-4 border-white hover:bg-secondary-200 hover:text-secondary-700 hover:border-secondary-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="mx-4 font-medium">Home</span>
        </a>
        <a href="<?php echo URLROOT ?>/about/" class="flex items-center lg:mt-5 w-full py-3 px-4 lg:px-6 <?php if ($data['current_route'] == 'index') : ?> bg-secondary-200 text-primary-700 border-r-4 border-primary-700 <?php else : ?> text-secondary-600 border-r-4 border-white hover:bg-secondary-200 hover:text-secondary-700 hover:border-secondary-700 <?php endif; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="mx-4 font-medium">About us</span>
        </a>
        <a href="<?php echo URLROOT ?>/about/privacyPolicy" class="flex items-center lg:mt-5 w-full py-3 px-4 lg:px-6 <?php if ($data['current_route'] == 'privacyPolicy') : ?> bg-secondary-200 text-primary-700 border-r-4 border-primary-700 <?php else : ?> text-secondary-600 border-r-4 border-white hover:bg-secondary-200 hover:text-secondary-700 hover:border-secondary-700 <?php endif; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
            </svg>
            <span class="mx-4 font-medium">Privacy policy</span>
        </a>
        <a href="<?php echo URLROOT ?>/about/termsOfService" class="flex items-center lg:mt-5 w-full py-3 px-4 lg:px-6 <?php if ($data['current_route'] == 'termsOfService') : ?> bg-secondary-200 text-primary-700 border-r-4 border-primary-700 <?php else : ?> text-secondary-600 border-r-4 border-white hover:bg-secondary-200 hover:text-secondary-700 hover:border-secondary-700 <?php endif; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11" />
            </svg>
            <span class="mx-4 font-medium">Terms of service</span>
        </a>
    </nav>
</div>