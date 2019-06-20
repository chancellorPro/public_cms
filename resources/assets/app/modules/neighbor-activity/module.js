import awardCreate from "listeners/awardCreate";
import awardDelete from "listeners/awardDelete";
import changeType from './handlers/changeType';
import showForm from "./listeners/showForm";

$(document)
    .on('click', '.award-create-button', awardCreate)
    .on('click', '.award-delete-button', awardDelete)
    .on('change', '.neighbor-activity-type', changeType);

/**
 * Run the show form handler.
 * After click at create or edit button
 */
$('.show-form')
    .click(showForm);
