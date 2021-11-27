<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="flex flex-col w-full mx-auto">
    <div class="min-w-full px-4 lg:px-1">

        <div class="mb-4">
            <nav class="text-black" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex text-sm text-secondary-500">
                    <li class="flex items-center">
                        <span aria-current="page">
                            Home
                        </span>
                    </li>
                </ol>
            </nav>
        </div>

        <form action="<?php echo URLROOT; ?>/profiles/userInfo" method="POST">
            <!-- <div class="text-black text-center">
        <?php flash('update_success'); ?>
      </div> -->

            <header class="flex flex-wrap items-center justify-between gap-3">
                <div class="w-64 flex-shrink-0">
                    <span class="text-2xl font-bold">Homepage</span>
                </div>
                <!-- <div>
                    <button type="button" class="flex text-blue-600 p-2 rounded-md hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500" @click="onEditMode = !onEditMode" x-show="!onEditMode">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <?php if ($data['has_password']) : ?>
                            Change password
                        <?php else : ?>
                            Create password
                        <?php endif; ?>
                    </button>
                    <button type="button" class="flex text-blue-600 p-2 rounded-md hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500" @click="onEditMode = !onEditMode" x-show="onEditMode">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Disable editing
                    </button>
                </div> -->
            </header>

            <div class="flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" data-name="Layer 1" width="400" height="400.12089" viewBox="0 0 752 613.12089">
                    <title>preservation</title>
                    <path d="M936.06709,644.81582c13.15168,46.82-113.43889,153.7908-336.16167,94.07509-179.32334-48.07958-336.16167-68.44335-336.16167-94.07509s150.50471,1.25433,336.16167,1.25433S929.13548,620.13917,936.06709,644.81582Z" transform="translate(-224 -143.43955)" fill="#3f3d56" />
                    <path d="M936.06709,644.81582c13.15168,46.82-113.43889,153.7908-336.16167,94.07509-179.32334-48.07958-336.16167-68.44335-336.16167-94.07509s150.50471,1.25433,336.16167,1.25433S929.13548,620.13917,936.06709,644.81582Z" transform="translate(-224 -143.43955)" opacity="0.1" />
                    <path d="M936.06709,644.81582c13.15168,46.82-113.43889,106.12609-336.16167,46.41038-179.32334-48.07959-336.16167-20.77864-336.16167-46.41038s150.50471-46.41038,336.16167-46.41038S929.13548,620.13917,936.06709,644.81582Z" transform="translate(-224 -143.43955)" fill="#3f3d56" />
                    <ellipse cx="484" cy="526" rx="26" ry="9" opacity="0.1" />
                    <ellipse cx="590" cy="526" rx="26" ry="9" opacity="0.1" />
                    <ellipse cx="376" cy="486" rx="85" ry="23" opacity="0.1" />
                    <path d="M976,559.43955v-416H224v416H571v55.60938c-17.33118,2.07513-29,5.9497-29,10.39062,0,6.62738,25.96747,12,58,12s58-5.37262,58-12c0-4.44092-11.66882-8.31549-29-10.39062V559.43955Z" transform="translate(-224 -143.43955)" fill="#3f3d56" />
                    <rect x="39" y="14.57447" width="674" height="372.85106" fill="#f2f2f2" />
                    <path d="M937,158.43955s-280,29-331,141-343,231-343,231H937Z" transform="translate(-224 -143.43955)" opacity="0.1" />
                    <path d="M811.24609,336.43955V364.088H707.75391V338.13h-3V669.43955h3v-59.3125H811.24609v59.3125h3v-333Zm0,30.64844v45.60742H707.75391V367.088ZM707.75391,509.91123V464.30381H811.24609v45.60742Zm103.49218,3v45.60742H707.75391V512.91123ZM707.75391,461.30381v-45.6084H811.24609v45.6084Zm0,145.82324v-45.6084H811.24609v45.6084Z" transform="translate(-224 -143.43955)" fill="#2f2e41" />
                    <path d="M675.121,343.02285V347.167s-2.96013,1.18405-2.96013,5.92026-2.36811,22.497-2.36811,22.497,4.14419,3.55216,7.69634,2.36811a14.4625,14.4625,0,0,0,5.32824-2.96014l.592-18.35281-2.36811-4.73621v-8.28837Z" transform="translate(-224 -143.43955)" fill="#d946ef" />
                    <path d="M788.37816,178.43955s-10.29611,1.18406-10.29611,5.92026-8.23688,22.497-8.23688,22.497,14.41455,3.55216,26.76988,2.36811,18.533-2.96013,18.533-2.96013l2.05922-18.35282-8.23689-4.73621Z" transform="translate(-224 -143.43955)" fill="#d946ef" />
                    <path d="M789.382,219.88139v-11.2485s-12.43255-24.8651-2.3681-24.8651,11.2485,22.497,11.2485,22.497v15.9847Z" transform="translate(-224 -143.43955)" fill="#ffb8b8" />
                    <path d="M682.81731,337.69461s-6.51229-3.55216-7.69634,0-4.73621,11.2485,0,11.84053,9.47242-3.55216,9.47242-3.55216Z" transform="translate(-224 -143.43955)" fill="#ffb8b8" />
                    <path d="M714.86866,361.67553s-3.56489,4.70807,1.60728,50.64,2.19194,79.37638,12.01076,78.918c0,0-2.56277,9.95987,5.78073,10.32728s12.15522.94639,12.80473-1.35475,1.66643-12.94579-.59946-12.84c0,0,.141,3.02118,1.08744-9.13405s-1.73353-69.55756,1.69032-77.28681l13.3894,27.38168s.59946,12.84,3.14744,18.77656,7.94651,40.50377,7.94651,40.50377l-.50846,5.32232s18.2681,2.17488,18.88234-.88156.40268-7.5882-.42314-9.06352-.82582-1.47533.54372-4.567a9.15592,9.15592,0,0,0,.40267-7.5882c-.86108-2.23062-3.15312-51.32472-3.15312-51.32472s-4.29631-59.59769-13.50088-62.19572S714.86866,361.67553,714.86866,361.67553Z" transform="translate(-224 -143.43955)" fill="#2f2e41" />
                    <path d="M730.96415,495.65943l-5.54867,10.85621s-9.59986-2.95805-7.30611,5.63968A151.09772,151.09772,0,0,0,745.66,510.4906s3.847,1.33428,4.4965-.96687-2.36428-10.10831-4.63016-10.00252S730.96415,495.65943,730.96415,495.65943Z" transform="translate(-224 -143.43955)" fill="#2f2e41" />
                    <path d="M774.63015,490.593s-5.40763,13.87739-3.10649,14.5269,22.83513,2.7186,24.381,3.40337,9.13405,1.08744,9.67777-3.47959-4.05857-5.866-4.05857-5.866-8.37875-1.1227-10.99726-8.56985S774.63015,490.593,774.63015,490.593Z" transform="translate(-224 -143.43955)" fill="#2f2e41" />
                    <circle cx="499.35674" cy="89.8249" r="15.81446" fill="#ffb8b8" />
                    <path d="M715.03334,240.75551s4.1617,21.64084,2.497,25.80254,23.30552-1.66468,23.30552-1.66468-4.994-21.64084-4.1617-26.63488S715.03334,240.75551,715.03334,240.75551Z" transform="translate(-224 -143.43955)" fill="#ffb8b8" />
                    <path d="M722.87639,213.73132a8.93863,8.93863,0,0,0-3.956.17466,10.315,10.315,0,0,0-2.81141,1.84424,32.90553,32.90553,0,0,1-4.8069,3.18472,11.216,11.216,0,0,0-3.74013,2.62176,7.95819,7.95819,0,0,0-1.05562,1.99817,23.944,23.944,0,0,0-1.25892,13.03151,5.99,5.99,0,0,0,.55443,1.78939c.86508,1.59385,2.77576,2.222,4.3853,3.05749,3.05585,1.5863,5.37231,4.25741,7.8787,6.61805a15.4025,15.4025,0,0,0,3.11291,2.399c3.57571,1.94956,7.9463,1.31355,11.96019.62417a2.15543,2.15543,0,0,0,2.15117-2.176l3.16829-14.25008a23.24887,23.24887,0,0,0,.812-6.48089c-.221-3.45921-2.0938-8.251-4.63253-10.70821C731.67982,214.59626,726.743,214.14067,722.87639,213.73132Z" transform="translate(-224 -143.43955)" fill="#2f2e41" />
                    <path d="M711.23457,267.83551s1.18405-8.28836,8.28837-8.88039a58.57015,58.57015,0,0,0,11.84052-2.3681c.592,0,8.28837.592,11.84053,4.14418,0,0,2.3681,3.55216,3.55215,1.18405s1.18406-3.55216,3.55216-2.3681,2.36811-3.55216,6.51229-2.96013,14.80066,27.2332,14.80066,27.2332l-3.55216,4.14419s-4.73621,31.96941,3.55216,45.586,11.84052,28.41726,3.55215,31.37739-66.30694,29.60131-63.93883,13.02458.592-42.62589-1.77608-43.21792-15.39268-47.3621-15.39268-47.3621a18.38855,18.38855,0,0,1,10.65647-13.6166C714.1947,269.61159,711.23457,267.83551,711.23457,267.83551Z" transform="translate(-224 -143.43955)" fill="#575a88" />
                    <path d="M753.86046,258.95512l2.96013-2.3681s5.32824,0,5.92026-1.18406,3.55216-1.18405,5.92027-2.3681-.592-2.96013,2.3681-4.14418,2.96013,0,2.96013-2.96014,7.69634-5.92026,8.28837-9.47242S788.79,216.32923,788.79,216.32923l11.2485,3.55216-2.96014,21.31294s0,10.65648-5.32823,17.76079-17.16876,24.8651-23.089,25.45713S753.86046,258.95512,753.86046,258.95512Z" transform="translate(-224 -143.43955)" fill="#575a88" />
                    <path d="M697.618,284.41225l-3.55216,2.96013s-1.18405,13.02458-1.18405,13.6166,1.18405,7.69635,0,8.28837-3.55216,12.43255-2.96013,13.02458h0V324.078l-8.28837,13.02457v12.43256l19.53686-12.43256s11.2485-1.18405,9.47242-11.24849S697.618,284.41225,697.618,284.41225Z" transform="translate(-224 -143.43955)" fill="#575a88" />
                    <circle cx="376" cy="405" r="11" fill="#d946ef" />
                </svg>

                <h1 class="text-2xl flex gap-3 items-end my-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    This page is still in development.
                </h1>
                <p class="text-secondary-500">You can instead move <a href="<?php echo URLROOT ?>/profiles" class="text-primary-500 font-semibold underline">here</a> to see other parts of the application.</p>
            </div>
        </form>
    </div>
</div>

<script>
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>