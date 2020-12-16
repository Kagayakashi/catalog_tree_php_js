// Отключение RESUBMITING POST FORM для кнопок с формой

if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
