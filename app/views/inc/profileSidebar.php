<div class="sidebar">
    <div class="sidebar-header">
        <?php echo $_SESSION['user_name']; ?>
    </div>

    <nav class="sidebar-nav">
        <a href="<?php echo URLROOT ?>/profiles/userInfo" class="sidebar-nav-item <?php if ($data['current_route'] == 'userInfo') : ?>active <?php endif; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
            </svg>
            <span class="sidebar-nav-item-label">User profile</span>
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
    </nav>
</div>