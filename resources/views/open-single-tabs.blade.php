<!DOCTYPE html>
<html>
<head>
    <title>Opening Tabs...</title>
    <script>
        window.onload = function () {
            window.open("{{ $url1 }}", "_blank");
            window.location.href = "{{ $return_action }}"; // Redirect back or wherever needed
        };
    </script>
</head>
<body>
    <p>Opening tabs, please wait...</p>
</body>
</html>
