<script type="text/javascript">
    var rdv_carrierID="{$rdv_carrierID|escape:'javascript'}";
    var rdv_carrierIntID="{$rdv_carrierIntID|escape:'javascript'}";

    {literal}
        $(function() {
    
            // Listener for selection of the chronordv carrier radio button
            $('input.delivery_option_radio, input[name=id_carrier]').click(function(e) {
                toggleRDVpane(cust_address_clean, cust_codePostal, cust_city, e);
            });


            // Prevent compatibility issues with Common Services' modules
            if($("#chronordv_container").length>0)
            {
                $('#chronordv_dummy_container').remove();
            } else {
                $('#chronordv_dummy_container').attr('id', 'chronordv_container');
            }

            // toggle on load
            toggleRDVpane(cust_address_clean, cust_codePostal, cust_city);

        });
    {/literal}
</script>



<div id="chronordv_dummy_container" class="">
    <table class="resume table table-bordered">
        <thead>
            <tr><th></th><th>Mercredi 03/11/14</th><th>Jeudi 04/11/14</th><th>Vendredi 05/11/14</th><th>Samedi 06/11/14</th><th>Dimanche 07/11/14</th><th>Lundi 08/11/14</th><th>Mardi 09/11/14</th></tr>
        </thead>
        <tbody>
            <tr><th>08 - 10H</th>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot" checked="checked" />17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
            </tr>
            <tr><th>09 - 10H</th>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
            </tr>
            <tr><th>10 - 12H</th>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
            </tr>
            <tr><th>12 - 14H</th>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
            </tr>
            <tr><th>14 - 16H</th>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
            </tr>
            <tr><th>16 - 18H</th>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
            </tr>
            <tr><th>18 - 20H</th>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
                <td><div class="radio">
                    <label>
                      <input type="radio" name="chronoRDVSlot"/>17,83&nbsp;€
                    </label>
                  </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>