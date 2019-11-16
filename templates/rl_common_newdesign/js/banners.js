/*$(document).ready(function() {

    $('.metrica_celi').on('click', function() {
        yaCounter17123545.reachGoal('clickrightsidbarbanner');
        return true;
    });

});*/

var elements = document.querySelectorAll(".metrica_celi");
for (var i = 0; i < elements.length; i++) {
    elements[i].onclick = function(){
        yaCounter17123545.reachGoal('clickrightsidbarbanner');
        return true;
    };
}