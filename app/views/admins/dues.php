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
            Dues
          </span>
        </li>
      </ol>
    </nav>
  </div>

  <header class="flex flex-wrap items-center justify-between gap-3 mb-10">
    <div class="w-64 flex-shrink-0">
      <span class="text-2xl font-bold">Dues</span>
    </div>
  </header>

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
              <option value="1" :selected="1 == startMonth">January</option>
              <option value="2" :selected="2 == startMonth">February</option>
              <option value="3" :selected="3 == startMonth">March</option>
              <option value="4" :selected="4 == startMonth">April</option>
              <option value="5" :selected="5 == startMonth">May</option>
              <option value="6" :selected="6 == startMonth">June</option>
              <option value="7" :selected="7 == startMonth">July</option>
              <option value="8" :selected="8 == startMonth">August</option>
              <option value="9" :selected="9 == startMonth">September</option>
              <option value="10" :selected="10 == startMonth">October</option>
              <option value="11" :selected="11 == startMonth">November</option>
              <option value="12" :selected="12 == startMonth">December</option>
            </select>
          </div>

          <select name="start_year" x-model="startYear" id="start_year" class="focus:ring-primary-500 focus:border-primary-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-secondary-300">
            <template x-for="(year, index) in dates.slice(1, -1)" :key="index">
              <option :value="year" x-text="year" :selected="year == startYear"></option>
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
              <option value="1" :selected="1 == endMonth">January</option>
              <option value="2" :selected="2 == endMonth">February</option>
              <option value="3" :selected="3 == endMonth">March</option>
              <option value="4" :selected="4 == endMonth">April</option>
              <option value="5" :selected="5 == endMonth">May</option>
              <option value="6" :selected="6 == endMonth">June</option>
              <option value="7" :selected="7 == endMonth">July</option>
              <option value="8" :selected="8 == endMonth">August</option>
              <option value="9" :selected="9 == endMonth">September</option>
              <option value="10" :selected="10 == endMonth">October</option>
              <option value="11" :selected="11 == endMonth">November</option>
              <option value="12" :selected="12 == endMonth">December</option>
            </select>
          </div>

          <select name="end_year" x-model="endYear" id="end_year" class="focus:ring-primary-500 focus:border-primary-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-secondary-300">
            <template x-for="(year, index) in resetEndYearsFromStartYear()" :key="index">
              <option :value="year" x-text="year" :selected="year == endYear"></option>
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

        // jquery datatable
        $.fn.dataTable.Debounce = function(table, options) {
          let tableId = table.settings()[0].sTableId;
          $('.dataTables_filter input[aria-controls="' + tableId + '"]') // select the correct input field
            .unbind() // Unbind previous default bindings
            .bind('input', (delay(function(e) { // Bind our desired behavior
              table.search($(this).val()).draw();
              return;
            }, 1000))); // Set delay in milliseconds
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
          'order': [
            [0, 'desc']
          ],
          'bLengthChange': false,
          'processing': true,
          'serverSide': true,
          'searchDelay': 350,
          'serverMethod': 'post',
          'ajax': {
            'url': 'duesDatatable',
            'data': function(data) {
              // Append to data
              data.startMonth = app.startMonth;
              data.endMonth = app.endMonth;
              data.startYear = app.startYear;
              data.endYear = app.endYear;
              // data.memberType = app.dt_member_type;
              // data.paymentType = app.dt_payment_type;
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
              data: 'date_posted',
              render: function(d, t, r, m) {
                return `<span class="text-secondary-500">${r.date_posted}</span>`
              }
            },
            {
              data: 'first_name',
              render: function(d, t, r, m) {
                if (!r.user_id) {
                  return `<a>${r.first_name}</a>`;
                }

                return `<a href="viewAccount/?id=${r.user_id}" class="font-medium hover:underline hover:text-primary-600 hover:bg-primary-50" class="text-danger-500">
                  ${r.first_name} </a>`;
              }
            },
            {
              data: 'amount',
              render: function(d, t, r, m) {
                return `<span class="font-mono">${parseInt(r.amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")}</span>`;
              }
            },
            {
              data: 'payment_status',
              render: function(d, t, r, m) {
                return `<span>${r.payment_status ?? ''}</span>`;
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
          },
          dom: 'fBrtip',
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
        let debounce = new $.fn.dataTable.Debounce(dataTable);

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

      startDateString: `${dayjs().format('MMMM')} 1981`,
      endDateString: `${dayjs().format('MMMM')} ${dayjs().add(1, 'year').year()}`,
      afterDrawStartMonth: dayjs().month() + 1,
      afterDrawEndMonth: dayjs().month() + 1,
      afterDrawStartYear: 1981,
      afterDrawEndYear: dayjs().add(1, 'year').year(),
      startMonth: dayjs().month() + 1,
      endMonth: dayjs().month() + 1,
      startYear: 1981,
      endYear: dayjs().add(1, 'year').year(),
      dates: <?php echo json_encode($data['dates']); ?>,
      resetEndYearsFromStartYear: function() {
        return this.dates.filter((value, index, arr) => {
          return value > this.startYear
        })
      },
      type: ''
    }))
  })
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>