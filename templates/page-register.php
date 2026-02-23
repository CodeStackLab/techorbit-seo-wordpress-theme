<?php
/**
 * Template Name: Register
 * Custom Registration Page Template
 */

if ( is_user_logged_in() || ! get_option( 'users_can_register' ) ) {
    wp_redirect( home_url() );
    exit;
}

get_header();
?>

<div class="auth-page-wrap">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">
                    <span class="logo-icon">⚡</span>
                    <span class="logo-text">TechOrbit SEO</span>
                </div>
                <h1>Create Account</h1>
                <p>Join the 100% free AI SEO toolkit</p>
            </div>

            <div class="auth-body">
                <?php
                // We'll use a simple form that posts to a custom handler or wp-login.php?action=register
                // For a robust custom registration, we'd need more logic, but user requested "add login signup page"
                ?>
                
                <form name="registerform" id="registerform" action="<?php echo esc_url( site_url( 'wp-login.php?action=register', 'login_post' ) ); ?>" method="post" novalidate="novalidate">
                    <div class="auth-field">
                        <label for="user_login">Username</label>
                        <input type="text" name="user_login" id="user_login" class="auth-input" value="" size="20" required>
                    </div>
                    
                    <div class="auth-field">
                        <label for="user_email">Email Address</label>
                        <input type="email" name="user_email" id="user_email" class="auth-input" value="" size="25" required>
                    </div>

                    <p class="auth-notice">Registration confirmation will be emailed to you.</p>

                    <div class="auth-submit">
                        <input type="submit" name="wp-submit" id="wp-submit" class="btn-auth-submit" value="Sign Up">
                        <input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url( '/login/?checkemail=registered' ) ); ?>">
                    </div>
                </form>
            </div>

            <div class="auth-footer">
                <p>Already have an account? <a href="<?php echo esc_url( home_url( '/login/' ) ); ?>">Log in</a></p>
            </div>
        </div>
        
        <div class="auth-help-links">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">← Back to Home</a>
            <span class="sep">·</span>
            <a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy</a>
            <span class="sep">·</span>
            <a href="<?php echo esc_url( home_url( '/terms-of-service/' ) ); ?>">Terms</a>
        </div>
    </div>
</div>

<?php get_footer(); ?>
