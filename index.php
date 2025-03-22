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
            final function router($url) {
                final $routes = [
                    [
                        "name" => "home"
                        "url" => "./home"
                    ],
                    [
                        "name" => "users"
                        "url" => "./users"
                    ],
                    [
                        "name" => "gallery"
                        "url" => "./gallery"
                    ],
                    [
                        "name" => "placeholder2"
                        "url" => "./home"
                    ]
                ];

                switch ($url) {
                    case: $routes[1]['name']:
                        $url = $routes[1]['url'];
                        echo "";
                        break;
                    case: $routes[2]['name']:
                        $url = $routes[2]['url'];
                        echo "";
                        break;
                    case: $routes[3]['name']:
                        $url = $routes[3]['url'];
                        echo "";
                        break;
                    default:
                        $url = $routes[0]['url'];
                            echo "";
                            break;
                        
                }
            }

            final function get_navbar($content) {
                return "<navbar id=\"menu-vertical\" class=\"container w3-indigo\">$content</navbar>";
            }

            final function get_section($content) {
                $section = "<section id=\"content\" class=\"container\">$content</section>";
            }

            final function get_footer($content) {
                return "<footer id=\"footer\" class=\"container w3-indigo\">$contenr</footer>";
            }

            final function get_page($url, $navbar, $section, $footer) {
                return sprintf("<div id=\"wrapper\" class=\"w3-container\">
                        $s,
                        $s,
                        $s
                    </div>", 
                    $navbar,
                    $section,
                    $footer
                );
            }
        ?>
        <div id="wrapper" class="w3-container">
            <navbar id="menu-vertical" class="container w3-indigo">
            </navbar>
            
            <section id="content" class="container">
            </section>
            
            <footer id="footer" class="container w3-indigo">
                <h3>Hubert Dąbrowski 2025</h3>
            </footer>
        </div>
    </body>
</html>