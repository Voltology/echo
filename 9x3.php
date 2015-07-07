<!DOCTYPE html>
<html>
  <head>
    <title>#BMA15 Echo</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="css/styles-led-9x3.css" />
    <link rel="stylesheet" href="css/font-awesome.css" />
    <script src="js/jquery.js"></script>
    <script>
      var ajax = {
        get : function(url, query, callback) {
          jQuery.ajax({
            type: 'POST',
            url: url,
            data: query,
            dataType: 'json',
            success: function(response) {
              callback(response);
            }
          });
        }
      };
      var rotation = ['flipped-vertical-bottom', 'flipped-vertical-top', 'flipped-horizontal-left', 'flipped-horizontal-right'];
      $(window).ready(function() {
        var $grid = $('#grid');
        //LED 9x3
        for (var i = 1; i <= 27; i++) {
        //LED 5x3
        //for (var i = 1; i <= 15; i++) {
        //WAVE 3x2
        //for (var i = 1; i <= 6; i++) {
        //WAVE 2x1
        //for (var i = 1; i <= 2; i++) {
          var rand = Math.floor(Math.random() * 2) + 1;
          $grid.append('<li id="panel' + i + '"></li>');
        }
        getData();
        randFlip();
        loadSponsor();
      });
      var data;
      function getData() {
        ajax.get('api/v0.1/', '&Method=GetData', function(response) {
          data = response.social;
          $('#instagram-count').html(response.instagram_count);
          $('#twitter-count').html(response.twitter_count);
        });
        setTimeout(function() {
          getData();
        }, 60000);
      }

      function flipPanel(id) {
        var $panel = $('#' + id);
        var random = Math.floor(Math.random() * (3 - 0 + 1));
        var animation = rotation[random];
        $panel.addClass('animated ' + animation);
        setTimeout(function() {
          var bgcolors = ['ffffff', 'ee2e24', '465260'];
          var rand = bgcolors[Math.floor(Math.random() * bgcolors.length)];
          $panel.css({
            'background-color' : '#' + rand,
            'background-image' : 'none',
            'visibility' : 'visible'
          });
          if (rand === 'ffffff') {
            $panel.css('color', '#000');
            $panel.css('text-shadow', 'none');
          } else {
            $panel.css('color', '#fff');
            $panel.css('text-shadow', '2px 2px 2px rgba(50, 50, 50, 1)');
          }
          var social = data[Math.floor(Math.random() * data.length)];
          if (social.type === 'instagram' || social.type === 'photobooth') {
            $panel.css('background-image', 'url(' + social.text + ')');
            //Uncomment for LED and WAVE
            $panel.css('background-size', '100%');
            $panel.css('color', '#fff');
            $panel.css('text-shadow', '2px 2px 2px rgba(0, 0, 0, 1)');
            $panel.html('<span class="author">@' + social.username + '</span><span class="social-icon"><i class="fa fa-' + social.type + '"></i></span>');
          } else if (social.type === 'twitter') {
            $panel.html(social.text + '<span class="author">@' + social.username + '</span><span class="social-icon"><i class="fa fa-' + social.type + '"></i></span>');
          }
        }, 590);
        setTimeout(function() {
          $panel.removeClass('animated ' + animation);
        }, 12000);
      }
      function randFlip() {
        setTimeout(function() {
          //LED 9x3
          var rand = Math.floor(Math.random() * 27) + 1;
          //LED 5x3
          //var rand = Math.floor(Math.random() * 15) + 1;
          //LED 3x3
          //var rand = Math.floor(Math.random() * 15) + 1;
          //WAVE 3x2
          //var rand = Math.floor(Math.random() * 6) + 1;
          //WAVE 2x1
          //var rand = Math.floor(Math.random() * 2) + 1;
          flipPanel('panel' + rand);
          randFlip();
        }, 12000);
      }

      var logos = [
        "Microsoft",
        "6Sense",
        "BaderRutter",
        "DemandBase",
        "Doremus",
        "Engineering360MediaSolutions",
        "EricMower",
        "EverString",
        "Microsoft",
        "FinancialTimes",
        "gyro",
        "Quarry",
        "Resolution",
        "SmartBrief",
        "SteinIAS",
        "WebDam"
      ];
      var sponsorIndex = 0;
      function loadSponsor() {
        $('#sponsor-logo').attr("src", "img/sponsors/" + logos[sponsorIndex] + ".jpg");
        setTimeout(function() { rotateSponsor(); }, 7000);
      }

      function rotateSponsor() {
        sponsorIndex++;
        if (sponsorIndex >= logos.length) { sponsorIndex = 0; }
        var $logo = $('#sponsor-logo');
        $logo.fadeOut('slow', function() {
          $logo.attr("src", "img/sponsors/" + logos[sponsorIndex] + ".jpg");
          $logo.fadeIn('slow');
        });
        setTimeout(function() { rotateSponsor(); }, 7000);
      }
    </script>
  </head>
  <body>
    <ul id="grid">
    </ul>
    <div id="sponsor-panel" style="background-color: #000; height: 388px; position: absolute; width: 587px; left: 610px; top: 12px; z-index: 100;">
      <img src="" width="100%" height="100%" id="sponsor-logo" />
    </div>
    <div id="stats">
      <i class="fa fa-twitter"></i> <span id="twitter-count">0</span>&nbsp;&nbsp;
      <i class="fa fa-instagram"></i> <span id="instagram-count">0</span>
    </div>
    <!--
    <h1><img src="img/logo.png" /></h1>
    <span class="right">Powered By:</span>
    <p>
      <strong>70% of Instragram accounts are private.  To participate in the BMA social wall, authorize your Instagram at http://bit.ly/bmaconf14</strong>
    </p>-->
  </body>
</html>
