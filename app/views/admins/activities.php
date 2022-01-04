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
            Activities
          </span>
        </li>
      </ol>
    </nav>
  </div>

  <header class="flex flex-wrap items-center justify-between gap-3 mb-10">
    <div class="w-64 flex-shrink-0">
      <span class="text-2xl font-bold">Activities</span>
    </div>
  </header>

  <div class="gap-y-8">
    <div class="table-container shadow overflow-hidden overflow-x-auto border-b border-secondary-200 sm:rounded-lg pb-10">
      <table id="myTable" style="width: 100%" class="divide-y divide-secondary-200">
        <thead class="border-t border-b">
          <tr>
            <th scope="col" class="hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
              Timestamp
            </th>
            <th scope="col" class="hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
              Initiated by
            </th>
            <th scope="col" class="hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
              Type
            </th>
            <th scope="col" class="hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
              Message
            </th>
          </tr>
        </thead>
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
            'url': 'activitiesDatatable'
          },
          'columns': [{
              data: 'created_at'
            },
            {
              data: 'initiator'
            },
            {
              data: 'type'
            },
            {
              data: 'message',
              render: function(d, t, r, m) {
                return `<p class="line-clamp-3 hover:line-clamp-none w-40"> ${r.message}</p>`
              }
            }
          ]
        });
        const debounce = new $.fn.dataTable.Debounce(dataTable);
      },
    }))
  })
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>