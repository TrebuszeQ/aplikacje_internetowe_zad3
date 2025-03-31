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

                switch ($url) {
                    case $routes[1]['name']:
                        $name = $routes[1]['name'];
                        stdout("Routing to $name target");
                        $url = $routes[1]['url'];
                        $section = get_section("users");
                        $page = get_page($default_navbar, $section, $default_footer);
                        echo $page;
                        break;

                    case $routes[2]['name']:
                        $name = $routes[2]['name'];
                        stdout("Routing to $name target");
                        $url = $routes[2]['url'];
                        $section = get_section("gallery");
                        $page = get_page($default_navbar, $section, $default_footer);
                        echo $page;
                        break;

                    case $routes[3]['name']:
                    default:
                        stdout("Routing to default target");
                        $url = $routes[0]['url'];
                        $section = get_home_section();
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

            // function get_home_section() {
            //     $user_details = [
            //         "name" => "Hubert",
            //         "surname" => "Dabrowski",
            //         "country" => "Poland",
            //         "city" => "Lodz",
            //         "index" => "162214"
            //     ];

            //     // $navbar = get_home_navbar();
            //     // $section .= $navbar;
            //     $table = "<table id=\"home-table\" class=\"section-table\">";
                
            //     foreach(array_keys($user_details) as $key) {
            //         $table_heading .= "<tr><th><b>$key</b></th></tr>";
            //     }
                
            //     $table .= $table_heading;

            //     foreach(array_keys($user_details) as $key) {
            //         $value = $user_details[$key];
            //         $content .= "<tr>";
            //         $content .= "<td>$value</td>";
            //         $content .= "</tr>";
            //         // stdout($content);
            //     };
            //     stdout($content);
            //     $table .= "</table>"
            //     $section .= "<section id=\"section\" class=\"block-container\">$content</section>";
            //     stdout($section);
            //     return $section;
            // }

            function get_home_section() {
                $user_details = [
                    "name" => "Hubert",
                    "surname" => "Dabrowski",
                    "country" => "Poland",
                    "city" => "Lodz",
                    "index" => "162214"
                ];

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
                stdout($content);
                $section .= "<section id=\"home-body\" class=\"grid-container body\">$content</section>";
                stdout($section);
                return $section;
            }
            
            function get_section($content) {
                return "<section id=\"section\" class=\"grid-container\">$content</section>";
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