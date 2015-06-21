<script type="text/javascript">
    var EM = {"location_post_type":"location"};
</script>
<div id="genarateMapDealer">
    <div id="em-location-data">
        <div id="location_coordinates" style="display: none;">
            <input id="location-latitude" name="location_latitude" value="0" size="15" type="text">
            <input id="location-longitude" name="location_longitude" value="0" size="15" type="text">
        </div>

        <table style="display: none;" class="em-location-data">
            <tbody>
                <tr>
                    <th>Location Name:</th>
                    <td>
                        <input id="location-id" name="location_id" value="" size="15" type="hidden">
                        <input aria-haspopup="true" aria-autocomplete="list" role="textbox" autocomplete="off" class="ui-autocomplete-input" id="location-name" name="location_name" type="text"><i>*</i>													
                        <br><em>Create a location or start typing to search a previously created location.</em>
                        <p id="em-location-reset" style="display:none;"><em>You cannot edit saved locations here. <a href="#">Reset this form to create a location.</a></em></p>
                    </td>
                </tr>
                <tr>
                    <th>Address:&nbsp;</th>
                    <td>
                        <input id="location-address" name="location_address" type="text" value=""><i>*</i>			</td>
                </tr>
                <tr>
                    <th>City/Town:&nbsp;</th>
                    <td>
                        <input id="location-town" name="location_town" type="text"><i>*</i>			</td>
                </tr>
                <tr>
                    <th>State/County:&nbsp;</th>
                    <td>
                        <input id="location-state" name="location_state" type="text">
                    </td>
                </tr>
                <tr>
                    <th>Postcode:&nbsp;</th>
                    <td>
                        <input id="location-postcode" name="location_postcode" type="text">
                    </td>
                </tr>
                <tr>
                    <th>Region:&nbsp;</th>
                    <td>
                        <input id="location-region" name="location_region" type="text">
                    </td>
                </tr>
                <tr>
                    <th>Country:&nbsp;</th>
                    <td>
                        <select id="location-country" name="location_country">
                            <option selected="selected" value="BD">Bangladesh</option>

                        </select><i>*</i>			
                    </td>
                </tr>
            </tbody>
        </table>    
    </div>
</div>

<div style="margin: 0;" class="content"> 
    <h1><?php echo "Total search item count: $total_result "; ?></h1>
</div>
<div class="showroomListAea">
    <?php
    if (!empty($dealer_list['dealer'])) {
        $number = 1;
        ?>
        <ul>
            <?php foreach ($dealer_list['dealer'] as $key => $value) { ?>
                <li>
                    <div class="addressInfo">
                        <p><strong><?php echo $value['title']; ?></strong></p> 
                        <p><?php echo $value['address']; ?></p>
                        <a onclick="genarate_map_dealer('<?php echo $value['id']; ?>');" class="viewMap" href="javascript:void(0);">View On Map</a>
                    </div>
                    <div class="contuctNumber">
                        <span>Telephone: <?php echo $value['telephone']; ?></span>
                        <span class="mobile">Mobile: <?php echo $value['mobile']; ?></span>
                    </div>
                </li>
                <?php if ($number % 2 == 0) { ?>
                    <li class="emptyRow">&nbsp;</li>
                    <li style="margin: 0;" class="emptyRow">&nbsp;</li>
                <?php } ?>
                <?php
                $number++;
            }
            ?>                 
        </ul>
    <?php } else { ?>
        <h4 style="margin: 0;">No item found !!!</h4>
    <?php } ?>
</div>
<!--showroomListAea-->
<script>
    $(document).ready(function(){
        $(".closemap").click(function(){
            location.reload();
        });
    });
</script>
