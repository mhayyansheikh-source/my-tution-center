<?php
/**
 * Demo data importer for My Tuition Center.
 * Run: wp eval-file wp-plugin/import-demo-data.php
 */

// === COURSES ===
$courses = [
  [
    'title'      => 'Cambridge O-Level Mathematics (Syllabus D)',
    'content'    => 'Master algebra, geometry, trigonometry, and statistics with past-paper techniques to secure an A* in your CAIE exams. This comprehensive course covers the entire Syllabus D with step-by-step problem solving.',
    'excerpt'    => 'Master algebra, geometry, and past-paper techniques to secure an A* in your CAIE exams.',
    'meta'       => [
      'price'       => 'PKR 15,000/mo',
      'subject_tag' => 'Mathematics',
      'grade'       => 'upper',
      'format'      => 'Online via Zoom',
      'tutor_name'  => 'Dr. Salman Ahmad',
      'rating'      => '★★★★★',
      'tag'         => 'Course',
    ],
  ],
  [
    'title'      => 'A-Level Physics (9702)',
    'content'    => 'Comprehensive preparation for AS and A2 Physics with focus on practical papers, theory, and past paper practice. Covers mechanics, waves, electricity, nuclear physics, and more.',
    'excerpt'    => 'Comprehensive preparation for AS and A2 Physics with focus on practical papers and theory.',
    'meta'       => [
      'price'       => 'PKR 18,000/mo',
      'subject_tag' => 'Physics',
      'grade'       => 'alevel',
      'format'      => 'Online via Zoom',
      'tutor_name'  => 'Ms. Fatima Rizvi',
      'rating'      => '★★★★★',
      'tag'         => 'Course',
    ],
  ],
  [
    'title'      => 'Sindh Board Matric Biology',
    'content'    => 'Complete coverage of the Sindh Board Matric Biology syllabus. Includes diagram-based learning, chapter-wise tests, and board exam preparation with past papers.',
    'excerpt'    => 'Complete coverage of the Sindh Board Matric Biology syllabus.',
    'meta'       => [
      'price'       => 'PKR 12,000/mo',
      'subject_tag' => 'Biology',
      'grade'       => 'primary',
      'format'      => 'Hybrid (Online + In-Person)',
      'tutor_name'  => 'Dr. Ayesha Khan',
      'rating'      => '★★★★☆',
      'tag'         => 'Course',
    ],
  ],
  [
    'title'      => 'English Language & Literature (O/A Level)',
    'content'    => 'Develop critical reading, essay writing, and textual analysis skills for CAIE English. Covers poetry, prose, drama, and language papers with individual feedback.',
    'excerpt'    => 'Develop critical reading, essay writing, and textual analysis skills for CAIE English.',
    'meta'       => [
      'price'       => 'PKR 14,000/mo',
      'subject_tag' => 'English',
      'grade'       => 'upper',
      'format'      => 'Online via Zoom',
      'tutor_name'  => 'Ms. Sara Ali',
      'rating'      => '★★★★★',
      'tag'         => 'Course',
    ],
  ],
  [
    'title'      => 'Dropshipping Masterclass — Shopify',
    'content'    => 'Learn to build and scale a dropshipping business from scratch. Covers product research, store setup, Facebook ads, TikTok organic, and order fulfilment for the Pakistani market.',
    'excerpt'    => 'Learn to build and scale a dropshipping business from scratch.',
    'meta'       => [
      'price'       => 'PKR 25,000 (One-Time)',
      'subject_tag' => 'Computing',
      'grade'       => 'upper',
      'format'      => 'Online via Zoom',
      'tutor_name'  => 'Mr. Hassan Raza',
      'rating'      => '★★★★★',
      'tag'         => 'Course',
    ],
  ],
  [
    'title'      => 'ECAT / NUST Entry Test Preparation',
    'content'    => 'Intensive preparation for the ECAT engineering entry test. Covers Mathematics, Physics, Chemistry, and English with mock tests, time management strategies, and past paper analysis.',
    'excerpt'    => 'Intensive preparation for the ECAT engineering entry test.',
    'meta'       => [
      'price'       => 'PKR 20,000/mo',
      'subject_tag' => 'Mathematics',
      'grade'       => 'alevel',
      'format'      => 'In-Person',
      'tutor_name'  => 'Dr. Salman Ahmad',
      'rating'      => '★★★★★',
      'tag'         => 'Course',
    ],
  ],
];

// === TUTORS ===
$tutors = [
  [
    'title'      => 'Dr. Salman Ahmad',
    'content'    => 'PhD in Applied Mathematics from NED University with 12+ years of experience teaching CAIE O/A-Level and ECAT preparation. Dr. Salman has helped over 500 students achieve A/A* grades. His teaching methodology focuses on conceptual clarity and exam technique.',
    'excerpt'    => 'PhD in Applied Mathematics from NED University. 12 years teaching CAIE O/A-Level and ECAT.',
    'meta'       => [
      'subject' => 'Advanced Mathematics & Statistics',
      'badges'  => 'A-Level,O-Level Math,ECAT',
    ],
  ],
  [
    'title'      => 'Ms. Fatima Rizvi',
    'content'    => 'MSc in Physics from University of Karachi with 8 years of teaching experience. Specializes in A-Level Physics (9702) and Cambridge International curriculum. Fatima uses interactive simulations and real-world examples to make physics accessible.',
    'excerpt'    => 'MSc in Physics from University of Karachi. 8 years teaching A-Level Physics.',
    'meta'       => [
      'subject' => 'Physics (O/A Level)',
      'badges'  => 'A-Level,O-Level,Physics',
    ],
  ],
  [
    'title'      => 'Ms. Sara Ali',
    'content'    => 'MA in English Literature from Oxford University with 10 years of teaching experience. Expert in CAIE English Language and Literature, creative writing, and literary analysis. Sara has published two collections of short stories.',
    'excerpt'    => 'MA in English Literature from Oxford University. 10 years teaching CAIE English.',
    'meta'       => [
      'subject' => 'English Language & Literature',
      'badges'  => 'A-Level,O-Level,English,Creative Writing',
    ],
  ],
  [
    'title'      => 'Mr. Hassan Raza',
    'content'    => 'Software engineer and entrepreneur with 6 years of experience in e-commerce and dropshipping. Built multiple 7-figure stores and now teaches students how to replicate his success. Expert in Shopify, Facebook Ads, and TikTok organic marketing.',
    'excerpt'    => 'Software engineer and entrepreneur. 6 years in e-commerce and dropshipping.',
    'meta'       => [
      'subject' => 'E-Commerce & Dropshipping',
      'badges'  => 'Shopify,E-Commerce,Marketing',
    ],
  ],
  [
    'title'      => 'Dr. Ayesha Khan',
    'content'    => 'PhD in Molecular Biology from AKU with 15 years of teaching and research experience. Specializes in Sindh Board Matric Biology, CAIE O-Level Biology, and medical entrance exam preparation. Dr. Ayesha has published 20+ research papers.',
    'excerpt'    => 'PhD in Molecular Biology from AKU. 15 years teaching Biology.',
    'meta'       => [
      'subject' => 'Biology & Life Sciences',
      'badges'  => 'Matric,O-Level,Biology,Medical',
    ],
  ],
];

echo "Importing courses...\n";
foreach ($courses as $data) {
  $existing = get_posts([
    'post_type'   => 'course',
    'title'       => $data['title'],
    'post_status' => 'any',
  ]);
  if (!empty($existing)) {
    echo "  Skipped (exists): {$data['title']}\n";
    continue;
  }
  $id = wp_insert_post([
    'post_title'   => $data['title'],
    'post_content' => $data['content'],
    'post_excerpt' => $data['excerpt'],
    'post_status'  => 'publish',
    'post_type'    => 'course',
  ]);
  if ($id && !is_wp_error($id)) {
    foreach ($data['meta'] as $key => $value) {
      update_field($key, $value, $id);
    }
    echo "  Created: {$data['title']}\n";
  }
}

echo "Importing tutors...\n";
foreach ($tutors as $data) {
  $existing = get_posts([
    'post_type'   => 'tutor_profile',
    'title'       => $data['title'],
    'post_status' => 'any',
  ]);
  if (!empty($existing)) {
    echo "  Skipped (exists): {$data['title']}\n";
    continue;
  }
  $id = wp_insert_post([
    'post_title'   => $data['title'],
    'post_content' => $data['content'],
    'post_excerpt' => $data['excerpt'],
    'post_status'  => 'publish',
    'post_type'    => 'tutor_profile',
  ]);
  if ($id && !is_wp_error($id)) {
    foreach ($data['meta'] as $key => $value) {
      update_field($key, $value, $id);
    }
    echo "  Created: {$data['title']}\n";
  }
}

echo "\nDone! Imported " . count($courses) . " courses and " . count($tutors) . " tutors.\n";
