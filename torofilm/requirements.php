<!DOCTYPE html>
<html>

<head>
    <title>Requirements</title>

    <!-- Standard favicon -->
    <link rel="icon" type="image/x-icon" href="https://torothemes.com/wp-content/uploads/2019/12/cropped-Grupo-13-32x32.png" />
    <link rel="icon" type="image/png" href="https://torothemes.com/wp-content/uploads/2019/12/cropped-Grupo-13-192x192.png" />

    <!-- Meta -->
    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta name="description" content="Toro Themes specializes in designing elegant" />

    <link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre-exp.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre-icons.min.css" />
</head>

<body>
    <div class="section text-center">
        <br />
        <h1>Requirements</h1>
        <br />
    </div>
    <div class="container grid-lg">
        <div class="columns">
            <div class="column col-10 col-sm-12 col-mx-auto text-left">
                <div class="tile tile-centered">
                    <div class="tile-icon">
                        <div class="example-tile-icon">
                            <i class="icon icon-file centered"></i>
                        </div>
                    </div>
                    <div class="tile-content">
                        <div class="tile-title">PHP 7.2 or higher</div>

                        <?php

                        if (phpversion() < "7.1") {
                            echo '<small class="tile-subtitle text-warning">v' . phpversion() . ' · lower</small>';
                        } else {
                            echo '<small class="tile-subtitle text-success">v' . phpversion() . ' · higher</small>';
                        }

                        ?>
                    </div>
                    <div class="tile-action">
                        <button class="btn btn-link">
                            <?php

                            if (phpversion() < "7.1") {
                                echo '<i class="icon icon-cross text-error"></i>';
                            } else {
                                echo '<i class="icon icon-check text-success"></i>';
                            }

                            ?>
                        </button>
                    </div>

                </div>

                <br />

                <div class="tile tile-centered">
                    <div class="tile-icon">
                        <div class="example-tile-icon">
                            <i class="icon icon-file centered"></i>
                        </div>
                    </div>
                    <div class="tile-content">
                        <div class="tile-title">MySQLi</div>
                        <?php

                        if (!extension_loaded('mysqli')) {
                            echo '<small class="tile-subtitle text-error">Disabled</small>';
                        } else {
                            echo '<small class="tile-subtitle text-success">Enabled</small>';
                        }

                        ?>
                    </div>
                    <div class="tile-action">
                        <button class="btn btn-link">
                            <?php

                            if (!extension_loaded('mysqli')) {
                                echo '<i class="icon icon-cross text-error"></i>';
                            } else {
                                echo '<i class="icon icon-check text-success"></i>';
                            }

                            ?>
                        </button>
                    </div>
                </div>

                <br />

                <div class="tile tile-centered">
                    <div class="tile-icon">
                        <div class="example-tile-icon">
                            <i class="icon icon-file centered"></i>
                        </div>
                    </div>
                    <div class="tile-content">
                        <div class="tile-title">PDO / Object-OR</div>

                        <?php

                        if (!extension_loaded('pdo')) {
                            echo '<small class="tile-subtitle text-error">Disabled</small>';
                        } else {
                            echo '<small class="tile-subtitle text-success">Enabled</small>';
                        }

                        ?>
                    </div>
                    <div class="tile-action">
                        <button class="btn btn-link">
                            <?php

                            if (!extension_loaded('pdo')) {
                                echo '<i class="icon icon-cross text-error"></i>';
                            } else {
                                echo '<i class="icon icon-check text-success"></i>';
                            }

                            ?>
                        </button>
                    </div>
                </div>

                <br />

                <div class="tile tile-centered">
                    <div class="tile-icon">
                        <div class="example-tile-icon">
                            <i class="icon icon-file centered"></i>
                        </div>
                    </div>
                    <div class="tile-content">
                        <div class="tile-title">cURL</div>

                        <?php

                        if (!extension_loaded('curl')) {
                            echo '<small class="tile-subtitle text-error">Disabled</small>';
                        } else {
                            echo '<small class="tile-subtitle text-success">Enabled</small>';
                        }

                        ?>
                    </div>
                    <div class="tile-action">
                        <button class="btn btn-link">
                            <?php

                            if (!extension_loaded('curl')) {
                                echo '<i class="icon icon-cross text-error"></i>';
                            } else {
                                echo '<i class="icon icon-check text-success"></i>';
                            }

                            ?>
                        </button>
                    </div>
                </div>

                <br />

                <div class="tile tile-centered">
                    <div class="tile-icon">
                        <div class="example-tile-icon">
                            <i class="icon icon-file centered"></i>
                        </div>
                    </div>
                    <div class="tile-content">
                        <div class="tile-title">MBString</div>

                        <?php

                        if (!extension_loaded('mbstring')) {
                            echo '<small class="tile-subtitle text-error">Disabled</small>';
                        } else {
                            echo '<small class="tile-subtitle text-success">Enabled</small>';
                        }

                        ?>
                    </div>
                    <div class="tile-action">
                        <button class="btn btn-link">
                            <?php

                            if (!extension_loaded('mbstring')) {
                                echo '<i class="icon icon-cross text-error"></i>';
                            } else {
                                echo '<i class="icon icon-check text-success"></i>';
                            }

                            ?>
                        </button>
                    </div>
                </div>

                <br />

                <div class="tile tile-centered">
                    <div class="tile-icon">
                        <div class="example-tile-icon">
                            <i class="icon icon-file centered"></i>
                        </div>
                    </div>
                    <div class="tile-content">
                        <div class="tile-title">GD</div>

                        <?php

                        if (!extension_loaded('gd')) {
                            echo '<small class="tile-subtitle text-error">Disabled</small>';
                        } else {
                            echo '<small class="tile-subtitle text-success">Enabled</small>';
                        }

                        ?>
                    </div>
                    <div class="tile-action">
                        <button class="btn btn-link">

                            <?php

                            if (!extension_loaded('gd')) {
                                echo '<i class="icon icon-cross text-error"></i>';
                            } else {
                                echo '<i class="icon icon-check text-success"></i>';
                            }

                            ?>
                        </button>
                    </div>
                </div>

                <br />

                <div class="tile tile-centered">
                    <div class="tile-icon">
                        <div class="example-tile-icon">
                            <i class="icon icon-file centered"></i>
                        </div>
                    </div>
                    <div class="tile-content">
                        <div class="tile-title">.ZIP</div>

                        <?php

                        if (!extension_loaded('zip')) {
                            echo '<small class="tile-subtitle text-error">Disabled</small>';
                        } else {
                            echo '<small class="tile-subtitle text-success">Enabled</small>';
                        }

                        ?>
                    </div>
                    <div class="tile-action">
                        <button class="btn btn-link">

                            <?php

                            if (!extension_loaded('zip')) {
                                echo '<i class="icon icon-cross text-error"></i>';
                            } else {
                                echo '<i class="icon icon-check text-success"></i>';
                            }

                            ?>
                        </button>
                    </div>
                </div>

                <br />

                <div class="tile tile-centered">
                    <div class="tile-icon">
                        <div class="example-tile-icon">
                            <i class="icon icon-file centered"></i>
                        </div>
                    </div>
                    <div class="tile-content">
                        <div class="tile-title">allow_url_fopen</div>

                        <?php

                        if (ini_get('allow_url_fopen') != "1" && ini_get('allow_url_fopen') != 'On') {
                            echo '<small class="tile-subtitle text-error">Disabled</small>';
                        } else {
                            echo '<small class="tile-subtitle text-success">Enabled</small>';
                        }

                        ?>
                    </div>
                    <div class="tile-action">
                        <button class="btn btn-link">
                            <?php

                            if (ini_get('allow_url_fopen') != "1" && ini_get('allow_url_fopen') != 'On') {
                                echo '<i class="icon icon-cross text-error"></i>';
                            } else {
                                echo '<i class="icon icon-check text-success"></i>';
                            }

                            ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>