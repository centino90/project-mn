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
        <form action="<?php echo URLROOT ?>/users/handleUserRegistration" method="post" @submit="$refs.label.textContent = 'Please wait...'; $refs.submit.disabled = true;">
          <input type="hidden" name="email_confirmation_type" value="<?php echo $data['email_confirmation_type'] ?>">
          <input type="hidden" name="vkeyType" value="<?php echo $data['vkeyType'] ?>">
          <input type="hidden" name="id_type" value="<?php echo $data['id_type'] ?>">
          <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
          <input type="hidden" name="receiver_email" value="<?php echo $data['receiver_email'] ?>">

          <button type="submit" x-ref="submit" class="disabled:opacity-50 disabled:pointer-events-none flex gap-3 items-center text-2xl rounded-lg border border-primary-500 py-3 px-5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <span x-ref="label">Resend email confirmation</span>
          </button>
        </form>

        <?php if (isset($data['cancellable']) && $data['cancellable']) : ?>
          <form action="<?php echo URLROOT ?>/users/abortRegistration" method="post"@submit.prevent="if (confirm('Abort your registration?')){$refs.label_abort.textContent = 'Please wait...'; $el.submit()}">
            <input type="email" name="email" hidden value="<?php echo $data['receiver_email'] ?>">

            <button type="submit" x-ref="submit_abort" class="disabled:opacity-50 disabled:pointer-events-none flex gap-3 items-center text-2xl rounded-lg border border-primary-500 py-3 px-5">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
              <span x-ref="label_abort">Abort registration</span>
            </button>
          </form>
        <?php endif; ?>

      <?php elseif (isset($data['reason']) && $data['reason'] == 'passwordReset') : ?>
        <form action="<?php echo URLROOT ?>/users/forgotPassword" method="post" @submit="$refs.label_new_password.textContent = 'Please wait...'; $refs.submit_new_password.disabled = true;">
          <input type="email" name="email" hidden value="<?php echo $data['email'] ?>">

          <button type="submit" x-ref="submit_new_password" class="disabled:opacity-50 disabled:pointer-events-none flex gap-3 items-center text-2xl rounded-lg border border-primary-500 py-3 px-5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <span x-ref="label_new_password">Resend new password</span>
          </button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>