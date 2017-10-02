<?php


/**
 * This file holds all of the themes required endpoints.
 *
 * If you wish to add more endpoints,
 * please do so in addonEndpoints.php
 */
class AltThemeEndpoints
{


    /**
     * Get an array of featured image size urls
     *
     * @param $id
     *
     * @return array|void
     */
    public function getFeaturedImg($id)
    {

        // Check for post thumbnail
        if (!get_the_post_thumbnail($id)) {
            return;
        }

        $imgArr = [];

        foreach (get_intermediate_image_sizes() as $size) {
            $imgArr[$size] = wp_get_attachment_image_src(get_post_thumbnail_id($id), $size)[0];
        }

        return $imgArr;
    }


    /**
     * Returns ACF Global Fields
     *
     *
     * @return array|bool
     */
    public static function getACFGlobalOptions()
    {

        if (!class_exists('acf') || !get_field_objects('option')) {
            return false;
        }

        return get_field_objects('option');
    }


    /**
     * Gets all taxonomy and term data
     *
     * @param $id
     * @param $taxs
     *
     * @return array
     */
    public static function getPostTaxTerm($id, $taxes)
    {

        $returnData = [];
        foreach ($taxes as $tax) {

            $returnData[] = [
                'name' => $tax['name'],
                'terms' => wp_get_post_terms($id, $tax['name'], ['fields' => 'names'])
            ];

        }

        return $returnData;
    }


    /**
     * Return all posts from any post type
     *
     * @param $data
     *
     */
    public static function getArchiveData($data)
    {

        $endpoints = new AltThemeEndpoints();
        $posts = [];
        $taxonomies = [];
        $postIds = get_posts([
            'fields' => 'ids',
            'post_type' => $data['post_type'],
            'showposts' => $data['amount']
        ]);
        $ignoredTaxonomies = [
            'post_tag',
            'post_format'
        ];
        $ignoredTerms = [
            // 'Uncategorized',
            // 'Uncategorised'
        ];

        foreach (get_object_taxonomies($data['post_type']) as $tax) {

            if (!in_array($tax, $ignoredTaxonomies)) {

                $terms = [];

                // exclude ignored terms
                foreach (get_terms(['fields' => 'names', 'taxonomy' => $tax]) as $term) {
                    !in_array($term, $ignoredTerms) ? $terms[] = $term : null;
                }

                $taxonomies[] = [
                    'name' => $tax,
                    'terms' => $terms
                ];

            }

        }

        foreach ($postIds as $postId) {
            $posts[] = [
                'title' => get_the_title($postId),
                'date' => get_the_date('d F', $postId),
                'link' => get_the_permalink($postId),
                'img' => $endpoints->getFeaturedImg($postId),
                'taxonomies' => AltThemeEndpoints::getPostTaxTerm($postId, $taxonomies),
                'acf' => $data['acf'] ? get_field_objects($postId) : false
            ];
        }

        echo helpers::alt_json_encode(['taxonomies' => $taxonomies, 'posts' => $posts]);

        die();
    }


    /**
     * Return Featured Image Array
     *
     * @param $data
     *
     */
    public function returnFeaturedImg($data)
    {

        var_dump(AltThemeEndpoints::getFeaturedImg($data['id']));
        die();
    }


    /**
     * Collect and return the data for a post from is ID
     *
     * @param $id
     *
     * @return array|null|string|WP_Post
     */
    public function getPostData($id, $isPreview)
    {
        // Get WordPress post object or post revision object
        if (!$isPreview) {
            $returnData = get_post($id) ?? 'No post found with that ID';
        } else {
            // Get array of post revisions for this ID
            $revisions = wp_get_post_revisions($id);

            if (count($revisions)) {
                // Get the post data for the latest revision
                $revisionsValues = array_values($revisions);
                $returnData = array_shift($revisionsValues);

                // Use the latest revisions ID from now on
                $id = $returnData->ID;
            } else {
                $returnData = 'No post revisions found for that ID. Has the post type got revisions enabled?';
            }
        }

        // Get any custom fields for this post if ACF is installed
        $returnData->acf = (class_exists('acf') && get_field_objects($id)) ? get_field_objects($id) : false;

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


    /**
     * Get breadcrumbs from ID
     *
     * @param $id
     *
     * @return array
     */
    public function getBreadcrumbs($id)
    {

        $breadArr[] = ['title' => get_the_title($id), 'permalink' => get_permalink($id)];

        $parentId = wp_get_post_parent_id($id);

        // Only prepend to array is has parent post
        if ($parentId) {

            do {
                array_unshift($breadArr,
                    ['title' => get_the_title($parentId), 'permalink' => get_permalink($parentId)]);
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


    /**
     * Checks the slug passed against post types to see if it matches,
     * This means that when we search for the slug, we can check only
     * against the correct post type, allowing us to have posts in
     * different types with the same slug!
     *
     * @param $slug
     *
     * @return array
     */
    public function checkType($slug)
    {
        $matchingPostType = '';

        if ($slug[0] !== '/') {
            $slug = '/' . $slug;
        }

        // Retrieves a list of all post types
        $allPostTypes = get_post_types('', 'objects', '');

        // Explode the different parts of the slug and remove blank array parts
        $slugParts = array_diff(explode('/', $slug), ['']);

        // Check is second part to slug or if slug is just 1 deep
        if (isset($slugParts[2]) && !empty($slugParts[2])) {

            // For each post type
            foreach ($allPostTypes as $postType) {
                $matchTo = $postType->rewrite['slug'] ? $postType->rewrite['slug'] : $postType->name;

                // if the first part of the slug matches a post type rewrite url
                if ($slugParts[1] === $matchTo) {
                    $matchingPostType = $postType->name;
                }
            }

            // if no matching post type, assume the slug multipart slug is because it's a child page, return the full slug
            if (!$matchingPostType) {
                $returnSlug = $slug;
            } else { // else return just the last part of the slug by stripping the post types rewrite url
                $returnSlug = str_replace('/', '', implode('', explode($matchingPostType, $slug, 2)));
            }

            // else if the slug has only one part, like a normal page
        } else {
            $returnSlug = $slug;
        }

        return [
            'post_type' => $matchingPostType ? $matchingPostType : 'page',
            'slug' => $returnSlug
        ];
    }


    /**
     * Returns an Object with everything you need in
     * Just pass it an ID or slug!
     *
     * @param $data
     *
     */
    public static function queryAll($data)
    {
        $AltThemeEndpoints = new AltThemeEndpoints();
        $isPreview = false;

        // Page Search Criteria
        $psc = $AltThemeEndpoints->checkType($data['slug']);

        // Handle previews and draft pages
        if (!empty($data['slug']) && isset($_GET['preview'])) {
            $isPreview = true;
            
            // Insert query params stug in slug into $_GET
            $urlParts = parse_url($data['slug']);
            parse_str($urlParts['query'], $params);

            foreach ($params as $key => $value) {
              if (!isset($_GET[$key])) {
                $_GET[$key] = $value;
              }
            }

            // Get the page ID from the preview_id param
            $id = $_GET['preview_id'] ?? $_GET['p'];
        }
        // If the slug is not empty and isn't "/" (Home page)
        elseif (!empty($data['slug'] && $data['slug'] !== '/')) {
            $id = get_page_by_path($psc['slug'], OBJECT, $psc['post_type'])->ID;
        } // If we have an ID instead of a slug
        elseif (!empty($data['id'])) {
            $id = $data['id'];
        } // Else, it will be the Home page
        else {
            $id = get_option('page_on_front');
        }


        // Get and return the content from our narrowed down ID
        // Ensures ID is an integer
        echo json_encode($AltThemeEndpoints->getPostData(intval($id), $isPreview));
        die();
    }

    public static function getArchives($type, $postType = false)
    {
        if ($type['type'] == 'date') {
            $y = 2009;
            $dateArr = [];
            $postType = $_GET['postType'];
            do{
                if(!empty(get_posts(['post_type' => $postType, 'date_query' => [['year' => $y]]]))){
                    $dateArr[] = $y;
                }
                $y++;
            }while($y <= date('Y'));
            echo json_encode($dateArr);
            die();
        }

        if ($type['type'] == 'categories') {
            echo json_encode(get_terms(
                [
                    'taxonomy' => 'category',
                    'hide_empty' => false
                ]
            ));
            die();
        }

        if ($type['type'] == 'expertise') {
            echo json_encode(get_terms(
                [
                    'taxonomy' => 'expertise',
                    'hide_empty' => false
                ]
            ));
            die();
        }

        echo 'Type not specified. Please add either `date`, `categories` or `expertise`';
        die();
    }
}


/**
 * Endpoints are registered on rest_api_init
 */
add_action('rest_api_init', function () {

    /**
     * Endpoint for getting post data by ID or slug
     */
    register_rest_route('alt/v1', '/all', [
        'methods' => 'GET',
        'callback' => ['AltThemeEndpoints', 'queryAll'],
        'args' => [
            'slug' => [
                'default' => false // Pass a slug
            ],
            'id' => [
                'default' => false
            ]
        ],
    ]);


    /**
     * Endpoint for getting ACF options page data
     */
    register_rest_route('alt/v1', '/global-acf', [
        'methods' => 'GET',
        'callback' => ['AltThemeEndpoints', 'getACFGlobalOptions'],
    ]);


    /**
     * Endpoint for getting Featured Images
     */
    register_rest_route('alt/v1', '/featured-image', [
        'methods' => 'GET',
        'callback' => ['AltThemeEndpoints', 'returnFeaturedImg'],
        'args' => [
            'id' => [
                'default' => false
            ]
        ]
    ]);


    /**
     * Endpoint for getting All posts of a certain post type
     */
    register_rest_route('alt/v1', '/archive', [
        'methods' => 'GET',
        'callback' => ['AltThemeEndpoints', 'getArchiveData'],
        'args' => [
            'post_type' => [
                'default' => false
            ],
            'amount' => [
                'default' => -1
            ],
            'acf' => [
                'default' => false
            ]
        ]
    ]);
});
