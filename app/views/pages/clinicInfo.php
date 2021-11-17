<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="flex flex-col w-full" x-data="app()">
  <div class="text-black text-center">
    <?php flash('update_success'); ?>
  </div>

  <header class="flex justify-content-between px-4 sm:px-0">
    <div class="w-64 flex-shrink-0">
      <span class="text-lg font-medium leading-6 text-gray-900">Clinic information</span>
      <p class="mt-1 text-sm text-gray-600">
        Use a permanent address where you can receive mail.
      </p>
    </div>
    <div class="w-full text-right">
      <a x-bind="trigger">
      </a>
    </div>
  </header>

  <div class="overflow-x-auto mt-9">
    <div class="inline-block min-w-full px-1">
      <div class="overflow-hidden sm:rounded-lg">
        <form action="<?php echo URLROOT; ?>/pages/clinicInfo" method="POST">
          <div x-bind="inputSelectGroup" class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 flex items-end">
              <div class="px-4 sm:px-0">
                <label for="clinic_name" class="block text-sm font-medium text-gray-700">
                  Name
                </label>
              </div>
            </div>
            <div class="mt-1 md:mt-0 md:col-span-2">
              <div class="px-4 sm:px-0">
                <input x-bind="inputSelectGroup.inputs" :value="serverData.clinic_name" type="text" name="clinic_name" id="clinic_name">
                <div class="err-message" x-bind="inputSelectGroup.errorMessage" x-show="serverData.clinic_name_err" x-text="serverData.clinic_name_err">
                </div>
              </div>
            </div>
          </div>

          <div x-bind="inputSelectGroup" class="mt-4 md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 flex items-end">
              <div class="px-4 sm:px-0">
                <label for="clinic_street" class="block text-sm font-medium text-gray-700">
                  Street
                </label>
              </div>
            </div>
            <div class="mt-1 md:mt-0 md:col-span-2">
              <div class="px-4 sm:px-0">
                <input x-bind="inputSelectGroup.inputs" :value="serverData.clinic_street" type="text" name="clinic_street" id="clinic_street">
                <div class="err-message" x-bind="inputSelectGroup.errorMessage" x-show="serverData.clinic_street_err" x-text="serverData.clinic_street_err">
                </div>
              </div>
            </div>
          </div>

          <div x-bind="inputSelectGroup" class="mt-4 md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 flex items-end">
              <div class="px-4 sm:px-0">
                <label for="clinic_district" class="block text-sm font-medium text-gray-700">
                  District
                </label>
              </div>
            </div>
            <div class="mt-1 md:mt-0 md:col-span-2">
              <div class="px-4 sm:px-0">
                <input x-bind="inputSelectGroup.inputs" :value="serverData.clinic_district" type="text" name="clinic_district" id="clinic_district">
                <div class="err-message" x-bind="inputSelectGroup.errorMessage" x-show="serverData.clinic_district_err" x-text="serverData.clinic_district_err">
                </div>
              </div>
            </div>
          </div>

          <div x-bind="inputSelectGroup" class="mt-4 md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 flex items-end">
              <div class="px-4 sm:px-0">
                <label for="clinic_city" class="block text-sm font-medium text-gray-700">
                  City
                </label>
              </div>
            </div>
            <div class="mt-1 md:mt-0 md:col-span-2">
              <div class="px-4 sm:px-0">
                <input x-bind="inputSelectGroup.inputs" :value="serverData.clinic_city" type="text" name="clinic_city" id="clinic_city">
                <div class="err-message" x-bind="inputSelectGroup.errorMessage" x-show="serverData.clinic_city_err" x-text="serverData.clinic_city_err">
                </div>
              </div>
            </div>
          </div>

          <div x-bind="inputSelectGroup" class="mt-4 md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 flex items-end">
              <div class="px-4 sm:px-0">
                <label for="clinic_contact_number" class="block text-sm font-medium text-gray-700">
                  Contact number
                </label>
              </div>
            </div>
            <div class="mt-1 md:mt-0 md:col-span-2">
              <div class="px-4 sm:px-0">
                <input x-bind="inputSelectGroup.inputs" :value="serverData.clinic_contact_number" type="text" name="clinic_contact_number" id="clinic_contact_number">
                <div class="err-message" x-bind="inputSelectGroup.errorMessage" x-show="serverData.clinic_contact_number_err" x-text="serverData.clinic_contact_number_err">
                </div>
              </div>
            </div>
          </div>

          <div class="mt-9 md:grid md:grid-cols-3 md:gap-3" x-data="{specified: false}">
            <div class="md:col-span-1"></div>
            <div class="md:mt-0 md:col-span-2">
              <div class="px-4 sm:px-0">
                <button type="submit" x-show="onEditMode" class="mx-1 group relative flex justify-center py-2 px-4 border border-transparent text-white font-bold rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  Submit to proceed
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    /**
   Passed all php data to javascript and used alpinejs to
   reduce any repeating code
  **/
    document.addEventListener('alpine:init', () => {
      Alpine.store('serverData', <?php echo json_encode($data) ?>)

      Alpine.data('app', () => ({
        init() {
          if (this.checkServerValidationError()) {
            this.onEditMode = true
          } else {
            this.onEditMode = false
          }
          console.log(this.serverData)
        },
        onEditMode: false,
        serverData: <?php echo json_encode($data); ?>,

        trigger: {
          ['x-text']() {
            return this.onEditMode ? 'Disable editing' : 'Enable editing'
          },
          ['@click']() {
            if (this.onEditMode && this.checkServerValidationError()) {
              if (!confirm(
                  `You seem to have unfinished action. Do you still want to proceed?
                  If so, your data will be reverted back.`
                )) {
                return
              }
              window.location.href = '<?php echo URLROOT; ?>/pages/personalInfo'
            }

            this.getInputs().forEach(input => {
              input.value = this.serverData[input.getAttribute('name')]
            })
            this.onEditMode = !this.onEditMode
          },
          [':class']() {
            return 'text-blue-400 hover:underline cursor-pointer'
          },
        },

        inputSelectGroup: {
          ['x-bind:class']() {
            return !this.onEditMode ? 'border-b' : ''
          },
          inputs: {
            [':disabled']() {
              return !this.onEditMode
            },
            [':class']() {
              let defaultClass = 'focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm'

              return !this.onEditMode ? `${defaultClass} border-0 uppercase` : `${defaultClass} border-gray-300`
            },
          },
          errorMessage: {
            ['x-bind:class']() {
              return 'err-message text-sm text-red-500 px-2 pt-2'
            },
          }
        },

        checkServerValidationError: function() {
          if (
            this.serverData.clinic_name_err !== '' ||
            this.serverData.clinic_street_err !== '' ||
            this.serverData.clinic_district_err !== '' ||
            this.serverData.clinic_city_err !== '' ||
            this.serverData.clinic_contact_number_err !== ''
          ) {
            return true
          }
          return false
        },
        getInputs() {
          return document.querySelectorAll('form input, form select, form textarea')
        },
      }))
    })
  </script>

  <?php require APPROOT . '/views/inc/footer.php'; ?>