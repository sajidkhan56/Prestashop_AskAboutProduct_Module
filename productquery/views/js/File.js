//Show form to the user
$(document).ready(function(){
  //to remove hidden from form
 $("button").click(function(){
    p = document.getElementById('form');
    p.removeAttribute("hidden");
  });
 //for accordion
 $('.accordion').on('click', function(){
    $(this).toggleClass('active');
    if ($('#form').css('display') == 'block') {
        $('#form').hide();
    } else {
        $('#form').show();
    }
  });
 //for show and disable button
  var count = 0;
  $("#check").click(function(){
    count++;
    p = document.getElementById('btnsubmit');
    p.removeAttribute("disabled");

    if(count > 1 && count % 2 == 0)
    {
      $("#btnsubmit").attr("disabled", true);
          
    }  else{

      p = document.getElementById('btnsubmit');
      p.removeAttribute("disabled");
    }
  });
  //validation on number
  $(".num").keypress(function() {
    if ($(this).val().length == $(this).attr("maxlength")) {
        return false;
    }
  });
  //for validation
  $('input.text').on('keypress', function (event) {
    var regex = new RegExp("^[a-zA-z0-9 ]*$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
       event.preventDefault();
       return false;
    }
  });
  //for validation
  $('textarea.tarea').on('keypress', function (event) {
    var regex = new RegExp("^[a-zA-z0-9 ]*$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
       event.preventDefault();
       return false;
    }
  });
  //ajax call
  $("#btnsubmit").click(function(event){
    event.preventDefault();
    var question = $('#tarea').val();
    var name = $('#text').val();
    var email = $('#email').val();
    var number = $('#number').val();
    var check = $('#check').val();

    if(question == "" || name == "" || email == "" || number == "" || $('input[type=checkbox]:checked').length == 0) {
      alert('All fields are required');
    }
    else {
      $.ajax({
        url: mylink,
        type: "POST",
        data:  $('#formdata').serialize(),
        success: function(msg) {
        alert("submit successfully");
        }
      });
    } 
  });
});
