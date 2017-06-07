$(function(){
   $(document).on('change', '#language', function() {
       var lang = $('#language :selected').val();
       $.post('site/language', {'lang':lang}, function(data) {
           location.reload();
       });
   });
});