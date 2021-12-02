<?php

/**
 * Set google client
 *
 * @param string $endpoint make call to this enpoint
 * @param array $params array keys are the variable names required by the endpoint
 *
 * @return array $response
 */
function setGoogleClient()
{
	// open curl call, set endpoint and other curl params

	$client = new Google_Client();
	$client->setClientId(GOOGLE_CLIENT_ID);
	$client->setClientSecret(GOOGLE_CLIENT_SECRET);
	$client->setRedirectUri(GOOGLE_REDIRECT_URI);
	$client->addScope('email');

	return $client;
}

/**
 * Get Google api login url that will take the user to google and present them with login dialog
 *
 * Endpoint: 
 *
 * @param void
 *
 * @return string
 */
function getGoogleLoginUrl()
{
	$client = setGoogleClient();

	// endpoint for Google login dialog
	return filter_var($client->createAuthUrl(), FILTER_SANITIZE_URL);
}

function tryAndLoginWithGoogle($get, $usersController)
{
	$userModel = $usersController->userModel;

	// assume fail
	$status = 'fail';
	$message = '';
	$user = '';
	$emailConfirmation = '';
	$isAdded = false;
	$reason = '';

	// reset session vars
	$_SESSION['google_access_token'] = array();
	$_SESSION['google_user_info'] = array();
	$_SESSION['eci_login_required_to_connect_google'] = false;

	if (isset($get['error'])) {
		// error comming from google GET vars
		$message = $get['error_description'];
	} else {
		// no error in google GET vars
		// get an access token with the code google sent us
		$client = setGoogleClient();
		$accessTokenInfo = $client->fetchAccessTokenWithAuthCode($get['code']);

		if (isset($accessTokenInfo['error'])) {
			// there was an error getting an access token with the code
			$message = 'Your google access token was already used. Try again';
		} else {
			// we have access token! :D
			$_SESSION['google_access_token'] = $accessTokenInfo['access_token'];

			$client->setAccessToken($accessTokenInfo);
			$gauth = new Google_Service_Oauth2($client);
			$googleUserInfo = $gauth->userinfo->get();

			if (!empty($googleUserInfo['id']) && !empty($googleUserInfo['email'])) { // google gave us the users id/email
				// 	all good!
				$status = 'ok';

				// save user info to session
				$_SESSION['google_user_info'] = $googleUserInfo;

				// check for user with google id		
				// $userInfoWithId = $userModel->getRowWithValue('users', 'google_user_id', $googleUserInfo->id);


				$userInfoWithId = $userModel->getRowWithValue('users', 'google_user_id', $googleUserInfo->id);
				$loggedInUser = $userModel->getRowWithValue('users', 'id', $_SESSION['user_id'] ?? '');

				if ($userInfoWithId) {
					//check if the registration is done inside or outside
					if (isLoggedIn()) {

						if ($userInfoWithId->id != $loggedInUser->id) {
							$status = 'fail';
							$reason = 'accountTaken';
							$message = 'This google account is already taken';
						} else {
							$status = 'fail';
							$reason = 'accountTaken';
							$message = 'You are currently using this google account. Try again.';
						}
					} else {
						if (!$userInfoWithId->email_verified) {
							$status = 'fail';
							$reason = 'unverifiedEmail';
							$message = 'Your email ' . $userInfoWithId->email . ' is still not verified. Please check your email to verify your account.';
							$emailConfirmation = [
								'email_confirmation_type' => 'register',
								'id_type' => 'google_user_id',
								'id' => $googleUserInfo->id,
								'receiver_email' => $googleUserInfo->email
							];
						} else {
							$userModel->updateRowById('google_access_token', $_SESSION['google_access_token'], $userInfoWithId->id);
							$userModel->updateRowById('google_user_id', $googleUserInfo->id, $userInfoWithId->id);

							$status = 'ok';
							$message = 'You have successfully logged in using your google account';
							$user = $userInfoWithId;
						}
					}
				} else {
					if (isLoggedIn()) {
						$userModel->updateRowById('google_access_token', $_SESSION['google_access_token'], $loggedInUser->id);
						$userModel->updateRowById('google_user_id', $googleUserInfo->id, $loggedInUser->id);

						$status = 'ok';
						$message = 'Google was added to your user account successfully.';
						$isAdded = true;
					} else {
						$userInfoWithEmail = $userModel->getRowWithValue('users', 'email', $googleUserInfo->email);

						if ($userInfoWithEmail) {
							if (!$userInfoWithEmail->email_verified) {
								$status = 'fail';
								$reason = 'unverifiedEmail';
								$message = 'You have an existing account with the email ' . $userInfoWithEmail->email . ' and is still not verified. Please verify your email first before adding google authentication.';
								$emailConfirmation = [
									'email_confirmation_type' => 'register',
									'id_type' => 'email',
									'id' => $googleUserInfo->email,
									'receiver_email' => $googleUserInfo->email
								];
							} else {
								$userModel->updateUserById('google_access_token', $_SESSION['google_access_token'], $userInfoWithEmail->id);
								$userModel->updateUserById('google_user_id', $googleUserInfo->id, $userInfoWithEmail->id);

								$status = 'ok';
								$message = 'Facebook authentication was added to your existing user account with the same email. You can now sign in using your facebook account.';
								$isAdded = true;
							}
						} else {
							if ($userModel->register(
								[
									'email' => $googleUserInfo->email,
									'google_user_id' => $googleUserInfo->id,
									'google_access_token' => $_SESSION['google_access_token']
								]
							)) {

								$status = 'ok';
								$message = 'You successfully registered using your Google account.';
								$emailConfirmation = [
									'email_confirmation_type' => 'register',
									'id_type' => 'google_user_id',
									'id' => $googleUserInfo->id,
									'receiver_email' => $googleUserInfo->email
								];
							}
						}
					}
				}
			} else {
				$status = 'fail';
				$message = 'Invalid credentials';
			}
		}
	}

	return array( // return status and message of login
		'status' => $status,
		'message' => $message,
		'user' => $user,
		'emailConfirmation' => $emailConfirmation,
		'added' => $isAdded,
		'reason' => $reason
	);
}
