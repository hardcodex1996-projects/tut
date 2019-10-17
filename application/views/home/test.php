<html>
<head>
    <title>Test</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<table class="table table-striped" style="width: auto">
    <thead>
    <tr>
        <?php
            function requireToVar($file,$pricing_data,$i){
                ob_start();
                require($file);
                return ob_get_clean();
            }

            foreach ($pricing_data['platforms_available'] as $e){
                echo '<td>'.$e.'</td>';
            }
        ?>
    </tr>
    <tbody>
        <tr>
            <?php
                for($i = 0; $i<sizeof($pricing_data['platforms_available']);$i++){
                    $html = '';
                    $html .= requireToVar(CURR_VIEW_PATH . "../partials/table.php",$pricing_data,$i);
                    echo '<td>' .$html. '</td>';
                }

            ?>
        </tr>
    </tbody>
    </thead>

</table>
</body>
</html>