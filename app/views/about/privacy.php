<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/guestSidebar.php'; ?>

<div class="flex flex-col w-full" x-data>
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
                            Privacy policy
                        </span>
                    </li>
                </ol>
            </nav>
        </div>

        <div>
            <header class="flex flex-wrap items-center justify-between gap-3 mb-10">
                <div class="w-64 flex-shrink-0">
                    <span class="text-2xl font-bold">Our Privacy Policy</span>
                </div>
            </header>

            <div class="flex flex-col lg:w-3/4 text-justify text-lg gap-y-8">
                <p>
                    The <b>Philippine Dental Association - Davao City Chapter (PDA-DCC)</b> works to preserve its stakeholders' right to
                    privacy in compliance with the Data Privacy Act of 2012 (R.A. 10173) and its Implementing Rules and Regulations.
                    As required by the National Privacy Commission, our organization rigorously follows its privacy standards in the
                    collecting, processing, disclosure, storage, and transport of personal and confidential data. This
                    privacy policy is intended to describe the data privacy framework to which our organization adheres.
                    <br> <br>
                    This privacy policy in particular, does not state the specific information with regards to the data collection and processing
                    of other PDA chapters nor the PDA. Thus, these policies are unique and are only effective for the usage of pda-dcc.com
                    and PDA-DCC.
                </p>

                <h1 class="text-3xl font-semibold">What types of data do we collect?</h1>
                <p>
                    We collect data that are relevant to both the members, officers, and executives of the PDA-DCC.
                    Such data will be required to allow pda-dcc.com to be operational. Data are categorized into (but not limited to)
                    the following:
                </p>

                <ul class="list-disc px-6">
                    <li>Personal information</li>
                    <li>License information</li>
                    <li>Clinic information</li>
                    <li>PDA-DCC Membership information</li>
                    <li>PDA-DCC Annual payments information</li>
                </ul>

                <h1 class="text-3xl font-semibold">What do we do with the data we collect?</h1>
                <p>
                    As an organization that deals with professional dentists, the PDA-DCC needs to collect the aforementioned data
                    and ensure its effective use. Personal, License, and Clinic data of the members are collected
                    to correctly identify the members and give them login access. The PDA-DCC Membership information is collected to
                    ensure that all members are properly registered and give reports to the supervising entities. The PDA-DCC Annual payments data
                    are recorded into the system by the authorized officers for recording purposes and give reports to the supervising entities.
                </p>

                <p>
                    All data that are collected by the authorized officers will be registered in our database via pda-dcc.com for organizational
                    use, and also to give access to the information about the members such as their personal information and payments.
                    Hence, these pieces of information are kept under strict confidentiality and are processed within their intended purpose.
                </p>

                <h1 class="text-3xl font-semibold">What choices or controls do you have on your data?</h1>
                <p>
                    Our goal is to give you simple and meaningful choices regarding your information. You are given
                    certain controls over your information that are built directly into your profile settings.
                    For example, you can:
                </p>

                <ul class="list-disc px-6">
                    <li>Edit your information at any time, such as your personal, license, and clinic
                        information.
                    </li>
                    <li>
                        Change your login credentials such as your email and password, and change your
                        third-party login channels like Facebook and Google.
                    </li>
                </ul>


                <h1 class="text-3xl font-semibold">How long do we keep your data?</h1>
                <p>
                    The PDA-DCC retains data as long as the organization deems it to be useful for its operations.
                    For instance, if a pda-dcc account is inactive, his/her data will be archived for organizational
                    use such as keeping records in case they (members) will be active again.
                </p>

                <p>
                    Our organization will store all data required in a well-managed and secure third-party
                    digital repository.
                </p>

                <h1 class="text-3xl font-semibold"> How do we protect such data? </h1>
                <p>
                    By utilizing efficient and well backed-up electronic and physical security methods,
                    we can ensure the availability, confidentiality, and integrity of all the data we collected.
                    These systems are designed to secure such data from abuse, deletion, illegal access, and
                    unauthorized modification. Under current information security and data privacy standards,
                    the organization's electronic and physical repositories for sensitive data are assured to be well-maintained
                    and frequently kept up to date.
                </p>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>