import awardCreate from "listeners/awardCreate";
import awardDelete from "listeners/awardDelete";
import showForm from "./listeners/showForm";

$(document)
    .on('click', '.award-create-button', awardCreate)
    .on('click', '.award-delete-button', awardDelete);

/**
 * Run the show form handler.
 * After click at create or edit button
 */
$('.show-form')
    .click(showForm);
