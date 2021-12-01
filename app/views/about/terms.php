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
                            Terms of service
                        </span>
                    </li>
                </ol>
            </nav>
        </div>

        <form action="<?php echo URLROOT; ?>/members/clinicInfo" method="POST">
            <header class="flex flex-wrap items-center justify-between gap-3 mb-10">
                <div class="w-64 flex-shrink-0">
                    <span class="text-2xl font-bold">Our Terms of service</span>
                </div>
            </header>

            <div class="flex flex-col text-lg lg:w-3/4 text-justify gap-y-8">
                These terms of use are an agreement between PDA-DCC (the “Association”), publisher of pda-dcc.com (the “Website”) and users of its Website (herein referred to as “you” or “user”). This agreement (the “Agreement”) also governs your use of the products and services made available to you through our Website. By using the Website, you acknowledge that you have reviewed and agree to all of the provisions, disclosures and disclaimers in this Agreement and agree to be bound by them in connection with your use of the Website. The Company reserves the right to modify or supplement any or all of the terms of this Agreement from time to time without notice to you. The Company reserves the right, in its sole discretion, to restrict, suspend or terminate access to all or any part of the Website(s) or to change, suspend or discontinue all or any aspect of the Website(s), including the availability of any feature, database, information or content, at any time and without prior notice or liability.

                As you use the Website, you will encounter windows and hyperlinks that take you to web pages or websites of other companies with which we contract, either to make their products and services available to you or to enable you to communicate directly with those companies. Your use of such web pages or websites, while subject to the terms of this Agreement, is also subject to and governed by the terms and guidelines, if any, contained within such web page or website. Where such web page or website contains terms, conditions, policies, notices or disclaimers prepared by the Company related to the use of our Website or other web pages, or websites accessed through our Website, such terms, conditions, policies, notices or disclaimers are incorporated by reference into this Agreement whether or not any such term, condition, policy, notice, or disclaimer is referenced below. You acknowledge that you are aware of and accept the terms and conditions of the Website’s Privacy Policy

                <h1 class="text-3xl font-semibold">Restricted to adults</h1>
                You must be at least 18 years of age to use the Website. You agree to be solely responsible for (i) maintaining such controls over the use and/or access to the Website by minors in your family or (ii) having access to your computer or login limited to the extent necessary to restrict use to adults.

                <h1 class="text-3xl font-semibold">Our staff</h1>
                Our staff includes, in part, dentists and other health care professionals. None of our dentists will enter into a dentist-patient relationship with you, and no other Professional participants will establish any clinical relationship with you while they are using our Website services. They can assist you in your personal, general research but they will not engage in any conduct that involves the practice of dentistry, medicine or other health care profession. The information you obtain from the Website should not substitute for or be used instead of a clinical or therapeutic relationship with a health care professional. You are responsible for reviewing and understanding all research and other information obtained by you from the Website.

                The Professional participants will not create or retain any medical records about you or monitor your care. The Professional participants should not be considered to be your treating or care giving health care professional and will not communicate with your own health care provider. Consequently, any information you obtain from the Website should not substitute or be used instead of a relationship with a health care professional. All users are encouraged to seek the advice of, and regularly consult with, dentists and other health care professionals of their selection. You should not disregard or delay medical advice or treatment based on information on the Website.

                The Website does not clinically evaluate or perform credentialing of the Professional participants, because the Professional participants are not practicing dentistry or providing dental advice about individual-specific treatment matters. The Professional participants do not diagnose or treat any dental or medical conditions or prescribe medication or treatments for anyone using the Website. The Professional participants may not accept payment from you and may not bill any insurance company, government payment program, or other source of health benefits in compensation for providing information to you on the Website. If you decide to seek information or obtain treatment from any Sponsor (as described below), the Professional participants will not follow up or monitor your care.

                Please do not share personal medical information of a kind you would wish to be held confidential in a dentist-patient or similar clinical relationship. The members of the Professional participants do not keep any medical records and will not have any records concerning prior contacts you may have made to our Website. Since the Professional participants are not in a dentist-patient relationship with you, the information you provide will not be considered a medical record. The Company shall have the right to use any questions, comments, or other information submitted by users in books, magazine articles, commentaries, research or similar ways.

                When we receive an e-mail, we make reasonable efforts to respond in as timely a manner as possible, but the Company does not guarantee that it will respond to all inquiries. We reserve the right to ignore or delete any information, including, without limitation, information that is fraudulent, abusive, defamatory, and obscene or in violation of a copyright, trademark or other intellectual property or ownership right of any other person. You should be aware of the general risks of transmitting information over the Internet. While we attempt to prevent unauthorized persons from accessing our files or tampering with our site, we cannot guarantee that these efforts will always be successful or that information will be transmitted without interruption or error and the Company specifically disclaims any liability with respect thereto.

                <h1 class="text-3xl font-semibold">Our sponsors</h1>
                The Website is one way for you to gather general dental/medical information and to make contact with certain contracting sponsors in your area who have arranged to post advertisements on, and make other information available through, our Website (the “Sponsors”). Our relationships with a Sponsor in a particular area are based on factors we establish, which may include offering exclusivity in a particular region. Sponsor information may be displayed based on the zip code where you reside. All information regarding a specific Sponsor has been provided by that Sponsor.

                We contract with Sponsors for a fee, and such fee is not based on the volume or value of any services Sponsors may or may not provide to our users. We do not endorse, credential or accredit the services our Sponsors advertise and make no representations or warranties about the type of services, quality of care, source of payment or billing practices of our Sponsors. We do not verify or update the licenses, accreditations, certifications or other permits and approvals of any Sponsor. You are responsible for all activities between you and a Sponsor.

                If you indicate that you wish information about or from a Sponsor, or to be contacted by a Sponsor, this information is passed along to the Sponsor. We also provide to our Sponsors general information about the users who contact our Website.

                <h1 class="text-3xl font-semibold">Contacts with others websites</h1>
                Our Website may include or provide links to other web sites on the Internet, which may include information, opinions or recommendations of various individuals, organizations or companies. In providing such links, we do not represent to you that the Company has investigated the content of such information, opinions or recommendations, and thus you understand and agree that our Website does not warrant or guarantee the accuracy of such information or endorse, credential or accredit any such opinions, recommendations, websites, individuals, organizations or companies. You acknowledge and agree that the Company has no control over such sites and is not responsible for the availability of such external sites. You also acknowledge and agree that we do not endorse and are not responsible or liable for any content, advertising, products, links or other materials on or available from such sites. You should contact the site administrator for other websites if you have any concerns regarding such links or the content located on such other websites.

                <h1 class="text-3xl font-semibold">Our information</h1>
                The Company strives to make the Website a valuable resource of timely information for our users. We cannot ensure that information we provide is accurate, exhaustive or complete on every subject or that it will necessarily include all of the most recent information available on a particular topic. This information is of a general nature and we urge you to review it with your healthcare provider. Users should never delay, ignore or fail to obtain medical advice based on information obtained from our Website.

                <h1 class="text-3xl font-semibold">Your information</h1>
                The Company may gather and share user information gathered through the Website with its Sponsors about the areas, topics and communities of interest, zip codes, and products and services identified, purchased or used by you and our other users of the Website. Such information may be aggregate or individual. Information we gather about the use of our website may be used, for example, in providing information to our Sponsors, advertisers or vendors of products and services with which we have a relationship. The manner in which we collect and use personally identifying information voluntarily provided by you is described in our Privacy Policy. Such information may also be used by the Company to enforce this Agreement.

                <h1 class="text-3xl font-semibold">Research organizations and studies</h1>
                We contract with research organizations and Individuals to complete research studies of various kinds. The Company is compensated under such arrangements. The Company does not evaluate, approve, review or endorse studies by any research organization. We do not control or determine how information provided to a research organization is used by that organization or whether the research organization provides such information to others with which it has agreements.

                <h1 class="text-3xl font-semibold">Copyright and trademark</h1>
                All text and images Copyright© 1983-2017 by the Company. The names on our Websites and associated logos are proprietary trademarks and service marks of the Company

                The Website contains information, software, text, photographs, graphics and other material that are protected by copyright, trademark or other proprietary rights of the Company. All content on the Website is copyrighted as a collective work pursuant to applicable copyright law. You are granted a limited nonexclusive license to use the information for your personal and noncommercial use. Otherwise, you may not copy, store in an electronic form, modify, print, transmit, sell or transfer, create derivative works from, distribute, perform, frame in another web page, display, or in any way exploit any of the content, in whole or in part. Permission to reprint or electronically reproduce any materials is expressly prohibited without prior written consent from the Company. You may hyperlink to the Website provided that the link is to the “home” page of the Website.

                The Website includes an interactive portion that allows users to submit information. Users shall not provide copyrighted or other proprietary information without permission from the owner of such material or rights and shall be solely responsible for any damages resulting from such disclosures. Users shall be solely responsible for obtaining such permission and agree to indemnify the Company for any claim that information or materials submitted by you infringe any third-party intellectual property right. You grant the Company a nonexclusive license to use, copy, edit, modify, transmit, distribute and to create a derivative work of any information or material submitted by you through the Website, including, but not limited to, distribution in the Company’s electronic and print publications.

                If you believe that your work has been copied on the Website in a way that constitutes copyright infringement, please provide us along with the copyright agent the following information:

                1. an electronic or physical signature of the person authorized to act on behalf of the owner of the copyright interest;

                2. a description of the copyrighted work that you claim has been infringed;

                3. a description of where the material that you claim is infringing is located on the site;

                4. your address, telephone number, and email address;

                5. a statement by you that you have a good faith belief that the dispute use is not authorized by the copyright owner, its agent, or the law;

                6. a statement by you, made under penalty of perjury, that the above information in your Notice is accurate and that you are the copyright owner or authorized to act on the copyright owners behalf.

                The Company’s Copyright Agent for Notice of claims of copyright infringement can be reached at: 734-665-2020 by telephone; or by email: connect@dentaladvisor.com

                <h1 class="text-3xl font-semibold">Your conduct</h1>
                We may adopt and revise policies from time to time governing the conduct of our users, including, without limitation, when they exchange messages or information, participate in chat sites or community forums, which policies are incorporated by reference into this Agreement as noted above. We have the right, but not the obligation, to review, modify, block or delete any postings or messages we consider to be potentially defamatory, obscene, harassing, abusive, threatening or otherwise intended to or having the effect of interfering with or disrupting the exchange of information or operation of the Website. You agree not to use the Website or information from other users to send unsolicited commercial messages, or to initiate unsolicited commercial transactions, either individually or in a mass mailing or message distribution. If you post information, or other materials on the Website, you agree and represent and warrant that you have all rights under applicable law, including without limitation, copyright, trademark, trade secret, or other intellectual property laws, that permit you to provide this information on the Website and that we and all users have the right to download and use that information, software or other materials. You warrant to the Company and its Website that you will not use them for any purpose that is unlawful or prohibited by this Agreement of use in any manner.

                <h1 class="text-3xl font-semibold">Limitation of warranty</h1>
                Information supplied by our website is provided “as is, as available” and neither the company nor any of the professional participants, including, without limitation, our doctors and sponsors, make any representation or warranty with respect to the contents of the website or information furnished by them or our agents, employees or representatives and specifically disclaim to the fullest extent permitted by law any and all warranties, express or implied, including, but not limited to, implied warranties of merchantability, completeness, timeliness, correctness, noninfringement, or fitness for any particular use, application or purpose. You hereby also agree that the company, and its shareholders, officers, directors, agents, employees, subsidiaries and affiliates, shall not be liable to you for any damages, claims, demands or causes of action, direct or indirect, special, incidental, consequential or punitive, as a result of your use of this website or any information you obtain on it or any other interaction with the company or its subsidiaries. In doing so, you agree that you are waiving voluntarily and unequivocally any liability of the company or its subsidiaries.

                The company cannot and does not make any representation or warranty concerning errors, omissions, delays or other defects in the information supplied to others, or that its files are free of viruses, worms, trojan horses or other code that include or manifest contaminating or destructive characteristics. The foregoing is in addition to any other limitations and disclaimers set forth elsewhere in this agreement.

                <h1 class="text-3xl font-semibold">INDEMNIFICATION</h1>
                In addition to any other indemnifications by you set forth elsewhere in this agreement, you agree to indemnify and hold harmless the company, its affiliates and their respective shareholders, officers, directors, agents, and employees from and against any claim, demand, or cause of action, including any (including attorneys fees) arising out of claims based on any aspect of your use of the website, including, without limitation (I) claims based on defamation or other conduct by you in using the website, or (ii) your violation of any intellectual property laws, including, without limitation, those relating to copyright, trademarks or trade secrets.

                <h1 class="text-3xl font-semibold">MISCELLANEOUS</h1>
                If any clause or provision set forth herein is determined to be illegal, invalid or unenforceable under present or future law, then, in that event, you understand and agree that the clause or provision so determined to be illegal, invalid or unenforceable shall be severable without affecting the enforceability of all remaining clauses or provisions. The application of these provisions, disclosures, terms, conditions and disclaimers and all other matters arising from your use of this Website or of any information you obtain from our Website shall be governed by the laws of the United States of America and the State of Michigan. Any claims, disputes or other controversies relating to or arising from these provisions, disclosures and disclaimers or from your use of this Website or any information you receive from the Company shall be brought exclusively in the United States District Court, Michigan District, or the Circuit Court for Washtenaw County, Michigan, and you hereby expressly consent to the exercise of jurisdiction over you by such courts. To the fullest extent permitted by applicable law, each party to this Agreement waives its right to a jury trial with respect to any action brought under or in connection with this Agreement. Any notice to the Company shall be given in writing and sent by certified and registered mail to PDA-DCC, 3110 W. Liberty, Ann Arbor, MI 48103, Attn.: John M. Powers, Senior Vice President.

                This Agreement constitutes your entire agreement with the Company regarding the Website and supersedes all prior or contemporaneous communications, proposals or agreements, whether oral or written, between us. You agree that this Agreement takes effect on your first use of the Website, and that it applies to all persons accessing the Website from your computer. You agree and are obligated to regularly review this Agreement for changes and agree to those changes by continuing to use the Website. The Company has the right to amend this Agreement at any time without notice to you by making changes to this Agreement as posted. If any inconsistency exists between the terms of this Agreement and any additional terms and conditions posted on the Website, such terms will be interpreted as to eliminate any inconsistency, if possible, and otherwise, the additional terms and conditions will control.

                The headings used in these terms of use are for convenience only and such headings are not to be used in determining the meaning or interpretation of these terms of use.

                You agree that regardless of any statute or law to the contrary, any claim or cause of action arising from or out of use of the Website must be filed within one (1) year after such claim or cause of arose.

                You acknowledge that the provisions, disclosures and disclaimers set forth in this Agreement are fair and reasonable and your agreement to follow and be bound by them is not the result of fraud, duress or undue influence exercised upon you by any person or entity. A printed version of this Agreement will be admissible in any proceeding relating to this Agreement to the same extent as other business documents and records generated and maintained in printed, hard copy form. Notwithstanding any provisions of this Agreement, the Company has available all remedies at law or equity to enforce this Agreement. There are no representations, promises, warranties or undertakings by the Company contrary to those set forth above.

                <h1 class="text-3xl font-semibold">SUBSCRIPTION CLAIMS</h1>
                Claims for missing issues must be submitted in writing within six months of publication date. Issues claimed after this time will be billed at the single copy rate plus postage. Paper editions are only available for two years (quantities are limited). Requests for cancellation of online subscriptions must be made within 30 days of account activation.

                Claims should be submitted via email to hgraber@dentaladvisor.com
                or by mail to:

                The Dental Advisor – Subscriptions

                3110 W. Liberty

                Ann Arbor, MI 48103
            </div>
        </form>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>