$( document ).ready(function() {
	if(lt) {
		setInactive();
		$("#shipping_table").append("<tr><td></td><td></td><td></td><td></td><td></td>"
		+"<td colspan=\"2\"><a class=\"cancelSkybill\" href=\"\">Annuler cet envoi</a></td></tr>");
	}

	$("#chronoSubmitButton").on('click', function(e) {
		if(lt) {
	  		e.preventDefault();
	  		document.location.href=path+"/skybills/"+lt+".pdf";
	  		return false;
	  	}

  		$(this).prop('disabled', true);
  	});

  	$(".cancelSkybill").on('click', function(e) {
  		e.preventDefault();
  		if(confirm("Êtes-vous sûr de vouloir annuler cet envoi ? La lettre de transport associée sera inutilisable.")) {
  			$.post(path+"/async/cancelSkybill.php", { skybill: lt, shared_secret: chronopost_secret}).done( function( data ) {
  				location.reload();
			});
  		}
  	});
});

function setInactive() {
	$("#chronoSubmitButton").val("Ré-imprimer l'étiquette Chronopost");
}