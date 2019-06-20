import http from "components/http/RequestBuilder";
import notifyError from "components/notify/notifyError";
import successHandler from "components/http/successHandler";

/**
 * Find User
 *
 * @returns {boolean}
 */
export function findUser() {
    const data = {uid: $('#sender').val(), name: $('#sender_name').val()};
    const user_template = $('#user_template').html();
    const insert_block = $('#sender_list');

    if (!data.uid.length && !data.name.length) {
        notifyError('Nothing to find!');
    } else {
        new http($(this).data('route'))
            .method('POST')
            .data(data)
            .success(response => {
                insert_block.html('');
                $(response.users).each(function (index, item) {
                    insert_block.closest('table').css('display', 'inline-table');
                    insert_block.append(user_template
                        .replace(/%user_id%/g, item.id)
                        .replace('%avatar%', item.avatar)
                        .replace('%pet_name%', item.user_pets.name)
                        .replace('%user_name%', item.first_name + ' ' + item.last_name)
                        .replace('%level%', item.xp)
                    );
                });
                successHandler(response);
            })
            .send();
    }
}
