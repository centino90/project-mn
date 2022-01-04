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
              Add profile
            </span>
          </li>
        </ol>
      </nav>
    </div>

    <header class="flex flex-wrap items-center justify-between gap-3 mb-10">
      <div class="flex-shrink-0">
        <span class="text-2xl font-bold">Add profile</span>
      </div>

      <div class="flex gap-3">
        <a href="<?php echo URLROOT ?>/users/downloadTemplates?filename=IMPORT_PROFILES_TEMPLATE.xlsx" class="flex border border-primary-600 text-primary-600 p-2 text-white rounded-md hover:bg-secondary-100">
          Download template
        </a>
      </div>
    </header>

    <div class="flex flex-col gap-y-8">

      <!-- import csv -->
      <div x-bind="formGroup">
        <label x-bind="formGroup.formLabel">Import Profiles</label>
        <div x-bind="formGroup.inputContainer">
          <input type="file" name="profile_file" id="profile_file" class="rounded border border-secondary-300 px-3 py-5 text-secondary-700 w-full focus:ring-primary-500 focus:border-primary-500">

          <div class="w-full text-xs text-secondary-400 font-bold px-2">CHOOSE OR DRAG YOUR CSV FILE</div>
          <span class="hidden text-danger-600 text-sm" id="profile_file_err"></span>
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
    </div>
  </div>
</div>

<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('app', () => ({
      init() {},
      onEditMode: true,
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

      importForm: function() {
        let actionText = this.$el.textContent
        this.$el.textContent = 'Please wait...'

        this.performImportRequest().then(data => data.json())
          .then(res => {
            this.$el.textContent = actionText
            this.$el.disabled = false
            console.log(res)
            // document.querySelector('#profile_file_form').reset()

            if (res.status == 'ok') {
              window.location.reload()
            } else {
              const profile_file_err = document.querySelector('#profile_file_err')

              profile_file_err.classList.remove('hidden')

              profile_file_err.textContent = res.message
            }
          })
      },
      performImportRequest: async function() {
        const updateRequest = new FormData();
        updateRequest.append('profile_file', document.querySelector('#profile_file').files[0])

        return await fetch('<?php echo URLROOT . "/admins/importProfile" ?>', {
          method: "POST",
          body: updateRequest,
        })
      },

      submitForm: function() {
        let actionText = this.$el.textContent
        this.$el.textContent = 'Please wait...'

        this.performRequest().then(data => data.json())
          .then(res => {
            this.$el.textContent = actionText
            this.$el.disabled = false
            console.log(res)

            if (res.status == 'ok') {
              // window.location.reload()
            } else {
              const profile_file_err = document.querySelector('#profile_file_err')

              profile_file_err.classList.remove('hidden')

              profile_file_err.textContent = res.errors.profile_file_err
            }
          })
      },
      performRequest: async function() {
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
    }))
  })
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>