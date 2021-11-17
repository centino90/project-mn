<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="mx-auto min-h-full w-full flex items-center justify-center px-4 sm:px-6 lg:px-8">
  <div class="max-w-md w-full space-y-8">
    <div>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
        Sign in with your account
      </h2>
    </div>
    <form class="mt-8 space-y-6" action="<?php echo URLROOT; ?>/users/login" method="post">
      <div class="text-black text-center">
        <?php flash('register_success'); ?>
      </div>

      <div>
        <div class="relative rounded-md">
          <input type="email" name="email" id="email" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Email address">
          <?php if (!empty($data['email_err'])) : ?>
            <div class="text-sm text-red-500 px-2 pt-2">
              <?php echo $data['email_err']; ?> !
            </div>
          <?php endif; ?>
        </div>

        <div class="mt-5 relative rounded-md">
          <input type="password" name="password" id="password" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Password">
          <?php if (!empty($data['password_err'])) : ?>
            <div class="text-sm text-red-500 px-2 pt-2">
              <?php echo $data['password_err']; ?> !
            </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="flex items-center justify-end">
        <div class="text-sm">
          <a href="<?php echo URLROOT; ?>/users/register" class="font-medium text-indigo-600 hover:text-indigo-500">
            Not registered yet?
          </a>
        </div>
      </div>

      <div>
        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-white font-bold rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Sign in
        </button>
      </div>
    </form>

    <div class="flex justify-evenly space-x-2 mt-4">
      <span class="bg-gray-300 h-px flex-grow t-2 relative top-2"></span>
      <span class="flex-none uppercase text-xs text-gray-500 font-semibold">Or continue with</span>
      <span class="bg-gray-300 h-px flex-grow t-2 relative top-2"></span>
    </div>

    <div>
      <div>
        <a href="<?php echo getFacebookLoginUrl(); ?>" class="block text-center w-full bg-blue-800 hover:bg-blue-900 rounded-md text-white font-bold py-2 px-4 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Facebook
        </a>
      </div>

      <div>
        <a href="<?php echo getGoogleLoginUrl(); ?>" class="mt-2 block text-center w-full bg-red-700 hover:bg-red-800 rounded-md text-white font-bold py-2 px-4 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Google
        </a>
      </div>
    </div>
  </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>