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
            Payment history
          </span>
        </li>
      </ol>
    </nav>
  </div>

  <header class="flex flex-col gap-10 mb-10">
    <div class="w-64 flex-shrink-0">
      <span class="text-2xl font-bold">Payment history</span>
    </div>
  </header>

  <div class="gap-y-8">
    <?php if (!empty($data['dues'])) : ?>
      <div class="table-container">
        <table x-cloak id="myTable" style="width: 100%">
          <thead class="border-t border-b">
            <tr>
              <th scope="col">
                Year
              </th>
              <th scope="col">
                DCC
              </th>
              <th scope="col">
                Receipt #
              </th>
              <th scope="col">
                PDA
              </th>
              <th scope="col">
                Receipt #
              </th>
              <th scope="col">
                Remarks
              </th>
            </tr>
          </thead>
          <tbody class="bg-white relative">
            <?php foreach ($data['dues'] as $due) : ?>
              <tr>
                <td class="text-secondary-500">
                  <?php echo $due->year ?>
                </td>
                <td>
                  <?php if (!empty($due->dcc)) : ?>
                    <?php echo $due->dcc ?>
                  <?php endif ?>
                </td>
                <td class="text-secondary-500">
                  <?php echo $due->dcc_or ?>
                </td>
                <td>
                  <?php if (!empty($due->pda)) : ?>
                    <?php echo $due->pda ?>
                  <?php endif ?>
                </td>
                <td class="ptext-secondary-500">
                  <?php echo $due->pda_or ?>
                </td>
                <td class="text-secondary-500">
                  <?php echo $due->remarks ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <tfoot>
            <th scope="col">
            </th>
            <th scope="col">
            </th>
            <th scope="col">
            </th>
            <th scope="col">
            </th>
            <th scope="col">
            </th>
          </tfoot>
          </tbody>
        </table>
      </div>
    <?php else : ?>
      <div class="shadow sm:rounded-md sm:overflow-hidden h-52 flex flex-wrap justify-center items-center">
        <div class="flex flex-col">
          <div class="mb-3 ml-auto">
          </div>
          <div class="rounded-lg w-96 py-8 px-4 bg-warning-100 flex justify-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            You currently do not have recorded payments
          </div>
        </div>
      </div>
    <?php endif ?>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.3/af-2.3.7/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/cr-1.5.5/date-1.1.1/fc-4.0.1/fh-3.2.0/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.3/sr-1.0.1/datatables.min.js"></script>
<script>
  $(document).ready(function() {

  });
  document.addEventListener('alpine:init', () => {
    Alpine.data('app', () => ({
      init() {
        this.writeToFooterColumn(0, 'Payment Summary', 'text')
        this.writeToFooterColumn(1, this.calculateTotalAmount(1), 'currency')
        this.writeToFooterColumn(3, this.calculateTotalAmount(3), 'currency')
      },
      type: '',
      calculateTotalAmount(colIndex) {
        let amountColumn = $('#myTable').DataTable().column(colIndex)
        let rows = $('#myTable').DataTable().rows({
          search: 'applied'
        })
        let rowData = rows.data().toArray()

        return rowData.reduce((acc, cur) => {
          let amount = 0
          let colString = cur[colIndex]
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
    }))

    // initilize datatable
    $('#myTable').DataTable({
      order: [[0, 'desc']],
      initComplete: function() {
        const api = this.api();
        api.columns('.hidden-first').visible(false)
      },
      dom: 'rtip',
    });
  })
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>