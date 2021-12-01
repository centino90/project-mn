<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="mx-auto min-h-full w-full flex-col items-center justify-center px-4 sm:px-6 lg:px-8" x-data="{affirm: false}">
  <div class="mb-8">
    <h2 class="mt-6 text-center text-3xl font-extrabold text-secondary-900">
      Register additional information
    </h2>
  </div>
  <div class="w-full py-6">
    <!-- Steps -->
    <div class="flex max-w-3xl w-full mx-auto mb-12">
      <div class="step">
        <div class="step-separator">
          <div class="step-icon done">
            <span class="step-icon-content current">
              <svg class="w-full fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path class="heroicon-ui" d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-2.3-8.7l1.3 1.29 3.3-3.3a1 1 0 0 1 1.4 1.42l-4 4a1 1 0 0 1-1.4 0l-2-2a1 1 0 0 1 1.4-1.42z" />
              </svg>
            </span>
          </div>
        </div>

        <div class="step-label">License information</div>
      </div>

      <div class="step">
        <div class="step-separator">
          <div class="step-separator-container">
            <div class="step-separator-outline">
              <div class="step-separator-bg full"></div>
            </div>
          </div>

          <div class="step-icon done">
            <span class="step-icon-content current">
              <svg class="w-full fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path class="heroicon-ui" d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-2.3-8.7l1.3 1.29 3.3-3.3a1 1 0 0 1 1.4 1.42l-4 4a1 1 0 0 1-1.4 0l-2-2a1 1 0 0 1 1.4-1.42z" />
              </svg>
            </span>
          </div>
        </div>

        <div class="step-label">Personal information</div>
      </div>

      <div class="step">
        <div class="step-separator">
          <div class="step-separator-container">
            <div class="step-separator-outline">
              <div class="step-separator-bg full"></div>
            </div>
          </div>

          <div class="step-icon done">
            <span class="step-icon-content current">
              <svg class="w-full fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path class="heroicon-ui" d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-2.3-8.7l1.3 1.29 3.3-3.3a1 1 0 0 1 1.4 1.42l-4 4a1 1 0 0 1-1.4 0l-2-2a1 1 0 0 1 1.4-1.42z" />
              </svg>
            </span>
          </div>
        </div>

        <div class="step-label done">Clinic information</div>
      </div>

      <div class="step">
        <div class="step-separator">
          <div class="step-separator-container">
            <div class="step-separator-outline">
              <div class="step-separator-bg full"></div>
            </div>
          </div>

          <div class="step-icon current">
            <span class="step-icon-content current">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01" />
              </svg>
            </span>
          </div>
        </div>

        <div class="step-label current">Case of emergency</div>
      </div>
    </div>

    <!-- Case of emergency information -->
    <div class="max-w-3xl w-full mx-auto">
      <form action="<?php echo URLROOT; ?>/users/registerEmergencyInfo" method="post" @submit="$el.querySelector('[type=submit]').disabled = true; $el.querySelector('[type=submit]').textContent = 'Please wait...'">
        <header class="flex items-center gap-3 py-5 mb-5 text-xl text-primary-500">
          <span class="font-bold mr-2">Step 4:</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01" />
          </svg>

          In case of emergency
        </header>

        <div class="flex flex-col gap-y-8">
          <!-- Full name -->
          <div x-data="formGroup()" class="form-group">
            <label x-bind="formLabel">
              Full name <span class="text-danger-500">*</span>
            </label>
            <div x-bind="inputContainer">
              <input type="text" value="<?php echo $data['emergency_person_name'] ?>" x-bind="formInput" name="emergency_person_name" autofocus>
              <?php if (!empty($data['emergency_person_name_err'])) : ?>
                <div x-bind="formInputError">
                  <?php echo $data['emergency_person_name_err']; ?> !
                </div>
              <?php endif; ?>
            </div>
          </div>

          <!-- Address -->
          <div x-data="formGroup()" class="form-group">
            <label x-bind="formLabel">
              Address <span class="text-danger-500">*</span>
            </label>
            <div x-bind="inputContainer">
              <input type="text" value="<?php echo $data['emergency_address'] ?>" x-bind="formInput" name="emergency_address">
              <?php if (!empty($data['emergency_address_err'])) : ?>
                <div x-bind="formInputError">
                  <?php echo $data['emergency_address_err']; ?> !
                </div>
              <?php endif; ?>
            </div>
          </div>

          <!-- Contact number -->
          <div x-data="formGroup()" class="form-group">
            <label x-bind="formLabel">
              Contact number <span class="text-danger-500">*</span>
            </label>
            <div x-bind="inputContainer">
              <input type="number" value="<?php echo $data['emergency_contact_number'] ?>" x-bind="formInput" name="emergency_contact_number">
              <?php if (!empty($data['emergency_contact_number_err'])) : ?>
                <div x-bind="formInputError">
                  <?php echo $data['emergency_contact_number_err']; ?> !
                </div>
              <?php endif; ?>
            </div>
          </div>

          <!-- Confirmation -->
          <div x-data="formGroup()" class="form-group">
            <label x-bind="formLabel">
              Confirmation <span class="text-danger-500">*</span>
            </label>
            <div x-bind="inputContainer">
              <div class="flex items-center flex-wrap gap-3 py-3 md:py-0">
                <input type="checkbox" @change="$event.target.checked ? affirm = true : affirm = false" value="<?php echo $data['confirm_policies'] ?>" name="confirm_policies" id="confirm_policies" class="text-primary-600 focus:ring-3 focus:ring-primary-300 h-4 w-4 rounded" required="">
                <div class="text-sm">
                  <label for="confirm_policies" class="font-medium">
                    <span class="font-bold">I affirm</span> to the
                    <a href="<?php echo URLROOT ?>/about/privacyPolicy" target="_blank" class="text-primary-500 font-bold underline hover:text-primary-700">Privacy policy</a> and
                    <a href="<?php echo URLROOT ?>/about/termsOfService" target="_blank" class="text-primary-500 font-bold underline hover:text-primary-700">Terms of service</a>
                    of PDA-DCC
                  </label>
                </div>
              </div>
              <?php if (!empty($data['confirm_policies_err'])) : ?>
                <div x-bind="formInputError">
                  <?php echo $data['confirm_policies_err']; ?> !
                </div>
              <?php endif; ?>
            </div>
          </div>

          <!-- Form submit -->
          <div x-data="formGroup()" class="form-group md:pl-3">
            <label class="form-label">
            </label>
            <div class="input-container-nowrap">
              <a href="<?php echo URLROOT . '/users/registerClinicInfo'; ?>" class="form-btn bg-secondary-500 text-white w-full md:w-80 py-2 px-4 mx-0">
                Go back
              </a>
              <button type="submit" :disabled="!affirm" class="form-btn gap-3 bg-primary-500 text-white w-full md:w-80 py-2 px-4">
                Submit to proceed
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('formGroup', () => ({
      formLabel: {
        [':for']() {
          return this.$el.parentNode.querySelector('input, select, textarea').getAttribute('name')
        },
        [':class']() {
          return 'mb-4 form-label'
        }
      },
      inputContainer: {
        [':class']() {
          return 'input-container'
        }
      },
      formInput: {
        [':id']() {
          return this.$el.getAttribute('name')
        },
        [':class']() {
          return 'form-input'
        }
      },
      formInputError: {
        [':class']() {
          return 'form-input-err'
        }
      }
    }))
  })
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>