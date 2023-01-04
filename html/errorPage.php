<!DOCTYPE html>
<html lang="pl">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <title>WSG - Hotels</title>
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="css/own-style.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
   </head>
   <style>
        @import url("https://fonts.googleapis.com/css?family=VT323");
        :root{
        --width: 280px;
        --height: 180px;
        }

        body{ background: #6BA1CA; }

        .error-500{
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        font-family: 'VT323';
        color: #1E4B6D;
        text-shadow: 1px 1px 1px rgba(255, 255, 255, .3);
        }

        .error-500:after{
        content: attr(data-text);
        display: block;
        margin-top: calc(var(--height) / 10 + 15px);
        font-size: 28pt;
        text-align: center;
        }

        spaguetti{
        width: var(--width);
        height: var(--height);
        filter: drop-shadow(0 0 0.75rem rgba(0, 0, 0, .2));
        display: block;
        margin: 0 auto;
        position: relative;
        }

        plate{
        width: 100%;
        height: calc(var(--height) / 2.5);
        background: #CAD7E4;
        position: absolute;
        bottom: 0;
        border-radius: 0 0 50px 50px;
        z-index: 4;
        }

        plate:before{
        content: '500 Spaghetti Error';
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        text-transform: uppercase;
        font-weight: bold;
        color: rgba(0, 0, 0, .2);
        text-align: center;
        }

        plate:after{
        content: '';
        width: calc(var(--width) / 2);
        height: calc(var(--height) / 10);
        background: #B5C3D0;
        position: absolute;
        top: 100%; left: 50%;
        transform: translateX(-50%);
        }

        pasta{
        width: calc(var(--width) / 4);
        height: calc(var(--width) / 4);
        border: 5px solid #DEA631;
        background: #EED269;
        border-radius: 50%;
        position: absolute;
        bottom: calc(calc(var(--height) / 2.5) / 3); right: 10px;
        box-shadow: calc(-1 * calc(var(--width) / 4) - 60px) 10px 1px 10px #EED269, calc(-1 * calc(var(--width) / 4) - 60px) 10px 0 15px #DEA631;
        z-index: 2;
        }

        pasta:before{
        content: '';
        width: calc(var(--width) / 4);
        height: calc(var(--width) / 4);
        border: 5px solid #DEA631;
        background: #EED269;
        border-radius: 50%;
        position: absolute;
        bottom: -5px; right: 60px;
        box-shadow: calc(-1 * calc(var(--width) / 4) - 30px) 10px 1px 1px #EED269, calc(-1 * calc(var(--width) / 4) - 30px) 10px 0 5px #DEA631;
        }

        pasta:after{
        content: '';
        width: calc(var(--width) / 3);
        height: calc(var(--width) / 4);
        border: 5px solid #DEA631;
        background: #EED269;
        border-radius: 50%;
        position: absolute;
        bottom: -15px; right: 100px;
        box-shadow: calc(var(--width) / 4) 10px 1px 1px #EED269, calc(var(--width) / 4) 10px 0 5px #DEA631;
        }

        meat{
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #B64C19;
        position: absolute;
        bottom: calc(var(--height) / 2.5); right: 64px;
        box-shadow: -150px -2px 0 0 #B64C19, -50px -7px 0 0 #B64C19, -100px 8px 0 0 #B64C19;
        z-index: 3;
        }

        fork{
        width: 20px;
        height: calc(var(--height) - 30px);
        background: #D3D3D3;
        border-right: 3px solid #B7B7B7;
        border-radius: 50px 50px 0 0;
        position: absolute;
        bottom: 25%; left: 75%;
        transform: translate(-75%, 0%) rotate(25deg);
        }
   </style>
   <body>
        <div class="error-500" data-text="O nie! Nasz spaghetti code nie działa prawidłowo. Zaraz sprawdzimy co w makaronie piszczy.">
            <spaguetti>
            <fork></fork>
            <meat></meat>
            <pasta></pasta>
            <plate></plate>
        </spaguetti>
        </div>
    </body>
    <script>
        const error = document.querySelector(".error-500");
        let i = 0, data = "", text = error.getAttribute("data-text");

        let typing = setInterval(() => {
        if(i == text.length){
            clearInterval(typing);
        }else{
            data += text[i];
            document.querySelector(".error-500").setAttribute("data-text", data);
            i++;
        }
        }, 100);
    </script>
</html>