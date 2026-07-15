<?php
/**
 * Plugin Name: My Tuition Center — Auto Deploy
 * Description: Triggers Vercel redeploy when courses or tutors are added/updated/deleted in WordPress.
 * Version: 1.0
 */

// Settings page
add_action('admin_menu', function () {
  add_options_page('Auto Deploy', 'Auto Deploy', 'manage_options', 'mtc-auto-deploy', 'mtc_deploy_settings_page');
});

add_action('admin_init', function () {
  register_setting('mtc_deploy_settings', 'mtc_vercel_deploy_hook');
});

function mtc_deploy_settings_page() {
  ?>
  <div class="wrap">
    <h1>Auto Deploy Settings</h1>
    <form method="post" action="options.php">
      <?php settings_fields('mtc_deploy_settings'); ?>
      <table class="form-table">
        <tr>
          <th scope="row">Vercel Deploy Hook URL</th>
          <td>
            <input type="url" name="mtc_vercel_deploy_hook"
                   value="<?php echo esc_attr(get_option('mtc_vercel_deploy_hook')); ?>"
                   style="width:100%;max-width:500px"
                   placeholder="https://api.vercel.com/v1/integrations/deploy/..." />
            <p class="description">
              Create a Deploy Hook in Vercel (Settings → Git → Deploy Hooks) and paste the URL here.
            </p>
          </td>
        </tr>
      </table>
      <?php submit_button(); ?>
    </form>
  </div>
  <?php
}

// Trigger deploy hook
function mtc_trigger_deploy() {
  $hook_url = get_option('mtc_vercel_deploy_hook');
  if (!$hook_url) return;

  $response = wp_remote_post($hook_url, [
    'timeout' => 10,
    'blocking' => false, // fire-and-forget
  ]);
}

// Watch for course/tutor changes
add_action('save_post_course', 'mtc_on_content_change');
add_action('save_post_tutor_profile', 'mtc_on_content_change');
add_action('trashed_post', 'mtc_on_content_change');
add_action('delete_post', 'mtc_on_content_change');

function mtc_on_content_change($post_id) {
  $post_type = get_post_type($post_id);
  if (!in_array($post_type, ['course', 'tutor_profile'])) return;
  mtc_trigger_deploy();
}
