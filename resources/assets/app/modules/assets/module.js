import awardCreate from "./listeners/awardCreate";
import awardDelete from "./listeners/awardDelete";
import changeType from "./handlers/changeType";
import getLastCollectionNumber from "./handlers/getLastCollectionNumber";

$('#assets-table')
    .on('click', '.award-create', awardCreate)
    .on('click', '.award-delete', awardDelete);

$('#asset-form-type')
    .change(changeType)
    .change();

$('#get-last-collection-number').click(getLastCollectionNumber);
