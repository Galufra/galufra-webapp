function showMessage(message){
    $('#messagebox').stop(true).hide().text(message)
    .fadeIn('slow')
    .delay(1300)
    .fadeOut('slow');
}
