import awardCreate from "listeners/awardCreate";
import awardDelete from "listeners/awardDelete";
import dropZoneInit from "listeners/dropZoneInit";
import {PRODUCT_SHOW_FORM} from "modules/product/constants";
import priceInit from "modules/product/handlers/priceInit";

$(document)
    .on('click', '.award-create-button', awardCreate)
    .on('click', '.award-delete-button', awardDelete);

/**
 * Preview Image (DropZone init)
 */
$('.show-form').click(dropZoneInit(PRODUCT_SHOW_FORM));

/**
 * Price format
 */
$('.product-price-view').each(priceInit);
