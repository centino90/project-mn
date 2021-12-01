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
                    In accordance with the Data Privacy Act of 2012 (R.A. 10173) and its Implementing Rules
                    and Regulations, the <b>PDA-DCC</b> puts forth its efforts to protect the right to privacy
                    of its stakeholders. Our organization strictly employs its privacy protocols in the collection,
                    processing, disclosure, storage, and transmission of personal and privileged data as obliged
                    by the National Privacy Commission. This Institutional Data Privacy Statement (IDPS) of the
                    PDA-DCC is designed to state the general data privacy framework in which the organization adheres.
                    Due to the numerous subordinating offices of the organization, this statement may not contain
                    specific information with regards to the data collection and processing of a particular
                    office or purpose. Thus, every other privacy statement or notice produced and to be produced by
                    the PDA-DCC for a particular office or purpose shall be consistent with this
                    IDPS and with the organization’s Privacy Manual.
                </p>

                <h1 class="text-3xl font-semibold">What personal data do we collect?</h1>
                <p>
                    As an organization that deals with professional dentists, the PDA-DCC is responsible for collecting specific personal and
                    privileged data in order to operate appropriately. Such data are categorized into
                    (but not limited to) the following:
                </p>

                <ul class="list-disc px-6">
                    <li>Student personal information</li>
                    <li>Student academic information</li>
                    <li>Alumni personal information</li>
                    <li>Employee personal information</li>
                    <li>Guidance counselor-counselee privileged information</li>
                    <li>Doctor-patient privileged information</li>
                    <li>Community partners’ personal information</li>
                    <li>Web cookies (organization website)</li>
                </ul>

                <h1 class="text-3xl font-semibold">On what purpose are such data being collected?</h1>
                <p>
                    As an organization that deals with professional dentists, the PDA-DCC needs to collect the aforementioned data in order to
                    carry on its operations effectively. Student personal and academic data are gathered to supervise
                    the learners’ educational progress and their overall learning experience within the period they
                    are enrolled in the organization. Privileged information collected by the organization’s physicians
                    and counselors intend to protect the welfare of both students and employees. These pieces of
                    information are kept under strict confidentiality and are processed within their intended purpose.
                    Records that belong to alumni are also being kept by the organization’s alumni organization for
                    particular functions such as alumni tracking and homecoming activities. The organization’s community
                    campaigns lead to the collection of sensitive and privileged information from community partners.
                    These data, like other data, are guaranteed to be protected and overseen under the principles of
                    lawfulness, fairness, and transparency.
                </p>

                <h1 class="text-3xl font-semibold">How long do we store such data?</h1>
                <p>
                    The PDA-DCC retains data as long as the organization deems it to be useful for its operations. It is
                    taken into consideration that different subordinating offices of the organization follow different data
                    retention protocols. The organization stores the personal and academic data of its students and alumni in
                    perpetuity. Such data are stored in well-managed digital and physical repositories within the period that
                    the Commission on Higher Education and the Department of Education require the organization to keep them.
                    Employee data are being processed by the organization’s HRD office as long as the data subject is employed
                    by the PDA-DCC. In the event that an employee’s service to the organization is terminated, sensitive records
                    that belong to that individual such as biometric data, government ID information, and other personal information
                    are appropriately archived from the organization’s database. Employee data are also stored in perpetuity. Thus,
                    archival, and not complete deletion, of both digital and physical data is obligatory. The organization also keeps
                    doctor-patient and counselor-counselee privileged information from its clinic and its Search and Growth Center.
                    These offices have retention policies that last for five (5) years. After such time, the data are then deleted or
                    disposed of in a manner that regards confidentiality. The organization’s Community Extension Services Office keeps
                    personal and privileged data of community partners. These data are kept within the arrangements stated in the contracts
                    and MOA that bind the PDA-DCC to such community partners. Confidentiality is taken into consideration in the disposal
                    of any community information by the time any of the said contracts or MOA expires.
                </p>

                <h1 class="text-3xl font-semibold"> How do we protect such data? </h1>
                <p>
                    The PDA-DCC and its trusted auxiliary third-parties ensure the availability, confidentiality, and integrity of its
                    collected data by employing efficient and properly backed-up electronic and physical security systems. These systems intend
                    to protect such data from misuse, destruction, unauthorized access, and illicit alteration. The organization’s electronic and
                    physical repositories for sensitive data are guaranteed to be well-maintained and regularly kept up to date under the modern
                    principles of information security and data privacy.
                </p>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>