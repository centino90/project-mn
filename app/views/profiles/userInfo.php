<?php require APPROOT . '/views/inc/header.php'; ?>

<!-- Profile sidebar -->
<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="flex flex-col w-full mx-auto" x-data="app()">
    <div class="min-w-full px-4 lg:px-1">

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
                            <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" stroke="currentColor">
                                <path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
                            </svg>
                        </span>
                    </li>
                    <li class="flex items-center">
                        <span aria-current="page">
                            My user profile
                        </span>
                    </li>
                </ol>
            </nav>
        </div>

        <form x-ref="change_password_form" x-data="{hasPassword: <?php echo $data['has_password'] ?>}" @submit.prevent>
            <header class="flex flex-wrap items-center justify-between gap-3 mb-10">
                <div class="w-64 flex-shrink-0">
                    <span class="text-2xl font-bold">My user profile</span>
                </div>
            </header>

            <div class="flex flex-col gap-y-8">
                <div x-bind="formGroup">
                    <label class="form-label">Profile image</label>
                    <div x-bind="formGroup.inputContainer">
                        <div>
                            <!-- Profile image -->
                            <?php if (empty($data['profile_image_path'])) : ?>
                                <a href="javascript:void(0)" class="py-2" @click="$refs.profile_input.click()">
                                    <div style="width: 50px;height:50px" class="border-2 rounded-full">
                                        <img x-ref="profile_imgs" class="w-full h-full" src="<?php echo URLROOT ?>/img/profiles/default-profile.png" alt="profile img">
                                    </div>
                                    <span class="text-sm flex items-center gap-2 pt-1 text-blue-600 hover:underline">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Choose a profile
                                    </span>
                                    <input type="file" @change="submitProfileImg" x-ref="profile_input" class="form-input hidden" name="profile_image">
                                </a>
                            <?php else : ?>
                                <div class="py-2">
                                    <a x-ref="view_img_link" href="<?php echo URLROOT . '/' . $data['profile_image_path'] ?>" target="_blank" class="py-2">
                                        <div class="rounded-full overflow-hidden hover:opacity-50 border-2" style="width: 50px;height:50px">
                                            <img x-ref="profile_imgs" class="w-full h-full" src="<?php echo URLROOT . '/' . $data['user']->thumbnail_img_path ?>" alt="profile img">
                                        </div>
                                    </a>

                                    <a href="javascript:void(0)" class="py-2" @click="$refs.profile_input.click()">
                                        <span class="flex items-center gap-2 pt-1 text-sm text-blue-600 hover:underline">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Update profile
                                        </span>
                                        <input type="file" @change="submitProfileImg" x-ref="profile_input" class="form-input hidden" name="profile_image">
                                    </a>
                                </div>
                            <?php endif; ?>
                            <span class="hidden text-danger-600 text-sm" id="profile_img_err">
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Activation type -->
                <div x-bind="formGroup">
                    <label class="form-label">Activation type(s)</label>
                    <div x-bind="formGroup.inputContainer">
                        <span class="flex flex-wrap gap-3 text-sm p-3">
                            <div>
                                <?php if ($data['has_password']) : ?>
                                    <span class="bg-secondary-100 text-secondary-600 whitespace-nowrap px-2 inline-flex items-center gap-1 text-xs leading-5 font-semibold rounded-full">Password activated</span>
                                <?php else : ?>
                                    <span @click="onEditMode = !onEditMode" class="cursor-pointer hover:underline text-blue-600 whitespace-nowrap px-2 inline-flex items-center gap-1 text-xs leading-5 font-semibold rounded-full">Create username and password</span>
                                <?php endif ?>
                                <?php if ($data['has_facebook_auth']) : ?>
                                    <a href="<?php echo getFacebookReauthenticateLoginUrl(); ?>" @click.prevent="if (confirm('Change facebook auth account?')) window.location.href=$event.target.getAttribute('href')" class="bg-blue-100 text-blue-600 whitespace-nowrap px-2 inline-flex items-center gap-1 text-xs leading-5 font-semibold rounded-full hover:underline">Change Facebook</a>
                                <?php else : ?>
                                    <a href="<?php echo getFacebookLoginUrl(); ?>" class="hover:underline text-blue-600 whitespace-nowrap px-2 inline-flex items-center gap-1 text-xs leading-5 font-semibold rounded-full">Activate Facebook</a>
                                <?php endif ?>
                                <?php if ($data['has_google_auth']) : ?>
                                    <a href="<?php echo getGoogleLoginUrl(); ?>" @click.prevent="if (confirm('Change google auth account?')) window.location.href=$event.target.getAttribute('href')" class="bg-danger-100 text-danger-600 whitespace-nowrap px-2 inline-flex items-center gap-1 text-xs leading-5 font-semibold rounded-full hover:underline">Change Google</a>
                                <?php else : ?>
                                    <a href="<?php echo getGoogleLoginUrl(); ?>" class="hover:underline text-blue-600 whitespace-nowrap px-2 inline-flex items-center gap-1 text-xs leading-5 font-semibold rounded-full">Activate Google</a>
                                <?php endif ?>
                            </div>
                        </span>
                    </div>
                </div>

                <!-- Email -->
                <div x-bind="formGroup">
                    <label class="form-label">
                        Email
                    </label>
                    <div x-bind="formGroup.inputContainer">
                        <span class="text-sm p-3">
                            <?php echo $data['email'] ?>
                        </span>
                        <a href="<?php echo URLROOT ?>/users/updateEmail" class="text-blue-500 ml-3 p-3 rounded-md hover:underline hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">Change email</a>
                    </div>
                </div>

                <!-- Old Password -->
                <div x-bind="formGroup">
                    <label x-bind="formGroup.formLabel">
                        Old Password
                    </label>
                    <div x-bind="formGroup.inputContainer">
                        <div class="w-full flex justify-between">
                            <input x-model="profile.old_password" type="password" x-bind="formGroup.formInput" :placeholder="!onEditMode && hasPassword ? '******' : ''" name="old_password" autocomplete="new-password">
                            <button @click="onEditMode = !onEditMode" x-show="!onEditMode" type="button" class="text-sm whitespace-nowrap flex items-center gap-2 text-blue-600 p-2 rounded-md hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                                Change password
                            </button>
                        </div>
                        <span x-bind="formGroup.formInputError" x-ref="old_password_err">
                        </span>
                    </div>
                </div>

                <!-- Password -->
                <div x-bind="formGroup" x-show="onEditMode">
                    <label x-bind="formGroup.formLabel">
                        New password
                    </label>
                    <div x-bind="formGroup.inputContainer">
                        <input x-model="profile.password" type="password" x-bind="formGroup.formInput" :placeholder="!onEditMode && hasPassword ? '******' : ''" name="password" autocomplete="new-password">
                        <span x-bind="formGroup.formInputError" x-ref="password_err">
                        </span>
                    </div>
                </div>

                <!-- Confirm password -->
                <div x-bind="formGroup" x-show="onEditMode">
                    <label x-bind="formGroup.formLabel">
                        Confirm new password
                    </label>
                    <div x-bind="formGroup.inputContainer">
                        <input x-model="profile.confirm_password" type="password" x-bind="formGroup.formInput" :placeholder="!onEditMode ? '******' : ''" name="confirm_password" autocomplete="new-password">
                        <span x-bind="formGroup.formInputError" x-ref="confirm_password_err">
                        </span>
                    </div>
                </div>

                <!-- Form submit -->
                <div x-bind="formGroup" x-show="onEditMode">
                    <label x-bind="formGroup.formLabel"></label>
                    <div x-bind="formGroup.inputContainer">
                        <div class="flex gap-3">
                            <input @click="submitChangePassword()" type="submit" value="Update" x-ref="submit" class="form-btn bg-primary-500 text-white w-full md:w-80 py-2 px-4">
                            </input>
                            <a @click="onEditMode = !onEditMode" x-show="onEditMode" href="javascript:void(0)" class="flex items-center gap-2 text-blue-600 py-2 px-4 bg-secondary-100 rounded-md hover:bg-secondary-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancel editing
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('app', () => ({
            init() {},
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
                old_password: '',
                password: '',
                confirm_password: '',
            },
            submitProfileImg(event) {
                const updateRequest = new FormData();
                const file = event.target.files[0];
                updateRequest.append('user_id', <?php echo $this->session->auth()->id ?>)
                updateRequest.append('profile_img', file)

                const errorMsg = document.querySelector('#profile_img_err')
                // greater than 2 mb
                if (file && file.size > 2 * 1024 * 1024) {
                    errorMsg.classList.remove('hidden')
                    errorMsg.textContent = 'File size limit error. Your file size must be below 2 MB'
                    return
                }

                const f = fetch('<?php echo URLROOT . "/profiles/profileImage" ?>', {
                    method: "POST",
                    body: updateRequest,
                })

                f.then(data => data.json()
                    .then(res => {
                        if (res.status == 'ok') {
                            this.$refs.profile_imgs.src = URL.createObjectURL(file)
                            this.$refs.view_img_link.href = '<?php echo URLROOT ?>' + `/public/${res.profile_img_path}`
                            errorMsg.classList.add('hidden')
                        } else {
                            errorMsg.classList.remove('hidden')
                            errorMsg.textContent = res.message
                        }
                    }))
            },
            submitChangePassword(event) {
                const old_password_err = this.$refs.old_password_err
                const password_err = this.$refs.password_err
                const confirm_password_err = this.$refs.confirm_password_err

                const f = fetch('<?php echo URLROOT . "/profiles/changePassword" ?>', {
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
                            old_password_err.classList.add('hidden')
                            password_err.classList.add('hidden')
                            confirm_password_err.classList.add('hidden')

                            this.onEditMode = false
                            this.profile = {
                                old_password: '',
                                password: '',
                                confirm_password: ''
                            }
                            this.$refs.change_password_form.reset()
                        } else {
                            old_password_err.classList.remove('hidden')
                            password_err.classList.remove('hidden')
                            confirm_password_err.classList.remove('hidden')

                            old_password_err.textContent = res.errors.old_password_err
                            password_err.textContent = res.errors.password_err
                            confirm_password_err.textContent = res.errors.confirm_password_err
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
        }))
    })
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>