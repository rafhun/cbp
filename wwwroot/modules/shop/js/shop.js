function viewPicture(picture, features) {
    window.open(picture, '', features);
}

// Remove a single product from the cart
function deleteProduct(product_index) {
    quantityElement = document.getElementById('quantity-' + product_index);
    if (!quantityElement) return;
    if (!confirm(cx.variables.get('TXT_SHOP_CONFIRM_DELETE_PRODUCT', 'shop'))) return;
    quantityElement.value = 0;
    document.shopForm.submit();
}

function toggleOptions(productId, event) {
    cx.jQuery(event).toggleClass('active');
    if (document.getElementById('product_options_layer' + productId)) {
        if (document.getElementById('product_options_layer' + productId).style.display == 'none') {
            document.getElementById('product_options_layer' + productId).style.display = 'block';
        } else {
            document.getElementById('product_options_layer' + productId).style.display = 'none';
        }
    }
}

function mark_valid(elements) {
    if (elements.first().attr('type') == 'radio') {
        return elements.next('label').removeClass('error');
    }
    return elements.removeClass('error');
}
function mark_invalid(elements) {
    if (elements.first().attr('type') == 'radio') {
        return elements.next('label').addClass('error');
    }
    return elements.addClass('error');
}

function checkProductOption(objForm, productId, strAttributeIds) {
    // The list of Product Attribute IDs, joined by semicolons.
    var arrAttributeIds = strAttributeIds.split(/;/);
    // Assume that the selection is okay
    var is_valid_all = true;
    // Remember invalid or missing choices in order to prompt the user
    var arrAttributeIdFailed = new Array();
    var elType = '';
    // check each option
    for (i = 0; i < arrAttributeIds.length; i++) {
        var attribute_id = arrAttributeIds[i];

        // See if there is a hidden field marking the Attribute as mandatory
        element_mandatory = cx.jQuery('#productOption-' + productId + '-' + attribute_id);
        if (!element_mandatory.length) {
            continue;
        }
        // The name of the Product Attribute currently being processed.
        // Only set for attributes with mandatory choice:
        // Types 1 (Radiobutton), 3 (Dropdown menu),
        // 5 (mandatory text), 7 (mandatory file).
        option_name = element_mandatory.val();
        // get options from form
        elements_option = cx.jQuery('[id^="productOption-' + productId + '-' + attribute_id + '-"]');
        if (!elements_option.length) {
            continue;
        }
        var is_valid_element = false;
        // Verify value according to the 'attributeVerification' regex
        var re_verify = cx.jQuery('#attributeVerification-' + productId + '-' + attribute_id);
        var elType = null;
        elements_option.each(function(index, element) {
            elType = element.type;
            switch (elType) {
                case 'radio':
                    if (element.checked) {
                        is_valid_element = true;
                        return false;
                    }
                    break;
                case 'select-one':
                    if (element.value > 0) {
                        is_valid_element = true;
                        return false;
                    }
                    break;
                case 'text':
                case 'textarea':
                case 'file':
                    if (re_verify && re_verify.val()) {
                        if (RegExp(re_verify.val()).test(element.value)) {
                            is_valid_element = true;
                            return false;
                        }
                    } else {
                        is_valid_element = true;
                        return false;
                    }
                    break;
            }
        }); // each
        // If the option selection is invalid, so is the item
        if (is_valid_element == false) {
            is_valid_all = false;
            mark_invalid(elements_option);
            arrAttributeIdFailed.push(option_name);
        } else {
            mark_valid(elements_option);
        }
    } // end for
    if (is_valid_all == false) {
        msg = cx.variables.get('TXT_MAKE_DECISION_FOR_OPTIONS', 'shop') + ":\n";
        for (i = 0; i < arrAttributeIdFailed.length; ++i) {
            msg += "- "+arrAttributeIdFailed[i]+"\n";
        }
        if (document.getElementById('product_options_layer' + productId)) {
            document.getElementById('product_options_layer' + productId).style.display = 'block';
        }
        alert(msg);
        return false;
    }
    if (shopUseJsCart === undefined) {
        return true;
    }
    addProductToCart(objForm);
    return false;
}

function addProductToCart(objForm) {
//  objCart = {products:new Array(),info:{}};
    // Default to one product in case the quantity field is not used
    objProduct = {id: 0, options: {}, quantity: 1}; // Obsolete: ,title:'',info:{}
    productOptionRe = /productOption\[([0-9]+)\]/;
    updateProductRe = /updateProduct\[([0-9]+)\]/;
    updateProduct = '';

    // Collect basic product information
    for (i = 0; i < document.forms[objForm].getElementsByTagName('input').length; i++) {
        formElement = document.forms[objForm].getElementsByTagName('input')[i];
        if (typeof(formElement.name) != 'undefined') {
            if (formElement.name == 'productId')
                objProduct.id = formElement.value;
            if (formElement.name == 'productTitle')
                objProduct.title = formElement.value;
            if (formElement.name == 'productQuantity')
                objProduct.quantity = formElement.value;
            arrUpdateProduct = updateProductRe.exec(formElement.name);
            if (arrUpdateProduct != null)
                updateProduct = '&updateProduct=' + arrUpdateProduct[1];
        }
    }

    // Collect product options
    for (el = 0; el < document.forms[objForm].elements.length; ++el) {
        var formElement = document.forms[objForm].elements[el];
        arrName = productOptionRe.exec(formElement.getAttribute('name'));
        if (arrName != null) {
            optionId = arrName[1];
            switch (formElement.type) {
                case 'radio':
                    if (formElement.checked) {
                        objProduct.options[optionId] = formElement.value;
                    }
                    break;
                case 'checkbox':
                    if (formElement.checked) {
                        if (typeof(objProduct.options[optionId]) == 'undefined') {
                            objProduct.options[optionId] = new Array();
                        }
                        objProduct.options[optionId].push(formElement.value);
                    }
                    break;
                case 'select-one':
                    if(formElement.value != 0){
                        objProduct.options[optionId] = formElement.value;
                    }
                    break;
                case 'text':
                    if (formElement.value != '') {
                        objProduct.options[optionId] = formElement.value;
                    }
                    break;
                // File uploads are recognised automatically;
                // no need to add the option ID
                default:
                    break;
            }
        }
    }
// Optional:  to consistently show up-to-date contents of the cart *only*
//  hideCart();
    cx.jQuery.ajax(cx.variables.get('url', 'shop/cart')
        + '&r=' + Math.random()
        + updateProduct, {
        data: objProduct,
        dataType: 'json',
        success: shopUpdateCart
    });
    showUpdateMessage();
    return false;
}

function showUpdateMessage() {
    cx.jQuery('body').append('<div id="shop-product-added-info-wrapper" style="display: none;"><div id="shop-product-added-info-box">' +
        cx.variables.get('TXT_SHOP_PRODUCT_ADDED_TO_CART', 'shop') +
    '</div></div>'
)
    ;
    cx.jQuery('#shop-product-added-info-wrapper').fadeIn(200).delay(1000).fadeOut(200, function() {
        cx.jQuery(this).remove();
    });
}


// Timeout in ms
var popUpTimeout = 2000;

function showPopup(id) {
    var obj = document.getElementById(id);
    if (!obj) {
//alert('Cannot find element '+id);
        return;
    }
    obj.style.display = 'none';
    var width = parseInt(obj.style.width);
    var height = parseInt(obj.style.height);
    var left = centerX(width);
    var top = centerY(height);
    obj.style.left = left + 'px';
    obj.style.top = top + 'px';
    obj.style.display = '';
    setTimeout("hidePopup('"+id+"')", popUpTimeout);
}

function hidePopup(id) {
    var obj = document.getElementById(id);
    if (obj) {
        obj.innerHtml = '';
        obj.style.display = 'none';
    }
}

function centerX(width) {
    var x;
    if (self.innerWidth) {
        // all except Explorer
        x = self.innerWidth;
    } else if (
        document.documentElement
            && document.documentElement.clientWidth) {
        // Explorer 6 Strict Mode
        x = document.documentElement.clientWidth;
    } else {
        // other Explorers
        x = document.body.clientWidth;
    }
    return parseInt((x - width) / 2);
}

function centerY(height) {
    var y;
    if (self.innerHeight) {
        // all eycept Eyplorer
        y = self.innerHeight;
    } else if (
        document.documentElement
            && document.documentElement.clientHeight) {
        // Eyplorer 6 Strict Mode
        y = document.documentElement.clientHeight;
    } else {
        // other Eyplorers
        y = document.body.clientHeight;
    }
    return parseInt((y - height) / 2);
}