<?php

return array(
    'original' => array('mode' => 'no'),
    'box_small' => array('w' => 400, 'h' => 300, 'mode' => 'scale', 'enlarge' => 0),
    'box_medium' => array('w' => 800, 'h' => 600, 'mode' => 'scale', 'enlarge' => 0),
    'box_large' => array('w' => 1600, 'h' => 1200, 'mode' => 'scale', 'enlarge' => 0),
    'thumb_h' => array('w' => 150, 'h' => 100, 'mode' => 'scale', 'enlarge' => 0),
    'thumb_v' => array('w' => 100, 'h' => 150, 'mode' => 'scale', 'enlarge' => 0),
    'thumb_sq' => array('w' => 100, 'h' => 100, 'mode' => 'scale', 'enlarge' => 0),

    'language_tiny' => array('w' => 16, 'h' => 16, 'mode' => 'scale', 'enlarge' => 0),
    'language' => array('w' => 32, 'h' => 32, 'mode' => 'scale', 'enlarge' => 0),
    'language_medium' => array('w' => 36, 'h' => 36, 'mode' => 'scale', 'enlarge' => 0),
    'language_large' => array('w' => 100, 'h' => 100, 'mode' => 'scale', 'enlarge' => 0),

    'tree_wide' => array('w' => 350, 'h' => 100, 'mode' => 'scale', 'enlarge' => 0),
    'tree_xlarge' => array('w' => 180, 'h' => 120, 'mode' => 'scale', 'enlarge' => 0),
    'tree_square' => array('w' => 150, 'h' => 150, 'mode' => 'scale', 'enlarge' => 0),

    'productstree' => array('w' => 16, 'h' => 16, 'mode' => 'stretch', 'enlarge' => 0),
    'product_icon' => array('w' => 32, 'h' => 32, 'mode' => 'scale', 'enlarge' => 0),
    'product_tiny' => array('w' => 50, 'h' => 65, 'mode' => 'scale', 'enlarge' => 0),
    'product_tiny2' => array('w' => 60, 'h' => 60, 'mode' => 'scale', 'enlarge' => 0),
    'product_thumb' => array('w' => 140, 'h' => 140, 'mode' => 'scale', 'enlarge' => 0),
    'product_thumb2' => array('w' => 150, 'h' => 150, 'mode' => 'scale', 'enlarge' => 0),
    'product_xlarge' => array('w' => 155, 'h' => 300, 'mode' => 'scale', 'enlarge' => 0),
    'product_box' => array('w' => 800, 'h' => 600, 'mode' => 'scale', 'enlarge' => 0),
    'category_xlarge' => array('w' => 150, 'h' => 200, 'mode' => 'scale', 'enlarge' => 0),
    'catalog_bin' => array('w' => 44, 'h' => 44, 'mode' => 'scale', 'enlarge' => 0),
    'orderposition_small' => array('w' => 27, 'h' => 45, 'mode' => 'scale', 'enlarge' => 0),

    'article_xlarge' => array('w' => 160, 'h' => 120, 'mode' => 'scale', 'enlarge' => 0),
    'article_large' => array('w' => 150, 'h' => 100, 'mode' => 'scale', 'enlarge' => 0),
    'article_medium' => array('w' => 100, 'h' => 100, 'mode' => 'scale', 'enlarge' => 0),
    'article_small' => array('w' => 80, 'h' => 80, 'mode' => 'scale', 'enlarge' => 0),
    'article_tiny' => array('w' => 60, 'h' => 30, 'mode' => 'scale', 'enlarge' => 0),
    'article_icon' => array('w' => 32, 'h' => 32, 'mode' => 'scale', 'enlarge' => 0),
    'news_head' => array('w' => 50, 'h' => 50, 'mode' => 'scale', 'enlarge' => 0),
    'news_xlarge' => array('w' => 200, 'h' => 100, 'mode' => 'scale', 'enlarge' => 0),
    'news_large' => array('w' => 150, 'h' => 100, 'mode' => 'scale', 'enlarge' => 0),
);

/** TEST 1 */
// f=19acd630e8ebe8673b47ab3179a71cdf9.jpeg
// w=457 h=282
/** TEST 2 */
// f=1bac43481cdbb8055fc9d377ca372568f.jpg
// w=290 h=468
/*
return array(
    // SCALE:
    'test_scale_minimize' => array('w' => 64, 'h' => 64, 'mode' => 'scale', 'enlarge' => 0),
    //result1: 64 x 39
    //result2: 40 x 64

    'test_scale_maximize_large' => array('w' => 500, 'h' => 450, 'mode' => 'scale', 'enlarge' => 1),
    //result1: 500 x 309
    //result2: 500 × 807

    'test_scale_maximize_nolarge' => array('w' => 500, 'h' => 450, 'mode' => 'scale', 'enlarge' => 0),
    //result1: 457 x 282
    //result2: 279 x 450

    'test_scale_minimize_w' => array('w' => 64, 'h' => 450, 'mode' => 'scale', 'enlarge' => 0),
    //result1: 64 x 39
    //result2: 64 x 103

    'test_scale_minimize_w_l' => array('w' => 64, 'h' => 450, 'mode' => 'scale', 'enlarge' => 1),
    //result1: 729 x 450
    //result2: 279 x 450

    'test_scale_minimize_h' => array('w' => 500, 'h' => 64, 'mode' => 'scale', 'enlarge' => 0),
    //result1: 104 x 64
    //result2: 40 x 64

    'test_scale_minimize_h_l' => array('w' => 500, 'h' => 64, 'mode' => 'scale', 'enlarge' => 1),
    //result1: 500 x 309
    //result2: 500 x 807

    // CROP:
    'test_crop_minimize' => array('w' => 64, 'h' => 64, 'mode' => 'crop', 'enlarge' => 0),
    //result1: 64 х 64
    //result2: 64 x 64

    'test_crop_maximize_large' => array('w' => 500, 'h' => 450, 'mode' => 'crop', 'enlarge' => 1),
    //result1: 500 x 309
    //result2: 500 x 450

    'test_crop_maximize_nolarge' => array('w' => 500, 'h' => 450, 'mode' => 'crop', 'enlarge' => 0),
    //result1: 457 x 282
    //result2: 290 x 450

    'test_crop_minimize_w' => array('w' => 64, 'h' => 450, 'mode' => 'crop', 'enlarge' => 0),
    //result1: 64 x 282
    //result2: 64 x 450

    'test_crop_minimize_w_l' => array('w' => 64, 'h' => 450, 'mode' => 'crop', 'enlarge' => 1),
    //result1: 64 x 450
    //result2: 64 x 450

    'test_crop_minimize_h' => array('w' => 500, 'h' => 64, 'mode' => 'crop', 'enlarge' => 0),
    //result1: 457 x 64
    //result2: 290 x 64

    'test_crop_minimize_h_l' => array('w' => 500, 'h' => 64, 'mode' => 'crop', 'enlarge' => 1),
    //result1: 500 x 64
    //result2: 500 x 64

    //STRETCH:
    'test_stretch_minimize' => array('w' => 64, 'h' => 64, 'mode' => 'stretch', 'enlarge' => 0),
    //result1: 64 x 64
    //result2: 64 x 64

    'test_stretch_maximize_large' => array('w' => 500, 'h' => 450, 'mode' => 'stretch', 'enlarge' => 1),
    //result1: 500 x 450
    //result2: 500 x 450

    'test_stretch_maximize_nolarge' => array('w' => 500, 'h' => 450, 'mode' => 'stretch', 'enlarge' => 0),
    //result1: 457 x 282
    //result2: 500 x 450

    // MODE = NO
    'test_modeoff' => array('w' => 500, 'h' => 640, 'mode' => 'no', 'enlarge' => 1)
    //result1: 457 x 282
    //result2: 290 x 468
);
*/