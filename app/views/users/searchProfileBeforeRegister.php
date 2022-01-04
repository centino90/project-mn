<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="mx-auto min-h-full w-full flex items-center justify-center px-4 sm:px-6 lg:px-8" x-data="app()">
  <div class="max-w-lg w-full space-y-16 lg:px-8 lg:py-10">
    <div>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-secondary-900">
        Input your prc number to identify your profile
      </h2>
    </div>
    <form method="POST" action="<?php echo URLROOT ?>/users/searchProfileBeforeRegister">
      <div class="flex flex-col gap-y-5">
        <div class="form-group">
          <div class="flex flex-col w-full">
            <div @click.outside="close()" class="w-full">
              <div class="flex flex-col items-center relative z-0">
                <div class="w-full">
                  <div class="mb-2 p-1 bg-white flex border border-secondary-200 rounded">
                    <input name="prc_number" x-model="searchProfileForm.prc_number" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @mousedown="open()" @keydown.enter.stop.prevent="selectOption()" @keydown.arrow-up.prevent="focusPrevOption()" @keydown.arrow-down.prevent="focusNextOption()" placeholder="Search your name, email, or prc no." autocomplete="off" class="p-1 px-2 appearance-none outline-none w-full text-secondary-800">
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
                              <img class="rounded-full" alt="A" x-bind:src="option.profile_img_path ? `<?php echo URLROOT . '/' ?>${option.profile_img_path}` : '<?php echo URLROOT . '/public/img/profiles/default-profile.png' ?>'">
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
            <!-- <span class="hidden text-danger-600 text-sm" id="prc_number_err"></span>
          </span> -->
            <?php if (!empty('prc_number_err')) : ?>
              <span class="text-danger-600 text-sm block w-full"><?php echo $data['prc_number_err'] ?></span>
              </span>
            <?php endif ?>
          </div>
        </div>

        <div class="form-group">
          <input value="Submit to proceed" type="submit" x-ref="submit" class="form-btn bg-primary-500 text-white w-full py-2 px-4">
          </input>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('app', () => ({
      init() {
        const app = this
        // this.$watch('searchProfileForm.prc_number', val => {
        //   console.log(val)
        // })

        // search user profile component
        fetch("<?php echo URLROOT . '/users/fetchUserProfile' ?>", {
            method: 'POST'
          })
          .then(response => response.json())
          .then(data => {
            if (data.status == 'ok') {
              app.options = data
            }
          });
      },
      // search input component
      searchProfileForm: {
        prc_number: ''
      },
      show: false,
      selected: null,
      focusedOptionIndex: null,
      options: null,
      close() {
        this.show = false;
        // this.searchProfileForm.prc_number = this.selectedName();
        this.focusedOptionIndex = this.selected ? this.focusedOptionIndex : null;
      },
      open() {
        this.show = true;
        // this.searchProfileForm.prc_number = '';
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
        return this.selected ? this.selected.prc_number : this.searchProfileForm.prc_number;
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
            return (`${option.first_name} ${option.last_name}`.toLowerCase().indexOf(this.searchProfileForm.prc_number) > -1) ||
              (`${option.last_name} ${option.first_name}`.toLowerCase().indexOf(this.searchProfileForm.prc_number) > -1) ||
              (option.prc_number.toLowerCase().indexOf(this.searchProfileForm.prc_number) > -1)
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
          // this.searchProfileForm.prc_number = '';
          // this.selected = null;
        } else {
          this.selected = selected;
          this.searchProfileForm.prc_number = this.selectedName();
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
      }
    }))
  })
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>