<?php

/* ---------------------------------
 * This file holds all of the themes required endpoints.
 * ---------------------------------
 * If you wish to add more endpoints,
 * please do so in addonEndpoints.php
 * --------------------------------- */

class AltThemeEndpoints
{

    /* ---------------------------------
     * Get an array of featured image size urls
     * --------------------------------- */
    public function getFeaturedImg($id)
    {

        if (get_the_post_thumbnail($id)) {
            $imgArr = [];

            foreach (get_intermediate_image_sizes() as $size) {
                $imgArr[$size] = wp_get_attachment_image_src(get_post_thumbnail_id($id), $size)[0];
            }

            return $imgArr;
        }

        return null;

    }


    /* ---------------------------------
     * Gets all taxonomy and term data
     * --------------------------------- */
    public static function getPostTaxTerm($id, $taxs)
    {

        $returnData = [];
        foreach ($taxs as $tax) {

            $returnData[] = [
                'name'  => $tax['name'],
                'terms' => wp_get_post_terms($id, $tax['name'], ['fields' => 'names'])
            ];

        }

        return $returnData;

    }

    /* ---------------------------------
     * Return all posts from any post type
     * --------------------------------- */
    public function getArchiveData($data)
    {

        $endpoints         = new AltThemeEndpoints();
        $posts             = [];
        $taxonomies        = [];
        $postIds           = get_posts([
            'posts_per_page' => -1,
            'fields'         => 'ids',
            'post_type'      => $data['post_type']
        ]);
        $ignoredTaxonomies = [
            'post_tag',
            'post_format'
        ];
        $ignoredTerms      = [
//            'Uncategorized',
//            'Uncategorised'
        ];

        foreach (get_object_taxonomies($data['post_type']) as $tax) {

            if ( ! in_array($tax, $ignoredTaxonomies)) {

                $terms = [];

                // exclude ignored terms
                foreach (get_terms(['fields' => 'names', 'taxonomy' => $tax]) as $term) {
                    ! in_array($term, $ignoredTerms) ? $terms[] = $term : null;
                }

                $taxonomies[] = [
                    'name'  => $tax,
                    'terms' => $terms
                ];

            }

        }

        foreach ($postIds as $postId) {
            $posts[] = [
                'title'      => get_the_title($postId),
                'date'       => get_the_date('d F', $postId),
                'link'       => get_the_permalink($postId),
                'img'        => $endpoints->getFeaturedImg($postId),
                'taxonomies' => AltThemeEndpoints::getPostTaxTerm($postId, $taxonomies)
            ];
        }

        echo helpers::alt_json_encode(['taxonomies' => $taxonomies, 'posts' => $posts]);

        die();

    }


    /* ---------------------------------
     * Return Featured Image Array
     * --------------------------------- */
    public function returnFeaturedImg($data)
    {

        var_dump(AltThemeEndpoints::getFeaturedImg($data['id']));
        die();

    }


    /* ---------------------------------
     * Collect and return the data for a post from is ID
     * --------------------------------- */
    public function getPostData($id)
    {

        // Get WordPress post object
        $returnData = get_post($id) ?? 'No post found with that ID';


        // Get any custom fields for this post if ACF is installed
        if (class_exists('acf') && get_field_objects($id)) {
            $returnData->acf = get_field_objects($id);
        }

        // Get any global custom fields if ACF is installed
        if (class_exists('acf') && get_field_objects('option')) {
            $returnData->global = get_field_objects('option');
        }

        // Get te featured image stuff
        $returnData->featured_image = AltThemeEndpoints::getFeaturedImg($id);

        // Get the breadcrumbs
        $returnData->breadcrumbs = $this->getBreadcrumbs($id);

        // List of post data not to be sent in response
        $noThanks = [
            'post_modified_gmt',
            'post_modified',
            'post_author',
            'pinged',
            'post_modified',
            'to_ping',
            'post_status',
            'post_password',
            'post_mime_type',
            'ping_status',
            'filter',
            'menu_order',
            'guid',
            'comment_status',
            'comment_count',
            'post_content_filtered',
            'post_date_gmt'
        ];

        foreach ($noThanks as $goodBye) {
            unset($returnData->{$goodBye});
        }

        return $returnData;

    }


    /* ---------------------------------
     * Get breadcrumbs from ID
     * --------------------------------- */
    public function getBreadcrumbs($id)
    {

        $breadArr[] = ['title' => get_the_title($id), 'permalink' => get_permalink($id)];

        $parentId = wp_get_post_parent_id($id);

        // Only prepend to array is has parent post
        if ($parentId) {

            do {
                array_unshift($breadArr, ['title' => get_the_title($parentId), 'permalink' => get_permalink($parentId)]);
                $parentId = wp_get_post_parent_id($parentId);
            } while ($parentId != 0);

        }

        // Prepend post type if not page
        $postType = get_post_type($id);
        if ($postType !== 'page') {
            array_unshift($breadArr, ['title' => ucfirst($postType), 'permalink' => get_home_url() . '/' . $postType]);
        }

        array_unshift($breadArr, ['title' => 'Home', 'permalink' => get_home_url() . '/']);

        return $breadArr;
    }


    /* ---------------------------------
     * Checks the slug passed against post types to see if it matches,
     * This means that when we search for the slug, we can check only
     * against the correct post type, allowing us to have posts in
     * different types with the same slug!
     *
     * @param $slug
     *
     * @return array
     * --------------------------------- */
    public function checkType($slug)
    {

        if ($slug[0] !== '/') {
            $slug = '/' . $slug;
        }

        $matchingPostType = '';

        // Retrieves a list of all post types
        $allPostTypes = get_post_types('', 'objects', '');

        // Explode the different parts of the slug and remove blank array parts
        $slugParts = array_diff(explode('/', $slug), ['']);

        // Check is second part to slug or if slug is just a page
        if (isset($slugParts[2]) && ! empty($slugParts[2])) {

            // For each post type
            foreach ($allPostTypes as $postType) {


                $matchTo = $postType->rewrite['slug'] ? $postType->rewrite['slug'] : $postType->name;
                // if the first part of the slug matches a post type rewrite url
                if ($slugParts[1] === $matchTo) {

                    $matchingPostType = $postType->name;

                }

            }

            $returnSlug = str_replace('/', '', implode('', explode($matchingPostType, $slug, 2)));

        } else {
            $returnSlug = str_replace('/', '', $slug);
        }

        return [
            'post_type' => $matchingPostType ? $matchingPostType : 'page',
            'slug'      => $returnSlug
        ];
    }

    /* --------------------------------- 
     * Returns an Object with everything you need in
     * Just pass it an ID or slug!
     *
     * @param $data
     * --------------------------------- */
    public function queryAll($data)
    {

        $AltThemeEndpoints = new AltThemeEndpoints();

        // Page Search Criteria
        $psc = $AltThemeEndpoints->checkType($data['slug']);


        // If the slug is not empty and isn't "/" (Home page)
        if ( ! empty($data['slug'] && $data['slug'] !== '/')) {

            $id = get_page_by_path($psc['slug'], OBJECT, $psc['post_type'])->ID;

        } // If we have an ID instead of a slug
        elseif ( ! empty($data['id'])) {

            $id = $data['id'];

        } // Else, it will be the Home page
        else {

            $id = get_option('page_on_front');

        }

        // Get and return the content from our narrowed down ID
        // Ensures ID is an integer
        echo json_encode($AltThemeEndpoints->getPostData(intval($id)));

        die();

    }

}


/* ---------------------------------
 *
 *
 * Endpoints are registered here
 *
 *
 * --------------------------------- */


/* ---------------------------------
 * API endpoint for getting post data by ID or slug
 * --------------------------------- */
add_action('rest_api_init', function () {
    register_rest_route('alt/v1', '/all', [
        'methods'  => 'GET',
        'callback' => ['AltThemeEndpoints', 'queryAll'],
        'args'     => [
            'slug' => [
                'default' => false // Pass a slug
            ],
            'id'   => [
                'default' => false // Or an ID
            ]
        ],
    ]);
});


/* ---------------------------------
 * API endpoint for getting Featured Images
 * --------------------------------- */
add_action('rest_api_init', function () {
    register_rest_route('alt/v1', '/featured-image', [
        'methods'  => 'GET',
        'callback' => ['AltThemeEndpoints', 'returnFeaturedImg'],
        'args'     => [
            'id' => [
                'default' => false // Or an ID
            ]
        ]
    ]);
});


/* ---------------------------------
 * API endpoint for getting All posts of a certain post type
 * --------------------------------- */
add_action('rest_api_init', function () {
    register_rest_route('alt/v1', '/archive', [
        'methods'  => 'GET',
        'callback' => ['AltThemeEndpoints', 'getArchiveData'],
        'args'     => [
            'post_type' => [
                'default' => false // Or an ID
            ]
        ]
    ]);
});
