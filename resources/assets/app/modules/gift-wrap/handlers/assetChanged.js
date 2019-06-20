import errorHandler from "components/http/errorHandler";

/**
 * Asset ID changed
 */
export default function () {
    const currentInput = $(this);
    const assetID = currentInput.val();
    const parent = currentInput.closest('tr');

    /**
     * Check duplicated assets ids
     */
    const currentAssetDuplicate = $('#gift-wraps-container').find('.asset-id').filter((_, item) => {
        return assetID === item.value;
    });

    if (currentAssetDuplicate.length > 1){
        errorHandler({'message': 'Duplicate asset ' + assetID});
        return false;
    }

    /**
     * Update inputs names
     */
    parent.find('input').each(function () {
        this.name = this.name.replace( /\[[\d]+\]/g, `[${assetID}]`);
    });

    /**
     * Update href of the delete button
     */
    parent.find('.ajax-confirm-action-custom').each(function () {
        this.href = this.href.replace( /\/[\d]+$/g, `/${assetID}`);
    });
}
