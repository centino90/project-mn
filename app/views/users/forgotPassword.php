<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="mx-auto min-h-full w-full flex items-center justify-center px-4 sm:px-6 lg:px-8" x-data>
  <div class="max-w-lg w-full space-y-8 lg:px-8 lg:py-10">
    <div>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-secondary-900">
        Password Reset
      </h2>
    </div>
    <form class="mt-8 space-y-6" action="<?php echo URLROOT; ?>/users/forgotPassword" method="post" @submit="$refs.submit.disabled = true; $refs.submit.value = 'Please wait...'">
      <!-- <div class="text-black text-center">
        <?php flash('login_status'); ?>
      </div> -->

      <div class="flex flex-col gap-y-5">
        <!-- email -->
        <div class="rounded-md">
          <div class="flex">
            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-secondary-300 bg-secondary-50 text-secondary-500 text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
              </svg>
            </span>
            <input type="email" name="email" value="<?php echo $data['email'] ?>" id="email" class="focus:ring-primary-500 focus:border-primary-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-secondary-300" placeholder="Enter email" autocomplete="username">
          </div>
          <?php if (!empty($data['email_err'])) : ?>
            <div class="text-sm text-danger-500 px-2 pt-2">
              <?php echo $data['email_err']; ?> !
            </div>
          <?php endif; ?>
        </div>

        <div class="g-recaptcha" id="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITEKEY ?>" data-callback="verifyCheckState"></div>
        <?php if (!empty($data['g_recaptcha_response_err'])) : ?>
          <div class="text-sm text-danger-500 px-2 pt-2">
            <?php echo $data['g_recaptcha_response_err']; ?> !
          </div>
        <?php endif; ?>

        <!-- Form submit -->
        <div class="my-4">
          <input disabled type="submit" value="Submit request" x-ref="submit" class="form-btn bg-primary-500 text-white w-full py-2 px-4">
          </input>
        </div>

        <div class="text-sm text-center">
          <a href="<?php echo URLROOT; ?>/users/login" class="font-medium hover:text-primary-500 hover:underline">
            Already have an account? <span class="text-primary-600">Sign in</span>
          </a>
        </div>

        <div class="text-sm text-center">
          <a href="<?php echo URLROOT; ?>/users/register" class="font-medium hover:text-primary-500 hover:underline">
            Don't have an account? <span class="text-primary-600">Sign up</span>
          </a>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  let isCaptchaChecked = false

  function verifyCheckState() {
    isCaptchaChecked = !isCaptchaChecked
    if (isCaptchaChecked) {
      document.querySelector('[type="submit"]').disabled = false
    }
  }
</script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<?php require APPROOT . '/views/inc/footer.php'; ?>