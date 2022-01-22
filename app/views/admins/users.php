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
            Users
          </span>
        </li>
      </ol>
    </nav>
  </div>

  <!-- header -->
  <header class="flex flex-col gap-3 mb-10">
    <div class="w-64 flex-shrink-0">
      <span class="text-2xl font-bold">Users</span>
    </div>
    <div class="w-full">
      <div class="mt-5">
        <ul class="list-reset flex flex-wrap border-b">
          <li @click="currentTab = 1" class="-mb-px mr-1">
            <a :class="currentTab == 1 ? 'border-l border-t border-r rounded-t' : 'hover:text-primary-500 hover:bg-secondary-100'" class="rounded-t-lg bg-white inline-block py-2 px-4 font-semibold" href="javascript:void(0);">General</a>
          </li>
          <li @click="currentTab = 2" class="-mb-px mr-1">
            <a :class="currentTab == 2 ? 'border-l border-t border-r rounded-t' : 'hover:text-primary-500 hover:bg-secondary-100'" class="rounded-t-lg bg-white inline-block py-2 px-4 font-semibold" href="javascript:void(0);">Archived users</a>
          </li>
        </ul>
      </div>
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

  <!--  general tab -->
  <div x-transition x-show="currentTab == 1" class="w-full bg-opacity-50">
    <div class="gap-y-8">
      <div class="bg-white w-full px-0 mb-3">
        <nav>
          <div class="flex gap-3">
            <div class="w-full lg:w-auto space-y-2">
              <label for="" class="form-label">Role</label>
              <select class="form-input" x-model="role">
                <option value="">All</option>
                <option value="member">Members</option>
                <option value="admin">Admins</option>
              </select>
            </div>

            <div class="w-full lg:w-auto space-y-2">
              <label for="" class="form-label">Status</label>
              <select class="form-input" x-model="account_status">
                <option value="">All</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>
          </div>
        </nav>
      </div>

      <div class="table-container">
        <table x-cloak id="myTable" style="width: 100%">
          <thead class="border-t border-b">
            <tr>
              <th></th>
              <th>SIGNED UP AT</th>
              <th>email</th>
              <th>role</th>
              <th>Account status</th>
              <th>Login status</th>
              <th>Last Log in</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>

  <!--  archived users tab -->
  <div x-transition x-show="currentTab == 2" class="w-full bg-opacity-50">
    <div class="table-container">
      <table x-cloak id="archivedUsersdataTable" style="width: 100%">
        <thead class="border-t border-b">
          <tr>
            <th></th>
            <th>SIGNED UP AT</th>
            <th>email</th>
            <th>role</th>
            <th>Account status</th>
            <th>Last Log in</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<script src="<?php echo URLROOT ?>/vendors/jquery-3.6.0.min.js"></script>
<script src="<?php echo URLROOT ?>/vendors/datatable/datatables.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<!-- <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.3/af-2.3.7/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/cr-1.5.5/date-1.1.1/fc-4.0.1/fh-3.2.0/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.3/sr-1.0.1/datatables.min.js"></script> -->
<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('app', () => ({
      init() {
        const app = this

        $.fn.dataTable.Debounce = function(tables = [], options) {
          if (tables.length == 0) return

          tables.forEach(table => {
            let tableId = table.settings()[0].sTableId;
            $('.dataTables_filter input[aria-controls="' + tableId + '"]')
              .unbind()
              .bind('input', (delay(function(e) {
                table.search($(this).val()).draw();
                return;
              }, 1000)));
          })
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
          "bStateSave": true,
          'lengthMenu': [
            [5, 10, 25, <?php echo MAX_ROW ?>],
            ['5 rows', '10 rows', '25 rows', 'All rows']
          ],
          'order': [
            [0, 'desc']
          ],
          'dom': 'fBrtilp',
          'pageLength': 5,
          'processing': true,
          'serverSide': true,
          'searchDelay': 350,
          'serverMethod': 'post',
          'ajax': {
            'url': 'usersDatatable',
            'data': function(data) {
              // Append to data
              data.role = app.role
              data.accountStatus = app.account_status
              data.includeDeleted = 'hide';
            }
          },
          "language": {
            "processing": 'Please wait...'
          },
          'columns': [{
              data: 'thumbnail_img_path',
              class: 'disabled-cols visible-always',
              sortable: false,
              render: function(d, t, r, m) {
                return `
                <div class="flex items-center gap-2">
                <a href="<?php echo URLROOT ?>/${r.profile_img_path ?? 'img/profiles/default-profile.png'}" target="_blank" class="block rounded-full w-10 h-10 overflow-hidden">
                  <img class="w-full h-full" src="<?php echo URLROOT ?>/${r.thumbnail_img_path ?? 'img/profiles/default-profile.png'}"/>
                </a>
                <?php if ($this->role->isSuperadmin()) : ?>
                <div x-show="${r.role != 'superadmin' ? true : false}" class="relative" x-data="{dropDownOpen:false}">
                  <a @click="dropDownOpen = true" href="javascript:void(0)" class="block text-lg text-secondary-500 hover:bg-secondary-200 rounded-full p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                    </svg>
                  </a>
                  <div 
                    class="absolute top-0 left-10 w-64 flex flex-col bg-white shadow-2xl border border-secondary-300 space-y-2 mt-2" 
                    x-show="dropDownOpen" 
                    @click.away="dropDownOpen=false"
                    x-transition:enter-start="transition ease-in duration-3000"
                  >
                      <a href="javascript:void(0)" @click="confirmSendAssignRole(${r.user_id})" class="flex gap-2 items-center justify-center text-secondary-700 text-center bg-white hover:bg-secondary-100 focus:bg-secondary-200 px-4 py-2">
                    ${r.role == 'admin' 
                      ? `<img width="20" src="<?php echo URLROOT ?>/img/icons/x-circle.svg"/>`
                      : `<img width="20" src="<?php echo URLROOT ?>/img/icons/badge-check.svg"/>`
                    }
                    ${r.role == 'admin' ? 'Retire as admin' : 'Assign as admin'}
                    </a>

                    <a href="javascript:void(0)" @click="archiveUser(${r.user_id});" class="flex gap-2 items-center justify-center text-center px-4 py-2" :class="'${r.deleted_at ? ' bg-success-600 hover:bg-success-700 focus:bg-success-800 text-white ' : ' bg-danger-600 hover:bg-danger-700 focus:bg-danger-800 text-white '}'" >
                      <img width="20" src="<?php echo URLROOT ?>/img/icons${r.deleted_at ? '/refresh.svg' : '/trash.svg'}"/>                    
                      <span>${r.deleted_at ? 'Restore' : 'Archive'}</span>
                      </a>                   
                  </div>
                </div>
                <?php endif ?>   
                <div x-show="${r.deleted_at != null ? true : false}" class="text-danger-600 italic text-sm">Archived</div>
                </div>
                `
              }
            },
            {
              data: 'created_at',
            },
            {
              data: 'email',
              class: 'visible-always'
            },
            {
              data: 'role',
              sortable: false
            },
            {
              data: 'account_status',
              sortable: false,
              render: function(d, t, r, m) {
                return `<span class="px-2 py-1 rounded-full whitespace-nowrap" :class="'${r.account_status}' == 'active' ? 'bg-success-100 text-success-700' : 'bg-secondary-100 text-secondary-700'">${r.account_status}</span>`
              }
            },
            {
              data: 'is_online',
              sortable: false,
              render: function(d, t, r, m) {
                return `<span class="px-2 py-1 rounded-full whitespace-nowrap" :class="'${r.is_online}' == 'online' ? 'bg-success-100 text-success-700' : 'bg-secondary-100 text-secondary-700'">${r.is_online}</span>`
              }
            },
            {
              data: 'logged_at'
            }
          ],
          initComplete: function() {
            const api = this.api();
            api.columns('.hidden-first').visible(false)
          },
          buttons: [{
              text: 'exports',
              extend: 'collection',
              className: 'buttons-excel custom-html-collection',
              buttons: [
                '<header>Export to</header>',
                {
                  extend: 'excel',
                  exportOptions: {
                    columns: ':visible :not(.disabled-cols)'
                  },
                  title: ''
                },
                {
                  extend: 'csv',
                  exportOptions: {
                    columns: ':visible :not(.disabled-cols)'
                  },
                  title: ''
                },
              ]
            },
            {
              text: 'column visibility',
              extend: 'colvis',
              prefixButtons: [{
                  extend: 'colvisRestore',
                },
                {
                  text: "<span>Show all</span>",
                  action: function(e, dt, node, config) {
                    dt.columns().visible(true);

                  }
                },
                {
                  text: "<span>Hide all</span>",
                  action: function(e, dt, node, config) {
                    dt.columns(':not(.visible-always)').visible(false);
                  }
                }
              ],
              columns: ':not(:first-child)'
            },
            {
              text: "<span>Refresh</span>",
              action: function(e, dt, node, config) {
                dt.clear().draw();
                dt.ajax.reload(null, false);
              }
            },
          ],
        });
        const archivedUsersdataTable = $('#archivedUsersdataTable').DataTable({
          "bStateSave": true,
          'lengthMenu': [
            [5, 10, 25, <?php echo MAX_ROW ?>],
            ['5 rows', '10 rows', '25 rows', 'All rows']
          ],
          'order': [
            [0, 'desc']
          ],
          'dom': 'frtilp',
          'pageLength': 5,
          'processing': true,
          'serverSide': true,
          'searchDelay': 350,
          'serverMethod': 'post',
          'ajax': {
            'url': 'usersDatatable',
            'data': function(data) {
              // Append to data
              data.role = ''
              data.accountStatus = ''
              data.includeDeleted = 'only';
            }
          },
          "language": {
            "processing": 'Please wait...'
          },
          'columns': [{
              data: 'thumbnail_img_path',
              class: 'disabled-cols visible-always',
              sortable: false,
              render: function(d, t, r, m) {
                return `
                <div class="flex items-center gap-2">
                <a href="<?php echo URLROOT ?>/${r.profile_img_path ?? 'img/profiles/default-profile.png'}" target="_blank" class="block rounded-full w-10 h-10 overflow-hidden">
                  <img class="w-full h-full" src="<?php echo URLROOT ?>/${r.thumbnail_img_path ?? 'img/profiles/default-profile.png'}"/>
                </a>
                <?php if ($this->role->isSuperadmin()) : ?>
                <a href="javascript:void(0)" @click="archiveUser(${r.user_id});" class="rounded flex gap-2 items-center justify-center text-center p-2 bg-success-600 hover:bg-success-700 focus:bg-success-800 text-white">
                    <img width="20" src="<?php echo URLROOT ?>/img/icons/refresh.svg"/>                    
                    <span>Restore</span>
                </a>  
                <?php endif ?>
                </div>
                `
              }
            },
            {
              data: 'created_at',
            },
            {
              data: 'email',
              class: 'visible-always'
            },
            {
              data: 'role',
              sortable: false
            },
            {
              data: 'account_status',
              sortable: false,
              render: function(d, t, r, m) {
                return `<span class="px-2 py-1 rounded-full whitespace-nowrap" :class="'${r.account_status}' == 'active' ? 'bg-success-100 text-success-700' : 'bg-secondary-100 text-secondary-700'">${r.account_status}</span>`
              }
            },
            {
              data: 'logged_at'
            }
          ],
          initComplete: function() {
            const api = this.api();
            api.columns('.hidden-first').visible(false)
            api.draw();
          },
          buttons: [{
              text: 'exports',
              extend: 'collection',
              className: 'buttons-excel custom-html-collection',
              buttons: [
                '<header>Export to</header>',
                {
                  extend: 'excel',
                  exportOptions: {
                    columns: ':visible :not(.disabled-cols)'
                  },
                  title: ''
                },
                {
                  extend: 'csv',
                  exportOptions: {
                    columns: ':visible :not(.disabled-cols)'
                  },
                  title: ''
                },
              ]
            },
            {
              text: 'column visibility',
              extend: 'colvis',
              prefixButtons: [{
                  extend: 'colvisRestore',
                },
                {
                  text: "<span>Show all</span>",
                  action: function(e, dt, node, config) {
                    dt.columns().visible(true);

                  }
                },
                {
                  text: "<span>Hide all</span>",
                  action: function(e, dt, node, config) {
                    dt.columns(':not(.visible-always)').visible(false);
                  }
                }
              ],
              columns: ':not(:first-child)'
            },
            {
              text: "<span>Refresh</span>",
              action: function(e, dt, node, config) {
                dt.clear().draw();
                dt.ajax.reload(null, false);
              }
            },
          ],
        });

        dataTable.on('preXhr.dt', function() {
          $('#myTable').addClass('text-secondary-200');
        });
        dataTable.on('xhr.dt', function() {
          $('#myTable').removeClass('text-secondary-200');
        });
        let debounce = new $.fn.dataTable.Debounce([dataTable, archivedUsersdataTable]);

        this.$watch('dt_include_deleted', (value) => {
          dataTable.draw();
        });
        this.$watch('role', (value) => {
          dataTable.draw();
        });
        this.$watch('account_status', (value) => {
          dataTable.draw();
        });

        this.$watch('setStatusModalOpen', value => {
          if (value === false) {
            this.enableRemarks = false
            this.setStatus.updateRemarks = false
            this.setStatus.remarks = ''
            this.setStatus.user_id = ''
          }
        })

      },
      currentTab: 1,
      dt_include_deleted: '',

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
        initiator: '<?php echo arrangeFullname($this->session->get(SessionManager::SESSION_USER)->first_name, $this->session->get(SessionManager::SESSION_USER)->middle_name, $this->session->get(SessionManager::SESSION_USER)->last_name) ?>',
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

      archiveUser(userId) {
        fetch('<?php echo URLROOT . "/admins/archiveUser" ?>', {
            method: "POST",
            body: JSON.stringify({
              user_id: userId
            }),
            headers: {
              "Content-type": "application/json"
            }
          }).then(data => data.json())
          .then(res => {
            if (res.status == 'ok') {
              $('#myTable').DataTable().draw('page');
              $('#archivedUsersdataTable').DataTable().draw('page');
            }
          })
      },

      setRole: {
        user_id: ''
      },
      confirmSendAssignRole: function(user_id) {
        this.setRole.user_id = user_id

        fetch('<?php echo URLROOT . "/admins/reassignAdminRole" ?>', {
            method: "POST",
            body: JSON.stringify({
              user_id: user_id
            }),
            headers: {
              "Content-type": "application/json"
            }
          }).then(data => data.json())
          .then(res => {
            if (res.status == 'ok') {
              $('#myTable').DataTable().draw('page');
            }
          })
      },

      role: '',
      account_status: '',
      practiceType: '',
    }))



  })
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>