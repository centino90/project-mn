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
            Payments
          </span>
        </li>
      </ol>
    </nav>
  </div>

  <!-- header -->
  <header class="flex flex-col gap-3 mb-10">
    <div class="w-64 flex-shrink-0">
      <span class="text-2xl font-bold">Payments</span>
    </div>
    <div class="w-full">
      <div class="mt-5">
        <ul class="list-reset flex flex-wrap border-b">
          <li @click="currentTab = 1" class="-mb-px mr-1">
            <a :class="currentTab == 1 ? 'border-l border-t border-r rounded-t' : 'hover:text-primary-500 hover:bg-secondary-100'" class="rounded-t-lg bg-white inline-block py-2 px-4 font-semibold" href="javascript:void(0);">General</a>
          </li>
          <li @click="currentTab = 2" class="-mb-px mr-1">
            <a :class="currentTab == 2 ? 'border-l border-t border-r rounded-t' : 'hover:text-primary-500 hover:bg-secondary-100'" class="rounded-t-lg bg-white inline-block py-2 px-4 font-semibold" href="javascript:void(0);">Add single payment</a>
          </li>
          <li @click="currentTab = 3" class="-mb-px mr-1">
            <a :class="currentTab == 3 ? 'border-l border-t border-r rounded-t' : 'hover:text-primary-500 hover:bg-secondary-100'" class="rounded-t-lg bg-white inline-block py-2 px-4 font-semibold" href="javascript:void(0);">Import bulk payments</a>
          </li>
          <li @click="currentTab = 4" class="-mb-px mr-1">
            <a :class="currentTab == 4 ? 'border-l border-t border-r rounded-t' : 'hover:text-primary-500 hover:bg-secondary-100'" class="rounded-t-lg bg-white inline-block py-2 px-4 font-semibold" href="javascript:void(0);">Archived payments</a>
          </li>

        </ul>
      </div>
    </div>
  </header>

  <!-- main content -->
  <main>
    <!--  general tab -->
    <div x-transition x-show="currentTab == 1" class="w-full bg-opacity-50">
      <div class="gap-y-8">
        <!-- main filters -->
        <div class="bg-white w-full px-0 pb-4 border-b mb-3">
          <div class="flex items-end gap-3">
            <!-- Start period -->
            <div class="w-full lg:w-auto space-y-2">
              <label class="form-label">Start period</label>
              <div class="flex">
                <div class="flex">
                  <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-secondary-300 bg-secondary-50 text-secondary-500 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                  </span>

                  <select name="start_month" x-model="startMonth" id="start_month" class="focus:ring-primary-500 focus:border-primary-500 flex-1 block w-full rounded-none sm:text-sm border-secondary-300 border-r-0">
                    <option value="1" :selected="1 == startMonth">January</option>
                    <option value="2" :selected="2 == startMonth">February</option>
                    <option value="3" :selected="3 == startMonth">March</option>
                    <option value="4" :selected="4 == startMonth">April</option>
                    <option value="5" :selected="5 == startMonth">May</option>
                    <option value="6" :selected="6 == startMonth">June</option>
                    <option value="7" :selected="7 == startMonth">July</option>
                    <option value="8" :selected="8 == startMonth">August</option>
                    <option value="9" :selected="9 == startMonth">September</option>
                    <option value="10" :selected="10 == startMonth">October</option>
                    <option value="11" :selected="11 == startMonth">November</option>
                    <option value="12" :selected="12 == startMonth">December</option>
                  </select>
                </div>

                <select name="start_year" x-model="startYear" id="start_year" class="focus:ring-primary-500 focus:border-primary-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-secondary-300">
                  <template x-for="(year, index) in dates.slice(1, -1)" :key="index">
                    <option :value="year" x-text="year" :selected="year == startYear"></option>
                  </template>
                </select>
              </div>
            </div>

            <!-- End period -->
            <div class="w-full lg:w-auto space-y-2">
              <label class="form-label">End period</label>
              <div class="flex">
                <div class="flex">
                  <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-secondary-300 bg-secondary-50 text-secondary-500 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                  </span>

                  <select name="end_month" x-model="endMonth" id="end_month" class="focus:ring-primary-500 focus:border-primary-500 flex-1 block w-full rounded-none sm:text-sm border-secondary-300 border-r-0">
                    <option value="1" :selected="1 == endMonth">January</option>
                    <option value="2" :selected="2 == endMonth">February</option>
                    <option value="3" :selected="3 == endMonth">March</option>
                    <option value="4" :selected="4 == endMonth">April</option>
                    <option value="5" :selected="5 == endMonth">May</option>
                    <option value="6" :selected="6 == endMonth">June</option>
                    <option value="7" :selected="7 == endMonth">July</option>
                    <option value="8" :selected="8 == endMonth">August</option>
                    <option value="9" :selected="9 == endMonth">September</option>
                    <option value="10" :selected="10 == endMonth">October</option>
                    <option value="11" :selected="11 == endMonth">November</option>
                    <option value="12" :selected="12 == endMonth">December</option>
                  </select>
                </div>

                <select name="end_year" x-model="endYear" id="end_year" class="focus:ring-primary-500 focus:border-primary-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-secondary-300">
                  <template x-for="(year, index) in resetEndYearsFromStartYear()" :key="index">
                    <option :value="year" x-text="year" :selected="year == endYear"></option>
                  </template>
                </select>
              </div>
            </div>

            <!-- Filter button -->
            <button type="button" id="report_filter" class="form-btn gap-2 bg-primary-500 text-white px-3 py-2 text-sm tracking-wide">
              Filter
            </button>
          </div>
        </div>

        <!-- sub filters -->
        <div class="bg-white w-full px-0 mb-3 mt-10 lg:mt-5">
          <div class="flex items-end gap-3">
            <div class="w-full lg:w-auto space-y-2">
              <label for="" class="form-label">Payment Type</label>
              <select class="form-input" x-model="dt_payment_type">
                <option value="">All</option>
                <option value="PDA">PDA</option>
                <option value="DCC">DCC</option>
              </select>
            </div>
          </div>
        </div>

        <div class="table-container">
          <table x-cloak id="myTable" style="width: 100%">
            <thead class="border-t border-b">
              <tr>
                <th>ACTION</th>
                <th scope="col">
                  DATE
                </th>
                <th scope="col">
                  MEMBER
                </th>
                <th scope="col">
                  PAID AMOUNT
                </th>
                <th scope="col">
                  PAYMENT TYPE
                </th>
                <th scope="col" class="hidden-first">
                  RECEIPT NO.
                </th>
                <th scope="col" class="hidden-first">
                  REMARKS
                </th>
                <th scope="col" class="hidden-first">
                  CHANNEL
                </th>
                <th class="" scope="col">surname</th>
                <th class="" scope="col">first_name</th>
                <th class="" scope="col">middle_name</th>
                <th class="" scope="col">prc_number</th>
                <th class="" scope="col">contact_number</th>
                <th class="" scope="col">email</th>
              </tr>
            </thead>
            <tfoot>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
            </tfoot>
          </table>
        </div>

        <section class="hidden text-right px-5 py-3 text-sm text-secondary-500">
          <span id="cap_start_year" x-text="`Selected start period: ${startDateString}`"> </span>
          <br>
          <span id="cap_end_year" x-text="`Selected end period: ${endDateString}`"></span>
        </section>
      </div>
    </div>

    <!--  single payment tab -->
    <div x-transition x-show="currentTab == 2" class="w-full bg-opacity-50">
      <div class="gap-y-8">
        <form @submit.prevent x-ref="dues_form" class="flex flex-col gap-y-8">
          <div x-bind="formGroup">
            <label for="user_id" class="form-label">PRC No. <span class="text-danger-600">*</span></label>
            <div class="input-container w-full flex flex-col items-center">
              <div @click.outside="close()" class="w-full">
                <div class="flex flex-col items-center relative z-0">
                  <div class="w-full">
                    <div class="mb-2 p-1 bg-white flex border border-secondary-200 rounded">
                      <input name="user_id" x-model="duesForm.prc_number" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @mousedown="open()" @keydown.enter.stop.prevent="selectOption()" @keydown.arrow-up.prevent="focusPrevOption()" @keydown.arrow-down.prevent="focusNextOption()" placeholder="Find existing prc no. by searching the name or prc no." autocomplete="off" class="p-1 px-2 appearance-none outline-none w-full text-secondary-800">
                      <div class="text-secondary-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-secondary-200">
                        <button @click="toggle()" class="cursor-pointer w-6 h-6 text-secondary-600 outline-none focus:outline-none">
                          <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline x-show="!isOpen()" points="18 15 12 20 6 15"></polyline>
                            <polyline x-show="isOpen()" points="18 15 12 9 6 15"></polyline>
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div x-show="isOpen()" class="absolute shadow bg-white top-full w-full left-0 rounded overflow-y-auto" style="max-height: 300px;" ;>
                    <div class="flex flex-col w-full">
                      <template x-for="(option, index) in filteredOptions()" :key="index">
                        <div @click="onOptionClick(index)" :class="classOption(option.prc_number, index)" :aria-selected="focusedOptionIndex === index">
                          <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-teal-100">
                            <div class="w-6 flex flex-col items-center">
                              <div class="flex relative w-5 h-5 bg-blue-500 justify-center items-center m-1 mr-2 w-4 h-4 mt-1 rounded-full">
                                <img class="rounded-full" alt="A" x-bind:src="option.thumbnail_img_path ? `<?php echo URLROOT . '/' ?>${option.thumbnail_img_path}` : '<?php echo URLROOT . '/img/profiles/default-profile.png' ?>'">
                              </div>
                            </div>
                            <div class="w-full items-center flex">
                              <div class="mx-2 -mt-1"><span x-text="option.first_name.toUpperCase() + ' ' + option.last_name.toUpperCase()"></span>
                                <div class="text-xs truncate w-full normal-case font-normal -mt-1 text-secondary-500" x-text="option.prc_number"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </template>
                    </div>
                  </div>
                </div>
              </div>
              <span class="hidden text-danger-600 text-sm" id="add_prc_number_err"></span>
              </span>
            </div>
          </div>

          <div x-bind="formGroup">
            <label x-bind="formGroup.formLabel">
              Amount <span class="text-danger-600">*</span>
            </label>
            <div x-bind="formGroup.inputContainer">
              <input type="number" x-model="duesForm.amount" x-bind="formGroup.formInput" name="amount">
              <span class="hidden text-danger-600 text-sm" id="add_amount_err"></span>
            </div>
          </div>

          <div x-bind="formGroup">
            <label x-bind="formGroup.formLabel">
              Paid to (PDA/DCC) <span class="text-danger-600">*</span>
            </label>
            <div x-bind="formGroup.inputContainer">
              <select x-model="duesForm.type" x-bind="formGroup.formInput" name="type">
                <option value="">Select type</option>
                <option value="PDA">PDA</option>
                <option value="DCC">DCC</option>
              </select>
              <span class="hidden text-danger-600 text-sm" id="add_type_err"></span>
            </div>
          </div>

          <div x-bind="formGroup">
            <label x-bind="formGroup.formLabel" class="wrap">
              Channel (gcash, paymaya, etc.) <span class="text-danger-600">*</span>
            </label>
            <div x-bind="formGroup.inputContainer">
              <input type="text" x-model="duesForm.channel" x-bind="formGroup.formInput" name="channel">
              <span class="hidden text-danger-600 text-sm" id="add_channel_err"></span>
            </div>
          </div>

          <div x-bind="formGroup">
            <label x-bind="formGroup.formLabel">
              OR Number <span class="text-danger-600">*</span>
            </label>
            <div x-bind="formGroup.inputContainer">
              <input type="text" x-model="duesForm.or_number" x-bind="formGroup.formInput" name="or_number">
              <span class="hidden text-danger-600 text-sm" id="add_or_number_err"></span>
            </div>
          </div>

          <div x-bind="formGroup">
            <label x-bind="formGroup.formLabel">
              Remarks <span class="text-secondary-400">(optional)</span>
            </label>
            <div x-bind="formGroup.inputContainer">
              <textarea type="number" x-model="duesForm.remarks" x-bind="formGroup.formInput" name="remarks" rows="3"></textarea>
            </div>
          </div>

          <div x-bind="formGroup">
            <label x-bind="formGroup.formLabel">
              Date posted <span class="text-danger-600">*</span>
            </label>
            <div x-bind="formGroup.inputContainer">
              <div class="flex w-full">
                <div class="flex w-3/4">
                  <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-secondary-300 bg-secondary-50 text-secondary-500 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                  </span>

                  <select name="month" x-model="duesForm.date_posted.month" id="month" class="focus:ring-primary-500 focus:border-primary-500 flex-1 block w-full rounded-none sm:text-sm border-secondary-300 border-r-0">
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                  </select>
                </div>

                <select name="year" x-model="duesForm.date_posted.year" id="year" class="w-1/4 focus:ring-primary-500 focus:border-primary-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-secondary-300">
                  <template x-for="(date, index) in generateYearsBetween().slice(1, -1)" :key="index">
                    <option :value="date" x-text="date" :selected="index == 0"></option>
                  </template>
                </select>
              </div>
              <span class="hidden text-danger-600 text-sm" id="add_date_posted_err"></span>
            </div>
          </div>

          <!-- Form submit -->
          <div x-bind="formGroup" x-show="onEditMode">
            <label></label>
            <div x-bind="formGroup.inputContainer">
              <button @click="addSingleDues" x-ref="submit" class="form-btn lg:ml-2 disabled:cursor-wait bg-primary-500 text-white w-full md:w-80 py-2 px-4">
                Submit
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!--  import bulk payment tab -->
    <div x-transition x-show="currentTab == 3" class="w-full bg-opacity-50">
      <div class="">
        <a href="<?php echo URLROOT ?>/users/downloadTemplates?filename=IMPORT_DUES_TEMPLATE.xlsx" class="flex-inline border border-primary-600 text-primary-600 p-2 text-white rounded-md hover:bg-secondary-100">
          Download template
        </a>

        <form @submit.prevent x-ref="dues_import" class="mt-10 flex flex-col gap-y-8">
          <!-- import csv -->
          <div x-bind="formGroup">
            <label x-bind="formGroup.formLabel">Import <span class="text-danger-600">*</span></label>
            <div x-bind="formGroup.inputContainer">
              <input type="file" id="dues_file" class="rounded border border-secondary-300 px-3 py-5 text-secondary-700 w-full focus:ring-primary-500 focus:border-primary-500">

              <div class="w-full text-xs text-secondary-400 font-bold px-2">CHOOSE OR DRAG YOUR SPREADSHEET FILE</div>
              <span class="hidden text-danger-600 text-sm" id="dues_file_err"></span>
            </div>
          </div>

          <!-- Form submit -->
          <div x-bind="formGroup">
            <label></label>
            <div x-bind="formGroup.inputContainer">
              <button type="submit" @click="importBulkDues" x-ref="submit" class="form-btn lg:ml-2 disabled:cursor-wait bg-primary-500 text-white w-full md:w-80 py-2 px-4">
                Submit
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!--  archived payments tab -->
    <div x-transition x-show="currentTab == 4" class="w-full bg-opacity-50">
      <div class="gap-y-8">
        <div class="table-container">
          <table x-cloak id="archivedDuesTable" style="width: 100%">
            <thead class="border-t border-b">
              <tr>
                <th>ACTION</th>
                <th scope="col">
                  DATE
                </th>
                <th scope="col">
                  MEMBER
                </th>
                <th scope="col">
                  PAID AMOUNT
                </th>
                <th scope="col">
                  PAYMENT TYPE
                </th>
                <th scope="col">
                  RECEIPT NO.
                </th>
                <th scope="col">
                  REMARKS
                </th>
                <th scope="col">
                  CHANNEL
                </th>
              </tr>
            </thead>
            <tfoot>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </main>

  <!-- Payment modal dialog -->
  <div x-cloak x-ref="modal" x-transition x-show.transition.opacity="paymentModalOpen" class="overflow-auto fixed z-20 top-0 left-0 w-screen h-screen bg-black bg-opacity-50 flex items-center justify-center" role="dialog" aria-modal="true">
    <div class="w-full h-full lg:h-4/5 max-w-screen-md bg-white rounded-xl shadow-xl flex flex-col absolute divide-y divide-secondary-200">

      <div class="px-5 py-4 flex items-center justify-between bg-gradient-to-r from-primary-400 to-primary-600 rounded-t-lg text-white">
        <h1 class="flex items-center gap-2 text-2xl leading-tight font-bold">
          Edit dues
        </h1>

        <button class="text-white hover:bg-primary-700 p-2 rounded-full" @click="paymentModalOpen = false">
          <svg class="w-4 fill-current transition duration-150" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.001 512.001">
            <path d="M284.286 256.002L506.143 34.144c7.811-7.811 7.811-20.475 0-28.285-7.811-7.81-20.475-7.811-28.285 0L256 227.717 34.143 5.859c-7.811-7.811-20.475-7.811-28.285 0-7.81 7.811-7.811 20.475 0 28.285l221.857 221.857L5.858 477.859c-7.811 7.811-7.811 20.475 0 28.285a19.938 19.938 0 0014.143 5.857 19.94 19.94 0 0014.143-5.857L256 284.287l221.857 221.857c3.905 3.905 9.024 5.857 14.143 5.857s10.237-1.952 14.143-5.857c7.811-7.811 7.811-20.475 0-28.285L284.286 256.002z" />
          </svg>
        </button>
      </div>

      <div class="pt-5 pb-10 overflow-auto" id="modal_content">
        <!-- input form -->
        <div class="space-y-4 flex flex-col px-5">
          <div>
            <div class="space-y-3">
              <label for="amount" class="form-label">Date posted <span class="text-danger-600">*</span></label>
              <div class="flex w-full">
                <div class="flex w-3/4">
                  <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-secondary-300 bg-secondary-50 text-secondary-500 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                  </span>

                  <select name="month" x-model="duesForm.date_posted.month" id="month" class="focus:ring-primary-500 focus:border-primary-500 flex-1 block w-full rounded-none sm:text-sm border-secondary-300 border-r-0">
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                  </select>
                </div>

                <select name="year" x-model="duesForm.date_posted.year" id="year" class="w-1/4 focus:ring-primary-500 focus:border-primary-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-secondary-300">
                  <template x-for="(date, index) in generateYearsBetween().slice(1, -1)" :key="index">
                    <option :value="date" x-text="date" :selected="index == 0"></option>
                  </template>
                </select>
              </div>
              <span class="hidden text-danger-600" id="date_posted_err"></span>
              </span>
            </div>
          </div>

          <label for="profile_id" class="form-label">PRC No. <span class="text-danger-600">*</span></label>
          <div class="w-full flex flex-col items-center">
            <div @click.outside="close()" class="w-full">
              <div class="flex flex-col items-center relative z-0">
                <div class="w-full">
                  <div class="mb-2 p-1 bg-white flex border border-secondary-200 rounded">
                    <input name="profile_id" x-model="duesForm.prc_number" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @mousedown="open()" @keydown.enter.stop.prevent="selectOption()" @keydown.arrow-up.prevent="focusPrevOption()" @keydown.arrow-down.prevent="focusNextOption()" placeholder="Search for user" autocomplete="off" class="p-1 px-2 appearance-none outline-none w-full text-secondary-800">
                    <div class="text-secondary-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-secondary-200">
                      <button @click="toggle()" class="cursor-pointer w-6 h-6 text-secondary-600 outline-none focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <polyline x-show="!isOpen()" points="18 15 12 20 6 15"></polyline>
                          <polyline x-show="isOpen()" points="18 15 12 9 6 15"></polyline>
                        </svg>
                      </button>
                    </div>
                  </div>
                </div>
                <div x-show="isOpen()" class="absolute shadow bg-white top-full w-full left-0 rounded overflow-y-auto" style="max-height: 300px;" ;>
                  <div class="flex flex-col w-full">
                    <template x-for="(option, index) in filteredOptions()" :key="index">
                      <div @click="onOptionClick(index)" :class="classOption(option.prc_number, index)" :aria-selected="focusedOptionIndex === index">
                        <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-teal-100">
                          <div class="w-6 flex flex-col items-center">
                            <div class="flex relative w-5 h-5 bg-blue-500 justify-center items-center m-1 mr-2 w-4 h-4 mt-1 rounded-full">
                              <img class="rounded-full" alt="A" x-bind:src="option.profile_img_path ? `<?php echo URLROOT . '/' ?>${option.profile_img_path}` : '<?php echo URLROOT . '/img/profiles/default-profile.png' ?>'">
                            </div>
                          </div>
                          <div class="w-full items-center flex">
                            <div class="mx-2 -mt-1"><span x-text="option.first_name.toUpperCase() + ' ' + option.last_name.toUpperCase()"></span>
                              <div class="text-xs truncate w-full normal-case font-normal -mt-1 text-secondary-500" x-text="option.prc_number"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </template>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <span class="hidden text-danger-600" id="profile_id_err">
          </span>

          <label for="type" class="form-label">Type <span class="text-danger-600">*</span></label>
          <select name="type" x-model="duesForm.type" class="rounded border border-secondary-300 px-3 py-2 text-secondary-700 w-full focus:ring-primary-500 focus:border-primary-500">
            <option value="">Select Type</option>
            <option value="PDA">PDA</option>
            <option value="DCC">DCC</option>
          </select>
          <span class="hidden text-danger-600" id="type_err">
          </span>

          <label for="amount" class="form-label">Amount <span class="text-danger-600">*</span></label>
          <input name="amount" type="number" x-model="duesForm.amount" class="rounded border border-secondary-300 px-3 py-2 text-secondary-700 w-full focus:ring-primary-500 focus:border-primary-500" placeholder="amount">
          <span class="hidden text-danger-600" id="amount_err">
          </span>

          <label for="channel" class="form-label">Payment option <span class="text-danger-600">*</span></label>
          <input name="channel" type="text" x-model="duesForm.channel" class="rounded border border-secondary-300 px-3 py-2 text-secondary-700 w-full focus:ring-primary-500 focus:border-primary-500" placeholder="payment option (e.g. gcash, paypal, DCC office, etc.)">
          <span class="hidden text-danger-600" id="channel_err">
          </span>

          <label for="or_number" class="form-label">OR No. <span class="text-danger-600">*</span></label>
          <input name="or_number" type="text" x-model="duesForm.or_number" class="rounded border border-secondary-300 px-3 py-2 text-secondary-700 w-full focus:ring-primary-500 focus:border-primary-500" placeholder="OR no.">
          <span class="hidden text-danger-600" id="or_number_err">
          </span>

          <label for="remarks" class="form-label">Remarks <span class="text-secondary-500">(optional)</span></label>
          <textarea name="remarks" type="text" x-model="duesForm.remarks" class="rounded border border-secondary-300 px-3 py-2 text-secondary-700 w-full focus:ring-primary-500 focus:border-primary-500">
            </textarea>
          <span class="hidden text-danger-600" id="remarks_err">
          </span>

        </div>
      </div>

      <div class="flex items-center justify-end px-5 py-4 gap-5">
        <button @click="paymentModalOpen = false" class="py-3 px-5 rounded bg-secondary-100 border text-secondary-600 font-semibold transition duration-150 hover:bg-secondary-100 hover:text-secondary-900 focus:outline-none">Cancel</button>

        <button @click="updateDues" class="py-3 px-10 rounded disabled:opacity-50 disabled:cursor-wait bg-primary-600 text-white font-semibold transition duration-150 hover:bg-primary-500 focus:outline-none">Update</button>
      </div>
    </div>
  </div>

  <!-- Import status dialog -->
  <div x-cloak x-ref="importSuccessModal" x-transition x-show.transition.opacity="successModalOpen" class="overflow-auto fixed z-20 top-0 left-0 w-screen h-screen bg-black bg-opacity-50 flex items-center justify-center" role="dialog" aria-modal="true">
    <div class="w-full h-full lg:h-4/5 max-w-screen-md bg-white rounded-xl shadow-xl flex flex-col absolute divide-y divide-secondary-200">

      <div class="px-5 py-4 flex items-center justify-between bg-gradient-to-r from-primary-400 to-primary-600 rounded-t-lg text-white">
        <h1 class="flex items-center gap-2 text-2xl leading-tight font-bold" x-ref="import_success_title">

        </h1>

        <button class="text-white hover:bg-primary-700 p-2 rounded-full" @click="successModalOpen = false">
          <svg class="w-4 fill-current transition duration-150" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.001 512.001">
            <path d="M284.286 256.002L506.143 34.144c7.811-7.811 7.811-20.475 0-28.285-7.811-7.81-20.475-7.811-28.285 0L256 227.717 34.143 5.859c-7.811-7.811-20.475-7.811-28.285 0-7.81 7.811-7.811 20.475 0 28.285l221.857 221.857L5.858 477.859c-7.811 7.811-7.811 20.475 0 28.285a19.938 19.938 0 0014.143 5.857 19.94 19.94 0 0014.143-5.857L256 284.287l221.857 221.857c3.905 3.905 9.024 5.857 14.143 5.857s10.237-1.952 14.143-5.857c7.811-7.811 7.811-20.475 0-28.285L284.286 256.002z" />
          </svg>
        </button>
      </div>

      <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
        <div class="flex items-center gap-2 font-bold">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          Reminder
        </div>
        <p class="text-sm">To fulfill your recent unsuccessful import, you have to resolve these following rows in your spreadsheet.</p>
      </div>

      <div class="overflow-y-scroll w-full py-3">
        <table class="w-full">
          <thead>
            <tr x-ref="import_success_table_thead">
              <th>Row no</th>
              <th>Column(s)</th>
              <th>Error(s)</th>
            </tr>
          </thead>
          <tbody x-ref="import_success_table_rows">
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- payment status dialog -->
  <div x-cloak class="fixed left-0 bottom-0 z-40 " @keydown.window.escape="fixedAlertOpen = false">
    <div x-show="fixedAlertOpen === true" x-ref="fixed_alert" class="fixed left-4 bottom-4 sm:bottom-10 rounded-lg bg-white shadow-2xl w-96 overflow-hidden" style="display: none;" x-transition:enter="transition ease-in duration-200" x-transition:enter-start="opacity-0 transform -translate-x-40" x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform -translate-x-40">
      <div class="">
        <div class="relative overflow-hidden px-6 pt-4">
          <header class="mb-2 flex gap-2 font-bold" :class="fixedAlertIsSuccess ? 'text-success-600' : 'text-danger-600'">
            <svg x-show="fixedAlertIsSuccess" class="w-6 sm:w-5 h-6 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <svg x-show="!fixedAlertIsSuccess" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span x-ref="fixed_alert_label" x-text="fixedAlertIsSuccess ? 'Success' : 'Fail'"></span>
          </header>
          <div class="pb-4 flex gap-2 justify-between items-end">
            <p class="line-clamp-3 text-secondary-800" x-ref="fixed_alert_message">
            </p>
            <button x-show="fixedAlertWithView" @click="successModalOpen = true" class="whitespace-nowrap text-sm font-bold hover:bg-secondary-100 p-2 rounded-md">
              View More
            </button>
          </div>
        </div>

        <div class="absolute right-4 top-3 text-gray-400 hover:text-gray-800 cursor-pointer" @click="fixedAlertOpen = !fixedAlertOpen">
          <svg class="w-6 sm:w-5 h-6 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </div>
      </div>
    </div>
    <button x-show="fixedAlertOpen === false" class="fixed left-4 bottom-10 uppercase text-sm px-4 py-3 bg-secondary-900 rounded-full" :class="fixedAlertIsSuccess ? 'text-success-600' : 'text-danger-600'" @click="fixedAlertOpen = !fixedAlertOpen">
      <svg x-show="fixedAlertIsSuccess" class="w-6 sm:w-5 h-6 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <svg x-show="!fixedAlertIsSuccess" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </button>
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

        // jquery datatable
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
          'dom': 'fBrtilp',
          'pageLength': 5,
          'order': [
            [1, 'desc']
          ],
          'processing': true,
          'serverSide': true,
          'searchDelay': 350,
          'serverMethod': 'post',
          'ajax': {
            'url': 'duesDatatable',
            'data': function(data) {
              // Append to data
              data.startMonth = app.startMonth;
              data.endMonth = app.endMonth;
              data.startYear = app.startYear;
              data.endYear = app.endYear;

              data.paymentType = app.dt_payment_type;

              data.includeDeleted = app.dt_include_deleted;
            }
          },
          "language": {
            "processing": 'Please wait...'
          },
          drawCallback: function(settings) {
            const totalAmount = settings.aoData[0] ? settings.aoData[0]._aData.total_amount : 0
            let pdaTotalAmount = 0
            let pdaRemittedMembers = []
            settings.aoData.forEach((item, index) => {
              if (item._aData.type == 'PDA') {
                pdaTotalAmount += parseInt(item._aData.amount)
                pdaRemittedMembers.push(item._aData.prc_number)
              }
            })
            pdaRemittedMembers = [...new Set(pdaRemittedMembers)]

            app.total_pda_members_remitted = pdaRemittedMembers.length
            app.total_pda_amounts_remitted = pdaTotalAmount

            app.writeToFooterColumn(0, 'Payment Summary', 'text')
            app.writeToFooterColumn(3, parseInt(totalAmount), 'currency')

            app.afterDrawStartMonth = app.startMonth
            app.afterDrawStartYear = app.startYear
            app.afterDrawEndMonth = app.endMonth
            app.afterDrawEndYear = app.endYear

            app.startDateString = `${dayjs().month(app.startMonth - 1).format('MMMM')} ${app.startYear}`
            app.endDateString = `${dayjs().month(app.endMonth - 1).format('MMMM')} ${app.endYear}`
          },
          'columns': [{
              data: 'dues.id',
              sortable: false,
              class: 'disabled-cols visible-always',
              render: function(d, t, r, m) {
                return `
                <div class="flex items-center gap-2">
                  <span class="text-secondary-600">${r['dues.id']}</span>
                  <div class="relative" x-data="{dropDownOpen:false}">
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
                      <a href="javascript:void(0)" @click="paymentModalOpen = true; showEditDues(${r['dues.id']});" class="flex gap-2 items-center justify-center text-secondary-700 text-center bg-white hover:bg-secondary-100 focus:bg-secondary-200 px-4 py-2">
                      <img width="20" src="<?php echo URLROOT ?>/img/icons/pencil-alt.svg"/>                    
                      Edit
                      </a>
                      <a href="javascript:void(0)" @click="deleteDues(${r['dues.id']});" class="flex gap-2 items-center justify-center text-center px-4 py-2" :class="'${r.deleted_at ? ' bg-success-600 hover:bg-success-700 focus:bg-success-800 text-white ' : ' bg-danger-600 hover:bg-danger-700 focus:bg-danger-800 text-white '}'" >
                      <img width="20" src="<?php echo URLROOT ?>/img/icons${r.deleted_at ? '/refresh.svg' : '/trash.svg'}"/>                    
                      <span>${r.deleted_at ? 'Restore' : 'Archive'}</span>
                      </a>
                    </div>                    
                  </div>
                  <div x-show="${r.deleted_at}" class="text-danger-600 italic text-sm">Archived</div>
                </div>
                `
              }
            },
            {
              data: 'date_posted',
              render: function(d, t, r, m) {
                return `<span class="text-secondary-500">${r.date_posted}</span>`
              }
            },
            {
              data: 'last_name',
              sortable: false,
              render: function(d, t, r, m) {
                if (!r.user_id) {
                  return `<span>${r.last_name}</span>`;
                }

                return `<a href="viewAccount/?id=${r.user_id}" class="font-medium hover:underline hover:text-primary-600 hover:bg-primary-50" class="text-danger-500">
                  ${r.last_name} </a>`;
              }
            },
            {
              data: 'amount',
              sortable: false,
              render: function(d, t, r, m) {
                return `<span class="font-mono">${parseInt(r.amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")}</span>`;
              }
            },
            {
              data: 'type',
              sortable: false,
              render: function(d, t, r, m) {
                return `<span class="uppercase">${r.type}</span>`
              }
            },
            {
              data: 'or_number',
              sortable: false,
              render: function(d, t, r, m) {
                return `<span class="text-secondary-600">${r.or_number}</span>`
              }
            },
            {
              data: 'remarks',
              visible: false,
              sortable: false,
              render: function(d, t, r, m) {
                return `<span class="text-secondary-600">${r.remarks}</span>`
              }
            },
            {
              data: 'channel',
              visible: false,
              sortable: false,
              render: function(d, t, r, m) {
                return `<span class="text-secondary-600">${r.channel}</span>`
              }
            },
            {
              data: 'surname',
              visible: false,
              sortable: false,
              class: 'disabled-cols'
            },
            {
              data: 'first_name',
              visible: false,
              sortable: false,
              class: 'disabled-cols'
            },
            {
              data: 'middle_name',
              visible: false,
              sortable: false,
              class: 'disabled-cols'
            },
            {
              data: 'prc_number',
              visible: false,
              sortable: false,
              class: 'disabled-cols'
            },
            {
              data: 'contact_number',
              visible: false,
              sortable: false,
              class: 'disabled-cols'
            },
            {
              data: 'email',
              visible: false,
              sortable: false,
              class: 'disabled-cols'
            },
          ],
          initComplete: function() {
            this.api().columns('.hidden-first').visible(false)

            // search user profile component
            fetch("<?php echo URLROOT . '/profiles/fetchUserProfile' ?>", {
                method: 'POST'
              })
              .then(response => response.json())
              .then(data => {
                if (data.status == 'ok') {
                  app.options = data
                }
              });

            this.api().draw('page')
          },
          buttons: [{
              text: 'exports',
              extend: 'collection',
              className: 'custom-html-collection buttons-excel',
              buttons: [
                '<header>Export to</header>',
                {
                  extend: 'csvHtml5',
                  exportOptions: {
                    columns: ':visible :not(.disabled-cols)'
                  },
                  title: '',
                  footer: true,
                  customize: function(csv) {
                    return $('#cap_start_year').text() + "\n" +
                      $('#cap_end_year').text() + "\n\n" +
                      csv;
                  }
                },
                {
                  extend: 'excelHtml5',
                  title: '',
                  exportOptions: {
                    columns: ':visible :not(.disabled-cols)'
                  },
                  messageTop: '',
                  messageBottom: '',
                  footer: true,
                  customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    var numrows = 3;
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
                      value: $('#cap_start_year').text()
                    }]);
                    var r2 = Addrow(2, [{
                      key: 'A',
                      value: $('#cap_end_year').text()
                    }]);
                    var r3 = Addrow(3, [{
                      key: 'A',
                      value: ''
                    }]);

                    var sheetData = sheet.getElementsByTagName('sheetData')[0];

                    sheetData.insertBefore(r3, sheetData.childNodes[0]);
                    sheetData.insertBefore(r2, sheetData.childNodes[0]);
                    sheetData.insertBefore(r1, sheetData.childNodes[0]);
                  }
                },
              ]
            },
            {
              text: 'column visibility',
              extend: 'colvis',
              columns: ':not(.disabled-cols)',
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
                },
              ],
            },
            {
              text: "<span>Refresh</span>",
              action: function(e, dt, node, config) {
                dt.page.len(5);
                dt.clear().draw();
                dt.ajax.reload(null, false);
              }
            },
          ],
        });
        const archivedDuesTable = $('#archivedDuesTable').DataTable({
          "bStateSave": true,
          'lengthMenu': [
            [5, 10, 25, <?php echo MAX_ROW ?>],
            ['5 rows', '10 rows', '25 rows', 'All rows']
          ],
          'dom': 'frtilp',
          'pageLength': 5,
          'order': [
            [1, 'desc']
          ],
          'processing': true,
          'serverSide': true,
          'searchDelay': 350,
          'serverMethod': 'post',
          'ajax': {
            'url': 'duesDatatable',
            'data': function(data) {
              // Append to data
              data.startMonth = 1;
              data.endMonth = 1;
              data.startYear = 1980;
              data.endYear = dayjs().year();

              data.paymentType = '';

              data.includeDeleted = 'only';
            }
          },
          "language": {
            "processing": 'Please wait...'
          },
          'columns': [{
              data: 'dues.id',
              sortable: false,
              class: 'disabled-cols visible-always',
              render: function(d, t, r, m) {
                return `
                <div class="flex items-center gap-2">
                  <span class="text-secondary-600">${r['dues.id']}</span>
                  <a href="javascript:void(0)" @click="deleteDues(${r['dues.id']});" class="flex gap-2 items-center justify-center text-center p-2 rounded bg-success-600 hover:bg-success-700 focus:bg-success-800 text-white" >
                      <img width="20" src="<?php echo URLROOT ?>/img/icons/refresh.svg"/>                    
                      <span>Restore</span>
                  </a>
                </div>
                `
              }
            },
            {
              data: 'date_posted',
              render: function(d, t, r, m) {
                return `<span class="text-secondary-500">${r.date_posted}</span>`
              }
            },
            {
              data: 'last_name',
              sortable: false,
              render: function(d, t, r, m) {
                if (!r.user_id) {
                  return `<span>${r.last_name}</span>`;
                }

                return `<a href="viewAccount/?id=${r.user_id}" class="font-medium hover:underline hover:text-primary-600 hover:bg-primary-50" class="text-danger-500">
                  ${r.last_name} </a>`;
              }
            },
            {
              data: 'amount',
              sortable: false,
              render: function(d, t, r, m) {
                return `<span class="font-mono">${parseInt(r.amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")}</span>`;
              }
            },
            {
              data: 'type',
              sortable: false,
              render: function(d, t, r, m) {
                return `<span class="uppercase">${r.type}</span>`
              }
            },
            {
              data: 'or_number',
              sortable: false,
              render: function(d, t, r, m) {
                return `<span class="text-secondary-600">${r.or_number}</span>`
              }
            },
            {
              data: 'remarks',
              sortable: false,
              render: function(d, t, r, m) {
                return `<span class="text-secondary-600">${r.remarks}</span>`
              }
            },
            {
              data: 'channel',
              sortable: false,
              render: function(d, t, r, m) {
                return `<span class="text-secondary-600">${r.channel}</span>`
              }
            },
          ],
          initComplete: function() {
            // this.api().columns('.hidden-first').visible(false)
            this.api().draw('page')
          },

        });
        let debounce = new $.fn.dataTable.Debounce([dataTable, archivedDuesTable]);
        dataTable.on('preXhr.dt', function() {
          $('#myTable').addClass('text-secondary-200');
        });
        dataTable.on('xhr.dt', function() {
          $('#myTable').removeClass('text-secondary-200');
        });

        $('#report_filter').click(function() {
          dataTable.draw();
        });

        this.$watch('fixedAlertOpen', value => {
          let alertTimer;
          clearTimeout(alertTimer)

          if (value === true) {
            alertTimer = setTimeout(() => {
              this.fixedAlertOpen = false
            }, 10000);
          }
        })

        this.$watch('dt_payment_type', (value) => {
          dataTable.draw();
        });
        this.$watch('dt_include_deleted', (value) => {
          dataTable.draw()
        });
        this.$watch('startDateString', (value) => {
          $('#cap_start_year').text(
            `Selected start period: ${value}`
          )
        });
        this.$watch('endDateString', (value) => {
          $('#cap_end_year').text(
            `Selected end period: ${value}`
          )
        });

        this.$watch('paymentModalOpen', value => {
          const body = document.body;
          if (!this.paymentModalOpen) {
            body.classList.remove('h-screen');
            app.duesForm = {
              prc_number: '',
              profile_id: '',
              type: '',
              amount: '',
              channel: '',
              or_number: '',
              remarks: '',
              date_posted: {
                month: 1,
                year: 1981
              },
            }
            document.querySelector('#profile_id_err').classList.add('hidden')
            document.querySelector('#type_err').classList.add('hidden')
            document.querySelector('#amount_err').classList.add('hidden')
            document.querySelector('#channel_err').classList.add('hidden')
            document.querySelector('#or_number_err').classList.add('hidden')
            document.querySelector('#date_posted_err').classList.add('hidden')

            return body.classList.remove('overflow-hidden');
          } else {
            body.classList.add('h-screen');
            return body.classList.add('overflow-hidden');
          }
        });

        this.startYear = this.startYear == '' ? '2021' : this.startYear;
        this.endYear = this.endYear == '' ? '2022' : this.endYear;
      },
      onEditMode: true,
      formGroup: {
        [':class']() {
          let defaultClass = 'form-group'

          return this.onEditMode ? `${defaultClass} border-0` : `${defaultClass} border-b`
        },
        inputContainer: {
          [':class']() {
            return 'input-container'
          }
        },
        formLabel: {
          [':for']() {
            return this.$el.parentNode.querySelector('input, select, textarea').getAttribute('name')
          },
          [':class']() {
            return 'form-label'
          }
        },
        formInput: {
          [':id']() {
            return this.$el.getAttribute('name')
          },
          [':disabled']() {
            return !this.onEditMode
          },
          [':class']() {
            let defaultClass = 'form-input'

            return !this.onEditMode ? `${defaultClass} border-0 uppercase` : `${defaultClass} border-secondary-300`
          },
        },
        formInputError: {
          ['x-show']() {
            return this.onEditMode
          },
          [':class']() {
            return 'form-input-err'
          }
        },
      },

      currentTab: 1,
      total_pda_members_remitted: 0,
      total_pda_amounts_remitted: 0,

      dt_payment_type: '',
      dt_include_deleted: '',

      deleteDues(duesId) {
        fetch('<?php echo URLROOT . "/admins/deleteDues" ?>', {
            method: "POST",
            body: JSON.stringify({
              dues_id: duesId
            }),
            headers: {
              "Content-type": "application/json"
            }
          }).then(data => data.json())
          .then(res => {
            if (res.status == 'ok') {
              $('#myTable').DataTable().draw('page');
              $('#archivedDuesTable').DataTable().draw('page');
            }
          })
      },
      duesForm: {
        prc_number: '',
        profile_id: '',
        type: '',
        amount: '',
        channel: '',
        or_number: '',
        remarks: '',
        date_posted: {
          month: 1,
          year: 1981
        },
      },
      // Add payment modal form
      showEditDues(duesId) {
        fetch('<?php echo URLROOT . "/admins/fetchSingleDues" ?>', {
            method: "POST",
            body: JSON.stringify({
              dues_id: duesId
            }),
            headers: {
              "Content-type": "application/json"
            }
          }).then(res => res.json())
          .then(data => {
            this.duesForm.prc_number = data.dues.prc_number
            this.duesForm.dues_id = data.dues.id
            this.duesForm.profile_id = data.dues.profile_id
            this.duesForm.type = data.dues.type
            this.duesForm.amount = data.dues.amount
            this.duesForm.channel = data.dues.channel
            this.duesForm.or_number = data.dues.or_number
            this.duesForm.remarks = data.dues.remarks
            this.duesForm.date_posted.month = data.date_posted_month
            this.duesForm.date_posted.year = data.date_posted_year
          })

      },
      updateDues: function() {
        let actionText = this.$el.textContent
        this.$el.textContent = 'Please wait...'

        fetch('<?php echo URLROOT . "/admins/updateDues" ?>', {
            method: "POST",
            body: JSON.stringify({
              duesForm: this.duesForm
            }),
            headers: {
              "Content-type": "application/json"
            }
          }).then(data => data.json())
          .then(res => {
            this.$el.textContent = actionText
            this.$el.disabled = false

            if (res.status == 'ok') {
              if (res.status == 'ok') {
                $('#myTable').DataTable().draw('page');
              }
              this.paymentModalOpen = false
            } else {
              const profile_id_err = document.querySelector('#profile_id_err')
              const type_err = document.querySelector('#type_err')
              const amount_err = document.querySelector('#amount_err')
              const channel_err = document.querySelector('#channel_err')
              const or_number_err = document.querySelector('#or_number_err')
              const date_err = document.querySelector('#date_posted_err')

              profile_id_err.classList.remove('hidden')
              type_err.classList.remove('hidden')
              amount_err.classList.remove('hidden')
              channel_err.classList.remove('hidden')
              or_number_err.classList.remove('hidden')
              date_err.classList.remove('hidden')

              profile_id_err.textContent = res.errors.profile_id_err
              type_err.textContent = res.errors.type_err
              amount_err.textContent = res.errors.amount_err
              channel_err.textContent = res.errors.channel_err
              or_number_err.textContent = res.errors.or_number_err
              date_err.textContent = res.errors.date_posted_err
            }
          })
      },
      paymentModalOpen: false,
      // search input component
      show: false,
      selected: null,
      focusedOptionIndex: null,
      options: null,
      close() {
        this.show = false;
        // this.duesForm.prc_number = this.selectedName();
        this.focusedOptionIndex = this.selected ? this.focusedOptionIndex : null;
      },
      open() {
        this.show = true;
        // this.duesForm.prc_number = '';
      },
      toggle() {
        if (this.show) {
          this.close();
        } else {
          this.open()
        }
      },
      isOpen() {
        return this.show === true
      },
      selectedName() {
        return this.selected ? this.selected.prc_number : this.duesForm.prc_number;
      },
      classOption(id, index) {
        const isSelected = this.selected ? (id == this.selected.prc_number) : false;
        const isFocused = (index == this.focusedOptionIndex);
        return {
          'cursor-pointer w-full border-secondary-100 border-b hover:bg-blue-50': true,
          'bg-blue-100': isSelected,
          'bg-blue-50': isFocused
        };
      },
      filteredOptions() {
        return this.options ?
          this.options.data.filter(option => {
            return (`${option.first_name} ${option.last_name}`.toLowerCase().indexOf(this.duesForm.prc_number) > -1) ||
              (`${option.last_name} ${option.first_name}`.toLowerCase().indexOf(this.duesForm.prc_number) > -1) ||
              (option.prc_number.toLowerCase().indexOf(this.duesForm.prc_number) > -1)
          }) : {}
      },
      onOptionClick(index) {
        this.focusedOptionIndex = index;
        this.selectOption();
      },
      selectOption() {
        if (!this.isOpen()) {
          return;
        }
        this.focusedOptionIndex = this.focusedOptionIndex ?? 0;
        const selected = this.filteredOptions()[this.focusedOptionIndex]
        if (this.selected && this.selected.prc_number == selected.prc_number) {
          this.duesForm.prc_number = '';
          this.selected = null;
        } else {
          this.selected = selected;
          this.duesForm.prc_number = this.selectedName();
        }
        this.close();
      },
      focusPrevOption() {
        if (!this.isOpen()) {
          return;
        }
        const optionsNum = Object.keys(this.filteredOptions()).length - 1;
        if (this.focusedOptionIndex > 0 && this.focusedOptionIndex <= optionsNum) {
          this.focusedOptionIndex--;
        } else if (this.focusedOptionIndex == 0) {
          this.focusedOptionIndex = optionsNum;
        }
      },
      focusNextOption() {
        const optionsNum = Object.keys(this.filteredOptions()).length - 1;
        if (!this.isOpen()) {
          this.open();
        }
        if (this.focusedOptionIndex == null || this.focusedOptionIndex == optionsNum) {
          this.focusedOptionIndex = 0;
        } else if (this.focusedOptionIndex >= 0 && this.focusedOptionIndex < optionsNum) {
          this.focusedOptionIndex++;
        }
      },

      // payments (need fix)
      calculateTotalAmount(colIndex) {
        let amountColumn = $('#myTable').DataTable().column(colIndex)
        let rows = $('#myTable').DataTable().rows({
          search: 'applied'
        })

        let rowData = rows.data().toArray()

        return rowData.reduce((acc, cur) => {
          let amount = 0
          let colString = cur.amount

          if (typeof(colString) == 'string') {
            colString = colString.split(',')
            amount = colString.reduce((acc, cur) => {
              return acc + parseInt(cur)
            }, 0)
          }

          if (isNaN(amount)) {
            amount = 0
          }

          return acc + amount
        }, 0)
      },
      writeToFooterColumn(colIndex, value, type) {
        let amountColumn = $('#myTable').DataTable().column(colIndex);

        if (type === 'currency') {
          $(amountColumn.footer()).addClass(
            'bg-secondary-50'
          )
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

      startDateString: `${dayjs().format('MMMM')} 1981`,
      endDateString: `${dayjs().format('MMMM')} ${dayjs().add(1, 'year').year()}`,
      afterDrawStartMonth: dayjs().month() + 1,
      afterDrawEndMonth: dayjs().month() + 1,
      afterDrawStartYear: 1981,
      afterDrawEndYear: dayjs().add(1, 'year').year(),
      startMonth: dayjs().month() + 1,
      endMonth: dayjs().month() + 1,
      startYear: 1981,
      endYear: dayjs().add(1, 'year').year(),
      dates: <?php echo json_encode($data['dates']); ?>,
      resetEndYearsFromStartYear: function() {
        return this.dates.filter((value, index, arr) => {
          return value > this.startYear
        })
      },
      type: '',

      addSingleDues: function() {
        const prc_number_err = document.querySelector('#add_prc_number_err')
        const type_err = document.querySelector('#add_type_err')
        const amount_err = document.querySelector('#add_amount_err')
        const channel_err = document.querySelector('#add_channel_err')
        const or_number_err = document.querySelector('#add_or_number_err')
        const date_posted_err = document.querySelector('#add_date_posted_err')

        let actionText = this.$el.textContent
        this.$el.textContent = 'Please wait...'

        fetch('<?php echo URLROOT . "/admins/addDues" ?>', {
            method: "POST",
            body: JSON.stringify({
              duesForm: this.duesForm
            }),
            headers: {
              "Content-type": "application/json"
            }
          }).then(data => data.json())
          .then(res => {
            $('#myTable').DataTable().draw('page');

            this.$el.textContent = actionText
            this.$el.disabled = false
            this.fixedAlertIsSuccess = false;
            this.fixedAlertWithView = false;
            this.fixedAlertOpen = false;

            if (res.status == 'ok') {
              this.$refs.dues_form.reset()
              this.duesForm = {
                prc_number: '',
                type: '',
                amount: '',
                channel: '',
                or_number: '',
                remarks: '',
                date_posted: {
                  month: 1,
                  year: 1981
                }
              }

              prc_number_err.classList.add('hidden')
              type_err.classList.add('hidden')
              amount_err.classList.add('hidden')
              channel_err.classList.add('hidden')
              or_number_err.classList.add('hidden')
              date_posted_err.classList.add('hidden')

              this.fixedAlertOpen = true
              this.fixedAlertIsSuccess = true;
              this.fixedAlertWithView = false
              this.$refs.fixed_alert_message.textContent = `You submitted a due`
            } else {
              this.fixedAlertOpen = true;
              this.fixedAlertIsSuccess = false;
              this.fixedAlertWithView = false;
              this.$refs.fixed_alert_message.textContent = res.message

              prc_number_err.classList.remove('hidden')
              type_err.classList.remove('hidden')
              amount_err.classList.remove('hidden')
              channel_err.classList.remove('hidden')
              or_number_err.classList.remove('hidden')
              date_posted_err.classList.remove('hidden')

              prc_number_err.textContent = res.errors.prc_number_err
              type_err.textContent = res.errors.type_err
              amount_err.textContent = res.errors.amount_err
              channel_err.textContent = res.errors.channel_err
              or_number_err.textContent = res.errors.or_number_err
              date_posted_err.textContent = res.errors.date_posted_err
            }
          })
      },
      importBulkDues: function() {
        const dues_file_err = document.querySelector('#dues_file_err')
        dues_file_err.classList.add('hidden')
        let actionText = this.$el.textContent
        this.$el.textContent = 'Please wait...'

        const updateRequest = new FormData();
        updateRequest.append('dues_file', document.querySelector('#dues_file').files[0])

        fetch('<?php echo URLROOT . "/admins/importDues" ?>', {
          method: "POST",
          body: updateRequest,
        }).then(data => data.json())
          .then(res => {
            this.$el.textContent = actionText
            this.$el.disabled = false
            this.fixedAlertIsSuccess = false;
            this.fixedAlertWithView = false;
            this.fixedAlertOpen = false;

            if (res.status == 'ok') {
              $('#myTable').DataTable().draw('page');
              this.$refs.dues_import.reset()

              this.fixedAlertOpen = true
              this.fixedAlertIsSuccess = true
              // this.fixedAlertWithView = true
              // this.insertedRows = res.insertedRows
              let newArr = []
              res.insertedRows.forEach((item, index) => {
                item.date_posted = dayjs(item.date_posted).year()
                newArr.push(Object.values(item))
              })

              this.$refs.fixed_alert_message.textContent = `You imported ${newArr.length} dues`            
            } else {
              this.fixedAlertOpen = true
              this.fixedAlertIsSuccess = false
              this.fixedAlertWithView = false;

              if (res.error_title == 'cell error') {
                this.fixedAlertWithView = true
                this.$refs.import_success_title.textContent = 'List of rows with validation errors'
                this.$refs.import_success_table_rows.innerHTML = ''

                for (const [key, value] of Object.entries(res.rows)) {
                  this.$refs.import_success_table_rows.innerHTML +=
                    `<tr>
                    <td>${value.rowNo}</td>
                    <td>(${value.column.split(',').length}) ${value.column}</td>
                    <td>(${value.status.split(',').length}) ${value.status}</td>
                  </tr>`
                }
              } else if (res.error_title == 'prc not found') {
                this.fixedAlertWithView = true
                this.$refs.import_success_title.textContent = 'List of rows with invalid prc numbers'
                this.$refs.import_success_table_rows.innerHTML = ''

                for (const [key, value] of Object.entries(res.rows)) {
                  this.$refs.import_success_table_rows.innerHTML +=
                    `<tr>
                    <td>${key}</td>
                    <td>${value}</td>
                    <td>PRC number is not linked to any profile</td>
                  </tr>`
                }
              } else if (res.error_title == 'spreadsheet duplicate') {
                this.fixedAlertWithView = true
                this.$refs.import_success_title.textContent = 'List of rows with duplicate OR Numbers'
                this.$refs.import_success_table_rows.innerHTML = ''

                res.rows.forEach((item, index) => {
                  this.$refs.import_success_table_rows.innerHTML +=
                    `<tr>
                    <td>${item.rowNo}</td>
                    <td>OR No.</td>
                    <td>duplicate OR No.</td>
                  </tr>`
                })
              } else if (res.error_title == 'database duplicate') {
                this.fixedAlertWithView = true
                this.$refs.import_success_title.textContent = 'List of rows with already taken OR Numbers'
                this.$refs.import_success_table_rows.innerHTML = ''

                for (const [key, value] of Object.entries(res.rows)) {
                  this.$refs.import_success_table_rows.innerHTML +=
                    `<tr>
                    <td>${key}</td>
                    <td>OR No.</td>
                    <td>Already taken OR No.</td>
                  </tr>`
                }
              }
              this.$refs.fixed_alert_message.textContent = res.message

              dues_file_err.classList.remove('hidden')
              dues_file_err.textContent = res.message
            }
          })
      },
      fixedAlertOpen: '',
      fixedAlertIsSuccess: false,
      fixedAlertWithView: false,
      successModalOpen: false,
      insertedRows: [],

      generateYearsBetween: function(startYear = 1980, endYear) {
        const endDate = endYear || new Date().getFullYear() + 1;
        let years = [];
        for (var i = startYear; i <= endDate; i++) {
          years.push(startYear);
          startYear++;
        }
        return years;
      },
    }))
  })
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>