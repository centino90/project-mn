<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="mx-auto min-h-full w-full flex items-center justify-center px-4 sm:px-6 lg:px-8" x-data>
  <div class=" w-full space-y-8 lg:px-8 lg:py-10">
    <div>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-secondary-900">
        <?php echo $data['message'] ?>
      </h2>

      <?php if (isset($data['note'])) : ?>
        <p class="text-center">
          <?php echo $data['note'] ?>
        </p>
      <?php endif; ?>
    </div>

    <div class="flex flex-col lg:flex-row justify-center items-center gap-3">
      <a href="<?php echo URLROOT ?>/users/login" class="text-2xl form-btn bg-primary-500 text-white py-3 px-5">Go back to Homepage</a>
      <?php if (isset($data['reason']) && $data['reason'] == 'unverifiedEmail') : ?>
        <a href="<?php echo URLROOT ?>/users/handleUserRegistration" class="flex gap-3 items-center text-2xl rounded-lg border border-primary-500 py-3 px-5">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
          </svg>
          Resend email confirmation
        </a>
      <?php elseif (isset($data['reason']) && $data['reason'] == 'passwordReset') : ?>
        <a href="<?php echo URLROOT ?>/users/handlePasswordReset" @click="$refs.label.textContent = 'Please wait...'; window.location.href=$el.getAttribute('href'); $el.classList.add('pointer-events-none', 'opacity-50' , 'cursor-wait');" class="flex gap-3 items-center text-2xl rounded-lg border border-primary-500 py-3 px-5">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
          </svg>
          <span x-ref="label">Resend new password</span>
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>