<?php
/**
 * Template Name: Login
 * Custom Login Page Template
 */

if ( is_user_logged_in() ) {
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
                <h1>Welcome Back</h1>
                <p>Log in to your account</p>
            </div>

            <div class="auth-body">
                <?php
                if ( isset( $_GET['login'] ) && $_GET['login'] === 'failed' ) {
                    echo '<div class="auth-error">Invalid username or password. Please try again.</div>';
                }
                ?>
                
                <form name="loginform" id="loginform" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">
                    <div class="auth-field">
                        <label for="user_login">Email or Username</label>
                        <input type="text" name="log" id="user_login" class="auth-input" value="" size="20" required>
                    </div>
                    
                    <div class="auth-field">
                        <label for="user_pass">Password</label>
                        <input type="password" name="pwd" id="user_pass" class="auth-input" value="" size="20" required>
                    </div>

                    <div class="auth-options">
                        <label for="rememberme">
                            <input name="rememberme" type="checkbox" id="rememberme" value="forever"> Remember Me
                        </label>
                        <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="forgot-link">Forgot Password?</a>
                    </div>

                    <div class="auth-submit">
                        <input type="submit" name="wp-submit" id="wp-submit" class="btn-auth-submit" value="Log In">
                        <input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url() ); ?>">
                    </div>
                </form>
            </div>

            <div class="auth-footer">
                <p>Don't have an account? <a href="<?php echo esc_url( home_url( '/register/' ) ); ?>">Sign up for free</a></p>
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
