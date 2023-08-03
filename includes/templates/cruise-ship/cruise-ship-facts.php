<?php

if ($ship->ship_facts) {
    
    /*echo '<pre>';
    print_r($ship->ship_facts);
    echo '<?pre>';*/

?>

<section id="ship-facts">
    <div class="row">
        <div class="col-md-12 no-padding">
            <div class="container-fluid no-padding cruise-ship-facts">
                <h3>Ship Facts</h3>
                
                <table class="table">
                
                <?php foreach($ship->ship_facts as $key => $value) { 
                        
                        if (isset($value) && $value != '') { ?>
                    
                    <tr>
                        <td><strong><?php echo ucfirst(str_replace('_', ' ', $key)); ?></strong></td>
                        <?php if ($key == 'electrical_plugs') { ?>
                            <td>
                                <?php foreach($value as $k => $v) {
                                        $v = $ship->maybe_add_suffix($k, $v);
                                        echo '<strong>' . esc_html(str_replace('_', ' ', $k)) . ': </strong><br />';
                                        
                                        if (is_array($v) || is_object($v)) {
                                            foreach($v as $i ) {
                                                echo esc_html($ship->maybe_add_suffix($v, $i)) . '<br />';
                                            }
                                        } else {
                                            echo esc_html($v);
                                        }
                                      } ?>
                        
                            </td>
                        <?php } else { ?>
                        
                                <td><?php echo esc_html($ship->maybe_add_suffix($key, $value)); ?></td>
                        <?php } ?>
                    </tr>
                
                <?php   }
                      } ?>
                
                </table>
            </div>
        </div>
    </div>
</section>

<?php } ?>