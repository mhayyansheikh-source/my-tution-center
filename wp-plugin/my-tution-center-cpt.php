<?php
/**
 * Plugin Name: My Tuition Center — CPT & Fields
 * Description: Registers Course/Tutor CPTs, meta boxes for editing, and REST API support.
 * Version: 2.0
 */

// === COURSE CPT ===
function mtc_register_course_cpt() {
  register_post_type('course', [
    'labels' => [
      'name'          => 'Courses',
      'singular_name' => 'Course',
      'add_new_item'  => 'Add New Course',
      'edit_item'     => 'Edit Course',
      'view_item'     => 'View Course',
    ],
    'public'        => true,
    'show_in_rest'  => true,
    'menu_icon'     => 'dashicons-welcome-learn-more',
    'supports'      => ['title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'],
    'has_archive'   => true,
    'rewrite'       => ['slug' => 'courses'],
  ]);
}
add_action('init', 'mtc_register_course_cpt');

// === TUTOR PROFILE CPT ===
function mtc_register_tutor_cpt() {
  register_post_type('tutor_profile', [
    'labels' => [
      'name'          => 'Tutors',
      'singular_name' => 'Tutor',
      'add_new_item'  => 'Add New Tutor',
      'edit_item'     => 'Edit Tutor',
      'view_item'     => 'View Tutor',
    ],
    'public'        => true,
    'show_in_rest'  => true,
    'menu_icon'     => 'dashicons-groups',
    'supports'      => ['title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'],
    'has_archive'   => true,
    'rewrite'       => ['slug' => 'tutors'],
  ]);
}
add_action('init', 'mtc_register_tutor_cpt');

// === REGISTER META FIELDS FOR REST API ===
function mtc_register_meta_fields() {
  $course_meta = [
    'price'        => 'PKR 15,000/mo',
    'subject_tag'  => 'Education',
    'grade'        => 'upper',
    'format'       => 'Online via Zoom',
    'tutor_name'   => 'Expert Tutor',
    'rating'       => '★★★★★',
    'tag'          => 'Course',
  ];

  foreach ($course_meta as $key => $default) {
    register_post_meta('course', $key, [
      'type'        => 'string',
      'single'      => true,
      'show_in_rest' => true,
      'default'     => $default,
    ]);
  }

  $tutor_meta = [
    'subject' => 'Specialized Subject',
  ];

  foreach ($tutor_meta as $key => $default) {
    register_post_meta('tutor_profile', $key, [
      'type'        => 'string',
      'single'      => true,
      'show_in_rest' => true,
      'default'     => $default,
    ]);
  }

  // badges stored as comma-separated string
  register_post_meta('tutor_profile', 'badges', [
    'type'        => 'string',
    'single'      => true,
    'show_in_rest' => true,
    'default'     => 'A-Level,O-Level,Expert',
  ]);
}
add_action('init', 'mtc_register_meta_fields');

// Convert badges from comma-separated string to array in REST response
function mtc_prepare_tutor_response($response, $post) {
  $badges = get_post_meta($post->ID, 'badges', true);
  if ($badges) {
    $response->data['meta']['badges'] = array_map('trim', explode(',', $badges));
  }
  return $response;
}
add_filter('rest_prepare_tutor_profile', 'mtc_prepare_tutor_response', 10, 2);

// === META BOXES (native WordPress, no ACF required) ===
function mtc_add_meta_boxes() {
  add_meta_box('mtc_course_fields', 'Course Details', 'mtc_course_fields_html', 'course', 'normal', 'high');
  add_meta_box('mtc_tutor_fields', 'Tutor Details', 'mtc_tutor_fields_html', 'tutor_profile', 'normal', 'high');
}
add_action('add_meta_boxes', 'mtc_add_meta_boxes');

function mtc_course_fields_html($post) {
  wp_nonce_field('mtc_save_meta', 'mtc_meta_nonce');
  $fields = ['price' => 'Price', 'subject_tag' => 'Subject Tag', 'grade' => 'Grade Level', 'format' => 'Format', 'tutor_name' => 'Tutor Name', 'rating' => 'Rating', 'tag' => 'Tag'];
  $grades = ['primary' => 'Primary (1–6)', 'lower' => 'Lower Secondary (7–9)', 'upper' => 'Upper Secondary (10–12)', 'alevel' => 'A-Level / Pre-University'];
  foreach ($fields as $key => $label) {
    $value = get_post_meta($post->ID, $key, true) ?: '';
    echo '<p><label style="display:inline-block;width:140px;font-weight:600">' . esc_html($label) . '</label>';
    if ($key === 'grade') {
      echo '<select name="' . $key . '" style="width:300px">';
      echo '<option value="">— Select —</option>';
      foreach ($grades as $val => $display) {
        echo '<option value="' . esc_attr($val) . '"' . selected($value, $val, false) . '>' . esc_html($display) . '</option>';
      }
      echo '</select>';
    } else {
      echo '<input type="text" name="' . $key . '" value="' . esc_attr($value) . '" style="width:300px" placeholder="' . esc_attr($fields[$key]) . '" />';
    }
    echo '</p>';
  }
}

function mtc_tutor_fields_html($post) {
  wp_nonce_field('mtc_save_meta', 'mtc_meta_nonce');
  $subject = get_post_meta($post->ID, 'subject', true) ?: '';
  $badges = get_post_meta($post->ID, 'badges', true) ?: '';
  echo '<p><label style="display:inline-block;width:140px;font-weight:600">Subject</label><input type="text" name="subject" value="' . esc_attr($subject) . '" style="width:300px" placeholder="e.g. Advanced Mathematics" /></p>';
  echo '<p><label style="display:inline-block;width:140px;font-weight:600">Badges</label><input type="text" name="badges" value="' . esc_attr($badges) . '" style="width:300px" placeholder="e.g. A-Level,O-Level Math" /><br><small style="margin-left:144px">Comma-separated list</small></p>';
}

function mtc_save_meta($post_id) {
  if (!isset($_POST['mtc_meta_nonce']) || !wp_verify_nonce($_POST['mtc_meta_nonce'], 'mtc_save_meta')) return;
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (!current_user_can('edit_post', $post_id)) return;

  $keys = ['price', 'subject_tag', 'grade', 'format', 'tutor_name', 'rating', 'tag', 'subject', 'badges'];
  foreach ($keys as $key) {
    if (isset($_POST[$key])) {
      update_post_meta($post_id, $key, sanitize_text_field($_POST[$key]));
    }
  }
}
add_action('save_post', 'mtc_save_meta');

// === ACF FIELD GROUPS (optional, only if ACF is active) ===
function mtc_register_acf_fields() {
  if (!function_exists('acf_add_local_field_group')) return;
  acf_add_local_field_group([
    'key' => 'group_mtc_course', 'title' => 'Course Details (ACF)',
    'fields' => [
      ['key' => 'field_mtc_price', 'label' => 'Price', 'name' => 'price', 'type' => 'text', 'default_value' => 'PKR 15,000/mo'],
      ['key' => 'field_mtc_subject_tag', 'label' => 'Subject Tag', 'name' => 'subject_tag', 'type' => 'text', 'default_value' => 'Education'],
      ['key' => 'field_mtc_grade', 'label' => 'Grade Level', 'name' => 'grade', 'type' => 'select', 'choices' => ['primary' => 'Primary (1–6)', 'lower' => 'Lower Secondary (7–9)', 'upper' => 'Upper Secondary (10–12)', 'alevel' => 'A-Level / Pre-University'], 'default_value' => 'upper'],
      ['key' => 'field_mtc_format', 'label' => 'Format', 'name' => 'format', 'type' => 'text', 'default_value' => 'Online via Zoom'],
      ['key' => 'field_mtc_tutor_name', 'label' => 'Tutor Name', 'name' => 'tutor_name', 'type' => 'text', 'default_value' => 'Expert Tutor'],
      ['key' => 'field_mtc_rating', 'label' => 'Rating', 'name' => 'rating', 'type' => 'text', 'default_value' => '★★★★★'],
      ['key' => 'field_mtc_tag', 'label' => 'Tag', 'name' => 'tag', 'type' => 'text', 'default_value' => 'Course'],
    ],
    'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'course']]], 'show_in_rest' => 1,
  ]);
  acf_add_local_field_group([
    'key' => 'group_mtc_tutor', 'title' => 'Tutor Details (ACF)',
    'fields' => [
      ['key' => 'field_mtc_subject', 'label' => 'Subject', 'name' => 'subject', 'type' => 'text', 'default_value' => 'Specialized Subject'],
      ['key' => 'field_mtc_badges', 'label' => 'Badges', 'name' => 'badges', 'type' => 'text', 'default_value' => 'A-Level,O-Level,Expert', 'instructions' => 'Comma-separated list of badges'],
    ],
    'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'tutor_profile']]], 'show_in_rest' => 1,
  ]);
}
add_action('init', 'mtc_register_acf_fields');
