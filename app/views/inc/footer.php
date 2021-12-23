  </div>

  <!-- Footer -->
  <footer class="bg-white mt-20">
    <div class="container mx-auto w-full px-6">
      <div class="flex mt-8 justify-center gap-8">
        <a href="<?php echo URLROOT ?>/about/" class="flex gap-1 text-sm font-semibold text-secondary-500 hover:text-secondary-900">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          About us
        </a>
        <a href="<?php echo URLROOT ?>/about/privacyPolicy" class="flex gap-1 text-sm font-semibold text-secondary-500 hover:text-secondary-900">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
          </svg>
          Privacy policy
        </a>
        <a href="<?php echo URLROOT ?>/about/termsOfService" class="flex gap-1 text-sm font-semibold text-secondary-500 hover:text-secondary-900">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11" />
          </svg>
          Terms of service
        </a>
      </div>
    </div>
    <div class="mx-auto px-6">
      <div class="mt-1 border-t ">
        <p class="text-sm text-center py-6 text-primary-400 font-bold">
          © 2021 - <?php echo SITENAME ?>
        </p>
      </div>
    </div>
  </footer>

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js" integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
  <script src="<?php echo URLROOT; ?>/js/main.bundle.js"></script>
  <script src="<?php echo URLROOT; ?>/js/vendor.bundle.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // inactivityTime();

      // function inactivityTime() {
      //   var time;
      //   window.onload = resetTimer;
      //   // DOM Events
      //   document.onclick = resetTimer;
      //   document.onscroll = resetTimer;

      //   function logout() {
      //     alert("You are now logged out.")
      //   }

      //   function resetTimer() {
      //     clearTimeout(time);
      //     time = setTimeout(logout, 300000) // 5minutes
      //     // 1000 milliseconds = 1 second
      //   }
      // };
    })
  </script>

  </body>

  </html>