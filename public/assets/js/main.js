/**
* Template Name: DevFolio
* Template URL: https://bootstrapmade.com/devfolio-bootstrap-portfolio-html-template/
* Updated: Mar 17 2024 with Bootstrap v5.3.3
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/


jQuery(document).ready(function (){
  jQuery('#formContact').submit(function (e){
    e.preventDefault();
    var frm = document.getElementById('formContact');
    jQuery.ajax({
      method: 'POST',
      type: 'POST',
      url: '/' ,
      dataType: 'json',
      data: jQuery(this).serialize(),
      success: function (response){
        if (response.success){
          jQuery('.toast.ok-send').removeClass('hidden').show();
          jQuery('.toast.not-send').addClass('hidden').hide();
          setTimeout(function() {
            jQuery('.toast.ok-send').addClass('hidden').hide();
          }, 5000);
        }else {
          jQuery('.toast.not-send').find('.toast-body').text(response.message);
          jQuery('.toast.not-send').removeClass('hidden').show();
          jQuery('.toast.ok-send').addClass('hidden').hide();
          setTimeout(function() {
            jQuery('.toast.not-send').addClass('hidden').hide();
          }, 5000);
        }
        frm.reset();
      },
      error: function (){

      }
    })
  })
})
