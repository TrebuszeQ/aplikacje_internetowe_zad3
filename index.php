<!DOCTYPE html>
<html>
    <title>Zadanie3</title>
    <head>
        <script src="./script.js"></script>
        <meta name="description" content="">
        <meta name="keywords" content="HTML, CSS, PHP">
        <meta name="author" content="Hubert Dabrowski">
        <meta charset="utf-8">
        <meta name="viewport" context="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./w3.css">
        <link rel="stylesheet" href="./my.css">
    </head>
    <body>
        <?php
            $url = "";
            if (isset($_GET["target"])) {
                $url = $_GET["target"];
                stdout($url);
            }
            
            /** 
             * Function that prints out to standard console output.
             * :param $data: Data to print
            */
            function stdout($data) {
                $output = json_encode($data);
                echo "<script>console.log(`Debug: " . $output . "`);</script>";
            }

            // App defined functions.
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

            /** 
             * Function builds and prints final html page based on the route.
             * :param $url: Not really a url, but the name of the target page.
             * :param $routes: All app routes passed to each page.
            */
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

            /** 
             * Function builds and prints navigation menu of the app.
             * :param $url: Not really a url, but the name of the target page.
             * :param $routes: All app routes passed to each page.
            */
            function get_navbar($routes) {
                $content = "";
                $counter = 0;
                $encoded_routes = json_encode($routes);
                
                foreach($routes as $route) {
                    $target = $route['url'];
                    $name = $route['name'];
                    $js_callback = "window.location.href='index.php?target=$name'";
                    $name_upp = strtoupper($name);
                    $content .= "<input type=\"button\" onclick=\"$js_callback\" id=\"nav-button-$name\" aria-label=\"$name navigation button\" class=\"nav-button w3-indigo w3-button\" value=\"$name_upp\">";
                    // stdout($content);
                    $counter += 1;
                };

                return "<navbar id=\"main-navbar\" aria-label=\"Navigation bar\" class=\"grid-container w3-indigo\">$content</navbar>";
            }

            /** 
             * Function reads text file.
             * :param $file_path: Path to the file.
            */
            function read_file($file_path) {
                try {
                    stdout("Reading file at: $");                    
                    $lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                    return $lines;

                }
                catch (Exception $e) {
                    stdout($e);
                }
                return [];
            }
            
            /** 
             * Function parses the lines from a text document.
             * :param $lines: Array of lines.
            */
            function parse_users_file($lines) {
                
                foreach ($lines as $line) {
                $line = ltrim($line, '|');

                $pairs = explode(',', $line);
                $entry = [];

                    foreach ($pairs as $pair) {
                        [$key, $value] = explode('=>', $pair);
                        $key = trim($key, " \"");
                        $value = trim($value, " \"");
                        $entry[$key] = $value;
                    }
                    $result[] = $entry;
                }

                return $result;
            }

            /** 
             * Function combines reading read_file and parse_users_file functions and returns the final users list. 
             * :return: Returns the final users array.
            */
            function get_users_data() {
                $lines = read_file("./users.txt");
                $users = parse_users_file($lines);
                return $users;
            }

            /** 
             * Function to get hardcoded galleries data.
             * :returns: Galleries as array of maps.
            */
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

            /** 
             * Function to build and get HTML home page section.
             * :param name: Name of the page.
             * :param classes: Classes to pass to get_section.
             * :returns: Built HTML home section as string.
            */
            function get_home_section($name, $classes) {
                $user_details = get_users_data()[0];
                $content = "";
                
                foreach(array_keys($user_details) as $key) {
                    $value = $user_details[$key];
                    $key_upp = strtoupper($key);
                    $content .= "<div id=\"key-block-$key\" aria-label=\"$key key block\" class=\"home-body-key-block\" style=\"grid-row: 1\"><b>$key_upp</b></div>";
                    $content .= "<div id=\"value-block-$key\" aria-label=\"$key value block\" class=\"home-body-value-block\" style=\"grid-row: 2\"><p>$value</p></div>";
                    // stdout($content);
                };
                // stdout($content);
                $section = get_section($name, $classes, $content);
                // stdout($section);
                return $section;
            }
            
            /** 
             * Function to build and get HTML home page section.
             * :param name: Name of the page.
             * :param classes: Classes to pass to get_section.
             * :returns: Built HTML home section as string.
            */
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
                            $content .= "<div id=\"key-block-$key\" aria-label=\"$key key block\" class=\"home-body-key-block\" style=\"grid-row: 1\"><b>$key_upp</b></div>";
                        }
                        $value = $user_details[$key];
                        $content .= "<div id=\"value-block-$key-$counter\" aria-label=\"$key value block\" class=\"home-body-value-block\" style=\"grid-row: $row\"><p>$value</p></div>";
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
            
            /** 
             * Function to register Javascript carousel data.
             * :param length: Number of images in the gallery.
             * :param unit: Number by how much move the carousel slider.
             * :returns: Nothing
            */
            function register_carousel_data($length, $unit) {
                echo "<script>
                    register_carousel_data($length, $unit)
                </script>";
            }
            
            /** 
             * Function to build and get HTML gallery page section.
             * :param name: Name of the page.
             * :param classes: Classes to pass to get_section.
             * :returns: Built HTML home section as string.
            */
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
                $content = "<h2 id=\"$name-title\" aria-label=\"$gallery_name gallery title\"  class=\"gallery-title\">$gallery_name</h2>";;
                $img_wrapper_id = "$gallery_name-img-wrapper";
                $carousel_unit = 86;
                
                $gallery_wrapper_element = "<div id=\"$gallery_name-wrapper\" aria-label=\"$gallery_name gallery wrapper\" class=\"gallery-wrapper grid-container\">";
                $js_callback = "carousel_move";
                $l_nav_button_block = "<input type=\"button\" aria-label=\"$gallery_name gallery slider left button\" onclick=\"{$js_callback}('$img_wrapper_id', '-$carousel_unit')\" id=\"left-$gallery_name-button\" class=\"left-gallery-button gallery-button nav-button w3-indigo w3-button\" value=\"<\">";
                $gallery_wrapper_element .= $l_nav_button_block;
                $img_wrapper_element = "<div id=\"$img_wrapper_id\" aria-label=\"$gallery_name gallery image wrapper\" class=\"gallery-img-wrapper grid-container\">";

                foreach($images as $img) {
                    // $img_name = $img["name"];
                    $img_name = $img["name"];
                    $img_description = $img["description"];
                    $img_path = $img["path"];
                    // stdout($img_path);
                    $img_element = "<img id=\"$img_name\" aria-label=\"$img_name image\" class=\"gallery-img\" src=\"$img_path\" alt=\"$img_description\" width=\"$width\" height=\"$height\" loading=\"lazy\">";
                    $img_wrapper_element .= $img_element;
                }

                $img_wrapper_element .= "</div>";
                $js_callback = "carousel_move";
                $r_nav_button_block = "<input type=\"button\"aria-label=\"$gallery_name gallery slider right button\"  onclick=\"{$js_callback}('$img_wrapper_id', '$carousel_unit')\" id=\"left-$gallery_name-button\" class=\"right-gallery-button gallery-button nav-button w3-indigo w3-button\" value=\">\">"; 
                $gallery_wrapper_element .= $img_wrapper_element;
                $gallery_wrapper_element .= $r_nav_button_block;
                $gallery_wrapper_element .= "</div>";
                $gallery_description_block_content = "<h3 id=\"$gallery_name-description-title\" aria-label=\"$gallery_name gallery description title\" class=\"gallery-description-title\">Description</h3>";
                $gallery_description_block_content.= "<p id=\"$gallery_name-description\" class=\"gallery-description\">$description</p>";
                $gallery_description_block = "<div id=\"$gallery_name-description-block\" aria-label=\"$gallery_name gallery description block\" class=\"gallery-description-block block-container\">$gallery_description_block_content</div>";
                $content .= $gallery_description_block;
                $content .= $gallery_wrapper_element;
                
                $section = get_section($name, $classes, $content);
                register_carousel_data(count($images), $carousel_unit);
                return $section;
            }

            function get_section($name, $classes, $content) {
                $classes_str = join(" ", $classes);
                return "<section id=\"$name-body\" aria-label=\"section\" class=\"$classes_str\">$content</section>";
            }

            function get_footer() {
                return "<footer id=\"footer\" aria-label=\"footer\" class=\"grid-container w3-indigo\"><h3>Hubert Dąbrowski 2025</h3></footer>";
            }

            function get_page($navbar, $section, $footer) {
                return sprintf("<div id=\"wrapper\" aria-label=\"page wrapper\" class=\"wrapper grid-container\">%s%s%s</div>", 
                    $navbar,
                    $section,
                    $footer
                );
            }
        ?>

    </body>
</html>