<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="flex flex-col w-full" x-data="app()">
  <div class="min-w-full px-4 lg:px-1">
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
              Add dues
            </span>
          </li>
        </ol>
      </nav>
    </div>

    <header class="flex flex-wrap items-center justify-between gap-3 mb-10">
      <div class="flex-shrink-0">
        <span class="text-2xl font-bold" x-show="!onImport">
          Add single dues
        </span>
        <span class="text-2xl font-bold" x-show="onImport">
          Import bulk dues
        </span>
      </div>

      <div class="flex gap-3">
        <a x-show="onImport" href="<?php echo URLROOT ?>/users/downloadTemplates?filename=IMPORT_DUES_TEMPLATE.xlsx" class="flex border border-primary-600 text-primary-600 p-2 text-white rounded-md hover:bg-secondary-100">
          Download template
        </a>

        <button type="button" class="flex text-blue-600 p-2 rounded-md hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500" @click="onImport = !onImport" x-show="!onImport">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
          </svg>
          Import bulk dues
        </button>
        <button type="button" class="flex text-blue-600 p-2 rounded-md hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500" @click="onImport = !onImport" x-show="onImport">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
          Add single dues
        </button>
      </div>
    </header>

    <!-- success modal -->
    <div x-cloak x-ref="success_modal" x-transition x-show.transition.opacity="successModalOpen" class="overflow-auto fixed z-20 top-0 left-0 w-screen h-screen bg-black bg-opacity-50 flex items-center justify-center" role="dialog" aria-modal="true">
      <div class="w-full max-w-screen-md bg-white lg:rounded-xl shadow-xl flex flex-col absolute divide-y divide-secondary-200 max-h-screen">

        <div class="px-5 py-4 flex items-center justify-between">
          <h2 class="text-xl leading-tight text-secondary-700">
            Last inserted rows
          </h2>

          <button class="text-secondary-400 hover:text-secondary-600" @click="successModalOpen = false">
            <svg class="w-4 fill-current transition duration-150" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.001 512.001">
              <path d="M284.286 256.002L506.143 34.144c7.811-7.811 7.811-20.475 0-28.285-7.811-7.81-20.475-7.811-28.285 0L256 227.717 34.143 5.859c-7.811-7.811-20.475-7.811-28.285 0-7.81 7.811-7.811 20.475 0 28.285l221.857 221.857L5.858 477.859c-7.811 7.811-7.811 20.475 0 28.285a19.938 19.938 0 0014.143 5.857 19.94 19.94 0 0014.143-5.857L256 284.287l221.857 221.857c3.905 3.905 9.024 5.857 14.143 5.857s10.237-1.952 14.143-5.857c7.811-7.811 7.811-20.475 0-28.285L284.286 256.002z" />
            </svg>
          </button>
        </div>

        <div class="py-5 px-5 mb-5 overflow-auto " id="modal_content">
          <table class="table-fixed w-full" id="inserted_rows">
            <thead class="text-secondary-400 text-xs font-semibold uppercase">
              <tr class="text-left">
                <th class="px-2 whitespace-nowrap">Row #</th>
                <th class="px-2 whitespace-nowrap">Linked profile</th>
                <th class="px-2 whitespace-nowrap">PRC #</th>
                <th class="px-2 whitespace-nowrap">Amount</th>
                <th class="px-2 whitespace-nowrap">Paid To</th>
                <th class="px-2 whitespace-nowrap">Channel</th>
                <th class="px-2 whitespace-nowrap">OR #</th>
                <th class="px-2 whitespace-nowrap">Remarks</th>
                <th class="px-2 whitespace-nowrap">Date Posted</th>
                <th class="px-2 whitespace-nowrap">Date Added</th>
              </tr>
            </thead>
            <tbody class="text-sm divide-y divide-secondary-200">

            </tbody>
          </table>
        </div>
      </div>
    </div>

    <form @submit.prevent x-ref="dues_form" x-show="!onImport" class="flex flex-col gap-y-8">
      <div x-bind="formGroup">
        <label for="user_id" class="form-label">PRC No. <span class="text-danger-600">*</span></label>
        <div class="input-container w-full flex flex-col items-center">
          <div @click.outside="close()" class="w-full">
            <div class="flex flex-col items-center relative z-0">
              <div class="w-full">
                <div class="mb-2 p-1 bg-white flex border border-secondary-200 rounded">
                  <input name="user_id" x-model="duesForm.prc_number" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @mousedown="open()" @keydown.enter.stop.prevent="selectOption()" @keydown.arrow-up.prevent="focusPrevOption()" @keydown.arrow-down.prevent="focusNextOption()" placeholder="Find existing prc no. by searching the name or prc no." autocomplete="off" class="p-1 px-2 appearance-none outline-none w-full text-secondary-800">
                  <div class="text-secondary-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-secondary-200">
                    <button @click="toggle()" class="cursor-pointer w-6 h-6 text-secondary-600 outline-none focus:outline-none">
                      <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline x-show="!isOpen()" points="18 15 12 20 6 15"></polyline>
                        <polyline x-show="isOpen()" points="18 15 12 9 6 15"></polyline>
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
              <div x-show="isOpen()" class="absolute shadow bg-white top-full w-full left-0 rounded overflow-y-auto" style="max-height: 300px;" ;>
                <div class="flex flex-col w-full">
                  <template x-for="(option, index) in filteredOptions()" :key="index">
                    <div @click="onOptionClick(index)" :class="classOption(option.prc_number, index)" :aria-selected="focusedOptionIndex === index">
                      <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-teal-100">
                        <div class="w-6 flex flex-col items-center">
                          <div class="flex relative w-5 h-5 bg-blue-500 justify-center items-center m-1 mr-2 w-4 h-4 mt-1 rounded-full">
                            <img class="rounded-full" alt="A" x-bind:src="option.thumbnail_img_path ? `<?php echo URLROOT . '/' ?>${option.thumbnail_img_path}` : '<?php echo URLROOT . '/public/img/profiles/default-profile.png' ?>'">
                          </div>
                        </div>
                        <div class="w-full items-center flex">
                          <div class="mx-2 -mt-1"><span x-text="option.first_name.toUpperCase() + ' ' + option.last_name.toUpperCase()"></span>
                            <div class="text-xs truncate w-full normal-case font-normal -mt-1 text-secondary-500" x-text="option.prc_number"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </template>
                </div>
              </div>
            </div>
          </div>
          <span class="hidden text-danger-600 text-sm" id="prc_number_err"></span>
          </span>
        </div>
      </div>

      <div x-bind="formGroup">
        <label x-bind="formGroup.formLabel">
          Amount <span class="text-danger-600">*</span>
        </label>
        <div x-bind="formGroup.inputContainer">
          <input type="number" x-model="duesForm.amount" x-bind="formGroup.formInput" name="amount">
          <span class="hidden text-danger-600 text-sm" id="amount_err"></span>
        </div>
      </div>

      <div x-bind="formGroup">
        <label x-bind="formGroup.formLabel">
          Paid to (PDA/DCC) <span class="text-danger-600">*</span>
        </label>
        <div x-bind="formGroup.inputContainer">
          <select x-model="duesForm.type" x-bind="formGroup.formInput" name="type">
            <option value="">Select type</option>
            <option value="PDA">PDA</option>
            <option value="DCC">DCC</option>
          </select>
          <span class="hidden text-danger-600 text-sm" id="type_err"></span>
        </div>
      </div>

      <div x-bind="formGroup">
        <label x-bind="formGroup.formLabel" class="wrap">
          Channel (gcash, paymaya, etc.) <span class="text-danger-600">*</span>
        </label>
        <div x-bind="formGroup.inputContainer">
          <input type="text" x-model="duesForm.channel" x-bind="formGroup.formInput" name="channel">
          <span class="hidden text-danger-600 text-sm" id="channel_err"></span>
        </div>
      </div>

      <div x-bind="formGroup">
        <label x-bind="formGroup.formLabel">
          OR Number <span class="text-danger-600">*</span>
        </label>
        <div x-bind="formGroup.inputContainer">
          <input type="text" x-model="duesForm.or_number" x-bind="formGroup.formInput" name="or_number">
          <span class="hidden text-danger-600 text-sm" id="or_number_err"></span>
        </div>
      </div>

      <div x-bind="formGroup">
        <label x-bind="formGroup.formLabel">
          Remarks <span class="text-secondary-400">(optional)</span>
        </label>
        <div x-bind="formGroup.inputContainer">
          <textarea type="number" x-model="duesForm.remarks" x-bind="formGroup.formInput" name="remarks" rows="3"></textarea>
        </div>
      </div>

      <div x-bind="formGroup">
        <label x-bind="formGroup.formLabel">
          Date posted <span class="text-danger-600">*</span>
        </label>
        <div x-bind="formGroup.inputContainer">
          <div class="flex w-full">
            <div class="flex w-3/4">
              <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-secondary-300 bg-secondary-50 text-secondary-500 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                </svg>
              </span>

              <select name="month" x-model="duesForm.date_posted.month" id="month" class="focus:ring-primary-500 focus:border-primary-500 flex-1 block w-full rounded-none sm:text-sm border-secondary-300 border-r-0">
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
              </select>
            </div>

            <select name="year" x-model="duesForm.date_posted.year" id="year" class="w-1/4 focus:ring-primary-500 focus:border-primary-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-secondary-300">
              <template x-for="(date, index) in generateYearsBetween().slice(1, -1)" :key="index">
                <option :value="date" x-text="date" :selected="index == 0"></option>
              </template>
            </select>
          </div>
          <span class="hidden text-danger-600 text-sm" id="date_posted_err"></span>
        </div>
      </div>

      <!-- Form submit -->
      <div x-bind="formGroup" x-show="onEditMode">
        <label></label>
        <div x-bind="formGroup.inputContainer">
          <button @click="submitForm" x-ref="submit" class="form-btn lg:ml-2 disabled:cursor-wait bg-primary-500 text-white w-full md:w-80 py-2 px-4">
            Submit
          </button>
        </div>
      </div>
    </form>

    <form @submit.prevent x-ref="dues_import" x-show="onImport" class="flex flex-col gap-y-8">
      <!-- import csv -->
      <div x-bind="formGroup">
        <label x-bind="formGroup.formLabel">Import <span class="text-danger-600">*</span></label>
        <div x-bind="formGroup.inputContainer">
          <input type="file" name="dues_file" id="dues_file" class="rounded border border-secondary-300 px-3 py-5 text-secondary-700 w-full focus:ring-primary-500 focus:border-primary-500">

          <div class="w-full text-xs text-secondary-400 font-bold px-2">CHOOSE OR DRAG YOUR CSV FILE</div>
          <span class="hidden text-danger-600 text-sm" id="dues_file_err"></span>
        </div>
      </div>

      <!-- Form submit -->
      <div x-bind="formGroup">
        <label></label>
        <div x-bind="formGroup.inputContainer">
          <button type="submit" @click="importForm" x-ref="submit" class="form-btn lg:ml-2 disabled:cursor-wait bg-primary-500 text-white w-full md:w-80 py-2 px-4">
            Submit
          </button>
        </div>
      </div>
    </form>
  </div>

  <div class="fixed left-0 bottom-0 z-40 " @keydown.window.escape="fixedAlertOpen = false">
    <div x-show="fixedAlertOpen === true" x-ref="fixed_alert" class="fixed left-4 bottom-4 sm:bottom-10 rounded-lg bg-white shadow-2xl w-96 overflow-hidden" style="display: none;" x-transition:enter="transition ease-in duration-200" x-transition:enter-start="opacity-0 transform -translate-x-40" x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform -translate-x-40">
      <div class="">
        <div class="relative overflow-hidden px-6 pt-4">
          <header class="text-success-600 flex gap-2 font-semibold">
            <svg class="w-6 sm:w-5 h-6 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span x-ref="fixed_alert_label">Success</span>
          </header>
          <div class="pb-4 flex gap-2 justify-between items-end">
            <p class="line-clamp-3 text-secondary-500" x-ref="fixed_alert_message">
            </p>
            <button x-show="fixedAlertWithView" @click="successModalOpen = true" class="whitespace-nowrap text-sm font-bold hover:bg-secondary-100 p-2 rounded-md">
              View More
            </button>
          </div>
        </div>

        <div class="absolute right-4 top-3 text-gray-400 hover:text-gray-800 cursor-pointer" @click="fixedAlertOpen = !fixedAlertOpen">
          <svg class="w-6 sm:w-5 h-6 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </div>
      </div>
    </div>
    <button x-show="fixedAlertOpen === false && !successModalOpen" class="fixed left-4 bottom-10 uppercase text-sm px-4 py-3 bg-secondary-900 text-success-500 rounded-full" @click="fixedAlertOpen = !fixedAlertOpen">
      <svg class="w-6 sm:w-5 h-6 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
    </button>
  </div>
</div>

<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('app', () => ({
      init() {
        const app = this
        // $('#inserted_rows').DataTable({
        //   'scrollX': true,
        //   'dom': 'frtip',
        //   'pageLength': 5
        // })

        this.$watch('duesForm.prc_number', val => {
          console.log(val)
        })

        // search user profile component
        fetch("<?php echo URLROOT . '/profiles/fetchUserProfile' ?>", {
            method: 'POST'
          })
          .then(response => response.json())
          .then(data => {
            if (data.status == 'ok') {
              app.options = data
            }
          });

        this.$watch('fixedAlertOpen', value => {
          let alertTimer;
          clearTimeout(alertTimer)

          if (value === true) {
            alertTimer = setTimeout(() => {
              this.fixedAlertOpen = false
            }, 10000);
          }
        })

        // this.$watch('successModalOpen', value => {
        //   if (value === true) {
        //     this.fixedAlertOpen = false;
        //   }
        // })
      },
      fixedAlertOpen: '',
      fixedAlertWithView: false,
      onEditMode: true,
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

      onImport: false,
      duesForm: {
        prc_number: '',
        type: '',
        amount: '',
        channel: '',
        or_number: '',
        remarks: '',
        date_posted: {
          month: 1,
          year: 1981
        },
      },
      submitForm: function() {
        const prc_number_err = document.querySelector('#prc_number_err')
        const type_err = document.querySelector('#type_err')
        const amount_err = document.querySelector('#amount_err')
        const channel_err = document.querySelector('#channel_err')
        const or_number_err = document.querySelector('#or_number_err')
        const date_posted_err = document.querySelector('#date_posted_err')

        let actionText = this.$el.textContent
        this.$el.textContent = 'Please wait...'

        this.performFormRequest().then(data => data.json())
          .then(res => {
            this.$el.textContent = actionText
            this.$el.disabled = false

            if (res.status == 'ok') {
              this.$refs.dues_form.reset()
              this.duesForm = {
                prc_number: '',
                type: '',
                amount: '',
                channel: '',
                or_number: '',
                remarks: '',
                date_posted: {
                  month: 1,
                  year: 1981
                }
              }

              prc_number_err.classList.add('hidden')
              type_err.classList.add('hidden')
              amount_err.classList.add('hidden')
              channel_err.classList.add('hidden')
              or_number_err.classList.add('hidden')
              date_posted_err.classList.add('hidden')

              this.fixedAlertOpen = true
              this.fixedAlertWithView = false
              this.$refs.fixed_alert_label.textContent = 'Success'
              this.$refs.fixed_alert_message.textContent = `You submitted a due`
              // window.location.reload()
            } else {
              const prc_number_err = document.querySelector('#prc_number_err')
              const type_err = document.querySelector('#type_err')
              const amount_err = document.querySelector('#amount_err')
              const channel_err = document.querySelector('#channel_err')
              const or_number_err = document.querySelector('#or_number_err')
              const date_posted_err = document.querySelector('#date_posted_err')

              prc_number_err.classList.remove('hidden')
              type_err.classList.remove('hidden')
              amount_err.classList.remove('hidden')
              channel_err.classList.remove('hidden')
              or_number_err.classList.remove('hidden')
              date_posted_err.classList.remove('hidden')

              prc_number_err.textContent = res.errors.prc_number_err
              type_err.textContent = res.errors.type_err
              amount_err.textContent = res.errors.amount_err
              channel_err.textContent = res.errors.channel_err
              or_number_err.textContent = res.errors.or_number_err
              date_posted_err.textContent = res.errors.date_posted_err
            }
          })
      },
      performFormRequest: async function() {
        return await fetch('<?php echo URLROOT . "/admins/addDues" ?>', {
          method: "POST",
          body: JSON.stringify({
            duesForm: this.duesForm
          }),
          headers: {
            "Content-type": "application/json"
          }
        })
      },
      importForm: function() {
        const dues_file_err = document.querySelector('#dues_file_err')
        dues_file_err.classList.add('hidden')
        let actionText = this.$el.textContent
        this.$el.textContent = 'Please wait...'

        this.performImportRequest().then(data => data.json())
          .then(res => {
            this.$el.textContent = actionText
            this.$el.disabled = false

            if (res.status == 'ok') {
              this.$refs.dues_import.reset()

              this.fixedAlertOpen = true
              // this.fixedAlertWithView = true
              // this.insertedRows = res.insertedRows
              let newArr = []
              res.insertedRows.forEach((item, index) => {
                item.date_posted = dayjs(item.date_posted).year()
                newArr.push(Object.values(item))
              })
              // $('#inserted_rows').dataTable().api().rows.add(newArr).draw()

              this.$refs.fixed_alert_label.textContent = 'Success'
              this.$refs.fixed_alert_message.textContent = `You imported ${newArr.length} dues`
            } else {
              dues_file_err.classList.remove('hidden')
              dues_file_err.textContent = res.message
            }
          })
      },
      performImportRequest: async function() {
        const updateRequest = new FormData();
        updateRequest.append('dues_file', document.querySelector('#dues_file').files[0])

        return await fetch('<?php echo URLROOT . "/admins/importDues" ?>', {
          method: "POST",
          body: updateRequest,
        })
      },
      successModalOpen: false,
      insertedRows: [],
      filterInsertedRows() {
        return this.insertedRows;
      },


      // search input component
      show: false,
      selected: null,
      focusedOptionIndex: null,
      options: null,
      close() {
        this.show = false;
        // this.duesForm.prc_number = this.selectedName();
        this.focusedOptionIndex = this.selected ? this.focusedOptionIndex : null;
      },
      open() {
        this.show = true;
        // this.duesForm.prc_number = '';
      },
      toggle() {
        if (this.show) {
          this.close();
        } else {
          this.open()
        }
      },
      isOpen() {
        return this.show === true
      },
      selectedName() {
        return this.selected ? this.selected.prc_number : this.duesForm.prc_number;
      },
      classOption(id, index) {
        const isSelected = this.selected ? (id == this.selected.prc_number) : false;
        const isFocused = (index == this.focusedOptionIndex);
        return {
          'cursor-pointer w-full border-secondary-100 border-b hover:bg-blue-50': true,
          'bg-blue-100': isSelected,
          'bg-blue-50': isFocused
        };
      },
      filteredOptions() {
        return this.options ?
          this.options.data.filter(option => {
            return (`${option.first_name} ${option.last_name}`.toLowerCase().indexOf(this.duesForm.prc_number) > -1) ||
              (`${option.last_name} ${option.first_name}`.toLowerCase().indexOf(this.duesForm.prc_number) > -1) ||
              (option.prc_number.toLowerCase().indexOf(this.duesForm.prc_number) > -1)
          }) : {}
      },
      onOptionClick(index) {
        this.focusedOptionIndex = index;
        this.selectOption();
      },
      selectOption() {
        if (!this.isOpen()) {
          return;
        }
        this.focusedOptionIndex = this.focusedOptionIndex ?? 0;
        const selected = this.filteredOptions()[this.focusedOptionIndex]
        if (this.selected && this.selected.prc_number == selected.prc_number) {
          this.duesForm.prc_number = '';
          this.selected = null;
        } else {
          this.selected = selected;
          this.duesForm.prc_number = this.selectedName();
        }
        this.close();
      },
      focusPrevOption() {
        if (!this.isOpen()) {
          return;
        }
        const optionsNum = Object.keys(this.filteredOptions()).length - 1;
        if (this.focusedOptionIndex > 0 && this.focusedOptionIndex <= optionsNum) {
          this.focusedOptionIndex--;
        } else if (this.focusedOptionIndex == 0) {
          this.focusedOptionIndex = optionsNum;
        }
      },
      focusNextOption() {
        const optionsNum = Object.keys(this.filteredOptions()).length - 1;
        if (!this.isOpen()) {
          this.open();
        }
        if (this.focusedOptionIndex == null || this.focusedOptionIndex == optionsNum) {
          this.focusedOptionIndex = 0;
        } else if (this.focusedOptionIndex >= 0 && this.focusedOptionIndex < optionsNum) {
          this.focusedOptionIndex++;
        }
      },

      generateYearsBetween: function(startYear = 1980, endYear) {
        const endDate = endYear || new Date().getFullYear() + 1;
        let years = [];
        for (var i = startYear; i <= endDate; i++) {
          years.push(startYear);
          startYear++;
        }
        return years;
      },
    }))
  })
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>