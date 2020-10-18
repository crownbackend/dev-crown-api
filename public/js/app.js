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

var forums = []
var topics = []


$.ajax({
    url: '/stats/forums',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
         $.each(data, function (i, k) {
             forums.push(k.name)
             topics.push(k.topics.length)
         })
        var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: forums,
                datasets: [{
                    data:topics,
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },

        });
    },
    error: function () {
        alert("Erreru serveur !")
    }
})

