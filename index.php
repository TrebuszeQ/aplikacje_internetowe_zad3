<!DOCTYPE html>
<html>
    <title>Zadanie3</title>
    <head>
        <script src="./script.js"></script>
        <meta name="description" content="">
        <meta name="keywords" content="HTML, CSS, PHP">
        <meta name="author" content="Hubert Dabrowski">
        <meta charset="utf-8">
        <meta name="viewport" context="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./w3.css">
        <link rel="stylesheet" href="./my.css">
    </head>
    <body>
        <?php
            $url = $_GET["target"];
            stdout($url);

            function stdout($data) {
                $output = json_encode($data);
                echo "<script>console.log(`Debug: " . $output . "`);</script>";
            }

            $routes = [
                [
                    "name" => "home",
                    "url" => "home",
                    "content" => "",
                ],
                [
                    "name" => "users",
                    "url" => "users",
                    "content" => ""
                ],
                [
                    "name" => "gallery",
                    "url" => "gallery",
                    "content" => ""
                ],
                [
                    "name" => "placeholder",
                    "url" => "home", 
                    "content" => ""
                ]
            ];
            // stdout("Routes: " . json_encode($routes));
            
            router($url, $routes);

            function router($url, $routes) {
                $default_navbar = get_navbar($routes);
                $default_footer = get_footer();
                
                $classes = [
                    "grid-container",
                    "body"
                ];

                switch ($url) {
                    case $routes[1]['name']:
                        $name = $routes[1]['name'];
                        stdout("Routing to $name target");
                        $url = $routes[1]['url'];
                        $section = get_users_data_section($url, $classes);
                        $page = get_page($default_navbar, $section, $default_footer);
                        echo $page;
                        break;

                    case $routes[2]['name']:
                        $name = $routes[2]['name'];
                        stdout("Routing to $name target");
                        $url = $routes[2]['url'];
                        $section = get_gallery_section($url, $classes);
                        $page = get_page($default_navbar, $section, $default_footer);
                        echo $page;
                        break;

                    case $routes[3]['name']:
                    default:
                        stdout("Routing to default target");
                        $url = $routes[0]['url'];
                        $section = get_home_section($url, $classes);
                        $page = get_page($default_navbar, $section, $default_footer);
                        echo $page;
                        break;
                }
            }

            function get_navbar($routes) {
                $content = "";
                $counter = 0;
                $encoded_routes = json_encode($routes);
                
                foreach($routes as $route) {
                    $target = $route['url'];
                    $name = $route['name'];
                    $js_callback = "window.location.href='index.php?target=$name'";
                    $name_upp = strtoupper($name);
                    $content .= "<input type=\"button\" onclick=\"$js_callback\" id=\"nav-button-$counter\" class=\"nav-button w3-indigo w3-button\" value=\"$name_upp\">";
                    // stdout($content);
                    $counter += 1;
                };

                return "<navbar id=\"main-navbar\" class=\"grid-container w3-indigo\">$content</navbar>";
            }

            function get_users_data() {
                $users = [
                    [
                        "name" => "Hubert",
                        "surname" => "Dabrowski",
                        "country" => "Poland",
                        "city" => "Lodz",
                        "index" => "162214"
                    ],
                    [
                        "name" => "Marcin",
                        "surname" => "Bobrowski",
                        "country" => "Poland",
                        "city" => "Lodz",
                        "index" => "131453"
                    ],
                    [
                        "name" => "Wojciech",
                        "surname" => "Frakowiak",
                        "country" => "Poland",
                        "city" => "Warszawa",
                        "index" => "155762"
                    ]
                ];
                return $users;
            }

            function get_gallery_data() {
                $galleries = [
                    [
                        "name" => "test-gallery",
                        "description" => "Test gallery",
                        "images" => [
                            [
                                "name" => "img_1",
                                "description" => "Image 1",
                                "path" => "./images/img_1.png"
                            ],
                            [
                                "name" => "img_2",
                                "description" => "Image 2",
                                "path" => "./images/img_2.png"
                            ]
                        ],
                        "height" => "100%",
                        "width" => "100%"
                    ]
                ];
                // stdout("$galleries");
                return $galleries;
            }

            function get_home_section($name, $classes) {
                $user_details = get_users_data()[0];
                $content = "";
                
                foreach(array_keys($user_details) as $key) {
                    $value = $user_details[$key];
                    $key_upp = strtoupper($key);
                    $content .= "<div id=\"key-block-$key\" class=\"home-body-key-block\" style=\"grid-row: 1\"><b>$key_upp</b></div>";
                    $content .= "<div id=\"value-block-$key\" class=\"home-body-value-block\" style=\"grid-row: 2\"><p>$value</p></div>";
                    // stdout($content);
                };
                // stdout($content);
                $section .= get_section($name, $classes, $content);
                // stdout($section);
                return $section;
            }
            
            function get_users_data_section($name, $classes) {
                $users = get_users_data();
                $content = "";

                $header_done = false;
                $counter = 0;

                foreach($users as $user_details) {
                    // stdout($user_details);
                    $row = $counter + 2;
                    
                    foreach(array_keys($user_details) as $key) {
                        if (!$header_done) {
                            $key_upp = strtoupper($key);
                            $content .= "<div id=\"key-block-$key\" class=\"home-body-key-block\" style=\"grid-row: 1\"><b>$key_upp</b></div>";
                        }
                        $value = $user_details[$key];
                        $content .= "<div id=\"value-block-$key-$counter\" class=\"home-body-value-block\" style=\"grid-row: $row\"><p>$value</p></div>";
                        // stdout($content);
                    }
                    
                    if (!$header_done) {
                        $header_done = true;
                    }
                    $counter += 1;
                };
                // stdout($content);
                $section = get_section($name, $classes, $content);
                // stdout($section);
                return $section;
            }

            function get_carousel() {
                $gallery_wrapper_element = "<div id=\"$name-wrapper\" class=\"\">";
                    $gallery_wrapper_element .= $l_nav_button_block;
            }  
            
            function register_carousel_data($length, $unit) {
                echo "<script>
                    register_carousel_data($length, $unit)
                </script>";
            }

            function get_gallery_section($name, $classes) {
                $classes_str = join(" ", $classes);
                $galleries_data = get_gallery_data();

                $gallery = $galleries_data[0];
                // stdout($gallery);
                $gallery_name = $gallery["name"];
                $description = $gallery["description"];
                $images = $gallery["images"];
                $height = $gallery["height"];
                $width = $gallery["width"];
                // stdout($images);
                $content = "<h2 id=\"$name-title\" class=\"gallery-title\">$gallery_name</h2>";;
                $img_wrapper_id = "$gallery_name-img-wrapper";
                $carousel_unit = 86;
                
                $gallery_wrapper_element = "<div id=\"$gallery_name-wrapper\" class=\"gallery-wrapper grid-container\">";
                $js_callback = "carousel_move";
                $l_nav_button_block = "<input type=\"button\" onclick=\"{$js_callback}('$img_wrapper_id', '-$carousel_unit')\" id=\"left-$gallery_name-button\" class=\"left-gallery-button gallery-button nav-button w3-indigo w3-button\" value=\"<\">";
                $gallery_wrapper_element .= $l_nav_button_block;
                $img_wrapper_element = "<div id=\"$img_wrapper_id\" class=\"gallery-img-wrapper grid-container\">";

                foreach($images as $img) {
                    // $img_name = $img["name"];
                    stdout($img_name);
                    $img_description = $img["description"];
                    $img_path = $img["path"];
                    // stdout($img_path);
                    $img_element = "<img id=\"$img_name\" class=\"gallery-img\" src=\"$img_path\" alt=\"$img_description\" width=\"$width\" height=\"$height\" loading=\"lazy\">";
                    $img_wrapper_element .= $img_element;
                }

                $img_wrapper_element .= "</div>";
                $js_callback = "carousel_move";
                $r_nav_button_block = "<input type=\"button\" onclick=\"{$js_callback}('$img_wrapper_id', '$carousel_unit')\" id=\"left-$gallery_name-button\" class=\"right-gallery-button gallery-button nav-button w3-indigo w3-button\" value=\">\">"; 
                $gallery_wrapper_element .= $img_wrapper_element;
                $gallery_wrapper_element .= $r_nav_button_block;
                $gallery_wrapper_element .= "</div>";
                $gallery_description_block_content = "<h3 id=\"$gallery_name-description-title\" class=\"gallery-description-title\">Description</h3>";
                $gallery_description_block_content.= "<p id=\"$gallery_name-description\" class=\"gallery-description\">$description</p>";
                $gallery_description_block = "<div id=\"$gallery_name-description-block\" class=\"gallery-description-block block-container\">$gallery_description_block_content</div>";
                $content .= $gallery_description_block;
                $content .= $gallery_wrapper_element;
                
                $section = get_section($name, $classes, $content);
                register_carousel_data(count($images), $carousel_unit);
                return $section;
            }

            function get_section($name, $classes, $content) {
                $classes_str = join(" ", $classes);
                return "<section id=\"$name-body\" class=\"$classes_str\">$content</section>";
            }

            function get_footer() {
                return "<footer id=\"footer\" class=\"grid-container w3-indigo\"><h3>Hubert Dąbrowski 2025</h3></footer>";
            }

            function get_page($navbar, $section, $footer) {
                return sprintf("<div id=\"wrapper\" class=\"wrapper\">%s%s%s</div>", 
                    $navbar,
                    $section,
                    $footer
                );
            }
        ?>

    </body>
</html>