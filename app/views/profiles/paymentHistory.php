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

  <div class="bg-white w-full px-0 mb-3 mt-10 lg:mt-5">
    <nav class="">
      <div class="mb-3">
        <h1 class="text-xl font-bold text-secondary-500">Filters</h1>
      </div>

      <div class="flex gap-3">
        <div class="w-full lg:w-auto">
          <label for="" class="form-label">Year</label>
          <select @change="year = $event.target.value; filterColumnByYear($event.target.value)" name="year" x-model="year" id="year" class="form-input">
            <option value="">Select year</option>
            <template x-for="(year, index) in years.slice(1, -1)" :key="index">
              <option :value="year" x-text="year"></option>
            </template>
          </select>
        </div>

        <div class="w-full lg:w-auto">
          <label for="" class="form-label">Type</label>
          <select class="form-input" @change="type = $event.target.value; filterColumnByType($event.target.value)" name="type" id="type">
            <option value="">Select type</option>
            <option value="PDA">PDA</option>
            <option value="DCC">DCC</option>
          </select>
        </div>
      </div>
    </nav>
  </div>

  <div class="flex flex-col gap-y-8">
    <div class="align-middle inline-block min-w-full">
      <div class="shadow overflow-hidden border-b border-secondary-200 sm:rounded-lg overflow-x-auto pb-10">
        <table id="myTable" class="min-w-full divide-y divide-secondary-200">
          <thead class="border-t border-b">
            <tr>
              <th scope="col" class="hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                Year
              </th>
              <th scope="col" class="hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                Type
              </th>
              <th scope="col" class="hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                Amount
              </th>
              <th scope="col" class="hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                OR No.
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-secondary-200 relative">
            <?php foreach ($data['paymentHistory'] as $payment) : ?>
              <tr class="hover:bg-secondary-100">
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  <?php echo date("Y", strtotime($payment->date_created)) ?>
                </td>
                <td class="px-6 py-4 text-sm text-secondary-900 whitespace-nowrap">
                  <?php echo strtoupper($payment->type) ?>
                </td>
                <td class="px-6 py-4 text-sm text-secondary-900 whitespace-nowrap">
                  <?php echo $payment->amount ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-500">
                  <?php echo $payment->or_number ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <tfoot>
            <th scope="col" class="hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold  uppercase tracking-wider">
            </th>
            <th scope="col" class="hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold  uppercase tracking-wider">

            </th>
            <th scope="col" class="hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold  uppercase tracking-wider">

            </th>
            <th scope="col" class="hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">

            </th>
          </tfoot>
          </tbody>
        </table>
      </div>
    </div>
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
        this.writeToFooterColumn(0, 'Payment Summary')
        this.writeToFooterColumn(2, this.calculateTotalAmount())
      },
      years: <?php echo json_encode($data['years']); ?>,
      year: '',
      type: '',
      calculateTotalAmount() {
        let amountColumn = $('#myTable').DataTable().column(2)
        let rows = $('#myTable').DataTable().rows({
          search: 'applied'
        })
        let rowData = rows.data().toArray()

        return rowData.reduce((acc, cur) => {
          let amount = parseInt(cur[2])
          if (amount == NaN) return

          return acc + amount
        }, 0)
      },
      writeToFooterColumn(colIndex, value) {
        let amountColumn = $('#myTable').DataTable().column(colIndex);

        $(amountColumn.footer()).html(
          value
        );
      },
      filterColumnByYear(year) {
        let yearColumn = $('#myTable').DataTable().column(0)
        this.year = year

        yearColumn
          .search(this.year ? '^' + this.year + '$' : '', true, false)
          .draw();

        this.writeToFooterColumn(2, this.calculateTotalAmount())
      },
      filterColumnByType(type) {
        let typeCol = $('#myTable').DataTable().column(1)
        this.type = type

        typeCol
          .search(this.type ? '^' + this.type + '$' : '', true, false)
          .draw();

        this.writeToFooterColumn(2, this.calculateTotalAmount())
      },
    }))

    // initilize datatable
    $('#myTable').DataTable({
      initComplete: function() {
        const api = this.api();
        api.columns('.hidden-first').visible(false)
      },
      dom: 'rtip',
    });
  })
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>