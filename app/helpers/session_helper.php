<?php
session_start();

// Flash message helper
// EXAMPLE - flash('register_success', 'You are now registered');
// DISPLAY IN VIEW - echo flash('register_success');
function flash($name = '', $label = '', $message = '', $class = 'bg-green-600')
{
  if (!empty($name)) {
    if (!empty($label) && empty($_SESSION[$name])) {
      if (!empty($_SESSION[$name])) {
        unset($_SESSION[$name]);
      }

      if (!empty($_SESSION[$name . '_message'])) {
        unset($_SESSION[$name . '_message']);
      }

      $_SESSION[$name] = $label;
      $_SESSION[$name . '_message'] = $message;
      $_SESSION[$name . '_class'] = $class;
    } elseif (empty($label) && !empty($_SESSION[$name])) {
      echo '<div x-data="{ open: true }" x-show="open" x-init="setTimeout(() => open = !open, 3000)" class="flex max-w-sm w-full bg-white shadow-md rounded-lg overflow-hidden mx-auto my-5">' .
        '<div class="w-2 ' . $_SESSION[$name . '_class'] . '">' .
        '</div>' .
        '<div class="w-full flex justify-between px-2 py-2">' .
        '<div class="flex flex-col ml-2">' .
        '<div class="flex gap-3 text-danger-500">
          <svg xmlns="http://www.w3.org/2000/svg" class="animate-bounce h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <label class="text-left">' . $_SESSION[$name] . '</label>
        </div>' .
        '<small class="text-secondary-500 text-left">' . $_SESSION[$name . "_message"] . '</small>' .
        '</div>' .
        '<a href="#" @click="open = !open" >' .
        '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">' .
        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />' .
        '</svg>' .
        '</a>' .
        '</div>' .
        '</div>';
      unset($_SESSION[$name]);
      unset($_SESSION[$name . '_class']);
    }
  }
}

/* SETTERS */

/* CHECKS */
function isLoggedIn()
{
  if (isset($_SESSION['user_id'])) {
    return true;
  } else {
    return false;
  }
}

function isSuperAdmin()
{
  if ($_SESSION['role'] == 'superadmin') {
    return true;
  } else {
    return false;
  }
}
function isAdmin()
{
  if ($_SESSION['role'] == 'admin') {
    return true;
  } else {
    return false;
  }
}
function isOfficer()
{
  if ($_SESSION['role'] == 'officer') {
    return true;
  } else {
    return false;
  }
}
function isMember()
{
  if ($_SESSION['role'] == 'member') {
    return true;
  } else {
    return false;
  }
}
function isCompleteInfo()
{
  if (isset($_SESSION['complete_info']) && $_SESSION['complete_info'] == true) {
    return true;
  } else {
    return false;
  }
}
function passwordRegistered()
{
  if (isset($_SESSION['password_registered']) && $_SESSION['password_registered'] == true) {
    return true;
  } else {
    return false;
  }
}
function isIdleUser()
{
  //check user if idle for 10mins
  if (isset($_SESSION['login_time_stamp']) && (time() - $_SESSION['login_time_stamp'] > 60 * 10)) {
    return true;
  } else {
    return false;
  }
}

function isEmailVerified()
{
  if (isset($_SESSION['email_verified'])) {
    return true;
  } else {
    return false;
  }
}

/* REDIRECTS */
function redirectAuthUserWithRole()
{
  if (isLoggedIn() && isEmailVerified()) {
    if (isAdmin()) {
      redirect('profiles/userInfo');
      return;
    }
    redirect('profiles/userInfo');
  }
}
function redirectIfNotOfficer()
{
  if (!isOfficer()) {
    redirect('profiles/userInfo');
  }
}
function redirectIfNotSuperAdmin()
{
  if (!isSuperAdmin()) {
    redirect('profiles/userInfo');
  }
}
function redirectIfNotAdmin()
{
  if (isMember()) {
    redirect('profiles/userInfo');
  }
}
function redirectIfNotLoggedIn()
{
  if (!isLoggedIn()) {
    redirect('users/login');
  }
}
function redirectIfNotAuthUser()
{
  if (!isLoggedIn() || !isEmailVerified()) {
    redirect('users/login');
  }
}
function redirectIfEmailAndPassNotRegistered()
{
  if (!$_SESSION['password_registered']) {
    redirect('users/login');
  }
}
function redirectIfEmailAndPassRegistered()
{
  if ($_SESSION['password_registered']) {
    redirect('profiles/userInfo');
  }
}

function redirectFullyRegisteredUser()
{
  if (isLoggedIn() && isEmailVerified() && isCompleteInfo()) {
    redirect('profiles/userInfo');
  }
}
function redirectNotFullyRegisteredUser()
{
  if (isLoggedIn() && !isCompleteInfo() && passwordRegistered()) {
    redirect('users/registerPrcInfo');
  } else if (isLoggedIn() && !isCompleteInfo() && !passwordRegistered()) {
    redirect('users/registerEmailPassword'); //temp
  }
}

function redirectInactiveUserOrRegenerateTimer()
{
  // if (isIdleUser()) {
  //   session_unset();
  //   session_destroy();
  //   redirect("users/login");
  //   return;
  // }
  // session_regenerate_id(true);
  // $_SESSION['login_time_stamp'] = time();
}

function sessionDestroyAll()
{
  unset($_SESSION['user_id']);
  unset($_SESSION['user_email']);
  unset($_SESSION['user_username']);
  unset($_SESSION['user_name']);
  unset($_SESSION['is_admin']);
  unset($_SESSION['complete_info']);
  unset($_SESSION['login_time_stamp']);
  session_destroy();
}




// function currentInfoNumber()
// {
//   if (isset($_SESSION['current_info_number']) && $_SESSION['current_info_number'] == true) {
//     return true;
//   } else {
//     return false;
//   }
// }
