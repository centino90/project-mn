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
        <div class="rounded-md">
          <input type="email" name="email" value="<?php echo $data['email'] ?>" id="email" class="focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-secondary-300 rounded-md" placeholder="Email" autocomplete="username">
          <?php if (!empty($data['email_err'])) : ?>
            <div class="text-sm text-danger-500 px-2 pt-2">
              <?php echo $data['email_err']; ?> !
            </div>
          <?php endif; ?>
        </div>

        <!-- Form submit -->
        <div class="my-4">
          <input type="submit" value="Submit request" x-ref="submit" class="form-btn bg-primary-500 text-white w-full py-2 px-4">
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
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>