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

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
  <!-- <script defer src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>
  <script defer src="https://unpkg.com/dayjs@1.8.21/plugin/relativeTime.js"></script> -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables-classic@latest" type="text/javascript"></script> -->
  <script defer src="<?php echo URLROOT; ?>/js/main.bundle.js"></script>
  <script defer src="<?php echo URLROOT; ?>/js/vendor.bundle.js"></script>
  <!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script> -->


  <script>
    document.addEventListener('DOMContentLoaded', () => {
        inactivityTime();

        function inactivityTime() {
          var time;
          window.onload = resetTimer;
          // DOM Events
          document.onclick = resetTimer;
          document.onscroll = resetTimer;

          function logout() {
            alert("You are now logged out.")
          }

          function resetTimer() {
            clearTimeout(time);
            time = setTimeout(logout, 300000) // 5minutes
            // 1000 milliseconds = 1 second
          }
        };
      })


      // let timer, currSeconds = 0;
      // /* Set a new interval */
      // timer =
      //   setInterval(startIdleTimer, 1000);

      // function resetTimer() {
      //   /* Hide the timer text */
      //   // document.querySelector(".timertext")
      //   //         .style.display = 'none';

      //   /* Clear the previous interval */
      //   clearInterval(timer);

      //   /* Reset the seconds of the timer */
      //   currSeconds = 0;

      //   /* Set a new interval */
      //   timer =
      //     setInterval(startIdleTimer, 1000);
      // }

      // // Define the events that would reset the timer
      // window.onmousedown = resetTimer;
      // window.ontouchstart = resetTimer;
      // window.onclick = resetTimer;
      // window.onkeypress = resetTimer;
      // window.onscroll = resetTimer;

      // let userSession = '<?php echo $_SESSION["user_id"] ?? '' ?>'
      // // only start timer if user is logged in
      // if (userSession) {
      //   function startIdleTimer() {
      //     /* Increment the
      //         timer seconds */
      //     currSeconds++;

      //     // logout users if they are idle for 10mins
      //     if (currSeconds == 60) {
      //       alert('The system will log you out for security reasons. You have been idle for 10 mins.')
      //       window.location.href = '<?php echo URLROOT . "/users/logout" ?>'
      //     }

      //     let currentUnixTimestamp = Math.round((new Date()).getTime() / 1000)
      //     setInterval(() => {
      //       const updateRequest = new FormData();
      //       updateRequest.append('current_timestamp', currentUnixTimestamp)

      //       if (currSeconds < 300) {
      //         console.log('refreshed timer')
      //         const response = fetch('<?php echo URLROOT . "/users/restartSessionTimer" ?>', {
      //             method: 'POST',
      //             body: updateRequest
      //           })
      //           .then((response) => response.json())
      //           .then((res) => {
      //             if (!res.ok) {
      //               console.error('there is something wrong')
      //             }
      //           })
      //       } else {
      //         console.log('continue timer')
      //       }
      //     }, 60000); // 5minutes
      //     // /* Set the timer text
      //     //     to the new value */
      //     // document.querySelector(".secs")
      //     //   .textContent = currSeconds;

      //     // /* Display the timer text */
      //     // document.querySelector(".timertext")
      //     //   .style.display = 'block';
      //   }
      // }
      <
      /> < /
    body >

      <
      /html>