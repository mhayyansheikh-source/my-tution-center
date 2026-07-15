<?php
/**
 * Plugin Name: My Tuition Center — Custom Post Types
 * Description: Registers Course and Tutor Profile CPTs with REST API support for the Astro frontend.
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
