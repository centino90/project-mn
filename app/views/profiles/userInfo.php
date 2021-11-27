<?php require APPROOT . '/views/inc/header.php'; ?>

<!-- Profile sidebar -->
<?php require APPROOT . '/views/inc/profileSidebar.php'; ?>

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
                            User profile
                        </span>
                    </li>
                </ol>
            </nav>
        </div>

        <form action="<?php echo URLROOT; ?>/profiles/userInfo" method="POST">
            <!-- <div class="text-black text-center">
        <?php flash('update_success'); ?>
      </div> -->

            <header class="flex flex-wrap items-center justify-between gap-3 mb-10">
                <div class="w-64 flex-shrink-0">
                    <span class="text-2xl font-bold">User profile</span>
                </div>
                <div>
                    <button type="button" class="flex text-blue-600 p-2 rounded-md hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500" @click="onEditMode = !onEditMode" x-show="!onEditMode">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <?php if ($data['has_password']) : ?>
                            Change password
                        <?php else : ?>
                            Create password
                        <?php endif; ?>
                    </button>
                    <button type="button" class="flex text-blue-600 p-2 rounded-md hover:bg-secondary-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500" @click="onEditMode = !onEditMode" x-show="onEditMode">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Disable editing
                    </button>
                </div>
            </header>

            <div class="flex flex-col gap-y-8">
                <!-- Email -->
                <div x-bind="formGroup">
                    <label class="form-label">Email</label>
                    <div x-bind="formGroup.inputContainer">
                        <span class="flex flex-wrap gap-3 text-sm p-3">
                            <span><?php echo $data['email'] ?></span>

                            <div>
                                <?php if ($data['has_facebook_auth']) : ?>
                                    <span class="bg-blue-100 text-blue-600 whitespace-nowrap px-2 inline-flex items-center gap-1 text-xs leading-5 font-semibold rounded-full">Facebook activated</span>
                                <?php endif ?>
                                <?php if ($data['has_google_auth']) : ?>
                                    <span class="bg-danger-100 text-danger-600 whitespace-nowrap px-2 inline-flex items-center gap-1 text-xs leading-5 font-semibold rounded-full">Google activated</span>
                                <?php endif ?>
                                <?php if ($data['has_password']) : ?>
                                    <span class="bg-secondary-100 text-secondary-600 whitespace-nowrap px-2 inline-flex items-center gap-1 text-xs leading-5 font-semibold rounded-full">Password activated</span>
                                <?php endif ?>
                            </div>
                        </span>
                    </div>
                </div>

                <!-- Password -->
                <div x-bind="formGroup">
                    <label x-bind="formGroup.formLabel">
                        Password
                    </label>
                    <div x-bind="formGroup.inputContainer">
                        <input type="password" x-bind="formGroup.formInput" :placeholder="!onEditMode ? '******' : ''" name="password">
                        <?php if (!empty($data['password_err'])) : ?>
                            <div x-bind="formGroup.formInputError">
                                <?php echo $data['password_err']; ?> !
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Confirm password -->
                <div x-bind="formGroup" x-show="onEditMode">
                    <label x-bind="formGroup.formLabel">
                        Confirm password
                    </label>
                    <div x-bind="formGroup.inputContainer">
                        <input type="password" x-bind="formGroup.formInput" :placeholder="!onEditMode ? '******' : ''" name="confirm_password">
                        <?php if (!empty($data['confirm_password_err'])) : ?>
                            <div x-bind="formGroup.formInputError">
                                <?php echo $data['confirm_password_err']; ?> !
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Form submit -->
                <div x-bind="formGroup" x-show="onEditMode">
                    <label x-bind="formGroup.formLabel"></label>
                    <div x-bind="formGroup.inputContainer">
                        <input type="submit" value="Update" class="form-btn bg-primary-500 text-white w-full md:w-80 py-2 px-4">
                        </input>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('app', () => ({
            init() {
                if (this.checkServerValidationError()) {
                    this.onEditMode = true
                } else {
                    this.onEditMode = false
                }
                console.log(this.checkServerValidationError())
                console.log(this.serverData)
            },
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

            checkServerValidationError: function() {
                if (
                    this.serverData.password_err !== '' ||
                    this.serverData.confirm_password_err !== ''
                ) {
                    return true
                }
                return false
            }
        }))
    })
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>