<?php
/**
 * Template Name: Contact
 *
 * @package techorbit-seo
 */
get_header();

// Handle form submission
$sent  = false;
$error = '';

if ( isset( $_POST['techorbit_contact_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['techorbit_contact_nonce'] ) ), 'techorbit_contact_form' ) ) {
    $name    = sanitize_text_field( $_POST['contact_name'] ?? '' );
    $email   = sanitize_email( $_POST['contact_email'] ?? '' );
    $subject = sanitize_text_field( $_POST['contact_subject'] ?? '' );
    $message = sanitize_textarea_field( $_POST['contact_message'] ?? '' );

    if ( $name && $email && $message && is_email( $email ) ) {
        $to       = get_option( 'admin_email' );
        $subject  = '[TechOrbit Contact] ' . ( $subject ?: 'New message from ' . $name );
        $body     = "Name: $name\nEmail: $email\n\nMessage:\n$message";
        $headers  = [ 'Content-Type: text/plain; charset=UTF-8', "Reply-To: $name <$email>" ];

        if ( wp_mail( $to, $subject, $body, $headers ) ) {
            $sent = true;
        } else {
            $error = 'There was a problem sending the message. Please try again.';
        }
    } else {
        $error = 'Please fill in all required fields with valid information.';
    }
}
?>

<div class="page-header-vibrant">
    <div class="container container-narrow">
        <h1 class="page-title-hero"><?php esc_html_e( 'Contact Our Team', 'techorbit-seo' ); ?></h1>
        <p class="page-subtitle"><?php esc_html_e( 'Have a question or suggestion? We\'d love to hear from you. We typically respond within 24 hours.', 'techorbit-seo' ); ?></p>
    </div>
</div>

<div class="contact-page-wrap container blog-centered-layout">

    <?php if ( $sent ) : ?>
        <div class="alert alert-success">
            <p><strong>✅ Message Sent Successfully!</strong></p>
            <p>Thank you for reaching out. We'll get back to you within 24–48 hours.</p>
        </div>
    <?php endif; ?>

    <?php if ( $error ) : ?>
        <div class="alert alert-error">
            <p>⚠️ <?php echo esc_html( $error ); ?></p>
        </div>
    <?php endif; ?>

    <div class="contact-page-layout">
        <div class="static-page-article">
            <div class="static-page-body">
                <h2 class="form-title">Send Us a Message</h2>

                <form method="post" action="<?php the_permalink(); ?>" id="contact-form" novalidate>
                    <?php wp_nonce_field( 'techorbit_contact_form', 'techorbit_contact_nonce' ); ?>

                    <div class="form-row-grid">
                        <div class="form-group">
                            <label for="contact_name">Full Name <span class="required">*</span></label>
                            <input type="text" id="contact_name" name="contact_name"
                                   value="<?php echo esc_attr( $_POST['contact_name'] ?? '' ); ?>"
                                   required class="tool-input" placeholder="Your full name">
                        </div>
                        <div class="form-group">
                            <label for="contact_email">Email Address <span class="required">*</span></label>
                            <input type="email" id="contact_email" name="contact_email"
                                   value="<?php echo esc_attr( $_POST['contact_email'] ?? '' ); ?>"
                                   required class="tool-input" placeholder="your@email.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="contact_subject">Subject</label>
                        <input type="text" id="contact_subject" name="contact_subject"
                               value="<?php echo esc_attr( $_POST['contact_subject'] ?? '' ); ?>"
                               class="tool-input" placeholder="e.g. Tool suggestion / Bug report / Partnership">
                    </div>

                    <div class="form-group">
                        <label for="contact_message">Message <span class="required">*</span></label>
                        <textarea id="contact_message" name="contact_message" rows="6"
                                   required class="tool-input"
                                   placeholder="Describe your question, feedback, or request..."><?php echo esc_textarea( $_POST['contact_message'] ?? '' ); ?></textarea>
                    </div>

                    <button type="submit" class="btn-primary btn-submit-form">
                        📬 Send Message
                    </button>
                </form>
            </div>
        </div>

        <!-- Contact Info + Social Grid -->
        <div class="contact-info-grid">
            <div class="contact-card">
                <div class="contact-card-icon">📱</div>
                <div class="contact-card-content">
                    <h3>Social Media</h3>
                    <p>Follow us for real-time updates, AI news, and SEO tips from the field.</p>
                    <div class="contact-social-row">
                        <?php foreach ( techorbit_social_links() as $key => $link ) : ?>
                            <a href="<?php echo esc_url( $link['url'] ); ?>"
                               class="social-icon social-<?php echo esc_attr( $key ); ?>"
                               target="_blank" rel="noopener noreferrer"
                               aria-label="<?php echo esc_attr( $link['label'] ); ?>">
                                <?php techorbit_social_svg( $key ); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
