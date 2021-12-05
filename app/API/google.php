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
	$isAdded = false;
	$reason = '';
	$email_confirmation_type = '';
	$id_type = '';
	$id = '';
	$receiver_email = '';
	$vkeyType = '';
	$cancellable = false;

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
						if (!$userInfoWithId->email_verified && $userInfoWithId->email) {
							$status = 'fail';
							$reason = 'unverifiedEmail';
							$message = 'Your email ' . $userInfoWithId->email . ' is still not verified. Please check your email to verify your account.';
							$email_confirmation_type = 'ACCOUNT_REGISTRATION';
							$id_type = 'google_user_id';
							$id = $googleUserInfo->id;
							$receiver_email = $userInfoWithId->email;
							$vkeyType = 'account_registration_vkey';
							$cancellable = true;
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
						if ($userModel->register(
							[
								'google_user_id' => $googleUserInfo->id,
								'google_access_token' => $_SESSION['google_access_token']
							]
						)) {

							$status = 'ok';
							$message = 'You successfully registered using your Facebook account.';
							$user = $userModel->getRowByColumn('google_user_id', $googleUserInfo->id);
						}
					}
				}
			} else if (empty($googleUserInfo->email)) {
				$status = 'fail';
				$message = 'You have to enable permission to access your email. Try again.';
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
		'added' => $isAdded,
		'reason' => $reason,
		'email_confirmation_type' => $email_confirmation_type,
		'id_type' => $id_type,
		'id' => $id,
		'receiver_email' => $receiver_email,
		'vkeyType' => $vkeyType,
		'cancellable' => $cancellable,
	);
}
