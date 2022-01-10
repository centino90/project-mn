<?php require APPROOT . '/views/inc/header.php'; ?>

<!-- sidebar -->
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
                Clinic information
              </span>
            </li>
          </ol>
        </nav>
      </div>

      <header class="flex flex-wrap items-center justify-between gap-3 mb-10">
        <div class="w-64 flex-shrink-0">
          <span class="text-2xl font-bold">Clinic information</span>
        </div>
        <div>
          <button type="button" class="flex text-blue-600 p-2 rounded-md hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500" @click="onEditMode = !onEditMode" x-show="!onEditMode">
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
        <!-- Name -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            Name
          </label>
          <div x-bind="formGroup.inputContainer">
            <input type="text" x-model="clinic.clinic_name" x-bind="formGroup.formInput" name="clinic_name">
            <span x-bind="formGroup.formInputError" id="clinic_name_err">
          </div>
        </div>

        <!-- Street -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            Street
          </label>
          <div x-bind="formGroup.inputContainer">
            <input type="text" x-model="clinic.clinic_street" x-bind="formGroup.formInput" name="clinic_street">
            <span x-bind="formGroup.formInputError" id="clinic_street_err">
          </div>
        </div>

        <!-- District -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            District
          </label>
          <div x-bind="formGroup.inputContainer">
            <input type="text" x-model="clinic.clinic_district" x-bind="formGroup.formInput" name="clinic_district">
            <span x-bind="formGroup.formInputError" id="clinic_district_err">
          </div>
        </div>

        <!-- City -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            City
          </label>
          <div x-bind="formGroup.inputContainer">
            <input type="text" x-model="clinic.clinic_city" x-bind="formGroup.formInput" name="clinic_city">
            <span x-bind="formGroup.formInputError" id="clinic_city_err">
          </div>
        </div>

        <!-- Contact number -->
        <div x-bind="formGroup">
          <label x-bind="formGroup.formLabel">
            Contact number
          </label>
          <div x-bind="formGroup.inputContainer">
            <input type="number" x-model="clinic.clinic_contact_number" x-bind="formGroup.formInput" name="clinic_contact_number">
            <span x-bind="formGroup.formInputError" id="clinic_contact_number_err">
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
      init() {},
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
      clinic: {
        clinic_name: '<?php echo $data['clinic_name'] ?>',
        clinic_street: '<?php echo $data['clinic_street'] ?>',
        clinic_district: '<?php echo $data['clinic_district'] ?>',
        clinic_city: '<?php echo $data['clinic_city'] ?>',
        clinic_contact_number: '<?php echo $data['clinic_contact_number'] ?>',
      },
      submitForm(event) {
        event.target.textContent = 'Please wait...'

        const f = fetch('<?php echo URLROOT . "/profiles/updateClinic" ?>', {
          method: "POST",
          body: JSON.stringify({
            clinic: this.clinic
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

              document.querySelector('#clinic_name_err').classList.add('hidden')
              document.querySelector('#clinic_street_err').classList.add('hidden')
              document.querySelector('#clinic_district_err').classList.add('hidden')
              document.querySelector('#clinic_city_err').classList.add('hidden')
              document.querySelector('#clinic_contact_number_err').classList.add('hidden')
            } else {
              document.querySelector('#clinic_name_err').classList.remove('hidden')
              document.querySelector('#clinic_street_err').classList.remove('hidden')
              document.querySelector('#clinic_district_err').classList.remove('hidden')
              document.querySelector('#clinic_city_err').classList.remove('hidden')
              document.querySelector('#clinic_contact_number_err').classList.remove('hidden')

              document.querySelector('#clinic_name_err').textContent = res.errors.clinic_name_err
              document.querySelector('#clinic_street_err').textContent = res.errors.clinic_street_err
              document.querySelector('#clinic_district_err').textContent = res.errors.clinic_district_err
              document.querySelector('#clinic_city_err').textContent = res.errors.clinic_city_err
              document.querySelector('#clinic_contact_number_err').textContent = res.errors.clinic_contact_number_err
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