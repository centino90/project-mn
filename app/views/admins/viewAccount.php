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
          <button type="button" @click="window.location.href='<?php echo URLROOT; ?>/admins/profiles'" class="flex items-center text-blue-600 p-2 rounded-md hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
            Profiles
          </button>

          <span class="separator">
            <svg class="fill-current text-secondary-300 w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" stroke="currentColor">
              <path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
            </svg>
          </span>
        </li>
        <li class="flex items-center">
          <span aria-current="page">
            View profile
          </span>
        </li>
      </ol>
    </nav>
  </div>

  <header class="flex flex-col gap-10 mb-10">
    <div class="flex gap-4">
      <a href="<?php echo URLROOT?>/admins/profiles" class="hover:text-blue-500 text-blue-700 text-sm font-bold flex items-center gap-1">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
        </svg>
        Return
      </a>
      <span class="text-2xl font-bold">View profile (<?php echo arrangeFullname($data['user']->first_name ?? '', $data['user']->middle_name ?? '', $data['user']->last_name ?? '') ?>)</span>
    </div>
  </header>

  <div>
    <?php if (!empty($data['profile_err'])) : ?>
      <div x-transition class="w-full bg-opacity-50">
        <div class="shadow sm:rounded-md sm:overflow-hidden h-52 lg:h-96 flex flex-wrap justify-center items-center">
          <div class="flex flex-col">
            <div class="mb-3 ml-auto">
              <a href="<?php echo URLROOT ?>/admins/profiles" class="text-blue-500 hover:text-blue-400 hover:underline">See profiles</a>
            </div>
            <div class="rounded-lg w-96 py-8 px-4 bg-danger-100 flex justify-center gap-3 text-danger-900 font-semibold">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
              </svg>
              <?php echo $data['profile_err'] ?>
            </div>
          </div>
        </div>
      </div>
    <?php else : ?>
      <div class="w-full">
        <div class="mt-5">
          <ul class="list-reset flex flex-wrap border-b">
            <li @click="currentTab = 1" class="-mb-px mr-1">
              <a :class="currentTab == 1 ? 'border-l border-t border-r rounded-t' : 'hover:text-primary-500 hover:bg-secondary-100'" class="rounded-t-lg bg-white inline-block py-2 px-4 font-semibold" href="javascript:void(0);">User account</a>
            </li>
            <li @click="currentTab = 2" class="-mb-px mr-1">
              <a :class="currentTab == 2 ? 'border-l border-t border-r rounded-t' : 'hover:text-primary-500 hover:bg-secondary-100'" class="rounded-t-lg bg-white inline-block py-2 px-4 font-semibold" href="javascript:void(0);">Personal</a>
            </li>
            <li @click="currentTab = 3" class="-mb-px mr-1">
              <a :class="currentTab == 3 ? 'border-l border-t border-r rounded-t' : 'hover:text-primary-500 hover:bg-secondary-100'" class="rounded-t-lg bg-white inline-block py-2 px-4 font-semibold" href="javascript:void(0);">License</a>
            </li>
            <li @click="currentTab = 4" class="-mb-px mr-1">
              <a :class="currentTab == 4 ? 'border-l border-t border-r rounded-t' : 'hover:text-primary-500 hover:bg-secondary-100'" class="rounded-t-lg bg-white inline-block py-2 px-4 font-semibold" href="javascript:void(0);">Clinic</a>
            </li>
            <li @click="currentTab = 5" class="-mb-px mr-1">
              <a :class="currentTab == 5 ? 'border-l border-t border-r rounded-t' : 'hover:text-primary-500 hover:bg-secondary-100'" class="rounded-t-lg bg-white inline-block py-2 px-4 font-semibold" href="javascript:void(0);">Emergency</a>
            </li>
            <li @click="currentTab = 6" class="-mb-px mr-1">
              <a :class="currentTab == 6 ? 'border-l border-t border-r rounded-t' : 'hover:text-primary-500 hover:bg-secondary-100'" class="rounded-t-lg bg-white inline-block py-2 px-4 font-semibold" href="javascript:void(0);">Payments</a>
            </li>
          </ul>
        </div>
      </div>

      <!--  profile info -->
      <div x-transition x-show="currentTab == 1" class="w-full bg-opacity-50">
        <?php if ($data['user']->email_verified) : ?>
          <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
              <div class="w-full">
                <button @click="onEditMode = !onEditMode" x-show="!onEditMode" type="button" class="ml-auto flex text-blue-600 p-2 rounded-md hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                  Change details
                </button>

                <button @click="onEditMode = !onEditMode" x-show="onEditMode" type="button" class="ml-auto flex text-blue-600 p-2 rounded-md bg-secondary-100 hover:bg-secondary-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                  Cancel editing
                </button>
              </div>

              <div class="flex flex-col gap-y-8">
                <!-- profile img -->
                <div x-bind="formGroup">
                  <label class="form-label">Profile image</label>
                  <div x-bind="formGroup.inputContainer">
                    <div class="py-2">
                      <?php if (empty($data['user']->profile_img_path)) : ?>
                        <!-- Profile image -->
                        <a href="javascript:void(0)" @click="onEditMode ? $refs.profile_input.click() : $event.target.preventDefault">
                          <div class="rounded-full border" style="width: 50px;height:50px">
                            <img class="w-full h-full profile-img" src="<?php echo URLROOT ?>/img/profiles/default-profile.png" alt="profile img">
                          </div>
                          <span x-show="onEditMode" class="text-sm flex items-center gap-2 pt-1 text-blue-600 hover:underline">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Choose a profile
                          </span>
                          <input type="file" @change="submitProfileImg" x-ref="profile_input" class="form-input hidden" name="profile_image">
                        </a>
                      <?php else : ?>
                        <a id="view_img_link" href="<?php echo URLROOT . '/' . $data['user']->profile_img_path ?>" target="_blank" class="py-2">
                          <div class="rounded-full border overflow-hidden hover:opacity-50" style="width: 50px;height:50px">
                            <img class="w-full h-full profile-img" src="<?php echo URLROOT . '/' . $data['user']->thumbnail_img_path ?>" alt="profile img">
                          </div>
                        </a>

                        <a x-show="onEditMode" href="javascript:void(0)" class="py-2" @click="$refs.profile_input.click()">
                          <span x-show="onEditMode" class="flex items-center gap-2 pt-1 text-sm text-blue-600 hover:underline">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Update profile
                          </span>
                          <input type="file" @change="submitProfileImg" x-ref="profile_input" class="form-input hidden" name="profile_image">
                        </a>
                      <?php endif; ?>
                      <span x-show="onEditMode" class="hidden text-danger-600 text-sm" id="profile_img_err">
                      </span>
                    </div>
                  </div>
                </div>

                <!-- Email -->
                <div x-bind="formGroup">
                  <label x-bind="formGroup.formLabel">
                    Email
                  </label>
                  <div x-bind="formGroup.inputContainer">
                    <input type="email" x-bind="formGroup.formInput" x-model="profile.email" x-ref="email_input" class="lowercase" placeholder="Enter their email" name="email" autocomplete="off">
                    <span x-bind="formGroup.formInputError" class="hidden" id="email_err">
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Form submit -->
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
              <div class="form-group">
                <label class="form-label"></label>
                <div class="input-container">
                  <button x-show="onEditMode" x-ref="submit" @click="submitProfileEmail" type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Save
                  </button>
                </div>
              </div>
            </div>
          </div>
        <?php else : ?>
          <div class="shadow sm:rounded-md sm:overflow-hidden h-52 lg:h-96 flex flex-wrap justify-center items-center">
            <div class="flex flex-col">
              <div class="mb-3 ml-auto">
                <a href="<?php echo URLROOT ?>/admins/users" class="text-blue-500 hover:text-blue-400 hover:underline">See users</a>
              </div>
              <div class="rounded-lg w-96 py-8 px-4 bg-warning-100 flex justify-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                This profile is not linked to any user account
              </div>
            </div>
          </div>
        <?php endif ?>
      </div>

      <!--  personal info -->
      <div x-transition x-show="currentTab == 2" class="w-full bg-opacity-50">
        <div class="shadow sm:rounded-md sm:overflow-hidden">
          <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
            <div class="w-full">
              <button @click="onEditMode = !onEditMode" x-show="!onEditMode" type="button" class="ml-auto flex text-blue-600 p-2 rounded-md hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Change details
              </button>

              <button @click="onEditMode = !onEditMode" x-show="onEditMode" type="button" class="ml-auto flex text-blue-600 p-2 rounded-md bg-secondary-100 hover:bg-secondary-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Cancel editing
              </button>
            </div>

            <div class="flex flex-col gap-y-8">
              <!-- First name -->
              <div x-bind="formGroup">
                <label x-bind="formGroup.formLabel">
                  First name
                </label>
                <div x-bind="formGroup.inputContainer">
                  <input type="text" x-model="personal.first_name" x-bind="formGroup.formInput" name="first_name">
                  <span x-bind="formGroup.formInputError" id="first_name_err">
                  </span>
                </div>
              </div>

              <!-- Middle name -->
              <div x-bind="formGroup">
                <label x-bind="formGroup.formLabel">
                  Middle name
                </label>
                <div x-bind="formGroup.inputContainer">
                  <input type="text" x-model="personal.middle_name" x-bind="formGroup.formInput" name="middle_name">
                  <span x-bind="formGroup.formInputError" id="middle_name_err">
                  </span>
                </div>
              </div>

              <!-- Last name -->
              <div x-bind="formGroup">
                <label x-bind="formGroup.formLabel">
                  Last name
                </label>
                <div x-bind="formGroup.inputContainer">
                  <input type="text" x-model="personal.last_name" x-bind="formGroup.formInput" name="last_name">
                  <span x-bind="formGroup.formInputError" id="last_name_err">
                </div>
              </div>

              <!-- Date of birth -->
              <div x-bind="formGroup">
                <label x-bind="formGroup.formLabel">
                  Date of Birth
                </label>
                <div x-bind="formGroup.inputContainer">
                  <input type="date" x-model="personal.birthdate" x-bind="formGroup.formInput" name="birthdate">
                  <span x-bind="formGroup.formInputError" id="birthdate_err">
                </div>
              </div>

              <!-- Gender -->
              <div x-bind="formGroup">
                <label x-bind="formGroup.formLabel">
                  Gender
                </label>
                <div x-bind="formGroup.inputContainer">
                  <select x-bind="formGroup.formInput" name="gender" x-model="personal.gender">
                    <option value="">Select</option>
                    <option value="Female">Female</option>
                    <option value="Male">Male</option>
                  </select>
                  <span x-bind="formGroup.formInputError" id="gender_err">
                </div>
              </div>

              <!-- Contact no -->
              <div x-bind="formGroup">
                <label x-bind="formGroup.formLabel">
                  Contact number
                </label>
                <div x-bind="formGroup.inputContainer">
                  <input type="text" x-model="personal.contact_number" x-bind="formGroup.formInput" name="contact_number">
                  <span x-bind="formGroup.formInputError" id="contact_number_err">
                </div>
              </div>

              <!-- Facebook account name -->
              <div x-bind="formGroup">
                <label x-bind="formGroup.formLabel">
                  Facebook account name
                </label>
                <div x-bind="formGroup.inputContainer">
                  <input type="text" x-model="personal.fb_account_name" x-bind="formGroup.formInput" name="fb_account_name">
                  <span x-bind="formGroup.formInputError" id="fb_account_name_err">
                </div>
              </div>

              <!-- Home address -->
              <div x-bind="formGroup">
                <label x-bind="formGroup.formLabel">
                  Home address
                </label>
                <div x-bind="formGroup.inputContainer">
                  <input type="text" x-model="personal.address" x-bind="formGroup.formInput" name="address">
                  <span x-bind="formGroup.formInputError" id="address_err">
                </div>
              </div>
            </div>
          </div>

          <!-- Form submit -->
          <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <div class="form-group">
              <label class="form-label"></label>
              <div class="input-container">
                <button x-show="onEditMode" @click="submitPersonal" type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                  Save
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!--  license info -->
      <div x-transition x-show="currentTab == 3" class="w-full bg-opacity-50">
        <div class="shadow sm:rounded-md sm:overflow-hidden">
          <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
            <div class="w-full">
              <button @click="onEditMode = !onEditMode" x-show="!onEditMode" type="button" class="ml-auto flex text-blue-600 p-2 rounded-md hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Change details
              </button>

              <button @click="onEditMode = !onEditMode" x-show="onEditMode" type="button" class="ml-auto flex text-blue-600 p-2 rounded-md bg-secondary-100 hover:bg-secondary-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Cancel editing
              </button>
            </div>

            <div class="flex flex-col gap-y-8">
              <!-- License no -->
              <div x-bind="formGroup">
                <label x-bind="formGroup.formLabel">
                  PRC license no
                </label>
                <div x-bind="formGroup.inputContainer">
                  <input type="text" x-model="license.prc_number" x-bind="formGroup.formInput" name="prc_number">
                  <span x-bind="formGroup.formInputError" id="prc_number_err">
                </div>
              </div>

              <!-- Registration date -->
              <div x-bind="formGroup">
                <label x-bind="formGroup.formLabel">
                  Registration date <small class="font-medium">(MM/DD/YY)</small>
                </label>
                <div x-bind="formGroup.inputContainer">
                  <div class="flex flex-1 items-center">
                    <input :type="!onEditMode ? 'text' : 'date'" x-model="license.prc_registration_date" :value="!onEditMode ? `<?php echo $data['user']->prc_registration_date ?> (${dayjs('<?php echo $data['user']->prc_registration_date ?>').format('MMMM DD, YYYY')})` : '<?php echo $data['user']->prc_registration_date ?>'" x-bind="formGroup.formInput" :max="dayjs().format('YYYY-MM-DD')" name="prc_registration_date">
                  </div>
                  <span x-bind="formGroup.formInputError" id="prc_registration_date_err">
                </div>
              </div>

              <!-- Expiration date -->
              <div x-bind="formGroup">
                <label x-bind="formGroup.formLabel">
                  Expiration date <small class="font-medium">(MM/DD/YY)</small>
                </label>
                <div x-bind="formGroup.inputContainer">
                  <div class="flex flex-1 items-center">
                    <input :type="!onEditMode ? 'text' : 'date'" x-model="license.prc_expiration_date" x-bind="formGroup.formInput" :min="dayjs().add(1, 'day').format('YYYY-MM-DD')" name="prc_expiration_date">
                    <span x-show="!onEditMode && license.prc_expiration_date != ''" :class="checkIfRegistrationIsExpired() ? 'bg-danger-100 text-danger-800' : 'bg-warning-100 text-warning-800'" class="whitespace-nowrap px-2 inline-flex items-center gap-1 text-xs leading-5 font-semibold rounded-full">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                      </svg>
                      <span x-ref="expiry_status" x-text="generateExpirationStatus()">
                      </span>
                    </span>
                  </div>
                  <span x-bind="formGroup.formInputError" id="prc_expiration_date_err">
                </div>
              </div>

              <!-- Field of practice -->
              <div x-bind="formGroup" x-data="{specified: false}" x-init="license.field_practice != 'General' ? specified = true : specified = false">
                <label x-bind="formGroup.formLabel">
                  Field of practice
                  <a class="mx-1 text-blue-400 hover:underline cursor-pointer" @click="specified = !specified" x-show="onEditMode && specified">Change option</a>
                </label>
                <div x-bind="formGroup.inputContainer">
                  <select x-model="license.field_practice" @change="if($event.target.value == 'Specialist') { specified = true;license.field_practice = ''}" x-bind="formGroup.formInput" x-show="onEditMode && !specified" :disabled="specified" name="field_practice">
                    <option value="">Select</option>
                    <option value="General">General</option>
                    <option value="Specialist">Specialist</option>
                  </select>
                  <input type="text" x-model="license.field_practice" x-bind="formGroup.formInput" x-show="!onEditMode || specified" :disabled="!specified" name="field_practice" placeholder="Specify your field of practice(s) (e.g. Endodontics, Prosthodontics, etc.)">
                  <span x-bind="formGroup.formInputError" id="field_practice_err">
                </div>
              </div>

              <!-- Type of practice -->
              <div x-bind="formGroup" x-data="{specified: false}">
                <label x-bind="formGroup.formLabel">
                  Type of practice
                  <a class="mx-1 text-blue-400 hover:underline cursor-pointer" @click="specified = !specified;license.type_practice = ''" x-show="onEditMode && !specified">Specify</a>
                  <a class="mx-1 text-blue-400 hover:underline cursor-pointer" @click="specified = !specified" x-show="onEditMode && specified">Change option</a>
                </label>
                <div x-bind="formGroup.inputContainer">
                  <input type="text" x-model="license.type_practice" x-bind="formGroup.formInput" x-show="!onEditMode || specified" :disabled="!specified" name="type_practice" placeholder="Specify your type of practice">
                  <select x-model="license.type_practice" x-bind="formGroup.formInput" x-show="onEditMode && !specified" :disabled="specified" name="type_practice">
                    <option value="">Select</option>
                    <option value="Government Dentist">Government Dentist</option>
                    <option value="Clinic Owner">Clinic Owner</option>
                    <option value="Dental Associate">Dental Associate</option>
                    <option value="School Dentist">School Dentist</option>
                    <option value="None Practicing">None Practicing</option>
                  </select>
                  <span x-bind="formGroup.formInputError" id="type_practice_err">
                  </span>
                </div>
              </div>
            </div>
          </div>

          <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <!-- Form submit -->
            <div class="form-group">
              <label class="form-label"></label>
              <div class="input-container">
                <button @click="submitLicense" x-show="onEditMode" type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                  Save
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Clinic info -->
      <div x-transition x-show="currentTab == 4" class="w-full bg-opacity-50">
        <div class="shadow sm:rounded-md sm:overflow-hidden">
          <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
            <div class="w-full">
              <button @click="onEditMode = !onEditMode" x-show="!onEditMode" type="button" class="ml-auto flex text-blue-600 p-2 rounded-md hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Change details
              </button>

              <button @click="onEditMode = !onEditMode" x-show="onEditMode" type="button" class="ml-auto flex text-blue-600 p-2 rounded-md bg-secondary-100 hover:bg-secondary-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Cancel editing
              </button>
            </div>

            <div class="flex flex-col gap-y-8">
              <!-- Name -->
              <div x-bind="formGroup">
                <label x-bind="formGroup.formLabel">
                  Name
                </label>
                <div x-bind="formGroup.inputContainer">
                  <input type="text" x-model="clinic.clinic_name" x-bind="formGroup.formInput" name="clinic_name">
                  <span x-bind="formGroup.formInputError" id="clinic_name_err">
                </div>
              </div>

              <!-- Street -->
              <div x-bind="formGroup">
                <label x-bind="formGroup.formLabel">
                  Street
                </label>
                <div x-bind="formGroup.inputContainer">
                  <input type="text" x-model="clinic.clinic_street" x-bind="formGroup.formInput" name="clinic_street">
                  <span x-bind="formGroup.formInputError" id="clinic_street_err">
                </div>
              </div>

              <!-- District -->
              <div x-bind="formGroup">
                <label x-bind="formGroup.formLabel">
                  District
                </label>
                <div x-bind="formGroup.inputContainer">
                  <input type="text" x-model="clinic.clinic_district" x-bind="formGroup.formInput" name="clinic_district">
                  <span x-bind="formGroup.formInputError" id="clinic_district_err">
                </div>
              </div>

              <!-- City -->
              <div x-bind="formGroup">
                <label x-bind="formGroup.formLabel">
                  City
                </label>
                <div x-bind="formGroup.inputContainer">
                  <input type="text" x-model="clinic.clinic_city" x-bind="formGroup.formInput" name="clinic_city">
                  <span x-bind="formGroup.formInputError" id="clinic_city_err">
                </div>
              </div>

              <!-- Contact number -->
              <div x-bind="formGroup">
                <label x-bind="formGroup.formLabel">
                  Contact number
                </label>
                <div x-bind="formGroup.inputContainer">
                  <input type="number" x-model="clinic.clinic_contact_number" x-bind="formGroup.formInput" name="clinic_contact_number">
                  <span x-bind="formGroup.formInputError" id="clinic_contact_number_err">
                </div>
              </div>
            </div>
          </div>

          <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <!-- Form submit -->
            <div class="form-group">
              <label class="form-label"></label>
              <div class="input-container">
                <button @click="submitClinic" x-show="onEditMode" type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                  Save
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Emergency info -->
      <div x-transition x-show="currentTab == 5" class="w-full bg-opacity-50">
        <div class="shadow sm:rounded-md sm:overflow-hidden">
          <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
            <div class="w-full">
              <button @click="onEditMode = !onEditMode" x-show="!onEditMode" type="button" class="ml-auto flex text-blue-600 p-2 rounded-md hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Change details
              </button>

              <button @click="onEditMode = !onEditMode" x-show="onEditMode" type="button" class="ml-auto flex text-blue-600 p-2 rounded-md bg-secondary-100 hover:bg-secondary-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Cancel editing
              </button>
            </div>

            <div class="flex flex-col gap-y-8">
              <!--  Person's name -->
              <div x-bind="formGroup">
                <label x-bind="formGroup.formLabel">
                  Person's name
                </label>
                <div x-bind="formGroup.inputContainer">
                  <input type="text" x-model="emergency.emergency_person_name" x-bind="formGroup.formInput" name="emergency_person_name">
                  <span x-bind="formGroup.formInputError" id="emergency_person_name_err">
                </div>
              </div>

              <!-- Address -->
              <div x-bind="formGroup">
                <label x-bind="formGroup.formLabel">
                  Address
                </label>
                <div x-bind="formGroup.inputContainer">
                  <input type="text" x-model="emergency.emergency_address" x-bind="formGroup.formInput" name="emergency_address">
                  <span x-bind="formGroup.formInputError" id="emergency_address_err">
                </div>
              </div>

              <!-- Contact number -->
              <div x-bind="formGroup">
                <label x-bind="formGroup.formLabel">
                  Contact number
                </label>
                <div x-bind="formGroup.inputContainer">
                  <input type="number" x-model="emergency.emergency_contact_number" x-bind="formGroup.formInput" name="emergency_contact_number">
                  <span x-bind="formGroup.formInputError" id="emergency_contact_number_err">
                </div>
              </div>
            </div>
          </div>

          <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <!-- Form submit -->
            <div class="form-group">
              <label class="form-label"></label>
              <div class="input-container">
                <button @click="submitEmergency" x-show="onEditMode" type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                  Save
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- payments -->
      <div x-transition x-show="currentTab == 6" class="w-full bg-opacity-50">
        <?php if (!empty($data['paymentHistory'])) : ?>
          <div class="gap-y-8">
            <div class="table-container">
              <table id="myTable" style="width: 100%">
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
                <tbody class="bg-white divide-y divide-secondary-200 relative">
                  <?php foreach ($data['paymentHistory'] as $payment) : ?>
                    <tr class="hover:bg-secondary-100">
                      <td class="text-secondary-500">
                        <?php echo $payment->year ?>
                      </td>
                      <td>
                        <?php if (!empty($payment->dcc)) : ?>
                          <?php echo $payment->dcc ?>
                        <?php endif ?>
                      </td>
                      <td class="text-secondary-500">
                        <?php echo $payment->dcc_or ?>
                      </td>
                      <td>
                        <?php if (!empty($payment->pda)) : ?>
                          <?php echo $payment->pda ?>
                        <?php endif ?>
                      </td>
                      <td class="ptext-secondary-500">
                        <?php echo $payment->pda_or ?>
                      </td>
                      <td class="text-secondary-500">
                        <?php echo $payment->remarks ?>
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
                  <th scope="col" class="hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">
                  </th>
                  <th scope="col" class="hover:bg-secondary-50 px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">
                  </th>
                </tfoot>
                </tbody>
              </table>
            </div>

            <div class="hidden" id="print_header">
              <div class="flex justify-center gap-5">
                <!-- <div style="width: 100px">
                  <img width="100%" src="<?php echo URLROOT ?>/img/PDA-DCC.jpg" />
                </div> -->
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

                <div style="width: 100px">
                  <img width="100%" src="<?php echo URLROOT ?>/img/PDA-DCC.jpg" />
                </div>
              </div>

              <div class="mt-4 flex justify-between">
                <div style="width: 100px;"></div>
                <div class="w-full flex gap-3">
                  <div class="w-3/4 border-b border-black text-xl">
                    NAME:
                    <?php echo arrangeFullname($data['user']->first_name, $data['user']->middle_name, $data['user']->last_name) ?>
                  </div>
                  <div class="w-1/4">
                    <div class="w-full border-b border-black">
                      PRC #: <?php echo $data['user']->prc_number ?>
                    </div>
                    <div class="w-full border-b border-black">
                      PDA #:
                    </div>
                  </div>
                </div>
                <div style="width: 100px;"></div>
              </div>

              <div class="mt-4 flex justify-between">
                <div style="width: 100px;"></div>
                <div class="w-full flex gap-3">
                  <div class="whitespace-nowrap">Clinic address:</div>
                  <div class="w-full">
                    <div class="w-full border-b border-black mt-4"> <?php echo $data['user']->clinic_street . ' ' . $data['user']->clinic_district . ' ' . $data['user']->clinic_city ?></div>
                  </div>
                </div>
                <div style="width: 100px;"></div>
              </div>

              <div class="mt-4 flex justify-between mb-5">
                <div style="width: 100px;"></div>
                <div class="w-full flex justify-between flex-wrap">
                  <div class="whitespace-nowrap w-1/2 pr-2">CONTACT #: <?php echo $data['user']->contact_number ?>
                  </div>
                  <div class="whitespace-nowrap w-1/2 pl-2">Birthday: <?php echo $data['user']->birthdate ?>
                  </div>
                  <div class="whitespace-nowrap w-1/2 pr-2 mt-2">EMAIL ADD: <?php echo $data['user']->email ?>
                  </div>
                  <div class="whitespace-nowrap w-1/2 pl-2 mt-2">PRC Registration Date: <?php echo $data['user']->prc_registration_date ?>
                  </div>
                  <div class="whitespace-nowrap w-1/2 pr-2 mt-2">Date of Induction:
                  </div>
                  <div class="whitespace-nowrap w-1/2 pl-2 mt-2">Expiry Date: <?php echo $data['user']->prc_expiration_date ?>
                  </div>
                </div>
                <div style="width: 100px;"></div>
              </div>
            </div>
          </div>
        <?php else : ?>
          <div class="shadow sm:rounded-md sm:overflow-hidden h-52 lg:h-96 flex flex-wrap justify-center items-center">
            <div class="flex flex-col">
              <div class="mb-3 ml-auto">
                <a href="<?php echo URLROOT ?>/admins/dues" class="text-blue-500 hover:text-blue-400 hover:underline">See dues</a>
              </div>
              <div class="rounded-lg w-96 py-8 px-4 bg-warning-100 flex justify-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                This profile currently has no paid dues
              </div>
            </div>
          </div>
        <?php endif ?>
      </div>
    <?php endif ?>
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
        this.$watch('currentTab', value => {
          this.onEditMode = false
        })

        // initilize datatable
        $('#myTable').DataTable({
          columnDefs: [{
            targets: [1, 2, 3, 4, 5],
            sortable: false
          }, ],
          initComplete: function() {
            const api = this.api();
            api.columns('.hidden-first').visible(false)
          },
          dom: 'Brtip',
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
                .addClass('border border-black py-2')
                .css('text-align', 'center')
                .css('max-width', '200px');
            }
          }, ]
        });
        this.writeToFooterColumn(0, 'Payment Summary', 'text')
        this.writeToFooterColumn(1, this.calculateTotalAmount(1), 'currency')
        this.writeToFooterColumn(3, this.calculateTotalAmount(3), 'currency')
      },
      years: <?php echo json_encode($data['years']); ?>,

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

          if (isNaN(amount)) {
            amount = 0
          }

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

      currentTab: 1,

      onEditMode: false,
      serverData: <?php echo json_encode($data); ?>,
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

      profile: {
        email: '<?php echo $data['user']->email ?>',
        user_id: '<?php echo $data['user']->id ?>'
      },
      submitProfileImg(event) {
        const errorMsg = document.querySelector('#profile_img_err')

        const updateRequest = new FormData();
        const file = event.target.files[0];
        updateRequest.append('user_id', <?php echo $data['user']->user_id ?>)
        updateRequest.append('profile_img', file)

        // greater than 2 mb
        if (file && file.size > 2 * 1024 * 1024) {
          errorMsg.classList.remove('hidden')
          errorMsg.textContent = 'File size limit error. Your file size must be below 2 MB'
          return
        }

        const f = fetch('<?php echo URLROOT . "/profiles/profileImage" ?>', {
          method: "POST",
          body: updateRequest,
        }).then(data => data.json()
          .then(res => {
            if (res.status == 'ok') {
              document.querySelectorAll('.profile-img').forEach(el => {
                el.src = URL.createObjectURL(file)
              })
              // console.log
              document.querySelector('#view_img_link').href = `<?php echo URLROOT ?>/${res.profile_img_path}`

              errorMsg.classList.add('hidden')
            } else {
              errorMsg.classList.remove('hidden')
              errorMsg.textContent = res.message
            }
          }))
      },
      submitProfileEmail(event) {
        event.target.textContent = 'Please wait...'

        const f = fetch('<?php echo URLROOT . "/admins/updateProfile" ?>', {
          method: "POST",
          body: JSON.stringify({
            profile: this.profile
          }),
          headers: {
            "Content-type": "application/json"
          }
        })

        f.then(data => data.json()
          .then(res => {
            if (res.status == 'ok') {
              this.onEditMode = false

              document.querySelector('#email_err').classList.add('hidden')
            } else {
              document.querySelector('#email_err').classList.remove('hidden')

              document.querySelector('#email_err').textContent = res.errors.email_err
            }
          }))
        event.target.textContent = 'Save'
      },
      personal: {
        first_name: '<?php echo $data['user']->first_name ?>',
        middle_name: '<?php echo $data['user']->middle_name ?>',
        last_name: '<?php echo $data['user']->last_name ?>',
        birthdate: '<?php echo $data['user']->birthdate ?>',
        gender: '<?php echo $data['user']->gender ?>',
        contact_number: '<?php echo $data['user']->contact_number ?>',
        fb_account_name: '<?php echo $data['user']->fb_account_name ?>',
        address: '<?php echo $data['user']->address ?>',
        user_id: '<?php echo $data['user']->id ?>'
      },
      submitPersonal(event) {
        event.target.textContent = 'Please wait...'

        const f = fetch('<?php echo URLROOT . "/admins/updatePersonal" ?>', {
          method: "POST",
          body: JSON.stringify({
            personal: this.personal
          }),
          headers: {
            "Content-type": "application/json"
          }
        })

        f.then(data => data.json()
          .then(res => {
            if (res.status == 'ok') {
              this.onEditMode = false

              document.querySelector('#first_name_err').classList.add('hidden')
              document.querySelector('#middle_name_err').classList.add('hidden')
              document.querySelector('#last_name_err').classList.add('hidden')
              document.querySelector('#birthdate_err').classList.add('hidden')
              document.querySelector('#gender_err').classList.add('hidden')
              document.querySelector('#contact_number_err').classList.add('hidden')
              document.querySelector('#fb_account_name_err').classList.add('hidden')
              document.querySelector('#address_err').classList.add('hidden')

            } else {
              document.querySelector('#first_name_err').classList.remove('hidden')
              document.querySelector('#middle_name_err').classList.remove('hidden')
              document.querySelector('#last_name_err').classList.remove('hidden')
              document.querySelector('#birthdate_err').classList.remove('hidden')
              document.querySelector('#gender_err').classList.remove('hidden')
              document.querySelector('#contact_number_err').classList.remove('hidden')
              document.querySelector('#fb_account_name_err').classList.remove('hidden')
              document.querySelector('#address_err').classList.remove('hidden')

              document.querySelector('#first_name_err').textContent = res.errors.first_name_err
              document.querySelector('#middle_name_err').textContent = res.errors.middle_name_err
              document.querySelector('#last_name_err').textContent = res.errors.last_name_err
              document.querySelector('#birthdate_err').textContent = res.errors.birthdate_err
              document.querySelector('#gender_err').textContent = res.errors.gender_err
              document.querySelector('#contact_number_err').textContent = res.errors.contact_number_err
              document.querySelector('#fb_account_name_err').textContent = res.errors.fb_account_name_err
              document.querySelector('#address_err').textContent = res.errors.address_err
            }
          }))

        event.target.textContent = 'Save'
      },
      license: {
        prc_number: '<?php echo $data['user']->prc_number ?>',
        prc_registration_date: '<?php echo $data['user']->prc_registration_date ?>',
        prc_expiration_date: '<?php echo $data['user']->prc_expiration_date ?>',
        field_practice: '<?php echo $data['user']->field_practice ?>',
        type_practice: '<?php echo $data['user']->type_practice ?>',
        user_id: '<?php echo $data['user']->id ?>'
      },
      licensePerm: {
        prc_number: '<?php echo $data['user']->prc_number ?>',
        prc_registration_date: '<?php echo $data['user']->prc_registration_date ?>',
        prc_expiration_date: '<?php echo $data['user']->prc_expiration_date ?>',
        field_practice: '<?php echo $data['user']->field_practice ?>',
        type_practice: '<?php echo $data['user']->type_practice ?>',
        user_id: '<?php echo $data['user']->id ?>'
      },
      submitLicense(event) {
        event.target.textContent = 'Please wait...'

        const f = fetch('<?php echo URLROOT . "/admins/updateLicense" ?>', {
          method: "POST",
          body: JSON.stringify({
            license: this.license
          }),
          headers: {
            "Content-type": "application/json"
          }
        })

        f.then(data => data.json()
          .then(res => {
            if (res.status == 'ok') {
              this.onEditMode = false

              document.querySelector('#prc_number_err').classList.add('hidden')
              document.querySelector('#prc_registration_date_err').classList.add('hidden')
              document.querySelector('#prc_expiration_date_err').classList.add('hidden')
              document.querySelector('#field_practice_err').classList.add('hidden')
              document.querySelector('#type_practice_err').classList.add('hidden')
            } else {
              document.querySelector('#prc_number_err').classList.remove('hidden')
              document.querySelector('#prc_registration_date_err').classList.remove('hidden')
              document.querySelector('#prc_expiration_date_err').classList.remove('hidden')
              document.querySelector('#field_practice_err').classList.remove('hidden')
              document.querySelector('#type_practice_err').classList.remove('hidden')

              document.querySelector('#prc_number_err').textContent = res.errors.prc_number_err
              document.querySelector('#prc_registration_date_err').textContent = res.errors.prc_registration_date_err
              document.querySelector('#prc_expiration_date_err').textContent = res.errors.prc_expiration_date_err
              document.querySelector('#field_practice_err').textContent = res.errors.field_practice_err
              document.querySelector('#type_practice_err').textContent = res.errors.type_practice_err
            }
          }))

        event.target.textContent = 'Save'
      },
      clinic: {
        clinic_name: '<?php echo $data['user']->clinic_name ?>',
        clinic_street: '<?php echo $data['user']->clinic_street ?>',
        clinic_district: '<?php echo $data['user']->clinic_district ?>',
        clinic_city: '<?php echo $data['user']->clinic_city ?>',
        clinic_contact_number: '<?php echo $data['user']->clinic_contact ?>',
        user_id: '<?php echo $data['user']->id ?>'
      },
      submitClinic(event) {
        event.target.textContent = 'Please wait...'

        const f = fetch('<?php echo URLROOT . "/admins/updateClinic" ?>', {
          method: "POST",
          body: JSON.stringify({
            clinic: this.clinic
          }),
          headers: {
            "Content-type": "application/json"
          }
        })

        f.then(data => data.json()
          .then(res => {
            if (res.status == 'ok') {
              this.onEditMode = false
              document.querySelector('#clinic_name_err').classList.add('hidden')
              document.querySelector('#clinic_street_err').classList.add('hidden')
              document.querySelector('#clinic_district_err').classList.add('hidden')
              document.querySelector('#clinic_city_err').classList.add('hidden')
              document.querySelector('#clinic_contact_number_err').classList.add('hidden')
            } else {
              document.querySelector('#clinic_name_err').classList.remove('hidden')
              document.querySelector('#clinic_street_err').classList.remove('hidden')
              document.querySelector('#clinic_district_err').classList.remove('hidden')
              document.querySelector('#clinic_city_err').classList.remove('hidden')
              document.querySelector('#clinic_contact_number_err').classList.remove('hidden')

              document.querySelector('#clinic_name_err').textContent = res.errors.clinic_name_err
              document.querySelector('#clinic_street_err').textContent = res.errors.clinic_street_err
              document.querySelector('#clinic_district_err').textContent = res.errors.clinic_district_err
              document.querySelector('#clinic_city_err').textContent = res.errors.clinic_city_err
              document.querySelector('#clinic_contact_number_err').textContent = res.errors.clinic_contact_number_err
            }
          }))

        event.target.textContent = 'Save'
      },
      emergency: {
        emergency_person_name: '<?php echo $data['user']->emergency_person_name ?>',
        emergency_address: '<?php echo $data['user']->emergency_address ?>',
        emergency_contact_number: '<?php echo $data['user']->emergency_contact_number ?>',
        user_id: '<?php echo $data['user']->id ?>'
      },
      submitEmergency(event) {
        event.target.textContent = 'Please wait...'

        const f = fetch('<?php echo URLROOT . "/admins/updateEmergency" ?>', {
          method: "POST",
          body: JSON.stringify({
            emergency: this.emergency
          }),
          headers: {
            "Content-type": "application/json"
          }
        })

        f.then(data => data.json()
          .then(res => {
            if (res.status == 'ok') {
              this.onEditMode = false
              document.querySelector('#emergency_person_name_err').classList.add('hidden')
              document.querySelector('#emergency_address_err').classList.add('hidden')
              document.querySelector('#emergency_contact_number_err').classList.add('hidden')
            } else {

              document.querySelector('#emergency_person_name_err').classList.remove('hidden')
              document.querySelector('#emergency_address_err').classList.remove('hidden')
              document.querySelector('#emergency_contact_number_err').classList.remove('hidden')

              document.querySelector('#emergency_person_name_err').textContent = res.errors.emergency_person_name_err
              document.querySelector('#emergency_address_err').textContent = res.errors.emergency_address_err
              document.querySelector('#emergency_contact_number_err').textContent = res.errors.emergency_contact_number_err
            }
          }))

        event.target.textContent = 'Save'
      },

      checkIfRegistrationIsExpired: function() {
        return dayjs(this.license.prc_expiration_date) < dayjs() ? true : false
      },
      getRelativeTimeSinceExpiration: function() {
        return `expired ${dayjs(this.license.prc_expiration_date).from(dayjs())}`
      },
      getRemainingTimeBeforeExpiration: function() {
        let remainingYear = dayjs(this.license.prc_expiration_date).year() - dayjs().year()

        return dayjs(this.license.prc_expiration_date).subtract(remainingYear, 'year')
      },
      getRelativeTimeBeforeExpiration: function() {
        let remainingTime = this.getRemainingTimeBeforeExpiration();

        return `expires ${dayjs(this.license.remainingTime).to(dayjs(this.license.prc_expiration_date))}`
      },
      generateExpirationStatus: function() {
        if (this.checkIfRegistrationIsExpired()) {
          return this.getRelativeTimeSinceExpiration()
        } else {
          return this.getRelativeTimeBeforeExpiration()
        }
      }
    }))
  })
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>