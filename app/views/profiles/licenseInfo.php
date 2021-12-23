<?php require APPROOT . '/views/inc/header.php'; ?>

<!-- Profile sidebar -->
<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="flex flex-col w-full" x-data="app()">
  <div class="min-w-full px-4 lg:px-1">
    <form action="<?php echo URLROOT; ?>/profiles/licenseInfo" method="POST" @submit.prevent="if (confirm('Confirm the changes of your license information?')){ $refs.submit.disabled = true; $refs.submit.value = 'Please wait...'; $el.closest('form').submit()}">
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
                License information
              </span>
            </li>
          </ol>
        </nav>
      </div>

      <header class="flex flex-wrap items-center justify-between gap-3 mb-10">
        <div class="w-64 flex-shrink-0">
          <span class="text-2xl font-bold">License information</span>
        </div>
        <div>
          <button type="button" @click="onEditMode = !onEditMode" x-show="!onEditMode" class="flex text-blue-600 p-2 rounded-md hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Enable editing
          </button>
          <button type="button" @click="onEditMode = !onEditMode" x-show="onEditMode" class="flex text-blue-600 p-2 rounded-md hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            Disable editing
          </button>
        </div>
      </header>

      <div class="flex flex-col gap-y-8">
        <!-- License no -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            PRC license no
          </label>
          <div x-bind="formGroup.inputContainer">
            <input type="number" value="<?php echo $data['prc_number'] ?>" x-bind="formGroup.formInput" name="prc_number">
            <?php if (!empty($data['prc_number_err'])) : ?>
              <div x-bind="formGroup.formInputError">
                <?php echo $data['prc_number_err']; ?> !
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Registration date -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            Registration date <small class="font-medium">(MM/DD/YY)</small>
          </label>
          <div x-bind="formGroup.inputContainer">
            <div class="flex flex-1 items-center">
              <input :type="!onEditMode ? 'text' : 'date'" :value="!onEditMode ? `<?php echo $data['prc_registration_date'] ?> (${dayjs('<?php echo $data['prc_registration_date'] ?>').format('MMMM DD, YYYY')})` : '<?php echo $data['prc_registration_date'] ?>'" x-bind="formGroup.formInput" :max="dayjs().format('YYYY-MM-DD')" name="prc_registration_date">
            </div>
            <?php if (!empty($data['prc_registration_date_err'])) : ?>
              <div x-bind="formGroup.formInputError">
                <?php echo $data['prc_registration_date_err']; ?> !
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Expiration date -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            Expiration date <small class="font-medium">(MM/DD/YY)</small>
          </label>
          <div x-bind="formGroup.inputContainer">
            <div class="flex flex-1 items-center">
              <input :type="!onEditMode ? 'text' : 'date'" :value="!onEditMode ? `<?php echo $data['prc_expiration_date'] ?> (${dayjs('<?php echo $data['prc_expiration_date'] ?>').format('MMMM DD, YYYY')})` : '<?php echo $data['prc_expiration_date'] ?>'" x-bind="formGroup.formInput" :min="dayjs().add(1, 'day').format('YYYY-MM-DD')" name="prc_expiration_date">
              <span x-show="!onEditMode" :class="checkIfRegistrationIsExpired() ? 'bg-danger-100 text-danger-800' : 'bg-warning-100 text-warning-800'" class="whitespace-nowrap px-2 inline-flex items-center gap-1 text-xs leading-5 font-semibold rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span x-text="generateExpirationStatus()">
                </span>
              </span>
            </div>
            <?php if (!empty($data['prc_expiration_date_err'])) : ?>
              <div x-bind="formGroup.formInputError">
                <?php echo $data['prc_expiration_date_err']; ?> !
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Field of practice -->
        <div x-bind="formGroup" x-data="{specified: false}">
          <label x-bind="formGroup.formLabel">
            Field of practice
            <a class="mx-1 text-blue-400 hover:underline cursor-pointer" @click="specified = !specified" x-show="onEditMode && !specified">Specify</a>
            <a class="mx-1 text-blue-400 hover:underline cursor-pointer" @click="specified = !specified" x-show="onEditMode && specified">Select</a>
          </label>
          <div x-bind="formGroup.inputContainer">
            <input type="text" value="<?php echo $data['field_practice'] ?>" x-bind="formGroup.formInput" x-show="!onEditMode || specified" :disabled="!specified" name="field_practice" placeholder="Specify your field of practice">
            <select x-bind="formGroup.formInput" x-show="onEditMode && !specified" :disabled="specified" name="field_practice">
              <option value="">Select</option>
              <option <?php if ($data['field_practice'] == 'General Practice') : ?> selected <?php endif; ?> value="General Practice">General Practice</option>
              <option <?php if ($data['field_practice'] == 'Endodontics') : ?> selected <?php endif; ?> value="Endodontics">Endodontics</option>
              <option <?php if ($data['field_practice'] == 'Prosthodontics') : ?> selected <?php endif; ?> value="Prosthodontics">Prosthodontics</option>
              <option <?php if ($data['field_practice'] == 'Orthodontics') : ?> selected <?php endif; ?> value="Orthodontics">Orthodontics</option>
              <option <?php if ($data['field_practice'] == 'Oral and maxillofacial surgery') : ?> selected <?php endif; ?> value="Oral and maxillofacial surgery">Oral and maxillofacial surgery</option>
              <option <?php if ($data['field_practice'] == 'Pedodontics') : ?> selected <?php endif; ?> value="Pedodontics">Pedodontics</option>
              <option <?php if ($data['field_practice'] == 'Periodontics') : ?> selected <?php endif; ?> value="Periodontics">Periodontics</option>
            </select>
            <?php if (!empty($data['field_practice_err'])) : ?>
              <div x-bind="formGroup.formInputError">
                <?php echo $data['field_practice_err']; ?> !
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Type of practice -->
        <div x-bind="formGroup" x-data="{specified: false}">
          <label x-bind="formGroup.formLabel">
            Type of practice
            <a class="mx-1 text-blue-400 hover:underline cursor-pointer" @click="specified = !specified" x-show="onEditMode && !specified">Specify</a>
            <a class="mx-1 text-blue-400 hover:underline cursor-pointer" @click="specified = !specified" x-show="onEditMode && specified">Select</a>
          </label>
          <div x-bind="formGroup.inputContainer">
            <input type="text" value="<?php echo $data['type_practice'] ?>" x-bind="formGroup.formInput" x-show="!onEditMode || specified" :disabled="!specified" name="type_practice" placeholder="Specify your type of practice">
            <select x-bind="formGroup.formInput" x-show="onEditMode && !specified" :disabled="specified" name="type_practice">
              <option value="">Select</option>
              <option <?php if ($data['type_practice'] == 'Government Dentist') : ?> selected <?php endif; ?> value="Government Dentist">Government Dentist</option>
              <option <?php if ($data['type_practice'] == 'Clinic Owner') : ?> selected <?php endif; ?> value="Clinic Owner">Clinic Owner</option>
              <option <?php if ($data['type_practice'] == 'Dental Associate') : ?> selected <?php endif; ?> value="Dental Associate">Dental Associate</option>
              <option <?php if ($data['type_practice'] == 'School Dentist') : ?> selected <?php endif; ?> value="School Dentist">School Dentist</option>
              <option <?php if ($data['type_practice'] == 'None Practicing') : ?> selected <?php endif; ?> value="None Practicing">None Practicing</option>
            </select>
            <?php if (!empty($data['type_practice_err'])) : ?>
              <div x-bind="formGroup.formInputError">
                <?php echo $data['type_practice_err']; ?> !
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Form submit -->
        <div x-bind="formGroup" x-show="onEditMode">
          <label x-bind="formGroup.formLabel">
          </label>
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
        }
      },

      checkIfRegistrationIsExpired: function() {
        return dayjs(this.serverData.prc_expiration_date) < dayjs() ? true : false
      },
      getRelativeTimeSinceExpiration: function() {
        return `expired ${dayjs(this.serverData.prc_expiration_date).from(dayjs())}`
      },
      getRemainingTimeBeforeExpiration: function() {
        let remainingYear = dayjs(this.serverData.prc_expiration_date).year() - dayjs().year()

        return dayjs(this.serverData.prc_expiration_date).subtract(remainingYear, 'year')
      },
      getRelativeTimeBeforeExpiration: function() {
        let remainingTime = this.getRemainingTimeBeforeExpiration();

        return `expires ${dayjs(this.serverData.remainingTime).to(dayjs(this.serverData.prc_expiration_date))}`
      },
      generateExpirationStatus: function() {
        if (this.checkIfRegistrationIsExpired()) {
          console.log('yeehuh')
          return this.getRelativeTimeSinceExpiration()
        } else {
          return this.getRelativeTimeBeforeExpiration()
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
    }))
  })
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>