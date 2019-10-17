<?php
?>
<table style="width: auto">
    <thead>
        <tr>
            <th>Symbol</th>
            <th>Step</th>
            <th>Max</th>
            <th>Available Liquidity</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach ($pricing_data['symbol_list'] as $symbol) { ?>
            <tr>
                <?php
                    if(isset($symbol['platforms'][$pricing_data['platforms_available'][$i]])){ ?>
                        <td><?php echo $symbol['name']?></td>
                        <td><?php echo $symbol['platforms'][$pricing_data['platforms_available'][$i]]['step']?></td>
                        <td><?php echo $symbol['platforms'][$pricing_data['platforms_available'][$i]]['max']?></td>
                        <td><?php echo $symbol['platforms'][$pricing_data['platforms_available'][$i]]['available_liquidity']?></td>
                <?php } else{?>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                  <?php  } ?>



            </tr>
    <?php } ?>
    </tbody>
</table>
