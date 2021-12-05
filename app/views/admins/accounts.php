<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="flex flex-col w-full px-4 lg:px-1">
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
            Accounts
          </span>
        </li>
      </ol>
    </nav>
  </div>

  <header class="flex flex-col gap-10 mb-10">
    <div class="w-64 flex-shrink-0">
      <span class="text-2xl font-bold">Accounts</span>
    </div>
  </header>

  <div class="mb-4">
    <a href="<?php echo URLROOT ?>/admins/createAccount" class="inline-flex gap-2 py-3 px-4 font-bold rounded-md bg-primary-500 text-white hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
      </svg>
      Create account
    </a>
  </div>

  <div class="bg-white px-6 lg:px-0">
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
  </div>

  <div class="flex flex-col gap-y-8">
    <div class="align-middle inline-block min-w-full">
      <div class="shadow overflow-hidden border-b border-secondary-200 sm:rounded-lg overflow-x-auto">
        <table id="myTable" class="min-w-full divide-y divide-secondary-200">
          <thead class="bg-secondary-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                Name
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                Profession
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                Role
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                Status
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-secondary-200">
            <?php foreach ($data['accounts'] as $member) : ?>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-500">
                  <?php echo arrangeFullname($member->first_name, $member->middle_name, $member->last_name) ?>
                  <?php if ($member->id == $_SESSION['user_id']) : ?>
                    <span class="bg-primary-100 text-primary-600 whitespace-nowrap px-2 inline-flex items-center gap-1 text-xs leading-5 font-semibold rounded-full">
                      You
                    </span>
                  <?php endif ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="text-sm text-secondary-900">
                    <?php echo $member->type_practice ?>
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-500">
                  <?php echo $member->role ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <?php if ($member->is_active) : ?>
                    <span class="px-2 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-success-100 text-success-800">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                      </svg>
                      <?php echo 'Active' ?>
                    </span>
                  <?php else : ?>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-danger-100 text-danger-800">
                      <?php echo 'Inactive' ?>
                    </span>
                  <?php endif; ?>
                </td>
                <td>
                  <button class="whitespace-nowrap text-base font-medium text-secondary-500 hover:text-secondary-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                    </svg>
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener('alpine:init', () => {


    })

    const dataTable = new simpleDatatables.DataTable("#myTable", {
      layout: {
        top: "{search}{select}",
        // bottom: "{info}{pager}"
      },
      labels: {
        placeholder: "Search for accounts",
        perPage: "{select}",
        noRows: "Sorry, there are no accounts to search.",
        // info: "Showing {start} to {end} of {rows} entries",
      },
      searchable: true,
      perPage: 5,
      fixedColumns: true,
      fixedHeight: true,      
    })

    dataTable.on("datatable.init", function () {
      console.log(this.columns())
      // this.columns().hide([0, 1])
    })

    // const roleSelector = document.querySelector('#role_selector')
    // roleSelector.addEventListener('change', function() {
    //   let rows = dataTable.rows().dt.data
    //   rows.forEach(el => {
    //     let role = el.cells[2].textContent.trim()
    //     console.log(dataTable.rows())
    //     if (role == 'admin') {
    //       //  console.log(dataTable.rows())
    //     }
    //   })
    //   // console.log(rows)
    //   // console.log(dataTable.wrapper.querySelector('.dataTable-search input').value = this.value)
    // })
    // dataTable.on('datatable.search', function(query, matched) {
    //   console.log(dataTable.wrapper.querySelector('.dataTable-search input').value = matched)
    // });

    // console.log(dataTable.searchData)
  })
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>