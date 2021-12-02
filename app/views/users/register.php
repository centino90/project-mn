<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="mx-auto min-h-full w-full flex items-center justify-center px-4 sm:px-6 lg:px-8" x-data>
  <div class="max-w-lg w-full space-y-8 lg:px-8 lg:py-10">
    <div>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-secondary-900">
        Sign up an account
      </h2>
    </div>
    <form class="mt-8" action="<?php echo URLROOT; ?>/users/register" method="post" @submit="$refs.submit.disabled = true; $refs.submit.value = 'Please wait...'">
      <div class="text-black text-center">
        <?php flash('register_success'); ?>
      </div>

      <div class="flex flex-col gap-y-5">
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

        <div class="rounded-md">
          <div class="flex">
            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-secondary-300 bg-secondary-50 text-secondary-500 text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
              </svg>
            </span>
            <input type="password" name="password" id="password" class="focus:ring-primary-500 focus:border-primary-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-secondary-300" placeholder="Enter password" autocomplete="current-password">
          </div>
          <?php if (!empty($data['password_err'])) : ?>
            <div class="text-sm text-danger-500 px-2 pt-2">
              <?php echo $data['password_err']; ?> !
            </div>
          <?php endif; ?>
        </div>

        <div class="rounded-md w-full">
          <div class="flex">
            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-secondary-300 bg-secondary-100 text-blue-500 text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
              </svg>
            </span>
            <input type="password" name="confirm_password" id="confirm_password" class="focus:ring-primary-500 focus:border-primary-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-secondary-300" placeholder="Confirm password" autocomplete="current-password">
          </div>
          <?php if (!empty($data['confirm_password_err'])) : ?>
            <div class="text-sm text-danger-500 px-2 pt-2">
              <?php echo $data['confirm_password_err']; ?> !
            </div>
          <?php endif; ?>
        </div>

        <!-- forgot password -->
        <div class="flex items-center">
          <div class="text-sm">
            <a href="<?php echo URLROOT; ?>/users/forgotPassword" class="font-medium text-primary-600 hover:text-primary-500 hover:underline">
              Forgot password?
            </a>
          </div>
        </div>

        <!-- Form submit -->
        <div class="my-4">
          <input type="submit" x-ref="submit" value="Sign up" class="form-btn bg-primary-500 text-white w-full py-2 px-4">
          </input>
        </div>

        <div class="text-sm text-center">
          <a href="<?php echo URLROOT; ?>/users/login" class="font-medium hover:text-primary-500 hover:underline">
            Already have an account? <span class="text-primary-600">Sign in</span>
          </a>
        </div>

        <div class="text-sm text-center">
          <a href="<?php echo URLROOT; ?>/users/login" class="font-medium hover:text-primary-500 hover:underline">
            Already have an account? <span class="text-primary-600">Sign in</span>
          </a>
        </div>        
      </div>
    </form>
  </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>