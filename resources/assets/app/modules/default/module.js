$(document).ready(function(){
    $('#common-menu').find('.common-menu-section').each(function () {
          if($(this).find('li').length === 0) {
              $(this).closest('.common-menu-section').hide()
          }
    });
});
