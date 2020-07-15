/**
 * Short description. Provides some feature.
 *
 * Description javascript to load and handle custom endpoint
 */
var newele ='';
jQuery(document).ready(
    function () {
        jQuery('#inpsyde_hadi_check_button').on(
            'click', function () {
                btn = jQuery(this);
                container = jQuery('#endpoint_field_container');
                btn.prop('disabled',true);
                jQuery('#checkstatus_message').html('accessing address.... please wait');
                container.html('');
                newele ='';

                jQuery.getJSON(
                    jQuery('#endpoint_address').val(), function (response) {
                        jQuery('#checkstatus_message').html('');
                        btn.prop('disabled',false);
                        jQuery.each(
                            response[0], function (key, val) {
                                create_ele([ [], key, val ]);
                            }
                        );

                        container.append(newele);    

                        jQuery('#checkstatus').val(1);
                        jQuery('#submit-button').prop('disabled',false);
            
                    }
                ).fail(
                    function (jqXHR) {
                        if (jqXHR.status == 404) {
                            jQuery('#checkstatus_message').html('Address 404 Not Found');
                        } else {
                            jQuery('#checkstatus_message').html('Other non-handled error ');
                        }
                        btn.prop('disabled',false);
                        jQuery('#endpoint_address').select();
                    }
                );
            }
        );

        jQuery('#endpoint_address').on(
            'keyup',function (event) {
                if (event.keyCode === 13) { 
                    jQuery("#inpsyde_hadi_check_button").click(); 
                } 
                jQuery('#checkstatus').val(0);
                jQuery('#submit-button').prop('disabled',true);
            }
        );

    
        jQuery('#inpsydehadi_form').on(
            'submit',function () {
                if (jQuery('#checkstatus').val() == 0 ) {
                    return false;
                }
        
                if (jQuery('.parentfield:checked').length < 3 ) {
                    alert('Please select at least 3 field to display');
                    return false;
                }

                //tricky part :)

                var b = jQuery("input:checkbox:not(:checked)");
                jQuery(b).each(
                    function () {
                        jQuery(this).parent().append('<input type="hidden" name="'+jQuery(this).attr('name')+'" value="0">');
                    }
                );
                return true;
            }
        );
    }
);
 
function create_ele(ele)
{

    // generate parent
       parent_lists = setparent_ele(ele[0]);
       //
       classname = ( parent_lists[0] == '' ) ? 'parentfield' : '';
    newele += parent_lists[1] + '<input type="checkbox" class="'+classname+'" name="inpsydehadi_option[endpoint_field]'+parent_lists[0]+'['+ele[1]+'][status]" value="1">'+
                    '<input name="inpsydehadi_option[endpoint_field]'+parent_lists[0]+'['+ele[1]+'][display_name]" type="text" value="'+ele[1]+'" /><br>';

    if (typeof ele[2] === "object") {
        ele[0].push(ele[1]);
        jQuery.each(
            ele[2], function (key, val) {
                ele[2] = val;
                ele[1] = key;
                create_ele(ele);
            }
        );
    }
}

function setparent_ele(ele)
{
    parent = '';
    space = '';
    for ( i=0; i< ele.length; i++ ) {
        parent +=  "["+ele[i]+"]" + "[child]";
        space += ' &nbsp; &nbsp;  &nbsp; ';
    }
    return [ parent, space ];
}