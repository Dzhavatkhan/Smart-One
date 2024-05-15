<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" id="logo" href="{{asset('img/home/LogoDark.svg')}}" />
    <title>Smart One</title>


</head>
@vite("resources/css/app.css")

<body class="bg-[#FBFFFF]">
    <div class="" id="app"></div>
    @vite("resources/js/app.js")
    <script>
        let logo = document.getElementById("logo").href
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            logo = "{{asset('img/home/LogoDark.svg')}}"
            console.log("White: ", logo);
        }
        else{
            logo = "{{asset('img/home/Logo.svg')}}"
            console.log("Dark: ", logo);
        }
    </script>
</body>
</html>
