<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="mx-auto min-h-full w-full flex items-center justify-center px-4 sm:px-6 lg:px-8" x-data="app()">
  <div class="max-w-lg w-full space-y-16 lg:px-8 lg:py-10">
    <div>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-secondary-900">
        Link to your existing profile or create one
      </h2>
    </div>
    <form method="POST" action="<?php echo URLROOT ?>/users/searchProfileBeforeRegister">
      <div class="flex flex-col gap-y-8">
        <div class="flex flex-col">
          <label for="" class="text-sm font-semibold text-secondary-500 pb-2">PRC number</label>
          <input type="text" name="prc_number" id="prc_number" class="focus:ring-primary-500 focus:border-primary-500 flex-1 block w-full rounded sm:text-sm border-secondary-300" placeholder="Enter your prc no." autocomplete="off">
          <?php if (!empty($data['prc_number_err'])) : ?>
            <div class="text-sm text-danger-500 px-2 pt-2">
              <?php echo $data['prc_number_err']; ?> !
            </div>
          <?php endif ?>
        </div>

        <div class="form-group">
          <input value="Submit to proceed" type="submit" x-ref="submit" class="form-btn bg-primary-500 text-white w-full py-2 px-4">
          </input>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>