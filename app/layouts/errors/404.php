<!-- Creditos para eightarmshq en CodePen http://codepen.io/EightArmsHQ/pen/HJsav-->
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <style media="screen">
    body {
    font-family: 'Montserrat', sans-serif;
    background: #2980b9;
    }

    h1 {
    color: #fff;
    text-align: center;
    }

    pre {
    font-family: 'Source Code Pro', monospace;
    margin: 2em;
    background: #222;
    color: #aaa;
    border: 5px solid #666;
    padding: 1em;
    height: 300px;
    width: 80%;
    max-width: 800px;
    margin: 2em auto;
    }

    p {
    text-align: center;
    }

    button {
    display: inline-block;
    display: none;
    background: #fff;
    border: none;
    border-radius: 4px;
    padding: 1em;
    }
    </style>
  </head>
  <body>
    <h1 title='Sure this name is trademarked!'>:( 404</h1>
    <pre id="output"></pre>
    <p>
      <button>Restart</button>
    </p>
  </body>
  <script type="text/javascript" src="public/jquery/jquery.min.js"></script>
  <script type="text/javascript">
  $(function() {
  // The base speed per character
  time_setting = 1;
  // How much to 'sway' (random * this-many-milliseconds)
  random_setting = 80;
  // The text to use NB use \n not real life line breaks!
  input_text = "<div class='main'>\n\t<!-- no se ha encontrado la ruta que estás buscando -->\n\t<h1>404 Requested page</h1>\n\t<p>Puedes seguir intentando programar en Snipe a pesar de eso. Suerte ;)</p>\n</div><!-- .main -->";
  // Where to fill up
  target_setting = $("#output");
  // Launch that function!
  type(input_text, target_setting, 0, time_setting, random_setting);

  $("button").click(function() {
    // When you click, remove the button
    $(this).fadeOut('fast', function() {
      // Remove all the text, then show the pre area again
      target_setting.text("").show();
      // And start again!
      type(input_text, target_setting, 0, time_setting, random_setting);
    });
  });
  });

  function type(input, target, current, time, random) {
  // If the current count is larger than the length of the string, then for goodness sake, stop
  if (current > input.length) {
    // Write Complete
    //console.log("Complete.");
    // Wait a bit, then do the complete function
    setTimeout(function() {
      //finished(input, target, current, time, random);
    }, 2000);

  } else {
    console.log(current)
      // Increment the marker
    current += 1;
    // fill the target with a substring, from the 0th character to the current one
    target.text(input.substring(0, current));
    // Wait ...
    setTimeout(function() {
      // do the function again, with the newly incremented marker
      type(input, target, current, time, random);
      // Time it the normal time, plus a random amount of sway
    }, time + Math.random() * random);
  }
  }

  // when its finished
  function finished(input, target, current, time, random) {
  // fade out the pre
  target.slideUp('fast', function() {
    // fade in the button
    $("button").delay(100).fadeIn('slow');
  });
  }
  </script>
</html>
