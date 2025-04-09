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
                        $section = get_home_section($url, $classes);
                        $page = get_page($default_navbar, $section, $default_footer);
                        echo $page;
                        break;

                    case $routes[2]['name']:
                        $name = $routes[2]['name'];
                        stdout("Routing to $name target");
                        $url = $routes[2]['url'];
                        $section = get_users_section($url, $classes);
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

            function get_users() {
                $users = [
                    [
                        "name" => "Hubert",
                        "surname" => "Dabrowski",
                        "country" => "Poland",
                        "city" => "Lodz",
                        "index" => "162214"
                    ]
                ];
                return $users;
            }

            function get_home_section($name, $classes) {
                $user_details = get_users()[0];
                $content = "";
                $counter = 0;
                
                
                foreach(array_keys($user_details) as $key) {
                    $value = $user_details[$key];
                    $key_upp = strtoupper($key);
                    $content .= "<div id=\"key-block-$key\" class=\"home-body-key-block\"><b>$key_upp</b></div>";
                    $content .= "<div id=\"value-block-$key\" class=\"home-body-value-block\">$value</div>";
                    $counter += 1;
                    // stdout($content);
                };
                // stdout($content);
                $section .= get_section($name, $classes, $content);
                // stdout($section);
                return $section;
            }
            
            function get_users_section($name, $classes) {
                $users = get_users();
                $content = "";
                $counter = 0;
                
                foreach($users as $user_details) {
                
                    foreach(array_keys($user_details) as $key) {
                        $value = $user_details[$key];
                        $key_upp = strtoupper($key);
                        $content .= "<div id=\"key-block-$key\" class=\"home-body-key-block\"><b>$key_upp</b></div>";
                        $content .= "<div id=\"value-block-$key\" class=\"home-body-value-block\">$value</div>";
                        $counter += 1;
                        // stdout($content);
                    }
                };
                // stdout($content);
                $section = get_section($name, $classes, $content);
                // stdout($section);
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