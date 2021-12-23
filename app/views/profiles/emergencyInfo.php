<?php require APPROOT . '/views/inc/header.php'; ?>

<!-- sidebar -->
<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="flex flex-col w-full" x-data="app()">
  <div class="min-w-full px-4 lg:px-1">
    <form action="<?php echo URLROOT; ?>/profiles/emergencyInfo" method="POST" @submit.prevent="if (confirm('Confirm the changes of your emergency information?')){ $refs.submit.disabled = true; $refs.submit.value = 'Please wait...'; $el.closest('form').submit()}">
      <div class="mb-4">
        <nav class="text-black" aria-label="Breadcrumb">
          <ol class="list-none p-0 inline-flex text-sm text-secondary-500">
            <li class="flex items-center">
              <button type="button" @click="window.location.href='<?php echo URLROOT; ?>'" class="flex items-center text-blue-600 p-2 pl-0 rounded-md hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
                Home
              </button>

              <span class="separator">
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" stroke="currentColor">
                  <path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
                </svg>
              </span>
            </li>
            <li class="flex items-center">
              <span aria-current="page">
                Emergency information
              </span>
            </li>
          </ol>
        </nav>
      </div>

      <header class="flex flex-wrap items-center justify-between gap-3 mb-10">
        <div class="flex-shrink-0">
          <span class="text-2xl font-bold">Emergency information</span>
        </div>
        <div>
          <button type="button" class="flex text-blue-600 p-2 rounded-md hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500" @click="onEditMode = !onEditMode" x-show="!onEditMode">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Enable editing
          </button>
          <button type="button" class="flex text-blue-600 p-2 rounded-md hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500" @click="onEditMode = !onEditMode" x-show="onEditMode">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            Disable editing
          </button>
        </div>
      </header>

      <div class="flex flex-col gap-y-8">
        <!--  Person's name -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            Person's name
          </label>
          <div x-bind="formGroup.inputContainer">
            <input type="text" value="<?php echo $data['emergency_person_name'] ?>" x-bind="formGroup.formInput" name="emergency_person_name">
            <?php if (!empty($data['emergency_person_name_err'])) : ?>
              <div x-bind="formGroup.formInputError">
                <?php echo $data['emergency_person_name_err']; ?> !
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Address -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            Address
          </label>
          <div x-bind="formGroup.inputContainer">
            <input type="text" value="<?php echo $data['emergency_address'] ?>" x-bind="formGroup.formInput" name="emergency_address">
            <?php if (!empty($data['emergency_address_err'])) : ?>
              <div x-bind="formGroup.formInputError">
                <?php echo $data['emergency_address_err']; ?> !
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Contact number -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            Contact number
          </label>
          <div x-bind="formGroup.inputContainer">
            <input type="number" value="<?php echo $data['emergency_contact_number'] ?>" x-bind="formGroup.formInput" name="emergency_contact_number">
            <?php if (!empty($data['emergency_contact_number_err'])) : ?>
              <div x-bind="formGroup.formInputError">
                <?php echo $data['emergency_contact_number_err']; ?> !
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Form submit -->
        <div x-bind="formGroup" x-show="onEditMode">
          <label x-bind="formGroup.formLabel"></label>
          <div x-bind="formGroup.inputContainer">
            <input type="submit" value="Update" x-ref="submit" class="form-btn bg-primary-500 text-white w-full md:w-80 py-2 px-4">
            </input>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('app', () => ({
      init() {
        if (this.checkServerValidationError()) {
          this.onEditMode = true
        } else {
          this.onEditMode = false
        }
      },
      onEditMode: false,
      serverData: <?php echo json_encode($data); ?>,
      formGroup: {
        [':class']() {
          let defaultClass = 'form-group'

          return this.onEditMode ? `${defaultClass} border-0` : `${defaultClass} border-b`
        },
        inputContainer: {
          [':class']() {
            return 'input-container'
          }
        },
        formLabel: {
          [':for']() {
            return this.$el.parentNode.querySelector('input, select, textarea').getAttribute('name')
          },
          [':class']() {
            return 'form-label'
          }
        },
        formInput: {
          [':id']() {
            return this.$el.getAttribute('name')
          },
          [':disabled']() {
            return !this.onEditMode
          },
          [':class']() {
            let defaultClass = 'form-input'

            return !this.onEditMode ? `${defaultClass} border-0 uppercase` : `${defaultClass} border-secondary-300`
          },
        },
        formInputError: {
          ['x-show']() {
            return this.onEditMode
          },
          [':class']() {
            return 'form-input-err'
          }
        },
      },

      checkServerValidationError: function() {
        if (
          this.serverData.emergency_person_name_err !== '' ||
          this.serverData.emergency_address_err !== '' ||
          this.serverData.emergency_contact_number_err !== ''
        ) {
          return true
        }
        return false
      }
    }))
  })
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>