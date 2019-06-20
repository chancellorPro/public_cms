import observer from "components/observer/EventObserver";
import {AWARD_CREATE} from "modules/award/constants";

export default function () {
    observer.subscribe(AWARD_CREATE, (data, self) => {
        observer.unsubscribe(AWARD_CREATE, self);

        const currentBtn = $(this);
        const saveAssetBtn = currentBtn.closest('tr').find('.save-asset');
        const editBtn = $('#' + this.dataset.templateId)
            .html()
            .replace( new RegExp(this.dataset.templatePlaceholder, "g"), data.award_id);

        currentBtn.parent().append(editBtn);
        currentBtn.remove();

        saveAssetBtn.click();
    });
}
