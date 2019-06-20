import Cleave from "cleave.js";

/**
 * Price init
 */
export default function() {
    new Cleave(this, {
        numeral: true,
        prefix: '$ ',
        rawValueTrimPrefix: true,
        onValueChanged: function (e) {
            let value = parseInt(parseFloat(e.target.rawValue) * 100);
            let productPrice = $(this.element).closest('td').find('.product-price');

            if (value !== parseInt(productPrice.val())) {
                productPrice
                    .val(value)
                    .change();
            }
        }
    });
}