<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="flex flex-col w-full">
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

  <header class="flex flex-wrap items-center justify-between gap-3 mb-10">
    <div class="w-64 flex-shrink-0">
      <span class="text-2xl font-bold">Accounts</span>
    </div>
    <!-- <div>
      <button type="button" class="flex text-blue-600 p-2 rounded-md hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500" @click="onEditMode = !onEditMode" x-show="!onEditMode">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
        Enable editing
      </button>
      <button type="button" class="flex text-blue-600 p-2 rounded-md hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500" @click="onEditMode = !onEditMode" x-show="onEditMode">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
        Disable editing
      </button>
    </div> -->
  </header>

  <div class="bg-white">
    <nav class="flex flex-col sm:flex-row">
      <button class="text-secondary-600 py-4 px-6 block hover:text-blue-500 focus:outline-none text-blue-500 border-b-2 font-medium border-blue-500">
        Tab 1
      </button>
      <button class="text-secondary-600 py-4 px-6 block hover:text-blue-500 focus:outline-none">
        Tab 2
      </button>
      <button class="text-secondary-600 py-4 px-6 block hover:text-blue-500 focus:outline-none">
        Tab 3
      </button>
      <button class="text-secondary-600 py-4 px-6 block hover:text-blue-500 focus:outline-none">
        Tab 4
      </button>
    </nav>
  </div>

  <div class="flex flex-col gap-y-8">
    <div class="align-middle inline-block min-w-full px-1">
      <div class="shadow overflow-hidden border-b border-secondary-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-secondary-200">
          <thead class="bg-secondary-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                Name
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                Profession
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                Contact no.
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
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="text-sm text-secondary-900">
                    <?php echo $member->type_practice ?>
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-500">
                  <?php echo $member->contact_number ?>
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


<?php require APPROOT . '/views/inc/footer.php'; ?>