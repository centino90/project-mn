import "./main.scss";

// generateYearsBetween: function(startYear = 1980, endYear) {
//     const endDate = endYear || new Date().getFullYear() + 1;
//     let years = [];
//     for (var i = startYear; i <= endDate; i++) {
//       years.push(startYear);
//       startYear++;
//     }
//     return years;
//   },


      // Alert notification
    //   openAlertBox: false,
    //   alertBackgroundColor: '',
    //   alertMessage: '',
    //   showAlert(type) {
    //     this.openAlertBox = true
    //     switch (type) {
    //       case 'success':
    //         this.alertBackgroundColor = 'bg-success-500'
    //         this.alertMessage = `${this.successIcon} ${this.defaultSuccessMessage}`
    //         break
    //       case 'info':
    //         this.alertBackgroundColor = 'bg-blue-500'
    //         this.alertMessage = `${this.infoIcon} ${this.defaultInfoMessage}`
    //         break
    //       case 'warning':
    //         this.alertBackgroundColor = 'bg-warning-500'
    //         this.alertMessage = `${this.warningIcon} ${this.defaultWarningMessage}`
    //         break
    //       case 'danger':
    //         this.alertBackgroundColor = 'bg-danger-500'
    //         this.alertMessage = `${this.dangerIcon} ${this.defaultDangerMessage}`
    //         break
    //     }
    //     this.openAlertBox = true
    //   },
    //   successIcon: `<svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 mr-2 text-white"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`,
    //   infoIcon: `<svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 mr-2 text-white"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`,
    //   warningIcon: `<svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 mr-2 text-white"><path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`,
    //   dangerIcon: `<svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 mr-2 text-white"><path d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>`,
    //   defaultInfoMessage: `This alert contains info message.`,
    //   defaultSuccessMessage: `This alert contains success message.`,
    //   defaultWarningMessage: `This alert contains warning message.`,
    //   defaultDangerMessage: `This alert contains danger message.`,


    // this.$watch('paymentModalOpen', value => {
    //   const body = document.body;
    //   if (!this.paymentModalOpen) {
    //     body.classList.remove('h-screen');
    //     return body.classList.remove('overflow-hidden');
    //   } else {
    //     body.classList.add('h-screen');
    //     return body.classList.add('overflow-hidden');
    //   }
    // });

    // // alertbox
    // this.$watch('openAlertBox', value => {
    //   if (value) {
    //     let timeout = window.setTimeout(() => {
    //       this.openAlertBox = false
    //     }, 10000)
    //   }
    // });