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

<div style="background:var(--gradient);padding:64px 24px;text-align:center;">
    <div class="container">
        <span class="section-label" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.9);">Get In Touch</span>
        <h1 style="font-size:clamp(28px,4vw,48px);color:#fff;margin:12px 0 16px;">Contact Us</h1>
        <p style="color:rgba(255,255,255,0.72);font-size:17px;">Have a question, suggestion, or partnership inquiry? We'd love to hear from you.</p>
    </div>
</div>

<div style="max-width:760px;margin:60px auto;padding:0 24px;">

    <?php if ( $sent ) : ?>
        <div style="background:#D1FAE5;border:1px solid #6EE7B7;border-radius:12px;padding:24px 32px;margin-bottom:32px;text-align:center;">
            <p style="font-size:18px;font-weight:700;color:#065F46;">✅ Message Sent Successfully!</p>
            <p style="color:#047857;margin-top:8px;">Thank you for reaching out. We'll get back to you within 24–48 hours.</p>
        </div>
    <?php endif; ?>

    <?php if ( $error ) : ?>
        <div style="background:#FEF2F2;border:1px solid #FECACA;border-radius:12px;padding:24px;margin-bottom:32px;">
            <p style="color:#991B1B;">⚠️ <?php echo esc_html( $error ); ?></p>
        </div>
    <?php endif; ?>

    <div class="single-post-article">
        <div class="single-post-body">
            <h2 style="font-size:24px;margin-bottom:24px;">Send Us a Message</h2>

            <form method="post" action="<?php the_permalink(); ?>" id="contact-form" novalidate>
                <?php wp_nonce_field( 'techorbit_contact_form', 'techorbit_contact_nonce' ); ?>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
                    <div>
                        <label style="display:block;font-weight:600;font-size:14px;margin-bottom:6px;" for="contact_name">Full Name <span style="color:#EF4444;">*</span></label>
                        <input type="text" id="contact_name" name="contact_name"
                               value="<?php echo esc_attr( $_POST['contact_name'] ?? '' ); ?>"
                               required class="tool-input" placeholder="Your full name">
                    </div>
                    <div>
                        <label style="display:block;font-weight:600;font-size:14px;margin-bottom:6px;" for="contact_email">Email Address <span style="color:#EF4444;">*</span></label>
                        <input type="email" id="contact_email" name="contact_email"
                               value="<?php echo esc_attr( $_POST['contact_email'] ?? '' ); ?>"
                               required class="tool-input" placeholder="your@email.com">
                    </div>
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block;font-weight:600;font-size:14px;margin-bottom:6px;" for="contact_subject">Subject</label>
                    <input type="text" id="contact_subject" name="contact_subject"
                           value="<?php echo esc_attr( $_POST['contact_subject'] ?? '' ); ?>"
                           class="tool-input" placeholder="e.g. Tool suggestion / Bug report / Partnership">
                </div>

                <div style="margin-bottom:28px;">
                    <label style="display:block;font-weight:600;font-size:14px;margin-bottom:6px;" for="contact_message">Message <span style="color:#EF4444;">*</span></label>
                    <textarea id="contact_message" name="contact_message" rows="6"
                              required class="tool-input"
                              placeholder="Describe your question, feedback, or request..."><?php echo esc_textarea( $_POST['contact_message'] ?? '' ); ?></textarea>
                </div>

                <button type="submit" class="btn-primary" style="font-size:15px;padding:14px 32px;">
                    📬 Send Message
                </button>
            </form>
        </div>
    </div>

    <!-- Contact Info + Social -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-top:32px;">
        <div style="background:#fff;border-radius:var(--radius);padding:28px;box-shadow:var(--shadow);border:1px solid var(--border);">
            <h3 style="font-size:18px;margin-bottom:16px;">📧 Direct Contact</h3>
            <p style="color:var(--text-muted);font-size:14px;line-height:1.7;">Send us an email directly at the admin address. We typically respond within 24–48 business hours.</p>
        </div>
        <div style="background:#fff;border-radius:var(--radius);padding:28px;box-shadow:var(--shadow);border:1px solid var(--border);">
            <h3 style="font-size:18px;margin-bottom:16px;">📱 Follow Us</h3>
            <div style="display:flex;gap:10px;flex-wrap:wrap;">
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

<?php get_footer(); ?>
