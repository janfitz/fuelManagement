// Clear Request
function clearRequest() {
  window.location.replace("index.php");
}

// Manage add new record show panel
$(document).ready(function(){
  $(".form_class").hide();
  $(".addRecord").show();
  $('.addRecord').click(function(){
    $(".form_class").slideToggle();
  });
});

// Manage modal for delete record
$(document).on("click", ".modalDeleteRecord", function () {
  var id = $(this).data('id');
  $(".modal-footer #inputDeleteID").val(id);
  $(".modal-content #recordIDdelete").text(id);
});

// Manage modal for edit record
$(document).on("click", ".modalEditRecord", function () {
  var id = $(this).data('id');
  $(".modal-content #recordIDedit").text(id);
});

// Complete field with overall price
function countOverallPrice() {
  document.getElementById("overallPriceID").value = document.getElementById("pricePerLiterID").value * document.getElementById("litersID").value;
}

// Datepicker function
$(document).ready(function(){
  var date_input=$('input[name="date"]'); //our date input has the name "date"
	var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
	date_input.datepicker({
	   format: 'yyyy-mm-dd',
     container: container,
     todayHighlight: true,
		 autoclose: true,
  })
});
