<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="mx-auto min-h-full w-full flex items-center justify-center px-4 sm:px-6 lg:px-8" x-data>
  <div class="max-w-lg w-full space-y-8 lg:px-8 lg:py-10">
    <div>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-secondary-900">
        Sign in with your account
      </h2>
    </div>
    <form class="mt-8 space-y-6" action="<?php echo URLROOT; ?>/users/login" method="post" @submit="$refs.submit.disabled = true; $refs.submit.value = 'Please wait...'">
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

        <!-- forgot password -->
        <div class="flex items-center">
          <div class="text-sm">
            <a href="<?php echo URLROOT; ?>/users/forgotPassword" class="font-medium text-primary-600 hover:text-primary-500 hover:underline">
              Forgot password?
            </a>
          </div>
        </div>

        <!-- Form submit -->
        <div class="mt-4">
          <input type="submit" x-ref="submit" value="Sign in" class="form-btn bg-primary-500 text-white w-full py-2 px-4">
          </input>
        </div>
      </div>
    </form>

    <div class="flex justify-evenly space-x-2 mt-4">
      <span class="bg-secondary-300 h-px flex-grow t-2 relative top-2"></span>
      <span class="flex-none uppercase text-xs text-secondary-500 font-semibold">Or continue with</span>
      <span class="bg-secondary-300 h-px flex-grow t-2 relative top-2"></span>
    </div>

    <div>
      <div>
        <a href="<?php echo getFacebookLoginUrl(); ?>" class="block text-center w-full bg-blue-700 hover:bg-blue-900 rounded-md text-white font-bold py-2 px-4 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
          Facebook
        </a>
      </div>

      <div>
        <a href="<?php echo getGoogleLoginUrl(); ?>" class="mt-4 block text-center w-full bg-danger-700 hover:bg-danger-800 rounded-md text-white font-bold py-2 px-4 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
          Google
        </a>
      </div>
    </div>

    <div class="text-sm text-center">
      <a href="<?php echo URLROOT; ?>/users/register" class="font-medium hover:text-primary-500 hover:underline">
        Don't have an account? <span class="text-primary-600">Sign up</span>
      </a>
    </div>
  </div>
</div>

<script>
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>