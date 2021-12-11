<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="flex flex-col w-full px-4 lg:px-1" x-data="app()">
  <!-- <div class="text-black text-center">
    <?php flash('login_status'); ?>
  </div> -->

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

  <header class="flex flex-col gap-10 mb-10">
    <div class="w-64 flex-shrink-0">
      <span class="text-2xl font-bold">Report</span>
    </div>
  </header>

  <!-- <div class="mb-4">
    <a href="<?php echo URLROOT ?>/admins/createAccount" class="inline-flex gap-2 py-3 px-4 font-bold rounded-md bg-primary-500 text-white hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
      </svg>
      Create account
    </a>
  </div> -->

  <!-- <div class="bg-white px-6 lg:px-0">
    <nav class="flex justify-center lg:justify-start">
      <a href="<?php echo URLROOT ?>/admins/accounts" class="py-4 px-6 block hover:text-blue-500 focus:outline-none <?php if ($data['current_tab'] == 'all') : ?>text-blue-500 border-b-2 font-medium border-blue-500 <?php else : ?>text-secondary-600<?php endif ?>">
        All
      </a>
      <a href="<?php echo URLROOT ?>/admins/accounts?filter=member" class="py-4 px-6 block hover:text-blue-500 focus:outline-none <?php if ($data['current_tab'] == 'member') : ?>text-blue-500 border-b-2 font-medium border-blue-500 <?php else : ?>text-secondary-600<?php endif ?>">
        Members
      </a>
      <a href="<?php echo URLROOT ?>/admins/accounts?filter=officer" class="py-4 px-6 block hover:text-blue-500 focus:outline-none <?php if ($data['current_tab'] == 'officer') : ?>text-blue-500 border-b-2 font-medium border-blue-500 <?php else : ?>text-secondary-600<?php endif ?>">
        Officers
      </a>
    </nav>
  </div> -->

  <div class="flex flex-col gap-y-8">
    <div class="align-middle inline-block min-w-full">
      <div class="flex flex-wrap justify-center items-end lg:justify-start gap-4 mb-4">
        <!-- Start year -->
        <div class="rounded-md">
        <label class="form-label" for="start_date">Start yr.</label>
          <div class="flex">
            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-secondary-300 bg-secondary-50 text-secondary-500 text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
              </svg>
            </span>
            <select name="start_date" x-model="startYear" id="start_date" class="focus:ring-primary-500 focus:border-primary-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-secondary-300">
              <template x-for="(date, index) in dates.slice(1, -1)" :key="index">
                <option :value="date" x-text="date"></option>
              </template>
            </select>
          </div>
          <?php if (!empty($data['email_err'])) : ?>
            <div class="text-sm text-danger-500 px-2 pt-2">
              <?php echo $data['email_err']; ?> !
            </div>
          <?php endif; ?>
        </div>
        
        <!-- End year -->
        <div class="rounded-md">
        <label class="form-label" for="start_date">End yr.</label>
          <div class="flex">
            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-secondary-300 bg-secondary-50 text-secondary-500 text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </span>
            <select name="end_date" x-model="endYear" id="end_date" class="focus:ring-primary-500 focus:border-primary-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-secondary-300">
              <template x-for="(date, index) in resetEndYearsFromStartYear(startYear)" :key="index">
                <option :value="date" x-text="date"></option>
              </template>
            </select>
          </div>
          <?php if (!empty($data['email_err'])) : ?>
            <div class="text-sm text-danger-500 px-2 pt-2">
              <?php echo $data['email_err']; ?> !
            </div>
          <?php endif; ?>
        </div>

        <!-- Filter button -->
        <button type="button" id="filter" @click="getPaymentsBetweenYears()" class="form-btn gap-2 bg-primary-500 text-white px-3 py-2 text-sm tracking-wide">
          FILTER
        </button>
      </div>

      <div class="shadow overflow-hidden border-b border-secondary-200 sm:rounded-lg overflow-x-auto pb-10">
        <table id="myTable" class="min-w-full divide-y divide-secondary-200">
          <thead class="border-t border-b">
            <th scope="col" class="hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
              PRC ID
            </th>
            <th scope="col" class="hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
              Member
            </th>
            <th scope="col" class="hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
              Paid amount
            </th>
            <th scope="col" class="hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
              Type
            </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-secondary-200 relative">
            <?php foreach ($data['amounts'] as $due) : ?>
              <tr class="hover:bg-secondary-100">
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  <?php echo $due->id ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  <?php echo arrangeFullname($due->first_name, $due->middle_name, $due->last_name) ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  <?php echo $due->amount ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  <?php echo $due->is_active ? 'active' : 'inactive' ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.3/af-2.3.7/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/cr-1.5.5/date-1.1.1/fc-4.0.1/fh-3.2.0/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.3/sr-1.0.1/datatables.min.js"></script>
<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('app', () => ({
      init() {
        // console.log($('#myTable').DataTable().columns());
      },
      dates: <?php echo json_encode($data['dates']); ?>,
      startYear: document.querySelector('#start_date').value,
      endYear: document.querySelector('#end_date').value,
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
      getPaymentsBetweenYears: function() {
        const updateRequest = new FormData();
        updateRequest.append('startYear', this.startYear);
        updateRequest.append('endYear', this.endYear);
        const dataTable = $('#myTable').DataTable();
        const tableEmptyRow = $(dataTable.table().container()).find('.dataTables_empty');

        // find table rows and remove and set loading cues
        dataTable.rows().remove().draw()
        tableEmptyRow.textContent = 'Please wait...'
        this.$el.textContent = 'Please wait...'

        // send start and end year then retrieve payments summary data 
        const response = fetch('<?php echo URLROOT . "/admins/filterData" ?>', {
            method: 'POST',
            body: updateRequest
          })
          .then((response) => response.json())
          .then((res) => {
            // remove loading cues
            console.log(res)
            this.$el.textContent = 'Filter'
            tableEmptyRow.textContent = 'Sorry, we found no records.'

            // load new rows on datatable
            let data = res.data
            data.forEach(row => {
              dataTable.rows().add([
                [row.id, row.first_name, row.amount, row.is_active]
              ])
            })
          })
      },
      // filterColumnBySelectedTab(newTab) {
      //   let roleColumn = $('#myTable').DataTable().column(2)
      //   this.roleTab = newTab

      //   roleColumn
      //     .search(this.roleTab ? '^' + this.roleTab + '$' : '', true, false)
      //     .draw();
      // },
    }))

    $('#myTable').DataTable({
      initComplete: function() {
        const api = this.api();
        api.columns('.hidden-first').visible(false)
      },
      dom: 'Bfrtip',
      buttons: [{
          extend: 'print',
          exportOptions: {
            columns: ':visible :not(.more)'
          },
        },
        {
          text: 'exports',
          extend: 'collection',
          className: 'custom-html-collection border-primary-600',
          buttons: [
            '<header>Export all</header>',
            {
              extend: 'csv',
              exportOptions: {
                columns: ':visible'
              },
              customize: function(csv) {
                console.log(csv)
                return 'Selected year start:  \n' +
                  "Selected year end:  \n" +
                  "Member type:  \n\n" +
                  csv;
              }
            },
            {
              extend: 'excel',
              title: '',
              exportOptions: {
                columns: ':visible'
              },
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
                  value: 'Selected year start:'
                }]);
                var r2 = Addrow(2, [{
                  key: 'A',
                  value: 'Selected year end:'
                }]);
                var r3 = Addrow(3, [{
                  key: 'A',
                  value: "Member type:"
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
        },
      ],
    });
  })
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>