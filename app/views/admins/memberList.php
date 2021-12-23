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

  <!-- Set status modal dialog -->
  <div x-cloak x-ref="modal" x-transition x-show.transition.opacity="setStatusModalOpen" class="overflow-auto fixed z-20 top-0 left-0 w-screen h-screen bg-black bg-opacity-50 flex items-center justify-center" role="dialog" aria-modal="true">
    <div class="w-full max-w-screen-sm bg-white rounded-xl shadow-xl flex flex-col absolute divide-y divide-secondary-200">

      <div class="px-5 py-4 flex items-center justify-between">
        <h2 class="text-xl text-secondary-700" x-ref="modal_title" x-text="setStatusOperation">
        </h2>

        <button class="text-secondary-400 hover:text-secondary-600" @click="setStatusModalOpen = false">
          <svg class="w-4 fill-current transition duration-150" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.001 512.001">
            <path d="M284.286 256.002L506.143 34.144c7.811-7.811 7.811-20.475 0-28.285-7.811-7.81-20.475-7.811-28.285 0L256 227.717 34.143 5.859c-7.811-7.811-20.475-7.811-28.285 0-7.81 7.811-7.811 20.475 0 28.285l221.857 221.857L5.858 477.859c-7.811 7.811-7.811 20.475 0 28.285a19.938 19.938 0 0014.143 5.857 19.94 19.94 0 0014.143-5.857L256 284.287l221.857 221.857c3.905 3.905 9.024 5.857 14.143 5.857s10.237-1.952 14.143-5.857c7.811-7.811 7.811-20.475 0-28.285L284.286 256.002z" />
          </svg>
        </button>
      </div>

      <div class="py-5 mb-5 overflow-auto" id="modal_content" style="min-height: 300px; max-height: 300px">

        <div class="flex flex-col mx-5 border-b">
          <label for="remarks" class="form-label">Subject</label>
          <h1 class="text-secondary-40" x-ref="modal_subject" x-text="setStatusModalSubject"></h1>
        </div>

        <div x-show="enableRemarks" class="flex flex-col px-5 mt-5">
          <label for="remarks" class="form-label">Remarks (optional)</label>
          <textarea name="remarks" type="text" x-model="setStatus.remarks" @keydown.enter="addEmail" class="rounded border border-secondary-300 px-3 py-2 text-secondary-700 w-full focus:ring-primary-500 focus:border-primary-500">
          </textarea>
        </div>
      </div>

      <div class="flex">
        <button @click="setStatusModalOpen = false" class="w-full p=4 rounded-bl-xl text-secondary-600 font-semibold transition duration-150 hover:bg-secondary-100 hover:text-secondary-900 focus:outline-none">Cancel</button>
        <button x-ref="modal_submit" x-text="setStatusModalSubmit.text" @click="statusChangeForm" :class="setStatusModalSubmit.class.join(' ')" class="w-full p-4 rounded-br-xl disabled:opacity-50 disabled:cursor-wait text-white font-semibold transition duration-150 focus:outline-none"></button>
      </div>
    </div>
  </div>

  <div class="gap-y-8">

    <div class="bg-white w-full px-0 mb-3 mt-10 lg:mt-5">
      <nav>
        <div class="mb-3">
          <h1 class="text-xl font-bold text-secondary-500">Filters</h1>
        </div>

        <div class="flex gap-3">
          <div class="w-full lg:w-auto">
            <label for="" class="form-label">Role</label>
            <select class="form-input" @change="roleTab = $event.target.value; filterColumnBySelectedTab($event.target.value)">
              <option value="">Select role</option>
              <option value="member">Members</option>
              <option value="admin">Admins</option>
            </select>
          </div>

          <div class="w-full lg:w-auto">
            <label for="" class="form-label">Status</label>
            <select class="form-input" @change="status = $event.target.value; filterColumnByStatus($event.target.value)" name="" id="">
              <option value="">Select status</option>
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>
        </div>
      </nav>
    </div>

    <div class="table-container">
      <table id="myTable" style="width: 100%">
        <thead class="border-t border-b">
          <tr>
            <th scope="col">
              TIMESTAMP
            </th>
            <th scope="col">
              Name
            </th>
            <th scope="col">
              Role
            </th>
            <th scope="col">
              Status
            </th>
            <th scope="col" class="hidden-first">
              Remarks
            </th>
            <th scope="col" class="more">
              More
            </th>

            <th scope="col" class="hidden-first">
              Email Address
            </th>
            <th scope="col" class="hidden-first">
              Timestamp of creation
            </th>
            <th scope="col" class="hidden-first">
              PRC license no.
            </th>
            <th scope="col" class="hidden-first">
              PRC Registration date
            </th>
            <th scope="col" class="hidden-first">
              PRC Date of expiry
            </th>
            <th scope="col" class="hidden-first">
              Field of practice
            </th>
            <th scope="col" class="hidden-first">
              Type of practice
            </th>
            <th scope="col" class="hidden-first">
              Date of Birth
            </th>
            <th scope="col" class="hidden-first">
              Gender
            </th>
            <th scope="col" class="hidden-first">
              Contact number
            </th>
            <th scope="col" class="hidden-first">
              Practice type
            </th>
            <th scope="col" class="hidden-first">
              Facebook Account Name
            </th>
            <th scope="col" class="hidden-first">
              Home Address
            </th>
            <th scope="col" class="hidden-first">
              Clinic Registered Name
            </th>
            <th scope="col" class="hidden-first">
              Clinic Street
            </th>
            <th scope="col" class="hidden-first">
              Clinic District
            </th>
            <th scope="col" class="hidden-first">
              Clinic Municipality
            </th>
            <th scope="col" class="hidden-first">
              Clinic Contact
            </th>
            <th scope="col" class="hidden-first">
              Emergency person
            </th>
            <th scope="col" class="hidden-first">
              Emergency person address
            </th>
            <th scope="col" class="hidden-first">
              Emergency person contact
            </th>
          </tr>
        </thead>
        <tbody class="bg-white relative">
          <?php foreach ($data['accounts'] as $member) : ?>
            <tr>
              <td>
                <?php echo $member->created_at ?>
              </td>
              <td class=" <?php if ($member->id == $_SESSION['user_id']) : ?> text-primary-600 font-semibold <?php endif ?>">
                <a href="<?php echo URLROOT ?>/admins/viewAccount?id=<?php echo $member->id ?>" class="hover:underline hover:text-primary-600 hover:bg-primary-50">
                  <?php echo strtoupper(arrangeFullname($member->first_name, $member->middle_name, $member->last_name)) ?>
                </a>
              </td>
              <td>
                <?php echo $member->role ?>
              </td>
              <td>
                <span class="rounded-lg px-2 <?php if ($member->is_active) : ?> bg-success-100 text-success-700 <?php else : ?>bg-secondary-100 text-secondary-400 <?php endif ?>"><?php echo $member->is_active ? 'active' : 'inactive' ?></span>
              </td>
              <td class="hidden-first">
                <?php echo $member->status_remarks ?>
              </td>
              <td class="more" x-data="{ dropdownOpen: false }">
                <button @click="dropdownOpen = !dropdownOpen" class="relative whitespace-nowrap text-base font-medium text-secondary-500 hover:text-secondary-900">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                  </svg>

                  <div x-show="dropdownOpen" class="absolute right-0 text-left mt-2 py-2 w-48 bg-white rounded-md shadow-2xl z-20 overflow-y-auto">
                    <!-- set status -->
                    <?php if ($member->is_active) : ?>
                      <a @click="openModalOnClick" href="javascript:void(0);" data-userid="<?php echo $member->id ?>" data-remarks="<?php echo $member->status_remarks ?>" data-username="<?php echo strtoupper(arrangeFullname($member->first_name, $member->middle_name, $member->last_name)) ?>" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 hover:text-white">
                        Set as inactive
                      </a>
                    <?php else : ?>
                      <a @click="openModalOnClick" href="javascript:void(0);" data-userid="<?php echo $member->id ?>" data-remarks="<?php echo $member->status_remarks ?>" data-username="<?php echo strtoupper(arrangeFullname($member->first_name, $member->middle_name, $member->last_name)) ?>" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 hover:text-white">
                        Update remarks
                      </a>
                      <a @click="openModalOnClick" href="javascript:void(0);" data-userid="<?php echo $member->id ?>" data-remarks="<?php echo $member->status_remarks ?>" data-username="<?php echo strtoupper(arrangeFullname($member->first_name, $member->middle_name, $member->last_name)) ?>" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 hover:text-white">
                        Set as active
                      </a>
                    <?php endif ?>

                    <!-- set role -->
                    <?php if (isSuperAdmin()) : ?>
                      <?php if ($member->role == 'admin') : ?>
                        <a @click="if (confirm('Retire admin role?')){ confirmSendAssignRole(<?php echo $member->id ?>) }" href="javascript:void(0);" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 hover:text-white">
                          Retire as admin
                        </a>
                      <?php elseif ($member->role == 'member') : ?>
                        <a @click="if (confirm('Assign admin role?')){ confirmSendAssignRole(<?php echo $member->id ?>) }" href="javascript:void(0);" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 hover:text-white">
                          Set as admin
                        </a>
                      <?php endif ?>
                    <?php endif ?>
                  </div>
                </button>

                <!-- backdrop -->
                <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>
              </td>

              <td class="hidden-first ">
                <?php echo $member->email ?>
              </td>
              <td class="hidden-first">
                <?php echo $member->created_at ?>
              </td>
              <td class="hidden-first">
                <?php echo $member->prc_number ?>
              </td>
              <td class="hidden-first">
                <?php echo $member->prc_registration_date ?>
              </td>
              <td class="hidden-first">
                <?php echo $member->prc_expiration_date ?>
              </td>
              <td class="hidden-first">
                <?php echo $member->field_practice ?>
              </td>
              <td class="hidden-first">
                <?php echo $member->type_practice ?>
              </td>
              <td class="hidden-first">
                <?php echo $member->birthdate ?>
              </td>
              <td class="hidden-first">
                <?php echo $member->gender ?>
              </td>
              <td class="hidden-first">
                <?php echo $member->contact_number ?>
              </td>
              <td class="hidden-first ">
                <?php echo $member->type_practice ?>
              </td>
              <td class="hidden-first">
                <?php echo $member->fb_account_name ?>
              </td>
              <td class="hidden-first">
                <?php echo $member->address ?>
              </td>
              <td class="hidden-first">
                <?php echo $member->clinic_name ?>
              </td>
              <td class="hidden-first">
                <?php echo $member->clinic_street ?>
              </td>
              <td class="hidden-first">
                <?php echo $member->clinic_district ?>
              </td>
              <td class="hidden-first">
                <?php echo $member->clinic_city ?>
              </td>
              <td class="hidden-first">
                <?php echo $member->clinic_contact_no ?>
              </td>
              <td class="hidden-first">
                <?php echo $member->emergency_person_name ?>
              </td>
              <td class="hidden-first">
                <?php echo $member->emergency_address ?>
              </td>
              <td class="hidden-first">
                <?php echo $member->emergency_contact_number ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.3/af-2.3.7/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/cr-1.5.5/date-1.1.1/fc-4.0.1/fh-3.2.0/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.3/sr-1.0.1/datatables.min.js"></script>
<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('app', () => ({
      init() {
        this.$watch('setStatusModalOpen', value => {
          if (value === false) {
            this.enableRemarks = false
            this.setStatus.updateRemarks = false
            this.setStatus.remarks = ''
            this.setStatus.user_id = ''
          }
        })

      },
      openModalOnClick(event) {
        const accountId = event.target.dataset.userid
        const accountName = event.target.dataset.username
        const accountRemarks = event.target.dataset.remarks

        this.setStatusOperation = event.target.textContent.toLowerCase().trim()
        this.setStatusModalSubmit.text = 'Confirm'
        this.setStatus.user_id = accountId
        this.setStatusModalOpen = true

        if (this.setStatusOperation == 'set as inactive' || this.setStatusOperation == 'update remarks') {
          this.enableRemarks = true
          this.setStatus.remarks = accountRemarks
        }
        if (this.setStatusOperation == 'set as inactive') {
          this.setStatusModalSubmit.text = `${this.setStatusModalSubmit.text} deactivation`
          this.setStatusModalSubmit.class = ['bg-danger-500', 'hover:bg-danger-700']
        }
        if (this.setStatusOperation == 'set as active') {
          this.setStatusModalSubmit.text = `${this.setStatusModalSubmit.text} activation`
          this.setStatusModalSubmit.class = ['bg-success-500', 'hover:bg-success-700']
        }
        if (this.setStatusOperation == 'update remarks') {
          this.setStatus.updateRemarks = true
          this.setStatusModalSubmit.text = `${this.setStatusModalSubmit.text} update`
          this.setStatusModalSubmit.class = ['bg-primary-500', 'hover:bg-primary-700']
        }

        this.setStatusOperation = this.setStatusOperation.charAt(0).toUpperCase() + this.setStatusOperation.slice(1);
        this.setStatusModalSubject = accountName
      },
      setStatusOperation: '',
      setStatusModalOpen: false,
      setStatusModalTitle: '',
      setStatusModalSubmit: {
        class: [],
        text: ''
      },
      setStatusModalSubject: '',
      enableRemarks: false,
      setStatus: {
        initiator: '<?php echo $_SESSION['user_name'] ?>',
        remarks: '',
        user_id: '',
        updateRemarks: false
      },
      statusChangeForm: function() {
        let actionText = this.$el.textContent
        this.$el.textContent = 'Please wait...'

        this.sendStatusChange().then(data => data.json())
          .then(res => {
            this.$el.textContent = actionText
            this.$el.disabled = false

            if (res.status == 'ok') {
              window.location.reload()
            }
          })
      },
      sendStatusChange: async function() {
        return await fetch('<?php echo URLROOT . "/admins/userStatusChange" ?>', {
          method: "POST",
          body: JSON.stringify({
            setStatus: this.setStatus
          }),
          headers: {
            "Content-type": "application/json"
          }
        })
      },

      setRole: {
        user_id: ''
      },
      confirmSendAssignRole: function($user_id) {
        this.setRole.user_id = $user_id

        this.sendAssignRole().then(data => data.json())
          .then(res => {
            console.log(res)
            if (res.status == 'ok') {
              window.location.reload()
            }
          })
      },
      sendAssignRole: async function() {
        return await fetch('<?php echo URLROOT . "/admins/reassignAdminRole" ?>', {
          method: "POST",
          body: JSON.stringify({
            user_id: this.setRole.user_id
          }),
          headers: {
            "Content-type": "application/json"
          }
        })
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
      }
    }))

    $('#myTable').DataTable({
      initComplete: function() {
        const api = this.api();
        api.columns('.hidden-first').visible(false)
      },
      order: [
        [0, 'desc']
      ],
      dom: 'Bfrtip',
      buttons: [{
          text: 'exports',
          extend: 'collection',
          className: 'custom-html-collection',
          buttons: [
            '<header>Export to</header>',
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