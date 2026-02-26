<?php
/**
 * Template Name: Privacy Policy
 *
 * @package techorbit-seo
 */
get_header();
$site_name = get_bloginfo( 'name' );
$site_url  = home_url( '/' );
$date      = 'February 23, 2025';
?>

<div class="page-header-vibrant">
    <div class="container">
        <h1 class="page-title-hero">Privacy Policy</h1>
        <p class="page-subtitle">Last Updated: <?php echo esc_html( $date ); ?></p>
    </div>
</div>

<div class="page-standard-wrap container">
    <div class="static-page-article">
        <div class="static-page-body single-post-content">

            <p>This Privacy Policy describes how <strong><?php echo esc_html( $site_name ); ?></strong> ("we", "us", "our") collects, uses, and protects any information that you provide when using our website at <a href="<?php echo esc_url( $site_url ); ?>"><?php echo esc_url( $site_url ); ?></a>.</p>

            <h2>1. Information We Collect</h2>
            <p>We collect information in the following ways:</p>
            <ul>
                <li><strong>Usage data</strong> — We collect anonymized data on how visitors interact with our AI tools (e.g., which tools are used, time of use). No personally identifiable information is attached to this data.</li>
                <li><strong>Contact form data</strong> — When you submit our contact form, we collect your name, email address, and message content to respond to your inquiry.</li>
                <li><strong>Cookies</strong> — We use cookies to improve site functionality and analyze traffic via Google Analytics and Google AdSense.</li>
            </ul>

            <h2>2. How We Use Your Information</h2>
            <ul>
                <li>To respond to your contact form inquiries</li>
                <li>To improve the performance and user experience of our AI tools</li>
                <li>To analyze website traffic and usage patterns (Google Analytics)</li>
                <li>To display contextually relevant advertisements (Google AdSense)</li>
            </ul>

            <h2>3. AI Tool Inputs</h2>
            <p>Text inputs you enter into our AI tools (e.g., keywords, product names, topics) are sent to third-party AI APIs (OpenAI and/or Google Gemini) for processing. We do not store your AI tool inputs on our servers beyond the duration of the API call. Please review <a href="https://openai.com/privacy" target="_blank" rel="noopener">OpenAI's Privacy Policy</a> and <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Google's Privacy Policy</a> for details on how they handle data.</p>

            <h2>4. Google AdSense & Cookies</h2>
            <p>We use Google AdSense to display advertisements. Google uses cookies to serve ads based on your visits to this and other websites. You may opt out of personalized advertising by visiting <a href="https://www.google.com/settings/ads" target="_blank" rel="noopener">Google Ads Settings</a>.</p>

            <h2>5. Third-Party Links</h2>
            <p>Our website may contain links to other websites. We are not responsible for the privacy practices of those sites. We encourage you to read the privacy policy of every website you visit.</p>

            <h2>6. Data Security</h2>
            <p>We implement appropriate technical and organizational measures to protect your information. However, no method of internet transmission is 100% secure. We cannot guarantee absolute security.</p>

            <h2>7. Children's Privacy</h2>
            <p>Our services are not directed to children under 13 years of age. We do not knowingly collect personal information from children under 13. If you believe we have inadvertently collected such information, please contact us immediately.</p>

            <h2>8. Your Rights</h2>
            <p>You have the right to request access to, correction of, or deletion of your personal data that we hold. To exercise these rights, please contact us via our <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact Page</a>.</p>

            <h2>9. Changes to This Policy</h2>
            <p>We may update this Privacy Policy periodically. Changes will be posted on this page with an updated revision date. Continued use of the site after changes constitutes your acceptance of the new policy.</p>

            <h2>10. Contact Us</h2>
            <p>If you have any questions about this Privacy Policy, please reach out via our <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact Page</a>.</p>

        </div>
    </div>
</div>

<?php get_footer(); ?>
