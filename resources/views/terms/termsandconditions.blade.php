@extends('layouts.app')

@section('content')
<br/>
<br/>
<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-10">

            <h1 class="mb-4">Terms & Conditions</h1>

            <p class="text-muted">
                Last Updated: {{ now()->format('F d, Y') }}
            </p>

            <p>
                Welcome to <strong>OwnAcres</strong>. By accessing or using our website, mobile application,
                or any related services (collectively, the "Platform"), you agree to comply with and be bound
                by these Terms & Conditions. If you do not agree with these Terms, please do not use the Platform.
            </p>

            <hr>

            <h3>1. About OwnAcres</h3>

            <p>
                OwnAcres is an online real estate marketplace that allows property owners, dealers,
                builders, and real estate professionals to publish property listings and communicate
                with prospective buyers or tenants.
            </p>

            <p>
                OwnAcres only provides a technology platform for publishing listings and facilitating
                communication between users. OwnAcres is not a real estate broker, agent, developer,
                legal advisor, or party to any property transaction.
            </p>

            <hr>

            <h3>2. Eligibility</h3>

            <ul>
                <li>You must be at least 18 years of age.</li>
                <li>You must have legal authority to use the Platform.</li>
                <li>All information provided during registration must be accurate and up to date.</li>
            </ul>

            <hr>

            <h3>3. User Accounts</h3>

            <p>Users are responsible for maintaining the confidentiality of their account credentials.</p>

            <p>You agree to:</p>

            <ul>
                <li>Provide accurate information.</li>
                <li>Keep your password secure.</li>
                <li>Notify us immediately of unauthorized account access.</li>
                <li>Be responsible for all activities under your account.</li>
            </ul>

            <hr>

            <h3>4. Property Listings</h3>

            <p>Users who publish property listings agree that:</p>

            <ul>
                <li>They have the legal authority to advertise the property.</li>
                <li>The listing information is truthful and accurate.</li>
                <li>Photos and documents uploaded belong to them or they have permission to use them.</li>
                <li>The listing complies with all applicable laws.</li>
            </ul>

            <p>
                OwnAcres reserves the right to remove, edit, or reject any listing that violates these
                Terms or applicable law.
            </p>

            <hr>

            <h3>5. Dealer Responsibilities</h3>

            <p>Dealers and property advertisers are solely responsible for:</p>

            <ul>
                <li>The accuracy of their listings.</li>
                <li>Property ownership or authorization.</li>
                <li>Negotiations with buyers.</li>
                <li>Compliance with applicable real estate laws.</li>
                <li>Updating sold, rented, or unavailable properties.</li>
            </ul>

            <hr>

            <h3>6. Buyer Responsibilities</h3>

            <p>Buyers are responsible for conducting their own due diligence before entering into any transaction.</p>

            <ul>
                <li>Verify ownership.</li>
                <li>Inspect the property.</li>
                <li>Verify legal documents.</li>
                <li>Consult legal or financial professionals where appropriate.</li>
            </ul>

            <hr>

            <h3>7. Messaging Service</h3>

            <p>
                OwnAcres provides an internal messaging system solely to facilitate communication
                between users.
            </p>

            <p>
                Users are solely responsible for the content of their communications.
                Harassment, fraud, spam, abusive language, or illegal activity is strictly prohibited.
            </p>

            <hr>

            <h3>8. Subscription & Payments</h3>

            <p>
                Certain services may require payment, including dealer subscriptions,
                premium listings, featured listings, or advertising packages.
            </p>

            <ul>
                <li>Fees are displayed before purchase.</li>
                <li>Payments are non-refundable unless otherwise stated.</li>
                <li>Applicable taxes may be charged.</li>
            </ul>

            <hr>

            <h3>9. No Brokerage</h3>

            <p>
                OwnAcres is a technology platform only.
            </p>

            <p>
                We do not act as a broker, real estate agent, intermediary in negotiations,
                attorney, financial advisor, or representative of buyers or sellers.
            </p>

            <p>
                We do not negotiate transactions, prepare agreements,
                collect commissions on property sales, or guarantee successful transactions.
            </p>

            <hr>

            <h3>10. No Property Verification</h3>

            <p>
                Unless explicitly stated otherwise, OwnAcres does not verify:
            </p>

            <ul>
                <li>Ownership of listed properties.</li>
                <li>Legal title.</li>
                <li>Government approvals.</li>
                <li>Property measurements.</li>
                <li>Pricing accuracy.</li>
                <li>Listing authenticity.</li>
            </ul>

            <p>
                Users are responsible for independently verifying all information before making
                any financial or legal decisions.
            </p>

            <hr>

            <h3>11. Prohibited Activities</h3>

            <p>Users must not:</p>

            <ul>
                <li>Create fake accounts.</li>
                <li>Publish fraudulent listings.</li>
                <li>Impersonate another person.</li>
                <li>Upload malicious software.</li>
                <li>Spam other users.</li>
                <li>Attempt unauthorized access to the Platform.</li>
                <li>Copy or scrape website content without permission.</li>
            </ul>

            <hr>

            <h3>12. Intellectual Property</h3>

            <p>
                The Platform, including its design, branding, logos, software,
                and content created by OwnAcres, is protected by applicable intellectual
                property laws.
            </p>

            <p>
                Users retain ownership of content they upload but grant OwnAcres
                a non-exclusive license to display, reproduce, and distribute such content
                for the operation and promotion of the Platform.
            </p>

            <hr>

            <h3>13. Account Suspension</h3>

            <p>We may suspend or terminate accounts that:</p>

            <ul>
                <li>Violate these Terms.</li>
                <li>Publish fraudulent content.</li>
                <li>Engage in illegal activities.</li>
                <li>Misuse the Platform.</li>
            </ul>

            <hr>

            <h3>14. Limitation of Liability</h3>

            <p>
                OwnAcres shall not be responsible for:
            </p>

            <ul>
                <li>Disputes between buyers and sellers.</li>
                <li>Accuracy of listings.</li>
                <li>Property ownership claims.</li>
                <li>Financial losses.</li>
                <li>Failed transactions.</li>
                <li>Fraud committed by users.</li>
            </ul>

            <p>
                Users acknowledge that all transactions are conducted at their own risk.
            </p>

            <hr>

            <h3>15. Indemnification</h3>

            <p>
                Users agree to indemnify and hold harmless OwnAcres, its directors,
                employees, and affiliates from any claims, damages, liabilities,
                or expenses arising from their use of the Platform or violation of these Terms.
            </p>

            <hr>

            <h3>16. Privacy</h3>

            <p>
                Your use of the Platform is also governed by our Privacy Policy.
            </p>

            <hr>

            <h3>17. Changes to These Terms</h3>

            <p>
                OwnAcres may modify these Terms at any time.
                Continued use of the Platform after updates constitutes acceptance
                of the revised Terms.
            </p>

            <hr>

            <h3>18. Governing Law</h3>

            <p>
                These Terms shall be governed by the laws of India.
                Any disputes shall be subject to the jurisdiction of the competent
                courts where OwnAcres is registered, unless otherwise required by applicable law.
            </p>

            <hr>

            <h3>19. Contact Us</h3>

            <p>
                If you have any questions regarding these Terms & Conditions,
                please contact us through the contact information provided on the Platform.
            </p>

        </div>
    </div>

</div>

@endsection