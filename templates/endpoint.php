<?php
/**
 * PHP version 7
 *
 * Inpsydehadi front end page
 *
 * front end page to display custom end point Settings .
 *
 * @file endpoint
 *
 * @category  Custom
 * @package   Inpsydehadi
 * @author    Hadi Budiman <hadibudiman@gmail.com>
 * @copyright 2020 Hadi Budiman
 * @license   http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0-or-later
 * @link      http://hadibudiman.site/
 *
 * @wordpress-plugin
 * Plugin Name: Inpsydehadi
 * Plugin URI:  http://hadibudiman.site/
 * Description: test plugin
 * Version:     1.0.0
 * Author:      Hadi Budiman
 * Author URI:  http://hadibudiman.site/
 * License:     GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: Inpsydehadi
 */

defined('ABSPATH') || exit;
?>
<div class="endpointwrap">
<p id="endpointaddress"> </p>
    <table id="endpoint_table">
        <thead>
            <tr></tr>
        </thead>
        <tbody>
            <tr><td colspan="10">requesting data.... please wait!</td></tr>
        </tbody>
    </table>
</div>

<!-- The Modal -->
<div id="detailModal" class="inpsyde_hadi_modal">

  <!-- Modal content -->
  <div class="inpsyde_hadi_modal_content">
    <span class="inpsyde_hadi_modalclose">&times;</span>
    <h5>Details</h5>
    <div id="inpsyde_hadi_endpoint_content"></div>
  </div>

</div>
<script>

var modal = jQuery("#detailModal");


jQuery(".inpsyde_hadi_modalclose").on('click',function() {
    modal.removeClass("inpsyde_hadi_show");
});

jQuery(window).on('click',function(event) {
    target = jQuery( event.target );
    if (target.attr('id') == modal.attr('id')) {
        modal.removeClass("inpsyde_hadi_show");
    }
});


var endpointdata;
jQuery(document).ready(function() {
    jQuery("#endpointaddress").html(
        '<strong>endpoint address:</strong> '+ endpoint_address
        );
    jQuery.each(endpoint_field,function(key, val){
        if (val.status==1) {
            jQuery("#endpoint_table thead tr").append(
                '<th>'+val.display_name+'</th>'
                );
        }
    });
    
    jQuery.getJSON(endpoint_address, function(response) {
            jQuery("#endpoint_table tbody tr").remove();
            endpointdata = response;
            jQuery.each(response, function(k1, v1){

                let new_ele="";
                jQuery.each(v1, function(k, v){
                    jQuery.each(endpoint_field,function(key, val){

                        if (key==k && val.status==1) {
                            new_ele += '<td valign="top"> '+
                                '<a href="#" class="endpoint_details">';
                            if (  typeof v === "object") {
                                new_ele += child_element(v,val.child);
                            } else {
                                new_ele += v;
                            }
                            new_ele += '</a></td>';
                        }
                    });

                });
                
                jQuery("#endpoint_table tbody").append(
                    '<tr id="'+k1+'">'+new_ele+'</tr>'
                    );
            });
            
    });
    function child_element(obj,tgt) {
        element = "";
        jQuery.each(obj, function(key, val){
            jQuery.each(tgt,function(k, v){

                if (key==k) {
                    element += key +': ' ;
                    if (  typeof val === "object") {
                        element += '<br><div class="custom_endpoint_chld">'+
                            child_element(val,v.child)+'</div>';
                    } else {
                        element += val;
                    }        
                     element +='<br>';
                }
            
            });
        });
        return element;
    }
    var generated_data;
    // When the user clicks the button, open the modal 
    jQuery(document).on('click', 'a.endpoint_details', function() {

        //console.log( endpointdata[jQuery(this).parents('tr').attr('id')] );
        data = endpointdata[ jQuery(this).parents('tr').attr('id') ];
        html = '<table width="100%">';
        jQuery.each(data, function(key, val){
            html += '<tr><td width="30%" valign="top">'+key+'</td>';
            html += '<td >';
            if (typeof val === "object") {
                html += getdata(val);
            } else {
                html += val;
            }
            html += '</td>';
        });
        html +='</table>';
        jQuery('#inpsyde_hadi_endpoint_content').html(html);
        modal.addClass('inpsyde_hadi_show');
        return false;
    });
        
    function getdata(data) {
        element = "";
        jQuery.each(data, function(key, val){
                element += key +': ' ;
                    if (  typeof val === "object") {
                        element += '<br>'+getdata(val);
                    } else {
                        element += val;
                    }
                element +='<br>';
        });
        return element
    }
});
</script>
