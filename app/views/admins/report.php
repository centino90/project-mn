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
            Report
          </span>
        </li>
      </ol>
    </nav>
  </div>

  <header class="flex flex-wrap items-center justify-between gap-3 mb-10">
    <div class="w-64 flex-shrink-0">
      <span class="text-2xl font-bold">Report</span>
    </div>
    <div class="flex gap-3">
      <a href="<?php echo URLROOT ?>/users/downloadTemplates?filename=IMPORT_PAYMENTS_TEMPLATE.xlsx" class="flex border border-primary-600 text-primary-600 p-2 text-white rounded-md hover:bg-secondary-100">
        Download template
      </a>

      <button type="button" @click="paymentModalOpen = true" class="flex bg-primary-500 p-2 text-white rounded-md hover:bg-primary-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
        Add payments
      </button>
    </div>
  </header>

  <!-- Payment modal dialog -->
  <div x-cloak x-ref="modal" x-transition x-show.transition.opacity="paymentModalOpen" class="overflow-auto fixed z-20 top-0 left-0 w-screen h-screen bg-black bg-opacity-50 flex items-center justify-center" role="dialog" aria-modal="true">
    <div class="w-full max-w-screen-md bg-white rounded-xl shadow-xl flex flex-col absolute divide-y divide-secondary-200">

      <div class="px-5 py-4 flex items-center justify-between">
        <h2 class="text-xl leading-tight text-secondary-700">
          Add payments
        </h2>

        <button class="text-secondary-400 hover:text-secondary-600" @click="paymentModalOpen = false">
          <svg class="w-4 fill-current transition duration-150" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.001 512.001">
            <path d="M284.286 256.002L506.143 34.144c7.811-7.811 7.811-20.475 0-28.285-7.811-7.81-20.475-7.811-28.285 0L256 227.717 34.143 5.859c-7.811-7.811-20.475-7.811-28.285 0-7.81 7.811-7.811 20.475 0 28.285l221.857 221.857L5.858 477.859c-7.811 7.811-7.811 20.475 0 28.285a19.938 19.938 0 0014.143 5.857 19.94 19.94 0 0014.143-5.857L256 284.287l221.857 221.857c3.905 3.905 9.024 5.857 14.143 5.857s10.237-1.952 14.143-5.857c7.811-7.811 7.811-20.475 0-28.285L284.286 256.002z" />
          </svg>
        </button>
      </div>

      <div class="pb-5 pb-5 mb-5 overflow-auto" id="modal_content" style="min-height: 300px; max-height: 300px">
        <div class="z-10 px-5 w-full py-2 bg-secondary-50 shadow-sm">
          <button x-text="!importOpen ? 'Import records' : 'Input form'" @click="importOpen = !importOpen;" class="shadow block bg-white ml-auto text-primary-600 p-2 rounded-md hover:bg-secondary-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
          </button>
        </div>

        <!-- input form -->
        <div x-show="!importOpen" class="space-y-4 flex flex-col px-5">
          <div class="w-full rounded-lg" x-show="openAlertBox" x-transition>
            <div class="py-4">
              <div class="flex items-center text-white text-sm font-bold px-4 py-3 rounded shadow-md" :class="alertBackgroundColor" role="alert">
                <span x-html="alertMessage" class="flex"></span>
              </div>
            </div>
          </div>

          <div x-data="{specifyDate: false}">
            <a x-show="!specifyDate" @click="specifyDate = true" class="text-primary-500 hover:underline" href="javascript:void(0);">Specify date?</a>
            <div x-show="specifyDate">
              <label for="amount" class="form-label">Date (MM/DD/YYYY)</label>
              <input name="date" x-ref="payment_date" type="date" x-model="paymentForm.date" class="my-3 rounded border border-secondary-300 px-3 py-2 text-secondary-700 w-full focus:ring-primary-500 focus:border-primary-500">
              <span class="hidden text-danger-600" id="date_err">
              </span>
            </div>
          </div>

          <label for="user_id" class="form-label">PRC No.</label>
          <div class="w-full flex flex-col items-center">
            <div @click.outside="close()" class="w-full">
              <div class="flex flex-col items-center relative z-0">
                <div class="w-full">
                  <div class="mb-2 p-1 bg-white flex border border-secondary-200 rounded">
                    <input name="user_id" x-model="paymentForm.user_id" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @mousedown="open()" @keydown.enter.stop.prevent="selectOption()" @keydown.arrow-up.prevent="focusPrevOption()" @keydown.arrow-down.prevent="focusNextOption()" placeholder="Search for user" autocomplete="off" class="p-1 px-2 appearance-none outline-none w-full text-secondary-800">
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
                              <img class="rounded-full" alt="A" x-bind:src="option.profile_img_path ? `<?php echo URLROOT . '/' ?>${option.profile_img_path}` : '<?php echo URLROOT . '/public/img/profiles/default-profile.png' ?>'">
                            </div>
                          </div>
                          <div class="w-full items-center flex">
                            <div class="mx-2 -mt-1"><span x-text="option.first_name + ' ' + option.last_name"></span>
                              <div class="text-xs truncate w-full normal-case font-normal -mt-1 text-secondary-500" x-text="option.email + ' / ' + option.prc_number"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </template>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <span class="hidden text-danger-600" id="user_id_err">
          </span>

          <label for="type" class="form-label">Type</label>
          <select name="type" x-model="paymentForm.type" class="rounded border border-secondary-300 px-3 py-2 text-secondary-700 w-full focus:ring-primary-500 focus:border-primary-500">
            <option value="">Select Type</option>
            <option value="PDA">PDA</option>
            <option value="DCC">DCC</option>
          </select>
          <span class="hidden text-danger-600" id="type_err">
          </span>

          <label for="amount" class="form-label">Amount</label>
          <input name="amount" type="number" x-model="paymentForm.amount" class="rounded border border-secondary-300 px-3 py-2 text-secondary-700 w-full focus:ring-primary-500 focus:border-primary-500" placeholder="amount">
          <span class="hidden text-danger-600" id="amount_err">
          </span>

          <label for="channel" class="form-label">Payment option</label>
          <input name="channel" type="text" x-model="paymentForm.channel" class="rounded border border-secondary-300 px-3 py-2 text-secondary-700 w-full focus:ring-primary-500 focus:border-primary-500" placeholder="payment option (e.g. gcash, paypal, DCC office, etc.)">
          <span class="hidden text-danger-600" id="channel_err">
          </span>

          <label for="or_number" class="form-label">OR No.</label>
          <input name="or_number" type="text" x-model="paymentForm.or_number" class="rounded border border-secondary-300 px-3 py-2 text-secondary-700 w-full focus:ring-primary-500 focus:border-primary-500" placeholder="OR no.">
          <span class="hidden text-danger-600" id="or_number_err">
          </span>

          <label for="remarks" class="form-label">Remarks</label>
          <textarea name="remarks" type="text" x-model="paymentForm.remarks" class="rounded border border-secondary-300 px-3 py-2 text-secondary-700 w-full focus:ring-primary-500 focus:border-primary-500">
          </textarea>
          <span class="hidden text-danger-600" id="remarks_err">
          </span>
        </div>

        <!-- import csv -->
        <div x-show="importOpen" class=" space-y-4 flex flex-col px-5">
          <div class="w-full rounded-lg" x-show="openAlertBox" x-transition>
            <div class="py-4">
              <div class="flex items-center text-white text-sm font-bold px-4 py-3 rounded shadow-md" :class="alertBackgroundColor" role="alert">
                <span x-html="alertMessage" class="flex"></span>
              </div>
            </div>
          </div>

          <form id="import_payments_form" action="" method="post">
            <label for="imported_payments" class="form-label">Import csv</label>
            <input type="file" name="imported_payments" id="imported_payments" class="rounded border border-secondary-300 px-3 py-5 text-secondary-700 w-full focus:ring-primary-500 focus:border-primary-500">

            <div class="text-center text-xs text-secondary-400 font-bold p-2">CHOOSE OR DRAG YOUR CSV FILE</div>
          </form>

        </div>

      </div>

      <!-- items-center justify-end px-5 py-4  -->
      <div class="flex">
        <button @click="paymentModalOpen = false" class="w-full p=4 rounded-bl-xl text-secondary-600 font-semibold transition duration-150 hover:bg-secondary-100 hover:text-secondary-900 focus:outline-none">Cancel</button>

        <button x-show="!importOpen" @click="submitForm" class="w-full p-4 rounded-br-xl disabled:opacity-50 disabled:cursor-wait bg-primary-600 text-white font-semibold transition duration-150 hover:bg-primary-500 focus:outline-none">Submit</button>
        <button x-show="importOpen" @click="importForm" class="w-full p-4 rounded-br-xl disabled:opacity-50 disabled:cursor-wait bg-primary-600 text-white font-semibold transition duration-150 hover:bg-primary-500 focus:outline-none">Import</button>
      </div>

    </div>


  </div>

  <div class="gap-y-8">
    <div class="mb-3">
      <h1 class="text-lg font-bold text-secondary-500">Main Filters</h1>
    </div>

    <div class="shadow p-3 flex flex-wrap justify-center items-end lg:justify-start gap-4 mb-4">
      <!-- Start month and year -->
      <div class="rounded-md">
        <label class="form-label">Start month and yr.</label>
        <div class="flex">
          <div class="flex">
            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-secondary-300 bg-secondary-50 text-secondary-500 text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
              </svg>
            </span>

            <select name="start_month" x-model="startMonth" id="start_month" class="focus:ring-primary-500 focus:border-primary-500 flex-1 block w-full rounded-none sm:text-sm border-secondary-300 border-r-0">
              <option value="1" :selected="1 == afterDrawStartMonth">January</option>
              <option value="2" :selected="2 == afterDrawStartMonth">February</option>
              <option value="3" :selected="3 == afterDrawStartMonth">March</option>
              <option value="4" :selected="4 == afterDrawStartMonth">April</option>
              <option value="5" :selected="5 == afterDrawStartMonth">May</option>
              <option value="6" :selected="6 == afterDrawStartMonth">June</option>
              <option value="7" :selected="7 == afterDrawStartMonth">July</option>
              <option value="8" :selected="8 == afterDrawStartMonth">August</option>
              <option value="9" :selected="9 == afterDrawStartMonth">September</option>
              <option value="10" :selected="10 == afterDrawStartMonth">October</option>
              <option value="11" :selected="11 == afterDrawStartMonth">November</option>
              <option value="12" :selected="12 == afterDrawStartMonth">December</option>
            </select>
          </div>

          <select name="start_year" x-model="startYear" id="start_year" class="focus:ring-primary-500 focus:border-primary-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-secondary-300">
            <template x-for="(date, index) in dates.slice(1, -1)" :key="index">
              <option :value="date" x-text="date" :selected="index == 0"></option>
            </template>
          </select>
        </div>
      </div>

      <!-- End month and year -->
      <div class="rounded-md">
        <label class="form-label">End month and yr.</label>
        <div class="flex">
          <div class="flex">
            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-secondary-300 bg-secondary-50 text-secondary-500 text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </span>

            <select name="end_month" x-model="endMonth" id="end_month" class="focus:ring-primary-500 focus:border-primary-500 flex-1 block w-full rounded-none sm:text-sm border-secondary-300 border-r-0">
              <option value="1" :selected="1 == afterDrawEndMonth">January</option>
              <option value="2" :selected="2 == afterDrawEndMonth">February</option>
              <option value="3" :selected="3 == afterDrawEndMonth">March</option>
              <option value="4" :selected="4 == afterDrawEndMonth">April</option>
              <option value="5" :selected="5 == afterDrawEndMonth">May</option>
              <option value="6" :selected="6 == afterDrawEndMonth">June</option>
              <option value="7" :selected="7 == afterDrawEndMonth">July</option>
              <option value="8" :selected="8 == afterDrawEndMonth">August</option>
              <option value="9" :selected="9 == afterDrawEndMonth">September</option>
              <option value="10" :selected="10 == afterDrawEndMonth">October</option>
              <option value="11" :selected="11 == afterDrawEndMonth">November</option>
              <option value="12" :selected="12 == afterDrawEndMonth">December</option>
            </select>
          </div>

          <select name="end_year" x-model="endYear" id="end_year" class="focus:ring-primary-500 focus:border-primary-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-secondary-300">
            <template x-for="(date, index) in resetEndYearsFromStartYear(startYear)" :key="index">
              <option :value="date" x-text="date" :selected="index == 0"></option>
            </template>
          </select>
        </div>
      </div>

      <!-- Filter button -->
      <!-- @click="getPaymentsBetweenYears()" -->
      <button type="button" id="report_filter" class="form-btn gap-2 bg-primary-500 text-white px-3 py-2 text-sm tracking-wide">
        Filter
      </button>
    </div>

    <div class="bg-white w-full px-0 mb-3 mt-10 lg:mt-5">
      <div class="mb-3">
        <h1 class="text-lg font-bold text-secondary-500">Sub Filters</h1>
      </div>

      <nav class="shadow-sm p-3">
        <div class="flex gap-3">
          <div class="w-full lg:w-auto">
            <label for="" class="form-label">Member Type</label>
            <select class="form-input" x-model="dt_member_type">
              <option value="">Select type</option>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>

          <div class="w-full lg:w-auto">
            <label for="" class="form-label">Payment Type</label>
            <select class="form-input" x-model="dt_payment_type">
              <option value="">Select type</option>
              <option value="PDA">PDA</option>
              <option value="DCC">DCC</option>
            </select>
          </div>
        </div>
      </nav>
    </div>

    <div class="table-container">
      <table id="myTable" style="width: 100%">
        <caption class="text-right px-5 py-3 text-sm text-secondary-500">
          <span id="cap_start_year" x-text="`Selected start month and year: ${startDateString}`"> </span>
          <br>
          <span id="cap_end_year" x-text="`Selected end month and year: ${endDateString}`"></span>
          <br>
          <span id="cap_member_type" x-text="!dt_member_type ? 'Member type: none' : `Member type: ${dt_member_type}`"></span>
        </caption>
        <thead class="border-t border-b">
          <tr>
            <th scope="col">
              Date
            </th>
            <th scope="col">
              Member
            </th>
            <th scope="col">
              Paid amount
            </th>
            <th scope="col">
              Member type
            </th>
            <th scope="col">
              Payment type
            </th>
            <th scope="col" class="hidden-first">
              Channel
            </th>
            <th scope="col" class="hidden-first">
              OR No.
            </th>
          </tr>
        </thead>
        <tfoot>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
        </tfoot>
      </table>
    </div>
  </div>
</div>

<!-- <script src="<?php echo URLROOT ?>/public/vendors/jquery-3.6.0.min.js"></script>
<script src="<?php echo URLROOT ?>/public/vendors/datatables.min.js"></script>
<script defer src="<?php echo URLROOT ?>/public/vendors/FixedColumns-4.0.1/js/dataTables.fixedColumns.min.js"></script>
<script defer src="<?php echo URLROOT ?>/public/vendors/Buttons-2.1.1/js/buttons.dataTables.min.js"></script>
<script defer src="<?php echo URLROOT ?>/public/vendors/JSZip-2.5.0/jszip.min.js"></script>
<script defer src="<?php echo URLROOT ?>/public/vendors/Buttons-2.1.1/js/buttons.colVis.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.3/af-2.3.7/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/cr-1.5.5/date-1.1.1/fc-4.0.1/fh-3.2.0/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.3/sr-1.0.1/datatables.min.js"></script>
<script>
  document.addEventListener('alpine:init', () => {

    Alpine.data('app', () => ({
      init() {
        const app = this
        // select component 2
        fetch("<?php echo URLROOT . '/profiles/fetchUserProfile' ?>")
          .then(response => response.json())
          .then(data => {
            if (data.status == 'ok') {
              this.options = data
            }
          });

        // jquery datatable
        const dataTable = $('#myTable').DataTable({
          "order": [
            [0, "desc"]
          ],
          "bLengthChange": false,
          'processing': true,
          'serverSide': true,
          'serverMethod': 'post',
          'ajax': {
            'url': 'reportsDatatable',
            'data': function(data) {
              // Append to data
              data.startMonth = app.startMonth;
              data.endMonth = app.endMonth;
              data.startYear = app.startYear;
              data.endYear = app.endYear;
              data.memberType = app.dt_member_type;
              data.paymentType = app.dt_payment_type;
            }
          },
          drawCallback: function(settings) {
            app.writeToFooterColumn(0, 'Payment Summary', 'text')
            app.writeToFooterColumn(2, app.calculateTotalAmount(2), 'currency')

            app.afterDrawStartMonth = app.startMonth
            app.afterDrawStartYear = app.startYear
            app.afterDrawEndMonth = app.endMonth
            app.afterDrawEndYear = app.endYear

            app.startDateString = `${dayjs().month(app.startMonth - 1).format('MMMM')} ${app.startYear}`
            app.endDateString = `${dayjs().month(app.endMonth - 1).format('MMMM')} ${app.endYear}`
          },
          'columns': [{
              data: 'date_created',
              render: function(d, t, r, m) {
                return `<span class="text-secondary-500">${r.date_created}</span>`
              }
            },
            {
              data: 'first_name',
              render: function(d, t, r, m) {
                return `<a href="viewAccount/?id=${r.user_id}" class="font-medium hover:underline hover:text-primary-600 hover:bg-primary-50" class="text-danger-500">
                  ${d} </a>`;
              }
            },
            {
              data: 'amount',
              render: function(d, t, r, m) {
                return `<span class="font-mono">${parseInt(r.amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")}</span>`;
              }
            },
            {
              data: 'is_active',
              render: function(d, t, r, m) {
                return `<span :class="'${r.is_active}' == 'active' ? 'bg-success-100 text-success-700' : 'bg-secondary-100 text-secondary-500'" class="rounded-lg px-2">${r.is_active}</span>`;
              }
            },
            {
              data: 'type',
              render: function(d, t, r, m) {
                return `<span class="uppercase">${r.type}</span>`
              }
            },
            {
              data: 'channel',
              render: function(d, t, r, m) {
                return `<span class="text-secondary-600">${r.channel}</span>`
              }
            },
            {
              data: 'or_number',
              render: function(d, t, r, m) {
                return `<span class="text-secondary-600">${r.or_number}</span>`
              }
            }
          ],

          initComplete: function() {
            this.api().columns('.hidden-first').visible(false)
          },
          dom: 'Bfrtip',
          buttons: [{
              text: 'exports',
              extend: 'collection',
              className: 'custom-html-collection border-primary-600',
              buttons: [
                '<header>Export to</header>',
                {
                  extend: 'csvHtml5',
                  exportOptions: {
                    columns: ':visible'
                  },
                  title: '',
                  footer: true,
                  customize: function(csv) {
                    return $('#cap_start_year').text() + "\n" +
                      $('#cap_end_year').text() + "\n" +
                      $('#cap_member_type').text() + "\n\n" +
                      csv;
                  }
                },
                {
                  extend: 'excelHtml5',
                  title: '',
                  exportOptions: {
                    columns: ':visible'
                  },
                  messageTop: '',
                  messageBottom: '',
                  footer: true,
                  customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    var numrows = 4;
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
                      value: $('#myTable #cap_start_year').text()
                    }]);
                    var r2 = Addrow(2, [{
                      key: 'A',
                      value: $('#myTable #cap_end_year').text()
                    }]);
                    var r3 = Addrow(3, [{
                      key: 'A',
                      value: $('#myTable #cap_member_type').text()
                    }]);
                    var r4 = Addrow(4, [{
                      key: 'A',
                      value: ''
                    }]);

                    var sheetData = sheet.getElementsByTagName('sheetData')[0];

                    sheetData.insertBefore(r4, sheetData.childNodes[0]);
                    sheetData.insertBefore(r3, sheetData.childNodes[0]);
                    sheetData.insertBefore(r2, sheetData.childNodes[0]);
                    sheetData.insertBefore(r1, sheetData.childNodes[0]);
                  }
                },
              ]
            },
            {
              text: 'column visibility',
              extend: 'colvis'
            }
          ],
        });

        $('#report_filter').click(function() {
          dataTable.draw();
        });

        this.$watch('dt_member_type', (value) => {
          dataTable.draw();
          $('#myTable #cap_member_type').text(
            `Member type: ${value == '' ? 'none' : value}`
          )
        });
        this.$watch('dt_payment_type', (value) => {
          dataTable.draw();
        });

        this.$watch('startDateString', (value) => {
          $('#myTable #cap_start_year').text(
            `Selected start month and year: ${value}`
          )
        });
        this.$watch('endDateString', (value) => {
          $('#myTable #cap_end_year').text(
            `Selected start month and year: ${value}`
          )
        });

        this.$watch('paymentModalOpen', value => {
          const body = document.body;
          if (!this.paymentModalOpen) {
            body.classList.remove('h-screen');
            return body.classList.remove('overflow-hidden');
          } else {
            body.classList.add('h-screen');
            return body.classList.add('overflow-hidden');
          }
        });

        // alertbox
        this.$watch('openAlertBox', value => {
          if (value) {
            let timeout = window.setTimeout(() => {
              this.openAlertBox = false
            }, 10000)
          }
        });

        this.startYear = this.startYear == '' ? '2021' : this.startYear;
        this.endYear = this.endYear == '' ? '2022' : this.endYear;
      },
      dt_member_type: '',
      dt_payment_type: '',

      // Add payment modal form
      importOpen: false,
      paymentModalOpen: false,
      paymentForm: {
        user_id: '',
        type: '',
        amount: '',
        channel: '',
        or_number: '',
        remarks: '',
        date: dayjs().format('YYYY-MM-DD')
      },
      submitForm: function() {
        let actionText = this.$el.textContent
        this.$el.textContent = 'Please wait...'

        this.sendPaymentForm().then(data => data.json())
          .then(res => {
            this.$el.textContent = actionText
            this.$el.disabled = false

            if (res.status == 'ok') {
              window.location.reload()
            } else {
              this.defaultDangerMessage = res.message
              this.showAlert('danger')

              const user_id_err = document.querySelector('#user_id_err')
              const type_err = document.querySelector('#type_err')
              const amount_err = document.querySelector('#amount_err')
              const channel_err = document.querySelector('#channel_err')
              const or_number_err = document.querySelector('#or_number_err')
              const date_err = document.querySelector('#date_err')

              user_id_err.classList.remove('hidden')
              type_err.classList.remove('hidden')
              amount_err.classList.remove('hidden')
              channel_err.classList.remove('hidden')
              or_number_err.classList.remove('hidden')
              date_err.classList.remove('hidden')

              user_id_err.textContent = res.errors.user_id_err
              type_err.textContent = res.errors.type_err
              amount_err.textContent = res.errors.amount_err
              channel_err.textContent = res.errors.channel_err
              or_number_err.textContent = res.errors.or_number_err
              date_err.textContent = res.errors.date_err
            }

            document.querySelector('#modal_content').scrollTo({
              top: 0,
              behavior: 'smooth'
            });
          })
      },
      importForm: function() {
        let actionText = this.$el.textContent
        this.$el.textContent = 'Please wait...'

        this.importPaymentForm().then(data => data.json())
          .then(res => {
            this.$el.textContent = actionText
            this.$el.disabled = false
            document.querySelector('#import_payments_form').reset()

            if (res.status == 'ok') {
              window.location.reload()
            } else {
              this.defaultDangerMessage = res.message
              this.showAlert('danger')
            }
          })
      },
      sendPaymentForm: async function() {
        return await fetch('<?php echo URLROOT . "/admins/addPayment" ?>', {
          method: "POST",
          body: JSON.stringify({
            paymentForm: this.paymentForm
          }),
          headers: {
            "Content-type": "application/json"
          }
        })
      },
      importPaymentForm: async function() {
        const updateRequest = new FormData();
        updateRequest.append('imported_payments', document.querySelector('#imported_payments').files[0])

        return await fetch('<?php echo URLROOT . "/admins/importPayment" ?>', {
          method: "POST",
          body: updateRequest,
        })
      },
      // search input component
      show: false,
      selected: null,
      focusedOptionIndex: null,
      options: null,
      close() {
        this.show = false;
        this.paymentForm.user_id = this.selectedName();
        this.focusedOptionIndex = this.selected ? this.focusedOptionIndex : null;
      },
      open() {
        this.show = true;
        this.paymentForm.user_id = '';
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
        return this.selected ? this.selected.prc_number : this.paymentForm.user_id;
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
            return (option.first_name.toLowerCase().indexOf(this.paymentForm.user_id) > -1) ||
              (option.last_name.toLowerCase().indexOf(this.paymentForm.user_id) > -1) ||
              (option.email.toLowerCase().indexOf(this.paymentForm.user_id) > -1) ||
              (option.prc_number.toLowerCase().indexOf(this.paymentForm.user_id) > -1)
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
          this.paymentForm.user_id = '';
          this.selected = null;
        } else {
          this.selected = selected;
          this.paymentForm.user_id = this.selectedName();
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

      // Alert notification
      openAlertBox: false,
      alertBackgroundColor: '',
      alertMessage: '',
      showAlert(type) {
        this.openAlertBox = true
        switch (type) {
          case 'success':
            this.alertBackgroundColor = 'bg-success-500'
            this.alertMessage = `${this.successIcon} ${this.defaultSuccessMessage}`
            break
          case 'info':
            this.alertBackgroundColor = 'bg-blue-500'
            this.alertMessage = `${this.infoIcon} ${this.defaultInfoMessage}`
            break
          case 'warning':
            this.alertBackgroundColor = 'bg-warning-500'
            this.alertMessage = `${this.warningIcon} ${this.defaultWarningMessage}`
            break
          case 'danger':
            this.alertBackgroundColor = 'bg-danger-500'
            this.alertMessage = `${this.dangerIcon} ${this.defaultDangerMessage}`
            break
        }
        this.openAlertBox = true
      },
      successIcon: `<svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 mr-2 text-white"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`,
      infoIcon: `<svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 mr-2 text-white"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`,
      warningIcon: `<svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 mr-2 text-white"><path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`,
      dangerIcon: `<svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 mr-2 text-white"><path d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>`,
      defaultInfoMessage: `This alert contains info message.`,
      defaultSuccessMessage: `This alert contains success message.`,
      defaultWarningMessage: `This alert contains warning message.`,
      defaultDangerMessage: `This alert contains danger message.`,

      // payments (need fix)
      calculateTotalAmount(colIndex) {
        let amountColumn = $('#myTable').DataTable().column(colIndex)
        let rows = $('#myTable').DataTable().rows({
          search: 'applied'
        })

        let rowData = rows.data().toArray()

        return rowData.reduce((acc, cur) => {
          let amount = 0
          let colString = cur.amount

          if (typeof(colString) == 'string') {
            colString = colString.split(',')
            amount = colString.reduce((acc, cur) => {
              return acc + parseInt(cur)
            }, 0)
          }

          if (isNaN(amount)) return 0

          return acc + amount
        }, 0)
      },
      writeToFooterColumn(colIndex, value, type) {
        let amountColumn = $('#myTable').DataTable().column(colIndex);

        if (type === 'currency') {
          $(amountColumn.footer()).addClass(
            'bg-secondary-50'
          )
          $(amountColumn.footer()).text(
            `₱ ${this.formatToCurrency(value)}`
          )
          return
        }

        $(amountColumn.footer()).text(value)
      },
      formatToCurrency(amount) {
        return amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")
      },

      startDateString: `${dayjs().format('MMMM')} ${dayjs().year()}`,
      endDateString: `${dayjs().format('MMMM')} ${dayjs().add(1, 'year').year()}`,
      afterDrawStartMonth: dayjs().month() + 1,
      afterDrawEndMonth: dayjs().month() + 1,
      afterDrawStartYear: dayjs().year(),
      afterDrawEndYear: dayjs().add(1, 'year').year(),
      startMonth: dayjs().month() + 1,
      endMonth: dayjs().month() + 1,
      startYear: dayjs().year(),
      endYear: dayjs().add(1, 'year').year(),
      dates: <?php echo json_encode($data['dates']); ?>,
      generateYearsBetween: function(startYear = 1980, endYear) {
        const endDate = endYear || new Date().getFullYear() + 1;
        let years = [];
        for (var i = startYear; i <= endDate; i++) {
          years.push(startYear);
          startYear++;
        }
        return years;
      },
      resetEndYearsFromStartYear: function(startYear) {
        return this.dates.filter((value, index, arr) => {
          return value > startYear
        })
      },
      type: '',

      // getPaymentsBetweenYears: function() {
      //   const updateRequest = new FormData();
      //   console.log(this.startMonth, this.startYear)
      //   console.log(this.endMonth, this.endYear)
      //   updateRequest.append('startMonth', this.startMonth);
      //   updateRequest.append('startYear', this.startYear);
      //   updateRequest.append('endMonth', this.endMonth);
      //   updateRequest.append('endYear', this.endYear);

      //   const dataTable = $('#myTable').DataTable();
      //   const tableEmptyRow = $(dataTable.table().container()).find('.dataTables_empty');

      //   // remove rows and set loading cues
      //   dataTable.rows().remove()
      //   tableEmptyRow.textContent = 'Please wait...'
      //   this.$el.textContent = 'Please wait...'

      //   // send start and end year then retrieve payments summary data 
      //   const response = fetch('<?php echo URLROOT . "/admins/filterData" ?>', {
      //       method: 'POST',
      //       body: updateRequest
      //     })
      //     .then((response) => response.json())
      //     .then((res) => {
      //       // remove loading cues
      //       this.$el.textContent = 'Filter'
      //       tableEmptyRow.textContent = 'Sorry, we found no records.'

      //       // load new rows on datatable
      //       let data = $(res.data)
      //       data.each(function(index, row) {
      //         if (row.is_active == 'active') {
      //           dataTable.rows.add([
      //             [row.date_created, `${row.last_name}, ${row.first_name} ${row.middle_name}.`, row.amount, `<span class="rounded-lg px-2 bg-success-100 text-success-600">${row.is_active}</span>`, row.type, row.channel, row.or_number]
      //           ])
      //         } else {
      //           dataTable.rows.add([
      //             [row.date_created, `${row.last_name}, ${row.first_name} ${row.middle_name}.`, row.amount, `<span class="rounded-lg px-2 bg-secondary-100 text-secondary-500">${row.is_active}</span>`, row.type, row.channel, row.or_number]
      //           ])
      //         }
      //       })

      //       dataTable.draw()
      //       this.writeToFooterColumn(2, this.calculateTotalAmount())
      //       this.afterDrawStartMonth = this.startMonth
      //       this.afterDrawStartYear = this.startYear
      //       this.afterDrawEndMonth = this.endMonth
      //       this.afterDrawEndYear = this.endYear

      //       this.startDateString = `${dayjs().month(this.startMonth - 1).format('MMMM')} ${this.startYear}`
      //       this.endDateString = `${dayjs().month(this.endMonth - 1).format('MMMM')} ${this.endYear}`
      //     })
      // },
      // filterColumnByType(type) {
      //   let typeColumn = $('#myTable').DataTable().column(3)
      //   this.type = type

      //   typeColumn
      //     .search(this.type ? '^' + this.type + '$' : '', true, false)
      //     .draw();

      //   this.writeToFooterColumn(2, this.calculateTotalAmount())
      // },
    }))
  })
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>