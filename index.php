<!DOCTYPE html>
<html>
    <title>Zadanie3</title>
    <head>
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
            if (isset($_GET['target'])) {
                $url = $_GET['target'];
            }
            else {
                $url = "";
            }

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

            function get_galleries_data() {
                $galleries = [
                    [
                        "name" => "gallery_1",
                        "description" => "Gallery 1",
                        "images" => [
                            [
                                "name" => "img_1",
                                "description" => "Image 1",
                                "path" => "./images/img_1.png"
                            ]
                        ],
                        "height" => "10%",
                        "width" => "20%"
                    ],
                    [
                        "name" => "gallery_2",
                        "description" => "Gallery 2",
                        "images" => [
                        ]
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

            function get_gallery_section($name, $classes) {
                $classes_str = join(" ", $classes);
                $galleries_data = get_galleries_data();
                $content = "";

                foreach($galleries_data as $gallery) {
                    // stdout($gallery);
                    $name = $gallery["name"];
                    $description = $gallery["description"];
                    $images = $gallery["images"];
                    $height = $gallery["height"];
                    $width = $gallery["width"];
                    stdout($images);
                    stdout(array_keys($images));
                    $gallery_block = "<div id=\"$name-wrapper\" class=\"\">";
                    
                    foreach($images as $img) {
                        $img_name = $img["name"];
                        stdout($img_name);
                        $img_description = $img["description"];
                        $img_path = $img["path"];
                        stdout($img_path);
                        $img_block = "<img src=\"$img_path\" alt=\"$img_description\" width=\"$width\" height=\"$height\"";
                        $gallery_block .= $img_block;
                    }
                    
                    $gallery_block .= "</div>";
                    stdout($gallery_block);
                    $content .= $gallery_block;
                }

                $section = get_section($name, $classes, $content);
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