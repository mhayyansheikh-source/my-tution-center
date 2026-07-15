<?php
/**
 * Plugin Name: My Tuition Center — CPT & ACF Fields
 * Description: Registers Course/Tutor CPTs, ACF field groups, and REST API meta for the Astro frontend.
 * Version: 1.0
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

// === ACF FIELD GROUPS (only if ACF is active) ===
function mtc_register_acf_fields() {
  if (!function_exists('acf_add_local_field_group')) return;

  acf_add_local_field_group([
    'key'      => 'group_mtc_course',
    'title'    => 'Course Details',
    'fields'   => [
      ['key' => 'field_mtc_price', 'label' => 'Price', 'name' => 'price', 'type' => 'text', 'default_value' => 'PKR 15,000/mo'],
      ['key' => 'field_mtc_subject_tag', 'label' => 'Subject Tag', 'name' => 'subject_tag', 'type' => 'text', 'default_value' => 'Education'],
      ['key' => 'field_mtc_grade', 'label' => 'Grade Level', 'name' => 'grade', 'type' => 'select', 'choices' => ['primary' => 'Primary (1–6)', 'lower' => 'Lower Secondary (7–9)', 'upper' => 'Upper Secondary (10–12)', 'alevel' => 'A-Level / Pre-University'], 'default_value' => 'upper'],
      ['key' => 'field_mtc_format', 'label' => 'Format', 'name' => 'format', 'type' => 'text', 'default_value' => 'Online via Zoom'],
      ['key' => 'field_mtc_tutor_name', 'label' => 'Tutor Name', 'name' => 'tutor_name', 'type' => 'text', 'default_value' => 'Expert Tutor'],
      ['key' => 'field_mtc_rating', 'label' => 'Rating', 'name' => 'rating', 'type' => 'text', 'default_value' => '★★★★★'],
      ['key' => 'field_mtc_tag', 'label' => 'Tag', 'name' => 'tag', 'type' => 'text', 'default_value' => 'Course'],
    ],
    'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'course']]],
    'show_in_rest' => 1,
  ]);

  acf_add_local_field_group([
    'key'      => 'group_mtc_tutor',
    'title'    => 'Tutor Details',
    'fields'   => [
      ['key' => 'field_mtc_subject', 'label' => 'Subject', 'name' => 'subject', 'type' => 'text', 'default_value' => 'Specialized Subject'],
      ['key' => 'field_mtc_badges', 'label' => 'Badges', 'name' => 'badges', 'type' => 'text', 'default_value' => 'A-Level,O-Level,Expert', 'instructions' => 'Comma-separated list of badges'],
    ],
    'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'tutor_profile']]],
    'show_in_rest' => 1,
  ]);
}
add_action('init', 'mtc_register_acf_fields');
