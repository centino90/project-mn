<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="flex flex-col w-full" x-data="app()">
  <div class="text-black text-center">
    <?php flash('update_success'); ?>
  </div>

  <header class="flex justify-content-between px-4 sm:px-0">
    <div class="w-64 flex-shrink-0">
      <span class="text-lg font-medium leading-6 text-gray-900">License information</span>
      <p class="mt-1 text-sm text-gray-600">
        Use a permanent address where you can receive mail.
      </p>
    </div>
    <div class="w-full text-right">
      <a x-bind="trigger"></a>
    </div>
  </header>

  <div class="overflow-x-auto mt-9">
    <div class="inline-block min-w-full px-1">
      <div class="overflow-hidden sm:rounded-lg">
        <form action="<?php echo URLROOT; ?>/pages/licenseInfo" method="POST">
          <div x-bind="inputSelectGroup" class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 flex items-end">
              <div class="px-4 sm:px-0">
                <label for="prc_number" class="block text-sm font-medium text-gray-700">
                  PRC number
                </label>
              </div>
            </div>
            <div class="mt-1 md:mt-0 md:col-span-2">
              <div class="px-4 sm:px-0">
                <input x-bind="inputSelectGroup.inputs" :value="serverData.prc_number" type="number" name="prc_number" id="prc_number">
                <div class="err-message" x-bind="inputSelectGroup.errorMessage" x-show="serverData.prc_number_err" x-text="serverData.prc_number_err">
                </div>
              </div>
            </div>
          </div>

          <div x-bind="inputSelectGroup" class="mt-4 md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 flex items-end">
              <div class="px-4 sm:px-0">
                <label for="prc_registration_date" class="block text-sm font-medium text-gray-700">
                  Registration date
                </label>
              </div>
            </div>
            <div class="mt-1 md:mt-0 md:col-span-2">
              <div class="px-4 sm:px-0">
                <input x-bind="inputSelectGroup.inputs" :value="serverData.prc_registration_date" type="date" name="prc_registration_date" id="prc_registration_date">
                <div class="err-message" x-bind="inputSelectGroup.errorMessage" x-show="serverData.prc_registration_date_err" x-text="serverData.prc_registration_date_err">
                </div>
              </div>
            </div>
          </div>

          <div x-bind="inputSelectGroup" class="mt-4 md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 flex items-end">
              <div class="px-4 sm:px-0">
                <label for="prc_expiration_date" class="block text-sm font-medium text-gray-700">
                  Expiration date
                </label>
              </div>
            </div>
            <div class="mt-1 md:mt-0 md:col-span-2">
              <div class="px-4 sm:px-0">
                <input x-bind="inputSelectGroup.inputs" :value="serverData.prc_expiration_date" type="date" name="prc_expiration_date" id="prc_expiration_date">
                <div class="err-message" x-bind="inputSelectGroup.errorMessage" x-show="serverData.prc_expiration_date_err" x-text="serverData.prc_expiration_date_err">
                </div>
              </div>
            </div>
          </div>

          <div x-bind="inputSelectGroup" class="mt-4 md:grid md:grid-cols-3 md:gap-6" x-data="{specified: false}">
            <div class="md:col-span-1 flex items-end">
              <div class="px-4 sm:px-0">
                <label for="field_practice" class="block text-sm font-medium text-gray-700">
                  Field of practice
                  <!-- <a x-bind="inputSelectGroup.toggler"></a> -->
                  <a class="mx-1 text-blue-400 hover:underline cursor-pointer" x-on:click="specified = !specified" x-show="!specified && onEditMode">Specify</a>
                  <a class="mx-1 text-blue-400 hover:underline cursor-pointer" x-on:click="specified = !specified" x-show="specified && onEditMode">Select</a>
                </label>
              </div>
            </div>

            <div class="mt-1 md:mt-0 md:col-span-2">
              <div class="px-4 sm:px-0">
                <input x-bind="inputSelectGroup.input" x-show="specified || !onEditMode" :disabled="!specified || !onEditMode" :value="serverData.field_practice" type="text" name="field_practice" id="field_practice">
                <select x-bind="inputSelectGroup.select" x-show="!specified && onEditMode" :disabled="!onEditMode || specified" name="field_practice" id="field_practice">
                  <option value="">Select</option>
                  <template x-for="(option, index) in inputSelectGroup.select.options.field_practice">
                    <option :value="option" x-text="option" :selected="option == serverData.field_practice">
                    </option>
                  </template>
                </select>

                <div class="err-message" x-bind="inputSelectGroup.errorMessage" x-show="serverData.field_practice_err" x-text="serverData.field_practice_err">
                </div>
              </div>
            </div>
          </div>

          <div x-bind="inputSelectGroup" class="mt-4 md:grid md:grid-cols-3 md:gap-6" x-data="{specified: false}">
            <div class="md:col-span-1 flex items-end">
              <div class="px-4 sm:px-0">
                <label for="type_practice" class="block text-sm font-medium text-gray-700">
                  Type of practice
                  <!-- <a x-bind="inputSelectGroup.toggler" @click="inputSelectGroup.toggler.toggle"></a> -->
                  <a class="mx-1 text-blue-400 hover:underline cursor-pointer" x-on:click="specified = !specified" x-show="!specified && onEditMode">Specify</a>
                  <a class="mx-1 text-blue-400 hover:underline cursor-pointer" x-on:click="specified = !specified" x-show="specified && onEditMode">Select</a>
                </label>
              </div>
            </div>

            <div class="mt-1 md:mt-0 md:col-span-2">
              <div class="px-4 sm:px-0">
                <input x-bind="inputSelectGroup.input" x-show="specified || !onEditMode" :disabled="!specified || !onEditMode" :value="serverData.type_practice" type="text" name="type_practice" id="type_practice">
                <select x-bind="inputSelectGroup.select" x-show="!specified && onEditMode" :disabled="!onEditMode || specified" name="type_practice" id="type_practice">
                  <option value="">Select</option>
                  <template x-for="(option, index) in inputSelectGroup.select.options.type_practice">
                    <option :value="option" x-text="option" :selected="option == serverData.type_practice">
                    </option>
                  </template>
                </select>

                <div class="err-message" x-bind="inputSelectGroup.errorMessage" x-show="serverData.type_practice_err" x-text="serverData.type_practice_err">
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
              window.location.href = '<?php echo URLROOT; ?>/pages/licenseInfo'
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
          input: {

            ['x-bind:class']() {
              let defaultClass = 'focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm'

              return !this.onEditMode ? `${defaultClass} border-0 uppercase` : `${defaultClass} border-gray-300`
            },
          },
          select: {
            ['x-bind:class']() {
              let defaultClass = 'focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm'

              return !this.onEditMode ? `${defaultClass} border-0 uppercase` : `${defaultClass} border-gray-300`
            },
            options: {
              type_practice: <?php echo json_encode($data['type_practice_options']); ?>,
              field_practice: <?php echo json_encode($data['field_practice_options']); ?>
            },
          },
          inputs: {

            [':class']() {
              let defaultClass = 'focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm'

              return !this.onEditMode ? `${defaultClass} border-0 uppercase` : `${defaultClass} border-gray-300`
            },
            [':disabled']() {
              return !this.onEditMode
            }
          },
          toggler: {
            specified: false,
            ['x-show']() {
              return this.onEditMode
            },
            ['x-text']() {
              return this.inputSelectGroup.toggler.specified ? 'Select' : 'Specify'
            },
            ['x-on:click']() {
              this.inputSelectGroup.toggler.specified = !this.inputSelectGroup.toggler.specified
            },
            ['x-bind:class']() {
              return 'mx-1 text-blue-400 hover:underline cursor-pointer'
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
            this.serverData.prc_number_err !== '' ||
            this.serverData.prc_registration_date_err !== '' ||
            this.serverData.prc_expiration_date_err !== '' ||
            this.serverData.field_practice_err !== '' ||
            this.serverData.type_practice_err !== ''
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