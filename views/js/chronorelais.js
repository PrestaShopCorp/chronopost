/**
  * MODULE PRESTASHOP OFFICIEL CHRONOPOST
  * 
  * LICENSE : All rights reserved - COPY AND REDISTRIBUTION FORBIDDEN WITHOUT PRIOR CONSENT FROM OXILEO
  * LICENCE : Tous droits réservés, le droit d'auteur s'applique - COPIE ET REDISTRIBUTION INTERDITES SANS ACCORD EXPRES D'OXILEO
  *
  * @author    Oxileo SAS <contact@oxileo.eu>
  * @copyright 2001-2015 Oxileo SAS
  * @license   Proprietary - no redistribution without authorization
  */

String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}


function toggleRelaisMap(cust_address, codePostal, city, e)
{
    if($("input.delivery_option_radio:checked").val()==carrierID+"," || $("input[name=id_carrier]:checked").val()==carrierIntID) 
    {
        if(typeof e != "undefined") {
            e.stopPropagation();
        }
        // Show Chronorelais controls
        $('#chronorelais_container').show();
        initRelaisMap(cust_address, codePostal, city);
        $.scrollTo($('#chronorelais_container'), 800);
        return false;
    }

    // Hide Chronorelais controls
    $('#chronorelais_container').hide();

};


function initRelaisMap(cust_address, codePostal, city)
{
    relais_map=mapInit();
    initRelaisMarkers(cust_address, codePostal, city);
};


function mapInit() {
    var myOptions = {
        // minimal to let the API do the heavy lifting
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        zoom: 14 // must be set, not used afterwards (cf fitBounds)
    }

    return new google.maps.Map(document.getElementById("chronorelais_map"), myOptions);
};


function associateRelais(relaisID)
{
    $.ajax({
        url: path+'/async/storePointRelais.php?relaisID='+relaisID+'&cartID='+cartID+'&customerFirstname='+cust_firstname+'&customerLastname='+cust_lastname
    });    
}

function createHomeMarker(address)
{
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode( { "address": address}, function(results, status) {
        latlngbounds.extend(results[0].geometry.location);
        if (status == google.maps.GeocoderStatus.OK) {
            new google.maps.Marker({
                map: relais_map,
                position: results[0].geometry.location,
                icon:path+'/views/img/home.png'
            }); // end marker
        } // end status
    }); // end geocode callback
};

function createAllPointRelais(json)
{
    var htmlForTxtSection='';
    var ldata=JSON.parse(json);
    if(ldata==null)
    {

        if(oldCodePostal!=null) 
        {
            alert('Code postal erroné, merci de saisir un code postal valide.');
            // init with original zipcode
            codePostal=oldCodePostal;
            cust_address=codePostal+", France";
            $('#relais_codePostal').val(codePostal);
            oldCodePostal=null;
            initRelaisMap(cust_address, codePostal);
        } else 
        {
            alert('Code postal erroné, merci de modifier le code postal dans votre adresse de livraison.');
            // init with original zipcode
            codePostal="75001";
            cust_address=codePostal+", France";
            $('#relais_codePostal').val(codePostal);
            oldCodePostal=null;
            initRelaisMap(cust_address, codePostal);
        }
        return;
    }
    for(var i=0;i<ldata.length;i++)
    {
        createRelaisMarker(ldata[i]);
        chronodata[ldata[i].identifiantChronopostPointA2PAS]=ldata[i];

        htmlForTxtSection+='<div class="checkbox"><label><input type="radio" name="chronorelaisSelect" id="bt'
            +ldata[i].identifiantChronopostPointA2PAS+'" value="'
            +ldata[i].identifiantChronopostPointA2PAS+'"';
        if(i==0) {
            htmlForTxtSection+=" checked";
        }

        htmlForTxtSection +='/>'+ldata[i].identifiantChronopostPointA2PAS+'"> '+ldata[i].nomEnseigne
            +' - '+ldata[i].adresse1+' - '+ldata[i].codePostal+' '+ldata[i].localite+'</label></div>';
    }

    $('#relais_txt').html(htmlForTxtSection);
    associateRelais(ldata[0].identifiantChronopostPointA2PAS);

    // Listener for BT select in radio list
    $('input[name="chronorelaisSelect"]').change(function() {
        var btid=$('input[name="chronorelaisSelect"]:checked').val();
        associateRelais(btid);
        openBTMarker(btid);

    });


    relais_map.fitBounds(latlngbounds);
};

var days={1:"lundi", 2:"mardi", 3:"mercredi", 4:"jeudi", 5:"vendredi", 6:"samedi", 7:"dimanche"};

function createAllPointRelais2(json)
{
    var htmlForTxtSection='';
    var ldata=JSON.parse(json);
    if(ldata.errorCode!=0)
    {
        alert('Code postal erroné, merci de modifier le code postal dans votre adresse de livraison.');
        // init with original zipcode
        codePostal="75001";
        cust_address=codePostal+", France";
        $('#relais_codePostal').val(codePostal);
        oldCodePostal=null;
        initRelaisMap(cust_address, codePostal);

        return;
    }

    ldata=ldata.listePointRelais;

    for(var i=0;i<ldata.length;i++)
    {
         
        // COMPAT WITH OLD RECHERCHEBT
        ldata[i].identifiantChronopostPointA2PAS=ldata[i].identifiant;
        ldata[i].nomEnseigne=ldata[i].nom;
        ldata[i].coordGeoLatitude=ldata[i].coordGeolocalisationLatitude;
        ldata[i].coordGeoLongitude=ldata[i].coordGeolocalisationLongitude;

        createRelaisMarker(ldata[i]);

        chronodata[ldata[i].identifiant]=ldata[i];

        htmlForTxtSection+='<div class="checkbox"><label><input type="radio" name="chronorelaisSelect" id="bt'
            +ldata[i].identifiant+'" value="'
            +ldata[i].identifiant+'"';
        if(i==0) {
            htmlForTxtSection+=" checked";
        }

        htmlForTxtSection +='/> '+ldata[i].nomEnseigne
            +' - '+ldata[i].adresse1+' - '+ldata[i].codePostal+' '+ldata[i].localite+'</label></div>';
    }


    $('#relais_txt').html(htmlForTxtSection);
    associateRelais(ldata[0].identifiantChronopostPointA2PAS);

    // Listener for BT select in radio list
    $('input[name="chronorelaisSelect"]').change(function() {
        var btid=$('input[name="chronorelaisSelect"]:checked').val();
        associateRelais(btid);
        openBTMarker(btid);
    });

    relais_map.fitBounds(latlngbounds);
};



function initRelaisMarkers(address, cp, city)
{

    // as well as home marker
    latlngbounds= new google.maps.LatLngBounds();

    if(typeof(city)==='undefined') {
        $.ajax({
            url: path+'/async/getPointRelais2.php?city=unknown&codePostal='+cp,
            success: createAllPointRelais2
        });

        createHomeMarker(address);
    }
    else  {
        $.ajax({
            url: path+'/async/getPointRelais2.php?codePostal='+cp+'&address='+address+'&city='+city,
            success: createAllPointRelais2
        });

        createHomeMarker(address+" "+cp+" "+city);
    }
};



function createRelaisMarker(chronodata)
{
    var pos=new google.maps.LatLng(chronodata.coordGeoLatitude, chronodata.coordGeoLongitude);
    latlngbounds.extend(pos);
    map_markers[chronodata.identifiantChronopostPointA2PAS]=new google.maps.Marker({
        map: relais_map,
        position: pos,
        icon:path+'/views/img/postal.png'
    });

    // link infowindow to marker
    google.maps.event.addListener(map_markers[chronodata.identifiantChronopostPointA2PAS], 'click',
        function() {openBTMarker(chronodata.identifiantChronopostPointA2PAS);});
};

function openBTMarker(btID) {
    console.log("Hello");

    if (infowindow) infowindow.close();
    var iwcontent='';

    // create infowindow

    if(typeof(chronodata[btID].horairesOuvertureLundi)==='undefined')
    {
        iwcontent='<div class="pointRelais"><h4>'
            +chronodata[btID].nomEnseigne+'</h4><class="address">'+chronodata[btID].adresse1+'<br/ >'+chronodata[btID].codePostal
            +' '+chronodata[btID].localite+'</p><h5>Horaires d\'ouverture</h5><table><tbody>';

        for(var i=0; i<chronodata[btID].listeHoraireOuverture.length;i++)
        {
            var day=chronodata[btID].listeHoraireOuverture[i];
            iwcontent+='<tr class="first_item item"><td>'+days[day.jour].capitalize()+'</td><td>'
            +day.horairesAsString+'</td></tr>';

        }

        iwcontent+='</tbody></table>'
        +'<p class="text-right"><input type="hidden" name="btID" value="'+chronodata[btID].identifiantChronopostPointA2PAS
        +'"/><a class="button_large btselect" href="javascript:;" class="pull-right">Sélectionner »</a></p>'
        +'</div>';
    } else {
        iwcontent='<div class="pointRelais"><h4>'
            +chronodata[btID].nomEnseigne+'</h4><class="address">'+chronodata[btID].adresse1+'<br/ >'+chronodata[btID].codePostal
            +' '+chronodata[btID].localite+'</p><h5>Horaires d\'ouverture</h5><table><tbody>'
            +'<tr class="first_item item"><td>Lundi</td><td>'
            +(chronodata[btID].horairesOuvertureLundi=='00:00-00:00 00:00-00:00'?'Fermé':chronodata[btID].horairesOuvertureLundi)
            +'</td></tr><tr class="alternate_item"><td>Mardi</td><td>'
            +(chronodata[btID].horairesOuvertureMardi=='00:00-00:00 00:00-00:00'?'Fermé':chronodata[btID].horairesOuvertureMardi)
            +'</td></tr><tr class="item"><td>Mercredi</td><td>'
            +(chronodata[btID].horairesOuvertureMercredi=='00:00-00:00 00:00-00:00'?'Fermé':chronodata[btID].horairesOuvertureMercredi)
            +'</td></tr><tr class="alternate_item"><td>Jeudi</td><td>'
            +(chronodata[btID].horairesOuvertureJeudi=='00:00-00:00 00:00-00:00'?'Fermé':chronodata[btID].horairesOuvertureJeudi)
            +'</td></tr><tr class="item"><td>Vendredi</td><td>'
            +(chronodata[btID].horairesOuvertureVendredi=='00:00-00:00 00:00-00:00'?'Fermé':chronodata[btID].horairesOuvertureVendredi)
            +'</td></tr><tr class="alternate_item"><td>Samedi</td><td>'
            +(chronodata[btID].horairesOuvertureSamedi=='00:00-00:00 00:00-00:00'?'Fermé':chronodata[btID].horairesOuvertureSamedi)
            +'</td></tr><tr class="last_item item"><td>Dimanche</td><td>'
            +(chronodata[btID].horairesOuvertureDimanche=='00:00-00:00 00:00-00:00'?'Fermé':chronodata[btID].horairesOuvertureDimanche)
            +'</td></tr></tbody></table>'
            +'<p class="text-right"><input type="hidden" name="btID" value="'+chronodata[btID].identifiantChronopostPointA2PAS
            +'"/><a class="button_large btselect" href="javascript:;" class="pull-right">Sélectionner »</a></p>'
            +'</div>';
    }
    infowindow = new google.maps.InfoWindow({
        content: iwcontent
    });

    infowindow.open(relais_map,map_markers[btID]);
};

// Triggered on BT select from InfoWindow
function btSelect(target, e) {
    var btID=$(this).parent().children('input').val();
    var mObj=$('#relais_txt input[value='+btID+']');
    mObj.click();
    associateRelais(btID);
    $.scrollTo(mObj);
};
