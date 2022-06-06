$(document).ready(function(){
    $.ajax({
      url: "http://localhost/wordlabwebapp/loginSystem/data.php",
      method: "GET",
      success: function(data) {
        console.log(data);
        var topic = [];
        var enrolled = [];
  



        for(var i in data) {
          topic.push(data[i].month) ;
          enrolled.push(data[i].pass_percentage);
        }
  
        var chartdata = {
          labels: topic,
          datasets : [
            {
              label: 'Progress',
              backgroundColor: 'rgba(200, 200, 200, 0.75)',
              borderColor: 'rgba(200, 200, 200, 0.75)',
              hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
              hoverBorderColor: 'rgba(200, 200, 200, 1)',
              data: enrolled
            }
          ]
        };
  
        var ctx = $("#mycanvas");
  
        var barGraph = new Chart(ctx, {
          type: 'line',
          data: chartdata
        });
      },
      error: function(data) {
        console.log(data);
      }
    });
  });