const WALK_CATEGORY = '6';
const RUN_CATEGORY ='7';

$(document)

    .ready(function() {
        const select2 = $('.table').find('.embed-group select.select2');
        let selectVal = 0;
        select2.each(function (n, i) {
            selectVal = $(i).val();
            if(selectVal === WALK_CATEGORY || selectVal === RUN_CATEGORY) {
                $(i).closest('.embed-group').find('.embed-group').find(".row:eq(1)").show();
            } else {
                $(i).closest('.embed-group').find('.embed-group').find(".row:eq(1)").hide();
            }
        })
    })

    /**
     * Show hide speed on trigger add-embed button
     */
    .on('ai_animation', '.add-embed', function () {
        const embed = $(this).closest('.embed-group');
        const selectVal = embed.find('.select2').val();
        if(selectVal === WALK_CATEGORY || selectVal === RUN_CATEGORY) {
            embed.find('.embed-group').find(".row:eq(1)").show();
        } else {
            embed.find('.embed-group').find(".row:eq(1)").hide();
        }
    })

    /**
     * Show hide speed
     */
    .on('.select2').change(function (item) {
        const selectVal = $(item.target).val();
        if(selectVal === WALK_CATEGORY || selectVal === RUN_CATEGORY) {
            $(item.target).closest('.embed-group').find('.embed-group').find(".row:eq(1)").show();
        } else {
            $(item.target).closest('.embed-group').find('.embed-group').find(".row:eq(1)").hide();
        }
    });
