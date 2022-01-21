<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="flex flex-col w-full px-4 lg:px-1" x-data="app()">
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
            <svg class="fill-current text-secondary-300 w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" stroke="currentColor">
              <path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
            </svg>
          </span>
        </li>
        <li class="flex items-center">
          <span aria-current="page">
            Profiles
          </span>
        </li>
      </ol>
    </nav>
  </div>

  <!-- header -->
  <header class="flex flex-col gap-3 mb-10">
    <div class="w-64 flex-shrink-0">
      <span class="text-2xl font-bold">Profiles</span>
    </div>
    <div class="w-full">
      <div class="mt-5">
        <ul class="list-reset flex flex-wrap border-b">
          <li @click="currentTab = 1" class="-mb-px mr-1">
            <a :class="currentTab == 1 ? 'border-l border-t border-r rounded-t' : 'hover:text-primary-500 hover:bg-secondary-100'" class="rounded-t-lg bg-white inline-block py-2 px-4 font-semibold" href="javascript:void(0);">General</a>
          </li>
          <li @click="currentTab = 2" class="-mb-px mr-1">
            <a :class="currentTab == 2 ? 'border-l border-t border-r rounded-t' : 'hover:text-primary-500 hover:bg-secondary-100'" class="rounded-t-lg bg-white inline-block py-2 px-4 font-semibold" href="javascript:void(0);">Import bulk profile</a>
          </li>
          <li @click="currentTab = 3" class="-mb-px mr-1">
            <a :class="currentTab == 3 ? 'border-l border-t border-r rounded-t' : 'hover:text-primary-500 hover:bg-secondary-100'" class="rounded-t-lg bg-white inline-block py-2 px-4 font-semibold" href="javascript:void(0);">Archived profiles</a>
          </li>
        </ul>
      </div>
    </div>
  </header>

  <!-- main content -->
  <main>
    <!--  general tab -->
    <div x-transition x-show="currentTab == 1" class="w-full bg-opacity-50">
      <div class="gap-y-8">
        <!-- filters -->
        <div class="bg-white w-full px-0 mb-3 mt-10 lg:mt-5">
          <nav>
            <div class="flex gap-3">
              <div class="w-full lg:w-auto space-y-2">
                <label for="" class="form-label">Payment status</label>
                <select class="form-input" @change="status = $event.target.value; filterColumnByStatus($event.target.value)" name="" id="">
                  <option value="">All</option>
                  <option value="Complete payment">Complete payment</option>
                  <option value="Incomplete payment">Incomplete payment</option>
                  <option value="Dormant">Dormant</option>
                </select>
              </div>
            </div>
          </nav>
        </div>

        <!-- datatable -->
        <div class="table-container">
          <table id="myTable" style="width: 100%" x-cloak>
            <thead class="border-t border-b">
              <tr>
                <th>ACTION</th>
                <th>SURNAME</th>
                <th>FIRST NAME</th>
                <th>MIDDLE NAME</th>
                <th>PRC #</th>
                <th>EMAIL</th>
                <th>PAYMENT STATUS</th>
                <th>REMARKS</th>
                <th>DCC DUES</th>
                <th>PDA</th>
                <th>BIRTHDATE</th>
                <th>ADDRESS</th>
                <th>CONTACT NUMBER</th>
                <th>GENDER</th>
                <th>FB ACCOUNT NAME</th>
                <th>PRC REGISTRATION DATE</th>
                <th>PRC EXPIRY DATE</th>
                <th>PRACTICE FIELD</th>
                <th>PRACTICE TYPE</th>
                <th>CLINIC NAME</th>
                <th>CLINIC STREET</th>
                <th>CLINIC DISTRICT</th>
                <th>CLINIC CITY</th>
                <th>CLINIC CONTACT</th>
                <th>EMERGENCY PERSON NAME</th>
                <th>EMERGENCY PERSON ADDRESS</th>
                <th>EMERGENCY PERSON CONTACT</th>
                <th>NAME</th>
              </tr>
            </thead>
          </table>
        </div>

        <!-- print DCC dues template -->
        <div class="hidden" id="print_header">
          <div class="flex justify-center gap-5">
            <div style="width: 100px">
              <img width="100%" src="<?php echo URLROOT ?>/img/PDA-DCC.jpg" />
            </div>
            <div>
              <h1 class="text-4xl text-center text-primary-500">DAVAO CITY DENTAL CHAPTER</h1>
              <div class="flex justify-between gap-3 mt-3 text-md">
                <div class="w-1/2">
                  <div class="mx-auto w-60">
                    <div>SECRETARIAT:</div>
                    DAVAO CITY DENTAL CHAPTER BLDG.
                    MAHOGANY ST., PALM VILLAGE
                    DACUDAO AVE. DAVAO CITY
                  </div>
                </div>

                <div class="w-1/2">
                  <div class="mx-auto w-60">
                    CONSTITUENT CHAPTER
                    OF THE
                    PHILIPPINE DENTAL
                    ASSOCIATION
                  </div>
                </div>
              </div>

              <div class="w-full border-b border-black mt-2"></div>
            </div>
          </div>

          <div class="mt-4 flex justify-center text-center">
            <h5>List of Members</h5>
          </div>
        </div>
      </div>
    </div>

    <!--  add profile tab -->
    <div x-transition x-show="currentTab == 2" class="w-full bg-opacity-50">
      <div class="gap-y-8">
        <a href="<?php echo URLROOT ?>/users/downloadTemplates?filename=IMPORT_PROFILES_TEMPLATE.xlsx" class="flex-inline border border-primary-600 text-primary-600 p-2 text-white rounded-md hover:bg-secondary-100">
          Download template
        </a>

        <!-- add profile form -->
        <form @submit.prevent x-ref="profile_file_form" class="mt-10 flex flex-col gap-y-8">

          <!-- import csv -->
          <div x-bind="formGroup">
            <label x-bind="formGroup.formLabel">Import Profiles</label>
            <div x-bind="formGroup.inputContainer">
              <input type="file" x-ref="profile_file" name="profile_file" id="profile_file" class="rounded border border-secondary-300 px-3 py-5 text-secondary-700 w-full focus:ring-primary-500 focus:border-primary-500">

              <div class="w-full text-xs text-secondary-400 font-bold px-2">CHOOSE OR DRAG YOUR SPREADSHEET FILE</div>
              <span class="hidden text-danger-600 text-sm" x-ref="profile_file_err" id="profile_file_err"></span>
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
    </div>

    <!--  archived profiles tab -->
    <div x-transition x-show="currentTab == 3" class="w-full bg-opacity-50">
      <div class="gap-y-8">
        <!-- datatable -->
        <div class="table-container">
          <table id="archivedProfilesTable" style="width: 100%" x-cloak>
            <thead class="border-t border-b">
              <tr class="border-b">
                <th>ACTION</th>
                <th>LAST NAME</th>
                <th>FIRST NAME</th>
                <th>MIDDLE NAME</th>
                <th>PRC #</th>
                <th>EMAIL</th>
                <th>PAYMENT STATUS</th>
                <th>REMARKS</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </main>


  <!-- Edit remarks dialog -->
  <div x-cloak x-ref="modal" x-transition x-show.transition.opacity="openEditRemarksModal" class="overflow-auto fixed z-20 top-0 left-0 w-screen h-screen bg-black bg-opacity-50 flex items-center justify-center" role="dialog" aria-modal="true">
    <div class="w-full h-full lg:h-4/5 max-w-screen-md bg-white rounded-xl shadow-xl flex flex-col absolute divide-y divide-secondary-200">

      <div class="px-5 py-4 flex items-center justify-between bg-gradient-to-r from-primary-400 to-primary-600 rounded-t-lg text-white">
        <h1 class="flex items-center gap-2 text-2xl leading-tight font-bold">
          Edit remarks
        </h1>

        <button class="text-white hover:bg-primary-700 p-2 rounded-full" @click="openEditRemarksModal = false">
          <svg class="w-4 fill-current transition duration-150" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.001 512.001">
            <path d="M284.286 256.002L506.143 34.144c7.811-7.811 7.811-20.475 0-28.285-7.811-7.81-20.475-7.811-28.285 0L256 227.717 34.143 5.859c-7.811-7.811-20.475-7.811-28.285 0-7.81 7.811-7.811 20.475 0 28.285l221.857 221.857L5.858 477.859c-7.811 7.811-7.811 20.475 0 28.285a19.938 19.938 0 0014.143 5.857 19.94 19.94 0 0014.143-5.857L256 284.287l221.857 221.857c3.905 3.905 9.024 5.857 14.143 5.857s10.237-1.952 14.143-5.857c7.811-7.811 7.811-20.475 0-28.285L284.286 256.002z" />
          </svg>
        </button>
      </div>

      <div class="pt-5 pb-10 overflow-auto" id="modal_content">
        <!-- input form -->
        <div class="space-y-4 flex flex-col px-5">
          <label for="remarks" class="form-label">Remarks <span class="text-secondary-500">(optional)</span></label>
          <textarea name="remarks" type="text" x-model="remarks" class="rounded border border-secondary-300 px-3 py-2 text-secondary-700 w-full focus:ring-primary-500 focus:border-primary-500">
            </textarea>
          <span class="hidden text-danger-600" id="remarks_err">
          </span>
        </div>
      </div>

      <div class="flex items-center justify-end px-5 py-4 gap-5">
        <button @click="openEditRemarksModal = false" class="py-3 px-5 rounded bg-secondary-100 border text-secondary-600 font-semibold transition duration-150 hover:bg-secondary-100 hover:text-secondary-900 focus:outline-none">Cancel</button>

        <button @click="submitEditRemarksForm" class="py-3 px-10 rounded disabled:opacity-50 disabled:cursor-wait bg-primary-600 text-white font-semibold transition duration-150 hover:bg-primary-500 focus:outline-none">Update</button>
      </div>
    </div>
  </div>

  <!-- Import status dialog -->
  <div x-cloak x-ref="importSuccessModal" x-transition x-show.transition.opacity="successModalOpen" class="overflow-auto fixed z-20 top-0 left-0 w-screen h-screen bg-black bg-opacity-50 flex items-center justify-center" role="dialog" aria-modal="true">
    <div class="w-full h-full lg:h-4/5 max-w-screen-md bg-white rounded-xl shadow-xl flex flex-col absolute divide-y divide-secondary-200">

      <div class="px-5 py-4 flex items-center justify-between bg-gradient-to-r from-primary-400 to-primary-600 rounded-t-lg text-white">
        <h1 class="flex items-center gap-2 text-2xl leading-tight font-bold" x-ref="import_success_title">

        </h1>

        <button class="text-white hover:bg-primary-700 p-2 rounded-full" @click="successModalOpen = false">
          <svg class="w-4 fill-current transition duration-150" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.001 512.001">
            <path d="M284.286 256.002L506.143 34.144c7.811-7.811 7.811-20.475 0-28.285-7.811-7.81-20.475-7.811-28.285 0L256 227.717 34.143 5.859c-7.811-7.811-20.475-7.811-28.285 0-7.81 7.811-7.811 20.475 0 28.285l221.857 221.857L5.858 477.859c-7.811 7.811-7.811 20.475 0 28.285a19.938 19.938 0 0014.143 5.857 19.94 19.94 0 0014.143-5.857L256 284.287l221.857 221.857c3.905 3.905 9.024 5.857 14.143 5.857s10.237-1.952 14.143-5.857c7.811-7.811 7.811-20.475 0-28.285L284.286 256.002z" />
          </svg>
        </button>
      </div>

      <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
        <div class="flex items-center gap-2 font-bold">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          Reminder
        </div>
        <p class="text-sm">To fulfill your recent unsuccessful import, you have to resolve these following rows in your spreadsheet.</p>
      </div>

      <div class="overflow-y-scroll w-full py-3">
        <table class="w-full">
          <thead>
            <tr x-ref="import_success_table_thead">
              <th>Row no</th>
              <!-- <th>Prc number</th> -->
            </tr>
          </thead>
          <tbody x-ref="import_success_table_rows">
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Success popup -->
  <div x-cloak class="fixed left-0 bottom-0 z-40 " @keydown.window.escape="fixedAlertOpen = false">
    <div x-show="fixedAlertOpen === true" x-ref="fixed_alert" class="fixed left-4 bottom-4 sm:bottom-10 rounded-lg bg-white shadow-2xl w-96 overflow-hidden" style="display: none;" x-transition:enter="transition ease-in duration-200" x-transition:enter-start="opacity-0 transform -translate-x-40" x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform -translate-x-40">
      <div class="">
        <div class="relative overflow-hidden px-6 pt-4">
          <header class="mb-2 flex gap-2 font-bold" :class="fixedAlertIsSuccess ? 'text-success-600' : 'text-danger-600'">
            <svg x-show="fixedAlertIsSuccess" class="w-6 sm:w-5 h-6 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <svg x-show="!fixedAlertIsSuccess" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span x-ref="fixed_alert_label" x-text="fixedAlertIsSuccess ? 'Success' : 'Fail'"></span>
          </header>
          <div class="pb-4 flex gap-2 justify-between items-end">
            <p class="line-clamp-3 text-secondary-800" x-ref="fixed_alert_message">
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
    <button x-show="fixedAlertOpen === false" class="fixed left-4 bottom-10 uppercase text-sm px-4 py-3 bg-secondary-900 rounded-full" :class="fixedAlertIsSuccess ? 'text-success-600' : 'text-danger-600'" @click="fixedAlertOpen = !fixedAlertOpen">
      <svg x-show="fixedAlertIsSuccess" class="w-6 sm:w-5 h-6 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <svg x-show="!fixedAlertIsSuccess" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </button>
  </div>
</div>

<script src="<?php echo URLROOT ?>/vendors/jquery-3.6.0.min.js"></script>
<script src="<?php echo URLROOT ?>/vendors/datatable/datatables.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<!-- <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.3/af-2.3.7/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/cr-1.5.5/date-1.1.1/fc-4.0.1/fh-3.2.0/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.3/sr-1.0.1/datatables.min.js"></script> -->
<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('app', () => ({
      init() {
        const app = this

        $.fn.dataTable.Debounce = function(tables = [], options) {
          if (tables.length == 0) return

          tables.forEach(table => {
            let tableId = table.settings()[0].sTableId;
            $('.dataTables_filter input[aria-controls="' + tableId + '"]')
              .unbind()
              .bind('input', (delay(function(e) {
                table.search($(this).val()).draw();
                return;
              }, 1000)));
          })
        }

        function delay(callback, ms) {
          let timer = 0;
          return function() {
            let context = this,
              args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function() {
              callback.apply(context, args);
            }, ms || 0);
          };
        }
        const dataTable = $('#myTable').DataTable({
          'bStateSave': true,
          'order': [
            [1, 'asc']
          ],
          'dom': 'fBrtilp',
          'lengthMenu': [
            [5, 10, 25, <?php echo MAX_ROW ?>],
            ['5 rows', '10 rows', '25 rows', 'All rows']
          ],
          'pageLength': 5,
          'processing': true,
          'serverSide': true,
          'searchDelay': 350,
          'serverMethod': 'post',
          'ajax': {
            'url': 'profilesDatatable',
            'data': function(data) {
              // Append to data

              data.status = app.status;
              data.includeDeleted = 'hide';
            }
          },
          "language": {
            "processing": 'Please wait...'
          },
          'columns': [{
              data: 'profiles.id',
              class: 'disabled-cols visible-always',
              sortable: false,
              render: function(d, t, r, m) {
                return `
                <div class="flex items-center gap-2">
                  <a href="<?php echo URLROOT ?>/${r.profile_img_path ?? 'img/profiles/default-profile.png'}" target="_blank" class="block rounded-full w-10 h-10 overflow-hidden">
                    <img class="w-full h-full" src="<?php echo URLROOT ?>/${r.thumbnail_img_path ?? 'img/profiles/default-profile.png'}"/>
                  </a>
                  <div class="relative" x-data="{dropDownOpen:false}">
                    <a @click="dropDownOpen = true" href="javascript:void(0)" class="block text-lg text-secondary-500 hover:bg-secondary-200 rounded-full p-1">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                      </svg>
                    </a>
                    <div 
                      class="absolute top-0 left-10 w-64 flex flex-col bg-white shadow-2xl border border-secondary-300 space-y-2 mt-2" 
                      x-show="dropDownOpen" 
                      @click.away="dropDownOpen=false"
                      x-transition:enter-start="transition ease-in duration-3000"
                    >
                      <a href="javascript:void(0)" @click="openEditRemarksModal = true; editRemarksProfileId = '${r['profiles.id']}'; remarks = '${r.status_remarks ?? ''}'" class="flex gap-2 hover:bg-secondary-100 focus:bg-secondary-200 items-center justify-center text-center px-4 py-2" >
                      <img width="20" src="<?php echo URLROOT ?>/img/icons/pencil-alt.svg"/>                    
                      <span>Edit remarks</span>
                      </a>
                      <a href="javascript:void(0)" @click="archiveProfile(${r['profiles.id']});" class="flex gap-2 items-center justify-center text-center px-4 py-2" :class="'${r.deleted_at ? ' bg-success-600 hover:bg-success-700 focus:bg-success-800 text-white ' : ' bg-danger-600 hover:bg-danger-700 focus:bg-danger-800 text-white '}'" >
                      <img width="20" src="<?php echo URLROOT ?>/img/icons${r.deleted_at ? '/refresh.svg' : '/trash.svg'}"/>                    
                      <span>${r.deleted_at ? 'Restore' : 'Archive'}</span>
                      </a>
                    </div>                    
                  </div>
                  <div x-show="${r.deleted_at != null ? true : false}" class="text-danger-600 italic text-sm">Archived</div>
                </div>
                `
              }
            },
            {
              data: 'last_name',
              render: function(d, t, r, m) {
                return `<a href="<?php echo URLROOT ?>/admins/viewAccount?id=${r['profiles.id']}" class="hover:underline hover:text-primary-600 hover:bg-primary-50">${r.last_name}</a>`
              }
            },
            {
              data: 'first_name',
            },
            {
              data: 'middle_name'
            },
            {
              data: 'prc_number',
              sortable: false
            },
            {
              data: 'email',
              sortable: false
            },
            {
              data: 'payment_status',
              sortable: false,
              render: function(d, t, r, m) {
                return `<span class="px-2 py-1 rounded-full whitespace-nowrap" :class="'${r.payment_status}' == 'Dormant' ? 'bg-secondary-100 text-secondary-700' : '${r.payment_status}' == 'Complete Payment' ? 'bg-success-100 text-success-700' : '${r.payment_status}' == 'Incomplete Payment' ? 'bg-danger-100 text-danger-700' : ''">${r.payment_status}</span>`
              }
            },
            {
              data: 'status_remarks',
              sortable: false,
              render: function(d, t, r, m) {
                return r.status_remarks
              }
            },
            {
              data: 'dcc_dues',
              sortable: false,
              visible: false,
              render: function(d, t, r, m) {
                return `<p class="line-clamp-3 hover:line-clamp-none w-40"> ${r.dcc_dues}</p>`
              }
            },
            {
              data: 'pda_dues',
              sortable: false,
              visible: false,
              render: function(d, t, r, m) {
                return `<p class="line-clamp-3 hover:line-clamp-none w-40"> ${r.pda_dues}</p>`
              }
            },
            {
              data: 'birthdate',
              visible: false,
              sortable: false
            },
            {
              data: 'address',
              visible: false,
              sortable: false
            },
            {
              data: 'contact_number',
              visible: false,
              sortable: false
            },
            {
              data: 'gender',
              visible: false,
              sortable: false
            },
            {
              data: 'fb_account_name',
              visible: false,
              sortable: false
            },
            {
              data: 'prc_registration_date',
              visible: false,
              sortable: false
            },
            {
              data: 'prc_expiration_date',
              visible: false,
              sortable: false
            },
            {
              data: 'field_practice',
              visible: false,
              sortable: false
            },
            {
              data: 'type_practice',
              visible: false,
              sortable: false
            },
            {
              data: 'clinic_name',
              visible: false,
              sortable: false,
              sortable: false
            },
            {
              data: 'clinic_street',
              visible: false,
              sortable: false
            },
            {
              data: 'clinic_district',
              visible: false,
              sortable: false
            },
            {
              data: 'clinic_city',
              visible: false,
              sortable: false
            },
            {
              data: 'clinic_contact',
              visible: false,
              sortable: false
            },
            {
              data: 'emergency_person_name',
              visible: false,
              sortable: false
            },
            {
              data: 'emergency_address',
              visible: false,
              sortable: false
            },
            {
              data: 'emergency_contact_number',
              visible: false,
              sortable: false
            },
            {
              data: 'fullname',
              class: 'disabled-cols',
              visible: false,
              sortable: false
            },
          ],
          initComplete: function() {
            const api = this.api();
            api.columns('.hidden-first').visible(false)
            api.draw('page');
          },
          buttons: [{
              extend: 'print',
              text: 'PRINT DCC MEMBERS LIST',
              exportOptions: {
                columns: [27, 4, 8]
              },
              title: '',
              footer: true,
              customize: function(win) {
                $(win.document.body)
                  .css('font-size', '10pt')
                  .prepend($('#print_header').html());

                $(win.document.body).find('table')
                  .addClass('compact')
                  .addClass('border-collapse, border, border-gray-400')
                  .css('font-size', 'inherit');

                $(win.document.body).find('table th, table td')
                  .addClass('border border-black p-2')
                  .css('font-size', '12px')
                  .css('text-align', 'left')
                  .css('max-width', '200px');

                $(win.document.body).find('table th')
                  .addClass('border border-black p-2')
                  .css('font-weight', 'bold')

                $(win.document.body).find('table td')
                  .css('padding-top', '0')
                  .css('padding-bottom', '0')
              },
            },
            {
              text: 'exports',
              extend: 'collection',
              className: 'buttons-excel custom-html-collection',
              buttons: [
                '<header>Export as</header>',
                {
                  extend: 'excel',
                  exportOptions: {
                    columns: ':visible :not(.disabled-cols)'
                  },
                  title: '',
                  customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    var numrows = 2;
                    var clR = $('row', sheet);

                    //update Row
                    clR.each(function() {
                      var attr = $(this).attr('r');
                      var ind = parseInt(attr);
                      ind = ind + numrows;
                      $(this).attr("r", ind);
                    });

                    // Create row before data
                    $('row c ', sheet).each(function(index) {
                      var attr = $(this).attr('r');

                      var pre = attr.substring(0, 1);
                      var ind = parseInt(attr.substring(1, attr.length));
                      ind = ind + numrows;
                      $(this).attr("r", pre + ind);
                    });

                    function Addrow(index, data) {
                      var row = sheet.createElement('row');
                      row.setAttribute("r", index);
                      for (i = 0; i < data.length; i++) {
                        var key = data[i].key;
                        var value = data[i].value;

                        var c = sheet.createElement('c');
                        c.setAttribute("t", "inlineStr");
                        c.setAttribute("s", "2");
                        c.setAttribute("r", key + index);

                        var is = sheet.createElement('is');
                        var t = sheet.createElement('t');
                        var text = sheet.createTextNode(value)

                        t.appendChild(text);
                        is.appendChild(t);
                        c.appendChild(is);

                        row.appendChild(c);
                      }

                      return row;
                    }

                    var r1 = Addrow(1, [{
                      key: 'A',
                      value: 'PDA-DCC MEMBERS\' PROFILES'
                    }]);
                    var r2 = Addrow(2, [{
                      key: 'A',
                      value: ''
                    }]);

                    var sheetData = sheet.getElementsByTagName('sheetData')[0];

                    sheetData.insertBefore(r2, sheetData.childNodes[0]);
                    sheetData.insertBefore(r1, sheetData.childNodes[0]);
                  }
                },
                {
                  extend: 'csv',
                  title: '',
                  exportOptions: {
                    columns: ':visible :not(.disabled-cols)'
                  },
                  customize: function(csv) {
                    return 'PDA-DCC MEMBERS\' PROFILES \n\n' +
                      csv;
                  }
                },
              ]
            },
            {
              text: 'column visibility',
              extend: 'colvis',
              columns: ':not(.disabled-cols)',
              prefixButtons: [{
                  extend: 'colvisRestore',
                },
                {
                  text: "<span>Show all</span>",
                  action: function(e, dt, node, config) {
                    dt.columns().visible(true);

                  }
                },
                {
                  text: "<span>Hide all</span>",
                  action: function(e, dt, node, config) {
                    dt.columns(':not(.visible-always)').visible(false);
                  }
                }
              ],
            },
            {
              text: "<span>Refresh</span>",
              action: function(e, dt, node, config) {
                dt.page.len(5);
                dt.clear().draw();
                dt.ajax.reload(null, false);
              }
            },
          ],
        });

        dataTable.on('preXhr.dt', function() {
          $('#myTable').addClass('text-secondary-200');
        });
        dataTable.on('xhr.dt', function() {
          $('#myTable').removeClass('text-secondary-200');
        });

        this.$watch('openEditRemarksModal', value => {
          if (value === false) {
            this.remarks = ''
            this.editRemarksProfileId = ''
          }
        })

        /* PROFILE FORM */
        this.$watch('fixedAlertOpen', value => {
          let alertTimer;
          clearTimeout(alertTimer)

          if (value === true) {
            alertTimer = setTimeout(() => {
              this.fixedAlertOpen = false
            }, 10000);
          }
        })

        /* ARCHIVE*/
        const archivedDataTable = $('#archivedProfilesTable').DataTable({
          'bStateSave': true,
          'order': [
            [1, 'asc']
          ],
          'dom': 'fBrtilp',
          'lengthMenu': [
            [5, 10, 25, <?php echo MAX_ROW ?>],
            ['5 rows', '10 rows', '25 rows', 'All rows']
          ],
          'pageLength': 5,
          'processing': true,
          'serverSide': true,
          'searchDelay': 350,
          'serverMethod': 'post',
          'ajax': {
            'url': 'profilesDatatable',
            'data': function(data) {
              // Append to data
              data.status = '';
              data.includeDeleted = 'only';
            }
          },
          "language": {
            "processing": 'Please wait...'
          },
          'columns': [{
              data: 'profiles.id',
              class: 'disabled-cols visible-always',
              sortable: false,
              render: function(d, t, r, m) {
                return `
                <div class="flex items-center gap-2">
                  <a href="<?php echo URLROOT ?>/${r.profile_img_path ?? 'img/profiles/default-profile.png'}" target="_blank" class="block rounded-full w-10 h-10 overflow-hidden">
                    <img class="w-full h-full" src="<?php echo URLROOT ?>/${r.thumbnail_img_path ?? 'img/profiles/default-profile.png'}"/>
                  </a>
                  <a href="javascript:void(0)" @click="archiveProfile(${r['profiles.id']});" class="flex gap-2 items-center justify-center text-center p-2 rounded" :class="'${r.deleted_at ? ' bg-success-600 hover:bg-success-700 focus:bg-success-800 text-white ' : ' bg-danger-600 hover:bg-danger-700 focus:bg-danger-800 text-white '}'" >
                      <img width="20" src="<?php echo URLROOT ?>/img/icons/refresh.svg"/>                    
                      <span>Restore</span>
                  </a>
                </div>
                `
              }
            },
            {
              data: 'last_name',
              render: function(d, t, r, m) {
                return `<a href="<?php echo URLROOT ?>/admins/viewAccount?id=${r['profiles.id']}" class="hover:underline hover:text-primary-600 hover:bg-primary-50">${r.last_name}</a>`
              }
            },
            {
              data: 'first_name',
            },
            {
              data: 'middle_name'
            },
            {
              data: 'prc_number',
              sortable: false
            },
            {
              data: 'email',
              sortable: false
            },
            {
              data: 'payment_status',
              sortable: false,
              render: function(d, t, r, m) {
                return `<span class="px-2 py-1 rounded-full whitespace-nowrap" :class="'${r.payment_status}' == 'Dormant' ? 'bg-secondary-100 text-secondary-700' : '${r.payment_status}' == 'Complete Payment' ? 'bg-success-100 text-success-700' : '${r.payment_status}' == 'Incomplete Payment' ? 'bg-danger-100 text-danger-700' : ''">${r.payment_status}</span>`
              }
            },
            {
              data: 'status_remarks',
              sortable: false,
              render: function(d, t, r, m) {
                return r.status_remarks
              }
            },
          ],
          initComplete: function() {
            const api = this.api();
            api.columns('.hidden-first').visible(false)
            api.draw('page');
          },
          buttons: [],
        });
        let debounce = new $.fn.dataTable.Debounce([dataTable, archivedDataTable]);
      },
      currentTab: 1,

      openEditRemarksModal: false,
      remarks: '',
      editRemarksProfileId: '',
      submitEditRemarksForm() {
        fetch('<?php echo URLROOT . "/admins/updateProfileRemarks" ?>', {
            method: "POST",
            body: JSON.stringify({
              profile_id: this.editRemarksProfileId,
              remarks: this.remarks
            }),
            headers: {
              "Content-type": "application/json"
            }
          }).then(data => data.json())
          .then(res => {
            if (res.status == 'ok') {
              this.openEditRemarksModal = false
              $('#myTable').DataTable().draw('page');
            }
          })
      },

      archiveProfile(profileId) {
        fetch('<?php echo URLROOT . "/admins/archiveProfile" ?>', {
            method: "POST",
            body: JSON.stringify({
              profile_id: profileId
            }),
            headers: {
              "Content-type": "application/json"
            }
          }).then(data => data.json())
          .then(res => {
            if (res.status == 'ok') {
              $('#myTable').DataTable().draw('page');
              $('#archivedProfilesTable').DataTable().draw('page');
            }
          })
      },

      status: '',
      filterColumnByStatus(status) {
        let statusColumn = $('#myTable').DataTable().column(2)
        this.status = status

        statusColumn
          .search(this.status ? '^' + this.status + '$' : '', true, false)
          .draw();
      },

      /* PROFILE FORM */
      successModalOpen: false,

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

      importForm: function() {
        let actionText = this.$el.textContent
        this.$el.textContent = 'Please wait...'

        const updateRequest = new FormData();
        updateRequest.append('profile_file', this.$refs.profile_file.files[0])

        fetch('<?php echo URLROOT . "/admins/importProfile" ?>', {
            method: "POST",
            body: updateRequest,
          }).then(data => data.json())
          .then(res => {
            this.$el.textContent = actionText
            this.$el.disabled = false
            this.fixedAlertIsSuccess = false;
            this.fixedAlertWithView = false;

            if (res.status == 'ok') {
              this.$refs.profile_file_form.reset()

              this.fixedAlertOpen = true
              this.fixedAlertIsSuccess = true
              let newArr = []
              res.insertedRows.forEach((item, index) => {
                item.date_posted = dayjs(item.date_posted).year()
                newArr.push(Object.values(item))
              })

              this.$refs.profile_file_err.classList.add('hidden')
              this.$refs.fixed_alert_message.textContent = `You imported ${newArr.length} profile(s)`
            } else {
              this.$refs.profile_file_err.classList.remove('hidden')
              this.fixedAlertOpen = true
              this.fixedAlertIsSuccess = false
              if (res.rows) {
                this.fixedAlertWithView = true
              }
              this.$refs.fixed_alert_message.textContent = `${res.message}`

              this.$refs.profile_file_err.textContent = res.message
              this.$refs.import_success_table_rows.innerHTML = ''
              this.$refs.import_success_table_thead.innerHTML = '<th>Row No.</th>'

              if (res.error_title == 'cell error') {
                this.$refs.import_success_title.textContent = 'List of rows with validation errors'

                const cols = document.createElement('th')
                cols.textContent = 'Column(s)'
                const errs = document.createElement('th')
                errs.textContent = 'Error(s)'
                this.$refs.import_success_table_thead.append(cols)
                this.$refs.import_success_table_thead.append(errs)

                for (const [key, value] of Object.entries(res.rows)) {
                  this.$refs.import_success_table_rows.innerHTML +=
                    `<tr>
                    <td>${value.rowNo}</td>
                    <td>(${value.column.split(',').length}) ${value.column}</td>
                    <td>(${value.status.split(',').length}) ${value.status}</td>
                  </tr>`
                }
              } else {
                if (res.error_title == 'spreadsheet duplicate') {
                  this.$refs.import_success_title.textContent = 'List of rows with duplicate prc number'

                  const cols = document.createElement('th')
                  cols.textContent = 'Column(s)'
                  const errs = document.createElement('th')
                  errs.textContent = 'Error(s)'
                  this.$refs.import_success_table_thead.append(cols)
                  this.$refs.import_success_table_thead.append(errs)

                  res.rows.forEach((item, index) => {
                    this.$refs.import_success_table_rows.innerHTML +=
                      `<tr>
                    <td>${item.rowNo}</td>
                    <td>PRC No.</td>
                    <td>Duplicate PRC No.</td>
                  </tr>`
                  })
                }
                if (res.error_title == 'database duplicate') {
                  this.$refs.import_success_title.textContent = 'List of rows with already taken prc numbers'

                  const cols = document.createElement('th')
                  cols.textContent = 'Column(s)'
                  const errs = document.createElement('th')
                  errs.textContent = 'Error(s)'
                  this.$refs.import_success_table_thead.append(cols)
                  this.$refs.import_success_table_thead.append(errs)

                  for (const [key, value] of Object.entries(res.rows)) {
                    this.$refs.import_success_table_rows.innerHTML +=
                      `<tr>
                    <td>${key}</td>
                    <td>PRC No.</td>
                    <td>Already taken PRC No.</td>
                  </tr>`
                  }
                }
              }
            }

            $('#myTable').DataTable().draw();
          })
      },
      fixedAlertOpen: '',
      fixedAlertIsSuccess: false,
      fixedAlertWithView: false,
    }))

  })
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>