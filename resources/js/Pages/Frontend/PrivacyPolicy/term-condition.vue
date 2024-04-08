<script setup>
import Footer from "../../Frontend/footer.vue";
import Header from "../../Frontend/header.vue";
import "../../../../css/frontend.css";
import { Head, Link, useForm } from '@inertiajs/vue3';
</script>
<template>
    <Header class="login-wrapper" />

    <Head title="termos-Condições" />
    <div class="about-us-bg-wrapper">
        <div class="container">
            <h1 class="mb-4 text-blue text-center">Termo e condição</h1>
            <div v-if="status" class="mb-4 text-sm font-medium text-green-600">A
                {{ status }}
            </div>
        </div>
    </div>
    <div class="privacy-content">
        <div class="container">
            <div style="margin-top:0; ">
                <h1 class="orf-intro-title">EMPRÉSTIMO INSTANTÂNEO – AVISO DE PRIVACIDADE DO USUÁRIO DO SITE E DO SERVIÇO </h1>
    
                <h2 class="orf-sub-title">
                    Introduction
                </h2>
                <p class="orf-paragraph">
                    It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.
                </p>
                <p class="orf-paragraph">
                    You can download a pdf version of the policy here: <a class="orf-link"
                        href="mailto:admin@instantloan.com">
                        admin@instantloan.com.
                    </a>. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy.
                </p>
    
                <h2 class="orf-sub-title">
                    1. Important information and who we are
                </h2>
                <h2 class="org-subTwo-title">
                    Purpose of this Privacy Notice
                </h2>
                <p class="orf-paragraph">
                <p class="orf-paragraph">
                    There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.
                </p>
                <!-- <div>
                    <ol class="orf-2nd-ol">
                        <div>
                            <ul class="orf-3rd-ul" type="disc">
                                <li class="orf-paragraph">
                                    use this website;
                                </li>
                                <li class="orf-paragraph">
                                    provide your contact details as a content creator;
                                </li>
                                <li class="orf-paragraph">
                                    register to use our products or services;
                                </li>
                                <li class="orf-paragraph">
                                    contact us to make a complaint; or
                                </li>
                                <li class="orf-paragraph">
                                    contact us directly for another purpose.
                                </li>
                            </ul>
                        </div>
                        <p class="orf-paragraph">This website is not intended for children, and we do not knowingly collect data
                            relating to any person under 18.</p>
                        <p class="orf-paragraph">It is important that you read this Privacy Notice together with any other
                            privacy, data protection or fair processing information we may provide on specific occasions when we
                            are collecting or processing Personal Data about you (including when we provide you with our
                            products and services) so that you are fully aware of how and why we are using it. This Privacy
                            Notice supplements other notices and privacy policies and is not intended to override them. You can
                            find our Service Terms here: <a class="orf-link" href="mailto:admin@instantloan.com">
                                admin@instantloan.com.
                            </a>.</p>
                    </ol>
                </div> -->
                </p>
                <h2 class="orf-sub-title">
                    Controller
                </h2>
                <p class="orf-paragraph">
                    Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.
                </p>
    
                <h2 class="orf-sub-title">
                    Contact details
                </h2>
                <p class="orf-paragraph">
                    If you have any questions about this Privacy Notice or our privacy practices, please contact us:
                </p>
                <p class="orf-paragraph">
                    Full name of legal entity: ORF Media Limited t/a My Fans Connect
                </p>
                <p class="orf-paragraph">
                    Email address: <a class="orf-link" href="mailto:admin@instantloan.com">
                        admin@instantloan.com.
                    </a>.
                </p>
                <p class="orf-paragraph">
                    Postal address: Unit 2 Actons Walk, Wigan, England, WN3 4HN
                </p>
                <p class="orf-paragraph">
                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"
                </p>
    
                <h2 class="orf-sub-title"> Changes to the Privacy Notice and your duty to inform us of changes</h2>
                <p class="orf-paragraph">
                    At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat."
                </p>
                <!-- <p class="orf-paragraph">
                    It is important that the Personal Data we hold about you is accurate and current. Please keep us informed if
                    your Personal Data changes during your relationship with us.
                </p>
    
                <h2 class="orf-sub-title">Third-party links</h2>
                <p class="orf-paragraph">
                    This website may include links to third-party websites, plug-ins, applications and social media platforms.
                    Clicking on those links or enabling those connections may allow third parties to collect or share data about
                    you. We do not control these third-party websites, plug-ins, applications or social media platforms and are
                    not responsible for their privacy statements. When you leave our website, we encourage you to read the
                    Privacy Notice of every website you visit.
                </p>
    
    
                <h2 class="orf-sub-title">
                    2. The data we collect about you
                </h2>
                <p class="orf-paragraph">
                    Personal Data means any information about an individual from which that person can be identified. It does
                    not include data where the identity has been removed (anonymous data).
                </p>
                <p class="orf-paragraph">
                    We may collect, use, store and transfer different kinds of Personal Data about you which we have grouped
                    together as follows:
                </p>
                <ul class="orf-2nd-ol" type="disc">
                    <div>
                        <li class="orf-paragraph">
                            Identity Data includes first name, last name, username or similar identifier and title.
                        </li>
    
                        <li class="orf-paragraph">
                            Contact Data includes billing/invoicing address email address and telephone numbers.
                        </li>
                        <li class="orf-paragraph">
                            Financial Data includes Paypal account details and activity.
                        </li>
                        <li class="orf-paragraph">
                            Transaction Data includes details about payments to and from you and other details of transactions
                            between subscribers and content creators.
                        </li>
                        <li class="orf-paragraph">
                            Technical Data includes internet protocol (IP) address, your login data, browser type and version,
                            time zone setting and location, browser plug-in types and versions, operating system and platform,
                            and other technology on the devices you use to access this website and our services.
                        </li>
                        <li class="orf-paragraph">
                            Profile Data includes your username and password, purchases or orders made by you, your interests,
                            preferences, feedback and survey responses.
                        </li>
                        <li class="orf-paragraph">
                            Usage Data includes information about how you use our website, products and services.
                        </li>
                        <li class="orf-paragraph">
                            Marketing and Communications Data includes your preferences in receiving marketing from us and your
                            communication preferences.
                        </li>
                    </div>
    
                </ul>
                <p class="orf-paragraph">
                    We also collect, use and share Aggregated Data such as statistical or demographic data for any purpose.
                    Aggregated Data could be derived from your Personal Data but is not considered Personal Data in law as this
                    data will not directly or indirectly reveal your identity. For example, we may aggregate your Usage Data to
                    calculate the percentage of users accessing a specific website feature. However, if we combine or connect
                    Aggregated Data with your Personal Data so that it can directly or indirectly identify you, we treat the
                    combined data as Personal Data which will be used in accordance with this Privacy Notice.
                </p>
                <p class="orf-paragraph">
                    We do not collect any Special Categories of Personal Data about you (this includes details about your race
                    or ethnicity, religious or philosophical beliefs, sex life, sexual orientation, political opinions, trade
                    union membership, information about your health, and genetic and biometric data). Nor do we collect any
                    information about criminal convictions and offences.
                </p>
                <p class="orf-paragraph">
                    Please note that any information you share with another party on our site is not shared with us but with the
                    other independent party.
                </p>
    
    
                <h2 class="orf-sub-title"> If you fail to provide Personal Data
                </h2>
                <p class="orf-paragraph">
                    Where we need to collect Personal Data by law, or under the terms of a contract we have with you, and you
                    fail to provide that data when requested, we may not be able to perform the contract we have or are trying
                    to enter into with you (for example, to provide you with our products or services). In this case, we may
                    have to cancel a product or service you have with us but we will notify you if this is the case at the time.
                </p>
    
                <h2 class="orf-sub-title">
                    3. How is your Personal Data collected?
                </h2>
                <p class="orf-paragraph">We use different methods to collect data from and about you including through:</p>
                <ul class="orf-2nd-ol" type="disc">
                    <li class="orf-paragraph">
                        Direct interactions. You may give us your Identity, Contact and Financial Data by filling in forms or by
                        corresponding with us by post, phone, email or otherwise. This includes Personal Data you provide when
                        you:
                    </li>
                    <li class="orf-paragraph">
                        enquire about, or place an order for, our products or services;
                    </li>
                    <li class="orf-paragraph">
                        create an account on our website;
                    </li>
                    <li class="orf-paragraph">
                        subscribe to services provided by content creators (or provide such services); or
                    </li>
                    <li class="orf-paragraph">
                        give us feedback or contact us.
                    </li>
                    <li class="orf-paragraph">
                        Automated technologies or interactions. As you interact with our website, we will automatically collect
                        Technical Data about your equipment, browsing actions and patterns. We collect this Personal Data by
                        using cookies, server logs and other similar technologies. We may also receive Technical Data about you
                        if you visit other websites employing our cookies. Please see our <a class="orf-link"
                            href="https://myfansconnect.com/cookie-notice">Cookie Policy</a> for further details.
                    </li>
                </ul>
    
                <h2 class="orf-sub-title"> 4. How we use your Personal Data
                </h2>
                <p class="orf-paragraph">
                    We will only use your Personal Data when the law allows us to. Most commonly, we will use your Personal Data
                    in the following circumstances:
                </p>
                <div>
                    <ul class="orf-3rd-ul" type="a">
                        <li class="orf-paragraph">
                            Where we need to perform the contract we are about to enter into or have entered into with you.
                        </li>
                        <li class="orf-paragraph">
                            Where it is necessary for our legitimate interests (or those of a third party) and your interests
                            and fundamental rights do not override those interests.
                        </li>
                        <li class="orf-paragraph">
                            Where we need to comply with a legal obligation.
                        </li>
                    </ul>
                </div>
                <p class="orf-paragraph">
                    Please see the Glossary and Lawful Basis sections of this Privacy Notice below to find out more about the
                    types of lawful basis that we will rely on to process your Personal Data.
                </p>
                <p class="orf-paragraph">
                    Generally, we do not rely on consent as a legal basis for processing your Personal Data although we will get
                    your consent before sending third party direct marketing communications to you via email or text message.
                    You have the right to withdraw consent to marketing at any time by contacting us using the details above.
                </p> -->
    
                <h2 class="orf-sub-title"> Purposes for which we will use your Personal Data
                </h2>
                <p class="orf-paragraph">
                    "On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pains."
                </p>
                <!-- <p class="orf-paragraph">
                    Please note that we may process your Personal Data for more than one lawful ground depending on the specific
                    purpose for which we are using your Personal Data. Please contact us if you need details about the specific
                    legal ground we are relying on to process your Personal Data where more than one ground has been set out in
                    the table below.
                </p> -->
    
                <!-- <table class="orf-table">
                    <tr>
                        <th>Purpose/Activity</th>
                        <th>Type of data</th>
                        <th>Lawful basis for processing including basis of legitimate interest</th>
                    </tr>
                    <tr>
                        <td>To register you as a new customer</td>
                        <td>
                            <ol type="a">
                                <li>Identity </li>
                                <li>Contact </li>
                            </ol>
                        </td>
                        <td>
                            <ol type="a">
                                <li>Performance of a contract with you </li>
                                <li>Necessary for our legitimate interests </li>
                            </ol>
                        </td>
                    </tr>
    
                    <tr>
                        <td>To process and deliver the agreement between a subscriber and content creator including:
                            <ol type="a">
                                <li>Manage payments, fees and charges </li>
                                <li>Collect and recover money </li>
                            </ol>
                        </td>
                        <td>
                            <ol type="a">
                                <li>Identity </li>
                                <li>Contact </li>
                                <li>Financial </li>
                                <li>Transaction </li>
                                <li>Marketing and Communications </li>
                            </ol>
                        </td>
                        <td>
                            <ol type="a">
                                <li>Necessary for our legitimate interests </li>
                            </ol>
                        </td>
                    </tr>
    
                    <tr>
                        <td>To process and deliver the agreement between a subscriber and content creator including:
                            <ol type="a">
                                <li>Manage payments, fees and charges </li>
                                <li>Collect and recover money </li>
                            </ol>
                        </td>
                        <td>
                            <ol type="a">
                                <li>Identity </li>
                                <li>Contact </li>
                                <li>Financial </li>
                                <li>Transaction </li>
                                <li>Marketing and Communications </li>
                            </ol>
                        </td>
                        <td>
                            <ol type="a">
                                <li>Necessary for our legitimate interests </li>
                            </ol>
                        </td>
                    </tr>
    
                    <tr>
                        <td>To manage our relationship with you which will include:
                            <ol type="a">
                                <li class="orf-paragraph">Notifying you about changes to our terms or Privacy Notice </li>
                                <li class="orf-paragraph">Asking you to leave a review or take a survey </li>
                            </ol>
                        </td>
                        <td>
                            <ol type="a">
                                <li>Identity </li>
                                <li>Contact </li>
                                <li>Profile </li>
                                <li>Marketing and Communications </li>
                            </ol>
                        </td>
                        <td>
                            <ol type="a">
                                <li>Performance of a contract with you </li>
                                <li>Necessary to comply with a legal obligation</li>
                                <li>Necessary for our legitimate interests (to keep our records updated and to study how
                                    customers use our products/services)</li>
                            </ol>
                        </td>
                    </tr>
    
                    <tr>
                        <td>
                            To prevent and detect crime (including fraud) and to administer and protect our business and this
                            website (including troubleshooting, data analysis, testing, system maintenance, support, reporting
                            and hosting of data)
                        </td>
                        <td>
                            <ol type="a">
                                <li>Identity </li>
                                <li>Contact </li>
                                <li>Technical </li>
                            </ol>
                        </td>
                        <td>
                            <ol type="a">
                                <li>Necessary for our legitimate interests (for running our business, provision of
                                    administration and IT services, network security, to prevent fraud and in the context of a
                                    business reorganisation or group restructuring exercise)</li>
                                <li>Necessary to comply with a legal obligation</li>
                            </ol>
                        </td>
                    </tr>
    
                    <tr>
                        <td>
                            To deliver relevant website content and advertisements to you and measure or understand the
                            effectiveness of the advertising we serve to you
                        </td>
                        <td>
                            <ol type="a">
                                <li>Identity </li>
                                <li>Contact </li>
                                <li>Profile </li>
                                <li>Usage </li>
                                <li>Marketing and Communications </li>
                                <li>Technical </li>
                            </ol>
                        </td>
                        <td>
                            Necessary for our legitimate interests (to study how customers use our products/services, to develop
                            them, to grow our business and to inform our marketing strategy)
                        </td>
                    </tr>
    
                    <tr>
                        <td>
                            To use data analytics to improve our website, products/services, marketing, customer relationships
                            and experiences
                        </td>
                        <td>
                            <ol type="a">
                                <li>Technical </li>
                                <li>Usage </li>
                            </ol>
                        </td>
                        <td>
                            Necessary for our legitimate interests (to define types of customers for our products and services,
                            to keep our website updated and relevant, to develop our business and to inform our marketing
                            strategy)
                        </td>
                    </tr>
    
                    <tr>
                        <td>
                            For assessment and analysis and to make suggestions and recommendations to you about products or
                            services that may be of interest to you, and to invite you to attend our events
                        </td>
                        <td>
                            <ol type="a">
                                <li>Identity </li>
                                <li>Contact </li>
                                <li>Technical </li>
                                <li>Usage </li>
                                <li>Profile </li>
                                <li>Marketing and Communications </li>
                            </ol>
                        </td>
                        <td>
                            Necessary for our legitimate interests (to develop our products/services and grow our business)
                        </td>
                    </tr>
                </table> -->
    
                <!-- <h2 class="orf-sub-title">Marketing
                </h2>
                <p class="orf-paragraph">
                    We may use your Identity, Contact, Technical, Usage and Profile Data to form a view on what we think you may
                    want or need, or what may be of interest to you. This is how we decide which products, services and offers
                    may be relevant for you (we call this marketing).
                </p>
                <p class="orf-paragraph">
                    You will receive marketing communications from us if you have requested information from us or purchased
                    products or services from us and you have not opted out of receiving that marketing.
                </p>
    
                <h2 class="orf-sub-title">Third party marketing
                </h2>
    
                <h2 class="orf-sub-title">Opting out
                </h2>
                <p class="orf-paragraph">
                    You can ask us to stop sending you marketing messages at any time by contacting us using the details
                    provided above.
                </p>
                <p class="orf-paragraph">
                    Where you opt out of receiving these marketing messages, this will not apply to Personal Data provided to us
                    as a result of a product or service purchase or order, product or service experience or other transactions.
                </p>
    
                <h2 class="orf-sub-title">Cookies
                </h2>
                <p class="orf-paragraph">
                    You can set your browser to refuse all or some browser cookies, or to alert you when websites set or access
                    cookies. If you disable or refuse cookies, please note that some parts of this website may become
                    inaccessible or not function properly. For more information about the cookies we use, please see <a
                        class="orf-link" href="https://myfansconnect.com/cookie-notice">Cookie Policy</a>.
                </p>
    
                <h2 class="orf-sub-title">Change of purpose
                </h2>
                <p class="orf-paragraph">
                    We will only use your Personal Data for the purposes for which we collected it, unless we reasonably
                    consider that we need to use it for another reason and that reason is compatible with the original purpose.
                    If you wish to get an explanation as to how the processing for the new purpose is compatible with the
                    original purpose, please contact us.
                </p>
                <p class="orf-paragraph">
                    If we need to use your Personal Data for an unrelated purpose, we will notify you and we will explain the
                    legal basis which allows us to do so.
                </p>
                <p class="orf-paragraph">
                    Please note that we may process your Personal Data without your knowledge or consent, in compliance with the
                    above rules, where this is required or permitted by law.
                </p>
    
                <h2 class="orf-sub-title">5. Disclosures of your Personal Data
                </h2>
                <p class="orf-paragraph">
                    We may share your Personal Data with the parties set out below for the purposes set out in the table above:
                </p>
    
                <ul class="orf-2nd-ol" type="disc">
                    <li class="orf-paragraph">
                        Third Parties as set out in the Glossary.
                    </li>
                    <li class="orf-paragraph">
                        Third parties to whom we may choose to sell, transfer or merge parts of our business or our assets.
                        Alternatively, we may seek to acquire other businesses or merge with them. If a change happens to our
                        business, then the new owners may use your Personal Data in the same way as set out in this Privacy
                        Notice.
                    </li>
                </ul>
                <p class="orf-paragraph">
                    We require all third parties to respect the security of your Personal Data and to treat it in accordance
                    with the law. We do not allow our third-party service providers to use your Personal Data for their own
                    purposes and only permit them to process your Personal Data for specified purposes and in accordance with
                    our instructions.
                </p>
    
                <h2 class="orf-sub-title">6. International transfers
                </h2>
                <p class="orf-paragraph">
                    We may transfer your Personal Data outside the UK or European Economic Area (EEA). We only do this where you
                    are outside the EEA or the person you are interacting with is outside the EEA.
                </p>
    
                <h2 class="orf-sub-title">7. Data security
                </h2>
                <p class="orf-paragraph">
                    We have put in place appropriate security measures to prevent your Personal Data from being accidentally
                    lost, used or accessed in an unauthorised way, altered or disclosed. In addition, we limit access to your
                    Personal Data to those employees, agents, contractors and other third parties who have a business need to
                    know. They will only process your Personal Data on our instructions and they are subject to a duty of
                    confidentiality.
                </p>
                <p class="orf-paragraph">
                    We have put in place procedures to deal with any suspected Personal Data breach and will notify you and any
                    applicable regulator of a breach where we are legally required to do so.
                </p>
    
                <h2 class="orf-sub-title">8. Data retention
                </h2>
                <h2 class="orf-sub-title">How long will you use my Personal Data for?
                </h2>
                <p class="orf-paragraph">
                    We will only retain your Personal Data for as long as reasonably necessary to fulfil the purposes we
                    collected it for, including for the purposes of satisfying any legal, regulatory, tax, accounting or
                    reporting requirements. We may retain your Personal Data for a longer period in the event of a complaint or
                    if we reasonably believe there is a prospect of litigation in respect to our relationship with you.
                </p>
                <p class="orf-paragraph">
                    To determine the appropriate retention period for Personal Data, we consider the amount, nature and
                    sensitivity of the Personal Data, the potential risk of harm from unauthorised use or disclosure of your
                    Personal Data, the purposes for which we process your Personal Data and whether we can achieve those
                    purposes through other means, and the applicable legal, regulatory, tax, accounting or other requirements.
                </p>
                <p class="orf-paragraph">
                    In some circumstances you can ask us to delete your Personal Data: see the Your Legal Rights section below
                    for further information.
                </p>
                <p class="orf-paragraph">
                    In some circumstances we will anonymise your Personal Data (so that it can no longer be associated with you)
                    for research or statistical purposes, in which case we may use this information indefinitely without further
                    notice to you.
                </p>
    
                <h2 class="orf-sub-title">9. Your legal rights
                </h2>
                <p class="orf-paragraph">
                    Under certain circumstances, you have rights under data protection laws in relation to your Personal Data.
                </p>
                <p class="orf-paragraph">
                    You have the right to:
                </p>
                <p class="orf-paragraph">
                    <span class="bold">Request access</span> to your Personal Data (commonly known as a "data subject access
                    request"). This enables you to receive a copy of the Personal Data we hold about you and to check that we
                    are lawfully processing it.
                </p>
                <p class="orf-paragraph">
                    <span class="bold">Request correction</span> of the Personal Data that we hold about you. This enables you
                    to have any incomplete or inaccurate data we hold about you corrected, though we may need to verify the
                    accuracy of the new data you provide to us.
                </p>
                <p class="orf-paragraph">
                    <span class="bold">Request erasure</span> of your Personal Data. This enables you to ask us to delete or
                    remove Personal Data where there is no good reason for us continuing to process it. You also have the right
                    to ask us to delete or remove your Personal Data where you have successfully exercised your right to object
                    to processing (see below), where we may have processed your information unlawfully or where we are required
                    to erase your Personal Data to comply with local law. Note, however, that we may not always be able to
                    comply with your request of erasure for specific legal reasons which will be notified to you, if applicable,
                    at the time of your request.
                </p>
                <p class="orf-paragraph">
                    <span class="bold">Object to processing</span> of your Personal Data where we are relying on a legitimate
                    interest (or those of a third party) and there is something about your particular situation which makes you
                    want to object to processing on this ground as you feel it impacts on your fundamental rights and freedoms.
                    You also have the right to object where we are processing your Personal Data for direct marketing purposes.
                    In some cases, we may demonstrate that we have compelling legitimate grounds to process your information
                    which override your rights and freedoms.
                </p>
                <p class="orf-paragraph">
                    <span class="bold">Request restriction of processing</span> of your Personal Data. This enables you to ask
                    us to suspend the processing of your Personal Data in the following scenarios:
                </p>
                <ul class="orf-3rd-ul" type="disc">
                    <li class="orf-paragraph">If you want us to establish the data's accuracy.</li>
                    <li class="orf-paragraph">Where our use of the data is unlawful but you do not want us to erase it.</li>
                    <li class="orf-paragraph">Where you need us to hold the data even if we no longer require it as you need it
                        to establish, exercise or defend legal claims. </li>
                    <li class="orf-paragraph">You have objected to our use of your Personal Data but we need to verify whether
                        we have overriding legitimate grounds to use it. </li>
                </ul>
                <p class="orf-paragraph">
                    <span class="bold">Request the transfer </span> of your Personal Data to you or to a third party. We will
                    provide to you, or a third party you have chosen, your Personal Data in a structured, commonly used,
                    machine-readable format. Note that this right only applies to automated information which you initially
                    provided consent for us to use or where we used the information to perform a contract with you.
                </p>
                <p class="orf-paragraph">
                    <span class="bold">Withdraw consent at any time </span> where we are relying on consent to process your
                    Personal Data. However, this will not affect the lawfulness of any processing carried out before you
                    withdraw your consent. If you withdraw your consent, we may not be able to provide certain products or
                    services to you. We will advise you if this is the case at the time you withdraw your consent.
                </p>
                <p class="orf-paragraph">
                    If you wish to exercise any of the rights set out above, please contact us using the details set out above.
                </p>
    
                <h2 class="orf-sub-title">No fee usually required
                </h2>
                <p class="orf-paragraph">
                    You will not have to pay a fee to access your Personal Data (or to exercise any of the other rights).
                    However, we may charge a reasonable fee if your request is clearly unfounded, repetitive or excessive.
                    Alternatively, we could refuse to comply with your request in these circumstances.
                </p>
    
                <h2 class="orf-sub-title">What we may need from you
                </h2>
                <p class="orf-paragraph">
                    We may need to request specific information from you to help us confirm your identity and ensure your right
                    to access your Personal Data (or to exercise any of your other rights). This is a security measure to ensure
                    that Personal Data is not disclosed to any person who has no right to receive it. We may also contact you to
                    ask you for further information in relation to your request to speed up our response.
                </p>
    
                <h2 class="orf-sub-title">Time limit to respond
                </h2>
                <p class="orf-paragraph">
                    We try to respond to all legitimate requests within one month. Occasionally it could take us longer than a
                    month if your request is particularly complex or you have made a number of requests. In this case, we will
                    notify you and keep you updated.
                </p>
    
                <h2 class="orf-sub-title">10. Glossary
                </h2>
                <h2 class="orf-sub-title">LAWFUL BASIS
                </h2>
                <p class="orf-paragraph">
                    <span class="bold">Legitimate Interest </span> means the interest of our business in conducting and managing
                    our business to enable us to give you the best service/product and the best and most secure experience. We
                    make sure we consider and balance any potential impact on you (both positive and negative) and your rights
                    before we process your Personal Data for our legitimate interests. We do not use your Personal Data for
                    activities where our interests are overridden by the impact on you (unless we have your consent or are
                    otherwise required or permitted to by law). You can obtain further information about how we assess our
                    legitimate interests against any potential impact on you in respect of specific activities by contacting us.
                </p>
                <p class="orf-paragraph">
                    <span class="bold">Performance of Contract </span> means processing your Personal Data where it is necessary
                    for the performance of a contract to which you are a party or to take steps at your request before entering
                    into such a contract.
                </p>
                <p class="orf-paragraph">
                    <span class="bold">Comply with a legal obligation </span>means processing your Personal Data where it is
                    necessary for compliance with a legal obligation that we are subject to.
                </p>
    
                <h2 class="orf-sub-title">THIRD PARTIES
                </h2>
                <h2 class="orf-sub-title">Third Parties
                </h2>
                <ul class="orf-3rd-ul">
                    <li class="orf-paragraph">
                        Content creators or subscribers.
                    </li>
                    <li class="orf-paragraph">
                        Service providers acting as processors based in the UK who provide IT and system administration
                        services.
                    </li>
                    <li class="orf-paragraph">
                        Professional advisers acting as processors or joint controllers including lawyers, bankers, auditors and
                        insurers based in the UK or Australia who provide consultancy, banking, legal, insurance and accounting
                        services.
                    </li>
                    <li class="orf-paragraph">
                        HM Revenue & Customs, regulators and other authorities acting as processors or joint controllers based
                        in the United Kingdom or Australia who require reporting of processing activities in certain
                        circumstances.
                    </li>
                </ul> -->
    
            </div>
        </div>
    </div>
    <Footer />
</template>

<style scoped>
.privacy-content{
    padding: 50px 0;
}
ol li,
ul li {
    font-size: 16px;
    font-weight: 500;
    line-height: 29px;
    margin-bottom: 15px;
    color: #000D37;
}

.orf-intro-title {
    font-size: 32px;
    font-weight: 600;
    line-height: 46px;
    margin-top: 25px;
    color: #000D37;
    margin-bottom: 0;

}

.orf-small {
    font-size: 14px;
    font-weight: 500;
    line-height: 20px;
    color: #000D37;
    margin-bottom: 24px;
}

.orf-big {
    margin: 30px 0px;
    font-size: 26px;
    line-height: 30px;
    font-weight: 300;
    color: #000D37;
}

.orf-sub-title {
    font-size: 18px;
    font-weight: 600;
    line-height: 29px;
    margin-bottom: 20px;
    color: #000D37;

}

.org-subTwo-title {
    font-size: 16px;
    font-weight: 600;
    line-height: 29px;
    margin-bottom: 20px;
    color: #000D37;
}

.orf-paragraph {
    font-size: 16px;
    font-weight: 500;
    line-height: 26px;
    margin-bottom: 15px;
    margin-top: 15px;
    color: #000D37;
}

.orf-2nd-ul,
.orf-2nd-ol {
    padding-left: 40px;
}

.orf-3rd-ul,
.orf-3rd-ol {
    padding-left: 60px;
}

.orf-4th-ul,
.orf-4th-ol {
    padding-left: 70px;
}

.orf-5th-ul,
.orf-5th-ol {
    padding-left: 80px;
}

.orf-link,
.pink {
    color: #2CBCDD;
}

.bold {
    font-weight: 600;
}

table.orf-table {
    border-collapse: collapse;
    width: 100%;
}

.orf-table li {
    line-height: 25px;
}

td,
th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 15px 30px;
}
</style>