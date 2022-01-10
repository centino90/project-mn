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
            List of members
          </span>
        </li>
      </ol>
    </nav>
  </div>

  <header class="flex flex-col gap-10 mb-10">
    <div class="w-64 flex-shrink-0">
      <span class="text-2xl font-bold">List of members</span>
    </div>
  </header>


  <div class="gap-y-8">

    <div class="bg-white w-full px-0 mb-3 mt-10 lg:mt-5">
      <nav>
        <!-- <div class="mb-3">
          <h1 class="text-xl font-bold text-secondary-500">Filters</h1>
        </div> -->
      </nav>
    </div>

    <div class="table-container">
      <table id="myTable" style="width: 100%">
        <thead class="border-t border-b">
          <tr>
            <th scope="col">
              Name
            </th>
            <th scope="col">
              PRC #
            </th>
            <th scope="col">
              DCDC Dues
            </th>
          </tr>
        </thead>
        <tbody class="bg-white relative">
          <?php foreach ($data['accounts'] as $member) : ?>
            <tr>
              <td>
                <a href="<?php echo URLROOT ?>/admins/viewAccount?id=<?php echo $member->id ?>" class="hover:underline hover:text-primary-600 hover:bg-primary-50">
                  <?php echo strtoupper(arrangeFullname($member->first_name, $member->middle_name, $member->last_name)) ?>
                </a>
              </td>
              <td>
                <?php echo $member->prc_number ?>
              </td>
              <td class="hidden-first">
                <?php echo $member->payments ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="hidden" id="print_header">
      <div class="flex justify-center gap-5">
        <div style="width: 100px">
          <img width="100%" src="<?php echo URLROOT ?>/public/img/PDA-DCC.jpg" />
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.3/af-2.3.7/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/cr-1.5.5/date-1.1.1/fc-4.0.1/fh-3.2.0/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.3/sr-1.0.1/datatables.min.js"></script>
<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('app', () => ({
      init() {
      }
    }))

    $('#myTable').DataTable({
      initComplete: function() {
        const api = this.api();
        api.columns('.hidden-first').visible(false)
      },
      dom: 'fBrtip',
      buttons: [{
        extend: 'print',
        exportOptions: {
          columns: ':visible'
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
            .css('text-align', 'left')
            .css('max-width', '200px');
        }
      }, ]
    });
  })
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>