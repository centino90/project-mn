<?php require APPROOT . '/views/inc/header.php'; ?>

<!-- Profile sidebar -->
<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="flex flex-col w-full" x-data="app()">
  <div class="min-w-full px-4 lg:px-1">
    <form method="POST" @submit.prevent>
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
          <button type="button" class="flex text-blue-600 p-2 rounded-md bg-secondary-100 hover:bg-secondary-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500" @click="onEditMode = !onEditMode" x-show="onEditMode">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            Cancel editing
          </button>
        </div>
      </header>

      <div class="flex flex-col gap-y-8">
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            PRC license no <span x-show="onEditMode" class="text-danger-600">*</span>
          </label>
          <div x-bind="formGroup.inputContainer">
            <input type="text" x-model="license.prc_number" x-bind="formGroup.formInput" name="prc_number">
            <span x-bind="formGroup.formInputError" id="prc_number_err">
          </div>
        </div>

        <!-- Registration date -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            Registration date <small class="font-medium">(MM/DD/YY)</small> <span x-show="onEditMode" class="text-danger-600">*</span>
          </label>
          <div x-bind="formGroup.inputContainer">
            <div class="flex flex-1 items-center">
              <input :type="!onEditMode ? 'text' : 'date'" x-model="license.prc_registration_date" x-bind="formGroup.formInput" :max="dayjs().format('YYYY-MM-DD')" name="prc_registration_date">
            </div>
            <span x-bind="formGroup.formInputError" id="prc_registration_date_err">
          </div>
        </div>

        <!-- Expiration date -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            Expiration date <small class="font-medium">(MM/DD/YY)</small> <span x-show="onEditMode" class="text-danger-600">*</span>
          </label>
          <div x-bind="formGroup.inputContainer">
            <div class="flex flex-1 items-center">
              <input :type="!onEditMode ? 'text' : 'date'" x-model="license.prc_expiration_date" x-bind="formGroup.formInput" :min="dayjs().add(1, 'day').format('YYYY-MM-DD')" name="prc_expiration_date">
              <span x-show="!onEditMode && license.prc_expiration_date != ''" :class="checkIfRegistrationIsExpired() ? 'bg-danger-100 text-danger-800' : 'bg-warning-100 text-warning-800'" class="whitespace-nowrap px-2 inline-flex items-center gap-1 text-xs leading-5 font-semibold rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span x-ref="expiry_status" x-text="generateExpirationStatus()">
                </span>
              </span>
            </div>
            <span x-bind="formGroup.formInputError" id="prc_expiration_date_err">
          </div>
        </div>

        <!-- Field of practice -->
        <div x-bind="formGroup" x-data="{specified: false}" x-init="license.field_practice != 'General' ? specified = true : specified = false">
          <label x-bind="formGroup.formLabel">
            Field of practice <span x-show="onEditMode" class="text-danger-600">*</span>
            <a class="mx-1 text-blue-400 hover:underline cursor-pointer" @click="specified = !specified" x-show="onEditMode && specified">Change option</a>
          </label>
          <div x-bind="formGroup.inputContainer">
            <select x-model="license.field_practice" @change="if($event.target.value == 'Specialist') { specified = true;license.field_practice = ''}" x-bind="formGroup.formInput" x-show="onEditMode && !specified" :disabled="specified" name="field_practice">
              <option value="">Select</option>
              <option value="General">General</option>
              <option value="Specialist">Specialist</option>
            </select>
            <input type="text" x-model="license.field_practice" x-bind="formGroup.formInput" x-show="!onEditMode || specified" :disabled="!specified" name="field_practice" placeholder="Specify your field of practice(s) (e.g. Endodontics, Prosthodontics, etc.)">
            <span x-bind="formGroup.formInputError" id="field_practice_err">
          </div>
        </div>

        <!-- Type of practice -->
        <div x-bind="formGroup" x-data="{specified: false}">
          <label x-bind="formGroup.formLabel">
            Type of practice <span x-show="onEditMode" class="text-danger-600">*</span>
            <a class="mx-1 text-blue-400 hover:underline cursor-pointer" @click="specified = !specified;license.type_practice = ''" x-show="onEditMode && !specified">Specify</a>
            <a class="mx-1 text-blue-400 hover:underline cursor-pointer" @click="specified = !specified" x-show="onEditMode && specified">Change option</a>
          </label>
          <div x-bind="formGroup.inputContainer">
            <input type="text" x-model="license.type_practice" x-bind="formGroup.formInput" x-show="!onEditMode || specified" :disabled="!specified" name="type_practice" placeholder="Specify your type of practice">
            <select x-model="license.type_practice" x-bind="formGroup.formInput" x-show="onEditMode && !specified" :disabled="specified" name="type_practice">
              <option value="">Select</option>
              <option value="Government Dentist">Government Dentist</option>
              <option value="Clinic Owner">Clinic Owner</option>
              <option value="Dental Associate">Dental Associate</option>
              <option value="School Dentist">School Dentist</option>
              <option value="None Practicing">None Practicing</option>
            </select>
            <span x-bind="formGroup.formInputError" id="type_practice_err">
            </span>
          </div>
        </div>

        <!-- Form submit -->
        <div x-bind="formGroup" x-show="onEditMode">
          <label class="form-label">
          </label>
          <div x-bind="formGroup.inputContainer">
            <button @click="submitForm" type="submit" x-ref="submit" class="form-btn bg-primary-500 text-white w-full md:w-80 py-2 px-4">
              Update
            </button>
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
      },
      onEditMode: false,
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

      license: {
        prc_number: '<?php echo $data['prc_number'] ?>',
        prc_registration_date: '<?php echo $data['prc_registration_date'] ?>',
        prc_expiration_date: '<?php echo $data['prc_expiration_date'] ?>',
        field_practice: '<?php echo $data['field_practice'] ?>',
        type_practice: '<?php echo $data['type_practice'] ?>'
      },
      submitForm(event) {
        event.target.textContent = 'Please wait...'

        const f = fetch('<?php echo URLROOT . "/profiles/updateLicense" ?>', {
          method: "POST",
          body: JSON.stringify({
            license: this.license
          }),
          headers: {
            "Content-type": "application/json"
          }
        })

        f.then(data => data.json()
          .then(res => {
            console.log(res)
            if (res.status == 'ok') {
              this.onEditMode = false

              document.querySelector('#prc_number_err').classList.add('hidden')
              document.querySelector('#prc_registration_date_err').classList.add('hidden')
              document.querySelector('#prc_expiration_date_err').classList.add('hidden')
              document.querySelector('#field_practice_err').classList.add('hidden')
              document.querySelector('#type_practice_err').classList.add('hidden')
            } else {
              document.querySelector('#prc_number_err').classList.remove('hidden')
              document.querySelector('#prc_registration_date_err').classList.remove('hidden')
              document.querySelector('#prc_expiration_date_err').classList.remove('hidden')
              document.querySelector('#field_practice_err').classList.remove('hidden')
              document.querySelector('#type_practice_err').classList.remove('hidden')

              document.querySelector('#prc_number_err').textContent = res.errors.prc_number_err
              document.querySelector('#prc_registration_date_err').textContent = res.errors.prc_registration_date_err
              document.querySelector('#prc_expiration_date_err').textContent = res.errors.prc_expiration_date_err
              document.querySelector('#field_practice_err').textContent = res.errors.field_practice_err
              document.querySelector('#type_practice_err').textContent = res.errors.type_practice_err
            }
          }))

        event.target.textContent = 'Save'
      },

      checkIfRegistrationIsExpired: function() {
        return dayjs(this.license.prc_expiration_date) < dayjs() ? true : false
      },
      getRelativeTimeSinceExpiration: function() {
        return `expired ${dayjs(this.license.prc_expiration_date).from(dayjs())}`
      },
      getRemainingTimeBeforeExpiration: function() {
        let remainingYear = dayjs(this.license.prc_expiration_date).year() - dayjs().year()

        return dayjs(this.license.prc_expiration_date).subtract(remainingYear, 'year')
      },
      getRelativeTimeBeforeExpiration: function() {
        let remainingTime = this.getRemainingTimeBeforeExpiration();

        return `expires ${dayjs(this.license.remainingTime).to(dayjs(this.license.prc_expiration_date))}`
      },
      generateExpirationStatus: function() {
        if (this.checkIfRegistrationIsExpired()) {
          return this.getRelativeTimeSinceExpiration()
        } else {
          return this.getRelativeTimeBeforeExpiration()
        }
      },
    }))
  })
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>