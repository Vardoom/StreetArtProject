$(document).ready(function(){
    
    $("div.zoneTexteAfficherMasquer").each(function(i) {
        $(this).find("div.TexteAAfficher").attr("id","TexteAAfficher"+(i+1)).hide();
        $(this).find("span.inviteClic").attr("statut","1").attr("id","inviteClick"+(i+1)).click(function(){
            $("#TexteAAfficher"+(i+1)).toggle();
            if($("#inviteClic"+(i+1)).attr("statut"=="1")){
                $("#inviteClic"+(i+1)).attr("statut","0").html("Reponse"+(i+1));
            }
            else{
                $("#inviteClic"+(i+1)).attr("statut","1").html("Question"+(i+1));
            }
        });
});
});