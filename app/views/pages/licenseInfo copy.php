<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="flex flex-col w-full" x-data="app()">
  <div class="text-black text-center">
    <?php flash('update_success'); ?>
  </div>

  <header class="flex justify-content-between px-4 sm:px-0">
    <div class="w-64 flex-shrink-0">
      <span class="text-lg font-medium leading-6 text-gray-900">Personal Information</span>
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
          <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 flex items-end">
              <div class="px-4 sm:px-0">
                <label for="prc_number" class="text-sm font-medium text-gray-700">
                  PRC number
                </label>
              </div>
            </div>
            <div class="mt-1 md:mt-0 md:col-span-2">
              <div class="px-4 sm:px-0" :class="!onEditMode ? 'border-b' : ''">
                <input type="number" name="prc_number" id="prc_number" value="<?php echo $data['prc_number'] ?>" :disabled="!onEditMode" :class="!onEditMode ? 'border-0 uppercase' : 'border-gray-300'" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm">
                <?php if (!empty($data['prc_number_err'])) : ?>
                  <div class="text-sm text-red-500 px-2 pt-2">
                    <?php echo $data['prc_number_err']; ?> !
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <div class="mt-4 md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 flex items-end">
              <div class="px-4 sm:px-0">
                <label for="prc_registration_date" class="block text-sm font-medium text-gray-700">
                  Registration date
                </label>
              </div>
            </div>
            <div class="mt-1 md:mt-0 md:col-span-2">
              <div class="px-4 sm:px-0" :class="!onEditMode ? 'border-b' : ''">
                <input type="date" name="prc_registration_date" id="prc_registration_date" value="<?php echo $data['prc_registration_date'] ?>" :disabled="!onEditMode" :class="!onEditMode ? 'border-0 uppercase' : 'border-gray-300'" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm">
                <?php if (!empty($data['prc_registration_date_err'])) : ?>
                  <div class="text-sm text-red-500 px-2 pt-2">
                    <?php echo $data['prc_registration_date_err']; ?> !
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <div class="mt-4 md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 flex items-end">
              <div class="px-4 sm:px-0">
                <label for="prc_expiration_date" class="block text-sm font-medium text-gray-700">
                  Expiration date
                </label>
              </div>
            </div>
            <div class="mt-1 md:mt-0 md:col-span-2">
              <div class="px-4 sm:px-0" :class="!onEditMode ? 'border-b' : ''">
                <input type="date" name="prc_expiration_date" id="prc_expiration_date" value="<?php echo $data['prc_expiration_date'] ?>" :disabled="!onEditMode" :class="!onEditMode ? 'border-0 uppercase' : 'border-gray-300'" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm">
                <?php if (!empty($data['prc_expiration_date_err'])) : ?>
                  <div class="text-sm text-red-500 px-2 pt-2">
                    <?php echo $data['prc_expiration_date_err']; ?> !
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <div class="mt-4 md:grid md:grid-cols-3 md:gap-6" x-data="{specified: false}">
            <div class="md:col-span-1 flex items-end">
              <div class="px-4 sm:px-0">
                <label for="field_practice" class="block text-sm font-medium text-gray-700">
                  Field of practice
                  <a class="mx-1 text-blue-400 hover:underline cursor-pointer" x-on:click="specified = !specified" x-show="!specified && onEditMode">Specify</a>
                  <a class="mx-1 text-blue-400 hover:underline cursor-pointer" x-on:click="specified = !specified" x-show="specified && onEditMode">Select</a>
                </label>
              </div>
            </div>
            <div class="mt-1 md:mt-0 md:col-span-2">
              <div class="px-4 sm:px-0" :class="!onEditMode ? 'border-b' : ''">
                <input type="text" name="field_practice" id="field_practice" :disabled="!specified" x-show="specified || !onEditMode" :class="!onEditMode ? 'border-0 uppercase' : 'border-gray-300'" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm" value="<?php echo $data['field_practice'] ?>">
                <select name="field_practice" id="field_practice" x-show="!specified && onEditMode" :disabled="!onEditMode || specified" :class="!onEditMode ? 'border-0 uppercase' : 'border-gray-300'" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm">
                  <option value="">Select</option>
                  <option <?php if ($data['field_practice'] == 'General Practice') : ?> selected <?php endif; ?> value="General Practice">General Practice</option>
                  <option <?php if ($data['field_practice'] == 'Endodontics') : ?> selected <?php endif; ?> value="Endodontics">Endodontics</option>
                  <option <?php if ($data['field_practice'] == 'Prosthodontics') : ?> selected <?php endif; ?> value="Prosthodontics">Prosthodontics</option>
                  <option <?php if ($data['field_practice'] == 'Orthodontics') : ?> selected <?php endif; ?> value="Orthodontics">Orthodontics</option>
                  <option <?php if ($data['field_practice'] == 'Oral and maxillofacial surgery') : ?> selected <?php endif; ?> value="Oral and maxillofacial surgery">Oral and maxillofacial surgery</option>
                  <option <?php if ($data['field_practice'] == 'Pedodontics') : ?> selected <?php endif; ?> value="Pedodontics">Pedodontics</option>
                  <option <?php if ($data['field_practice'] == 'Periodontics') : ?> selected <?php endif; ?> value="Periodontics">Periodontics</option> ?> value="None Practicing">None Practicing</option>
                </select>
                <?php if (!empty($data['field_practice_err'])) : ?>
                  <div class="text-sm text-red-500 px-2 pt-2">
                    <?php echo $data['field_practice_err']; ?> !
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <div x-bind="inputSelectGroup" class="mt-4 md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 flex items-end">
              <div class="px-4 sm:px-0">
                <label for="field_practice" class="block text-sm font-medium text-gray-700">
                  Field of practice
                  <a x-bind="inputSelectGroup.toggler"></a>
                </label>
              </div>
            </div>

            <div class="mt-1 md:mt-0 md:col-span-2">
              <div class="px-4 sm:px-0">
                <input x-bind="inputSelectGroup.input" :value="serverData.field_practice" type="text" name="field_practice" id="field_practice">
                <select x-bind="inputSelectGroup.select" name="field_practice" id="field_practice">
                  <option value="">Select</option>
                  <template x-for="(option, index) in inputSelectGroup.select.options.field_practice">
                    <option :value="option" x-text="option" :selected="option == serverData.field_practice">
                    </option>
                  </template>
                </select>

                <div x-bind="inputSelectGroup.errorMessage" x-show="serverData.field_practice_err" x-text="serverData.field_practice_err">
                </div>
              </div>
            </div>
          </div>

          <div x-bind="inputSelectGroup" class="mt-4 md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 flex items-end">
              <div class="px-4 sm:px-0">
                <label for="type_practice" class="block text-sm font-medium text-gray-700">
                  Type of practice
                  <a x-bind="inputSelectGroup.toggler" @click="inputSelectGroup.toggler.toggle"></a>
                </label>
              </div>
            </div>

            <div class="mt-1 md:mt-0 md:col-span-2">
              <div class="px-4 sm:px-0">
                <input x-bind="inputSelectGroup.input" :value="serverData.type_practice" type="text" name="type_practice" id="type_practice">
                <select x-bind="inputSelectGroup.select" name="type_practice" id="type_practice">
                  <option value="">Select</option>
                  <template x-for="(option, index) in inputSelectGroup.select.options.type_practice">
                    <option :value="option" x-text="option" :selected="option == serverData.type_practice">
                    </option>
                  </template>
                </select>

                <div x-bind="inputSelectGroup.errorMessage" x-show="serverData.type_practice_err" x-text="serverData.type_practice_err">
                </div>
              </div>
            </div>
          </div>

          <!-- test -->
          <div x-data="inputSelectGroup('type_practice', 'test 123', 'type_practice_err')" class="mt-4 md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 flex items-end">
              <div class="px-4 sm:px-0">
                <label for="type_practice" class="block text-sm font-medium text-gray-700">
                  Type of practice
                  <a x-bind="inputSelectGroup.toggler" @click="inputSelectGroup.toggler.toggle"></a>
                </label>
              </div>
            </div>

            <div class="mt-1 md:mt-0 md:col-span-2">
              <div class="px-4 sm:px-0" @click="console.log($data)">
                <input x-bind="input" type="text">
                <select x-bind="inputSelectGroup.select" @click="console.log($data)" name="type_practice" id="type_practice">
                  <option value="">Select</option>
                  <template x-for="(option, index) in inputSelectGroup.select.options.type_practice">
                    <option :value="option" x-text="option" :selected="option == serverData.type_practice">
                    </option>
                  </template>
                </select>

                <div x-bind="inputSelectGroup.errorMessage" x-show="serverData.type_practice_err" x-text="serverData.type_practice_err">
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
  <!-- testing ground -->
  <!-- <div class="m-5" x-data="app()">
    <span x-text="checkServerValidationError"></span>
    www
  </div> -->
  <div x-data="dropdown">
    <button @click="toggle">Expand</button>

    <span x-show="open">Content...</span>
  </div>

  <div x-data="dropdown">
    <button @click="toggle">Expand</button>

    <span x-show="open">Some Other Content...</span>
  </div>
</div>

<script>
  /**
   Try passing all php data to javascript and use alpinejs to
   reduce any repeating code
  **/
  document.addEventListener('alpine:init', () => {
    Alpine.store('editMode', () => ({
      on: false,
      toggle() {
        this.on = !this.on
      }
    }))

    let editData = Alpine.store('editMode')().on
    let onEditMode = Alpine.reactive(editData)

    Alpine.data('app', () => ({
      init() {
        this.checkServerValidationError()
        console.log(<?php echo json_encode($data); ?>)
      },
      onEditMode: onEditMode,
      serverData: <?php echo json_encode($data); ?>,
      trigger: {
        ['x-text']() {
          return this.onEditMode ? 'Disable editing' : 'Enable editing'
        },
        ['@click']() {
          onEditMode = !onEditMode
          this.onEditMode = onEditMode
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
          ['x-show']() {
            return this.inputSelectGroup.toggler.specified || !this.onEditMode
          },
          ['x-bind:disabled']() {
            return !this.inputSelectGroup.toggler.specified
          },
          ['x-bind:class']() {
            let defaultClass = 'focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm'

            return !this.onEditMode ? `${defaultClass} border-0 uppercase` : `${defaultClass} border-gray-300`
          },
        },
        select: {
          ['x-show']() {
            return !this.inputSelectGroup.toggler.specified && this.onEditMode
          },
          ['x-bind:disabled']() {
            return !this.onEditMode || this.inputSelectGroup.toggler.specified
          },
          ['x-bind:class']() {
            let defaultClass = 'focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm'

            return !this.onEditMode ? `${defaultClass} border-0 uppercase` : `${defaultClass} border-gray-300`
          },
          options: {
            type_practice: <?php echo json_encode($data['type_practice_options']); ?>,
            field_practice: <?php echo json_encode($data['field_practice_options']); ?>
          },
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
            return 'text-sm text-red-500 px-2 pt-2'
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
          this.onEditMode = true
          return true
        }
        this.onEditMode = false
        return false
      },
    }))

    Alpine.data('app2', () => ({
      init() {
        this.checkServerValidationError()
      },
      onEditMode: false,
      serverData: <?php echo json_encode($data); ?>,
      trigger: {
        ['x-text']() {
          return this.onEditMode ? 'Disable editing' : 'Enable editing'
        },
        ['@click']() {
          onEditMode = !onEditMode
          this.onEditMode = onEditMode
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
          ['x-show']() {
            return this.inputSelectGroup.toggler.specified || !this.onEditMode
          },
          ['x-bind:disabled']() {
            return !this.inputSelectGroup.toggler.specified
          },
          ['x-bind:class']() {
            let defaultClass = 'focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm'

            return !this.onEditMode ? `${defaultClass} border-0 uppercase` : `${defaultClass} border-gray-300`
          },
        },
        select: {
          ['x-show']() {
            return !this.inputSelectGroup.toggler.specified && this.onEditMode
          },
          ['x-bind:disabled']() {
            return !this.onEditMode || this.inputSelectGroup.toggler.specified
          },
          ['x-bind:class']() {
            let defaultClass = 'focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm'

            return !this.onEditMode ? `${defaultClass} border-0 uppercase` : `${defaultClass} border-gray-300`
          },
          options: {
            type_practice: <?php echo json_encode($data['type_practice_options']); ?>,
            field_practice: <?php echo json_encode($data['field_practice_options']); ?>
          },
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
            return 'text-sm text-red-500 px-2 pt-2'
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
          this.onEditMode = true
          return true
        }
        this.onEditMode = false
        return false
      },
    }))

    Alpine.data('inputSelectGroup', (name = '', value = '', errorMsg = '') => ({
      init() {
        console.log(name)
        console.log(value)
        console.log(errorMsg)
      },
      serverData: <?php echo json_encode($data); ?>,
      onEditMode: onEditMode,
      specified: false,

      ['x-bind:class']() {
        return !this.onEditMode ? 'border-b' : ''
      },
      input: {
        ['x-show']() {
          return this.specified || !this.onEditMode
        },
        [':disabled']() {
          return !this.specified
        },
        [':name']() {
          return name
        },
        [':id']() {
          return name
        },
        [':value']() {
          return this.filterServerDataByName()
        },
        [':class']() {
          let defaultClass = 'focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm'

          return !this.onEditMode ? `${defaultClass} border-0 uppercase` : `${defaultClass} border-gray-300`
        },
      },
      select: {
        ['x-show']() {
          console.log($data)
          return !this.specified && this.onEditMode
        },
        ['x-bind:disabled']() {
          return !this.onEditMode || this.specified
        },
        ['x-bind:class']() {
          let defaultClass = 'focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm'

          return !this.onEditMode ? `${defaultClass} border-0 uppercase` : `${defaultClass} border-gray-300`
        },
        options: {
          type_practice: <?php echo json_encode($data['type_practice_options']); ?>,
          field_practice: <?php echo json_encode($data['field_practice_options']); ?>
        },
      },
      toggler: {
        ['x-show']() {
          return this.onEditMode
        },
        ['x-text']() {
          return this.specified ? 'Select' : 'Specify'
        },
        ['x-on:click']() {
          this.specified = !this.specified
        },
        ['x-bind:class']() {
          return 'mx-1 text-blue-400 hover:underline cursor-pointer'
        },
      },
      errorMessage: {
        ['x-bind:class']() {
          return 'text-sm text-red-500 px-2 pt-2'
        },
      },

      filterServerDataByName() {
        let data
        for (const [key, value] of Object.entries(this.serverData)) {
          if (name == key) {
            data = value
          }
        }
        return data
      },
    }))
    Alpine.data('dropdown', () => ({
      open: false,

      toggle() {
        this.open = !this.open
      }
    }))
  })
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>