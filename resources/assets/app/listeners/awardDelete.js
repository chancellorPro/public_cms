import observer from "components/observer/EventObserver";
import {AWARD_DELETE} from "modules/award/constants";

export default function () {
    observer.subscribe(AWARD_DELETE, (data, self) => {
        observer.unsubscribe(AWARD_DELETE, self);

        const createBtn = $('#' + this.dataset.templateId).html();
        const parent = $(this).parent();

        parent.children().remove();
        parent.append(createBtn);
    });
}
