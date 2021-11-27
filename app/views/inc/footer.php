  </div>

  <!-- Footer -->
  <footer class="bg-white mt-20">
    <div class="container mx-auto w-full px-6">
      <div class="flex mt-8 justify-center gap-8">
        <a href="<?php echo URLROOT?>/about/" class="flex gap-1 text-sm font-semibold text-secondary-500 hover:text-secondary-900">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          About us
        </a>
        <a href="<?php echo URLROOT?>/about/privacyPolicy" class="flex gap-1 text-sm font-semibold text-secondary-500 hover:text-secondary-900">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
          </svg>
          Privacy policy
        </a>
        <a href="<?php echo URLROOT?>/about/termsOfService" class="flex gap-1 text-sm font-semibold text-secondary-500 hover:text-secondary-900">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11" />
          </svg>
          Terms of service
        </a>
      </div>
    </div>
    <div class="container mx-auto px-6">
      <div class="mt-1 border-t-2 border-secondary-300">
        <p class="text-sm text-center py-6 text-primary-400 font-bold">
          © 2021 - PDO-DCC
        </p>
      </div>
    </div>
  </footer>

  <!-- <script defer src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>
  <script defer src="https://unpkg.com/dayjs@1.8.21/plugin/relativeTime.js"></script> -->
  <script src="<?php echo URLROOT; ?>/js/main.bundle.js"></script>
  <script src="<?php echo URLROOT; ?>/js/vendor.bundle.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script> -->


  <script>
    // document.querySelectorAll('input').forEach(input => {
    //   console.log(input)
    //   new Pikaday({
    //     field: input,
    //     format: 'MM/DD/YYYY',
    //     onSelect: function(date) {
    //       input.value = this.toString();
    //     },
    //     toString(date, format) {
    //       // you should do formatting based on the passed format,
    //       // but we will just return 'D/M/YYYY' for simplicity
    //       const day = dayjs(date).day()
    //       const month = dayjs(date).month() + 1
    //       const year = dayjs(date).year()
    //       return `${month}/${day}/${year}`
    //     },
    //   })
    // })
  </script>
  </body>

  </html>