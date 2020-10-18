$(document).ready(function() {
    $(".js-datepicker").datetimepicker({format: 'yyyy-mm-dd hh:ii'});

    $('#articleTable').DataTable({
        "order": [[ 2, "desc" ]], //or asc
        "columnDefs" : [{"targets":2, "type":"date-eu"}],
    });
    $('#videosTable').DataTable({
        "order": [[ 3, "desc" ]], //or asc
        "columnDefs" : [{"targets":3, "type":"date-eu"}],
    });

    $("#TechnologyTable, #playlistTable, #forumTable, #topicTable, #forumShowTable").DataTable();

    $('textarea.ckeditor').ckeditor();


});

hljs.initHighlightingOnLoad()

document.addEventListener('DOMContentLoaded', () => {
    // This is the bare minimum JavaScript. You can opt to pass no arguments to setup.
    const player = new Plyr('#player');

    // Expose
    window.player = player;

    // Bind event listener
    function on(selector, type, callback) {
        document.querySelector(selector).addEventListener(type, callback, false);
    }

    // Play
    on('.js-play', 'click', () => {
        player.play();
    });

    // Pause
    on('.js-pause', 'click', () => {
        player.pause();
    });

    // Stop
    on('.js-stop', 'click', () => {
        player.stop();
    });

    // Rewind
    on('.js-rewind', 'click', () => {
        player.rewind();
    });

    // Forward
    on('.js-forward', 'click', () => {
        player.forward();
    });
});

$.ajax({
    url: '/stats/forums',
    type: 'GET',
    dataType: 'json',
    success: function (data) {

        var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: data['label'],
                datasets: [{
                    data: data['numberTopic'],
                    backgroundColor: data['color'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },

        });
    },
    error: function () {
        alert("Erreru serveur !")
    }
})
