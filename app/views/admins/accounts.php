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

  <!-- <div class="mb-4">
    <a href="<?php echo URLROOT ?>/admins/createAccount" class="inline-flex gap-2 py-3 px-4 uppercase font-bold rounded-md bg-primary-500 text-white hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
      </svg>
      Create account
    </a>
  </div> -->

  <div class="bg-white w-full px-0 mb-3 mt-10 lg:mt-5">
    <nav class="">
      <div class="mb-3">
        <h1 class="text-xl font-bold text-secondary-500">Filters</h1>
      </div>

      <div class="flex gap-3">
        <select class="form-input" @change="roleTab = $event.target.value; filterColumnBySelectedTab($event.target.value)">
          <option value="">Select role</option>
          <option value="member">Members</option>
          <option value="officer">Officers</option>
          <option value="admin">Admins</option>
        </select>

        <select class="form-input" @change="status = $event.target.value; filterColumnByStatus($event.target.value)" name="" id="">
          <option value="">Select status</option>
          <option value="Active">Active</option>
          <option value="Unverified">Unverified</option>
          <option value="Inactive">Inactive</option>
        </select>

        <select class="form-input" @change="practiceType = $event.target.value; filterColumnByPracticeType($event.target.value)" name="" id="">
          <option value="">Select practice type</option>
          <option value="Government Dentist">Government Dentist</option>
          <option value="Clinic Owner">Clinic Owner</option>
          <option value="Dental Associate">Dental Associate</option>
          <option value="School Dentist">School Dentist</option>
          <option value="None Practicing">None Practicing</option>
        </select>
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
                Name
              </th>
              <th scope="col" class="hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                Practice type
              </th>
              <th scope="col" class="hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                Role
              </th>
              <th scope="col" class="hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                Status
              </th>
              <th scope="col" class="more hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                More
              </th>
              <th scope="col" class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                Timestamp of creation
              </th>
              <th scope="col" class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                PRC license no.
              </th>
              <th scope="col" class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                PRC Registration date
              </th>
              <th scope="col" class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                PRC Date of expiry
              </th>
              <th scope="col" class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                Field of practice
              </th>
              <th scope="col" class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                Type of practice
              </th>
              <th scope="col" class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                Date of Birth
              </th>
              <th scope="col" class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                Gender
              </th>
              <th scope="col" class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                Contact number
              </th>
              <th scope="col" class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                Email Address
              </th>
              <th scope="col" class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                Facebook Account Name
              </th>
              <th scope="col" class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                Home Address
              </th>
              <th scope="col" class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                Clinic Registered Name
              </th>
              <th scope="col" class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                Clinic Street
              </th>
              <th scope="col" class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                Clinic District
              </th>
              <th scope="col" class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                Clinic Municipality
              </th>
              <th scope="col" class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                Clinic Contact
              </th>
              <th scope="col" class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                Emergency person
              </th>
              <th scope="col" class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                Emergency person address
              </th>
              <th scope="col" class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                Emergency person contact
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-secondary-200 relative">
            <?php foreach ($data['accounts'] as $member) : ?>
              <tr class="hover:bg-secondary-100">
                <td class="px-6 py-4 whitespace-nowrap text-sm <?php if ($member->id == $_SESSION['user_id']) : ?> text-primary-600 font-semibold <?php else : ?> text-secondary-500 <?php endif ?>">
                  <?php echo strtoupper(arrangeFullname($member->first_name, $member->middle_name, $member->last_name)) ?>
                </td>
                <td class="px-6 py-4 text-sm text-secondary-900 whitespace-nowrap">
                  <?php echo $member->type_practice ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-500">
                  <?php echo $member->role ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap <?php if ($member->is_active) : ?> text-success-600 <?php elseif (!$member->is_active && !$member->email_verified) : ?>  text-danger-600 <?php else : ?> text-secondary-400 <?php endif ?>">
                  <?php if ($member->is_active) : ?>
                    <?php echo 'Active' ?>
                  <?php elseif (!$member->is_active && !$member->email_verified) : ?>
                    <?php echo 'Unverified' ?>
                  <?php else : ?>
                    <?php echo 'Inactive' ?>
                  <?php endif; ?>
                </td>
                <td class="more" x-data="{ dropdownOpen: false }">
                  <button @click="dropdownOpen = !dropdownOpen" class="whitespace-nowrap text-base font-medium text-secondary-500 hover:text-secondary-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                    </svg>
                  </button>

                  <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>

                  <div x-show="dropdownOpen" class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-2xl z-20 overflow-y-auto">
                    <a href="#" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 hover:text-white">
                      View
                    </a>
                    <a href="#" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 hover:text-white">
                      Set to inactive
                    </a>
                    <a href="#" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 hover:text-white">
                      Re-assign role
                    </a>
                  </div>
                </td>

                <td class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                  <?php echo $member->created_at ?>
                </td>
                <td class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                  <?php echo $member->prc_number ?>
                </td>
                <td class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                  <?php echo $member->prc_registration_date ?>
                </td>
                <td class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                  <?php echo $member->prc_expiration_date ?>
                </td>
                <td class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                  <?php echo $member->field_practice ?>
                </td>
                <td class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                  <?php echo $member->type_practice ?>
                </td>
                <td class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                  <?php echo $member->birthdate ?>
                </td>
                <td class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                  <?php echo $member->gender ?>
                </td>
                <td class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                  <?php echo $member->contact_number ?>
                </td>
                <td class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                  <?php echo $member->email ?>
                </td>
                <td class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                  <?php echo $member->fb_account_name ?>
                </td>
                <td class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                  <?php echo $member->address ?>
                </td>
                <td class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                  <?php echo $member->clinic_name ?>
                </td>
                <td class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                  <?php echo $member->clinic_street ?>
                </td>
                <td class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                  <?php echo $member->clinic_district ?>
                </td>
                <td class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                  <?php echo $member->clinic_city ?>
                </td>
                <td class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                  <?php echo $member->clinic_contact_no ?>
                </td>
                <td class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                  <?php echo $member->emergency_person_name ?>
                </td>
                <td class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                  <?php echo $member->emergency_address ?>
                </td>
                <td class="hidden-first hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">
                  <?php echo $member->emergency_contact_number ?>
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
  $(document).ready(function() {

  });
  document.addEventListener('alpine:init', () => {
    Alpine.data('app', () => ({
      init() {
        // console.log($('#myTable').DataTable().columns());
      },
      roleTab: '',
      practiceType: '',
      status: '',
      filterColumnBySelectedTab(newTab) {
        let roleColumn = $('#myTable').DataTable().column(2)
        this.roleTab = newTab

        roleColumn
          .search(this.roleTab ? '^' + this.roleTab + '$' : '', true, false)
          .draw();
      },
      filterColumnByStatus(status) {
        let statusColumn = $('#myTable').DataTable().column(3)
        this.status = status

        statusColumn
          .search(this.status ? '^' + this.status + '$' : '', true, false)
          .draw();
      },
      filterColumnByPracticeType(practiceType) {
        let practiceTypeCol = $('#myTable').DataTable().column(1)
        this.practiceType = practiceType

        practiceTypeCol
          .search(this.practiceType ? '^' + this.practiceType + '$' : '', true, false)
          .draw();
      },
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
          className: 'custom-html-collection',
          buttons: [
            '<header>Export all</header>',
            {
              extend: 'csv',
              exportOptions: {
                columns: ':not(.more)'
              },
              customize: function(csv) {
                console.log(csv)
                return 'CHAPTER:______________________                                                                                                                                                  PDA MEMBERSHIP REMITTANCE FORM \n' +
                  "PRESIDENT'S NAME:______________________\n" +
                  'TOTAL NUMBER OF MEMBERS REMITTED:______________________\n' +
                  'TOTAM AMOUNT REMITTED:______________________\n\n' +
                  csv;
              }
            },
            {
              extend: 'excel',
              title: '',
              exportOptions: {
                columns: ':not(.more)'
              },
              customize: function(xlsx) {
                var sheet = xlsx.xl.worksheets['sheet1.xml'];
                var numrows = 6;
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
                  key: 'E',
                  value: 'PDA MEMBERSHIP REMITTANCE FORM'
                }]);
                var r2 = Addrow(2, [{
                  key: 'A',
                  value: 'CHAPTER:__________________________'
                }]);
                var r3 = Addrow(3, [{
                  key: 'A',
                  value: "PRESIDENT'S NAME:__________________________"
                }]);
                var r4 = Addrow(4, [{
                  key: 'A',
                  value: 'TOTAL NUMBER OF MEMBERS REMITTED:__________________________'
                }]);
                var r5 = Addrow(5, [{
                  key: 'A',
                  value: 'TOTAL AMOUNT REMITTED:__________________________'
                }]);
                var r6 = Addrow(6, [{
                  key: 'A',
                  value: ''
                }]);


                var sheetData = sheet.getElementsByTagName('sheetData')[0];

                sheetData.insertBefore(r6, sheetData.childNodes[0]);
                sheetData.insertBefore(r5, sheetData.childNodes[0]);
                sheetData.insertBefore(r4, sheetData.childNodes[0]);
                sheetData.insertBefore(r3, sheetData.childNodes[0]);
                sheetData.insertBefore(r2, sheetData.childNodes[0]);
                sheetData.insertBefore(r1, sheetData.childNodes[0]);
              }
            },

            '<header>Export visible</header>',
            {
              extend: 'csv',
              exportOptions: {
                columns: ':visible :not(.more)'
              },
              customize: function(csv) {
                console.log(csv)
                return 'CHAPTER:______________________                                                                                                                                                  PDA MEMBERSHIP REMITTANCE FORM \n' +
                  "PRESIDENT'S NAME:______________________\n" +
                  'TOTAL NUMBER OF MEMBERS REMITTED:______________________\n' +
                  'TOTAM AMOUNT REMITTED:______________________\n\n' +
                  csv;
              }
            },
            {
              extend: 'excel',
              exportOptions: {
                columns: ':visible :not(.more)'
              },
              customize: function(xlsx) {
                var sheet = xlsx.xl.worksheets['sheet1.xml'];
                var numrows = 6;
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
                  key: 'E',
                  value: 'PDA MEMBERSHIP REMITTANCE FORM'
                }]);
                var r2 = Addrow(2, [{
                  key: 'A',
                  value: 'CHAPTER:__________________________'
                }]);
                var r3 = Addrow(3, [{
                  key: 'A',
                  value: "PRESIDENT'S NAME:__________________________"
                }]);
                var r4 = Addrow(4, [{
                  key: 'A',
                  value: 'TOTAL NUMBER OF MEMBERS REMITTED:__________________________'
                }]);
                var r5 = Addrow(5, [{
                  key: 'A',
                  value: 'TOTAL AMOUNT REMITTED:__________________________'
                }]);
                var r6 = Addrow(6, [{
                  key: 'A',
                  value: ''
                }]);


                var sheetData = sheet.getElementsByTagName('sheetData')[0];

                sheetData.insertBefore(r6, sheetData.childNodes[0]);
                sheetData.insertBefore(r5, sheetData.childNodes[0]);
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