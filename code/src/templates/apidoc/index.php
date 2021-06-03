<?php
/** @var string $data */
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>API Specification - Swagger UI</title>
	<link rel="stylesheet" type="text/css"
	      href="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/3.26.1/swagger-ui.css">
</head>
<body>
<div id="swagger-ui"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/3.26.1/swagger-ui-bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/3.26.1/swagger-ui-standalone-preset.js"></script>
<script>
  window.onload = function () {
    const ui = SwaggerUIBundle({
      spec: <?= $data ?>,
      dom_id: '#swagger-ui',
      deepLinking: true,
      // supportedSubmitMethods: ['GET', 'POST', 'PUT', 'DELETE'],
      supportedSubmitMethods: ['get', 'post', 'put', 'delete'],
      presets: [
        SwaggerUIBundle.presets.apis,
        // SwaggerUIStandalonePreset
      ],
      plugins: [
        SwaggerUIBundle.plugins.DownloadUrl,
      ],
      // layout: "StandaloneLayout",
    });



    window.ui = ui
  };
</script>
</body>
</html>
