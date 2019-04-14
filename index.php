<html>
    <head>
    <title>YouTube Music Video Meta Data Scrapper</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>*{padding:0; margin:0}</style>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-54987871-11"></script>
    <script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'UA-54987871-11');</script>
    </head>
    <body>
    <center>
        <div style="border: 1px dashed; width: 420px; height: 420px; margin: 0 auto; background-color: #FFFDE7; margin-top:50px; font-weight: normal;">

        <h2 style="margin-top: 50px;">YouTube Music Video Meta Data Scrapper</h2>
            <form action="#youtube.php" style="margin-top: 50px;">
                <input type="text" placeholder="youtube URL" name="url" id="url" style="padding: 5px; border-radius: 5px; border: 1px dashed; margin: 5px;width: 300px;">
                <input id="submit" type="submit" value="Submit" style="background: #f44336; color: #eee; padding: 5px 17px; border: 1px dashed white;">
                <table style="border: 1px dashed;margin: 10px;padding: 5px; width: 380px; border-radius: 5px;">
                    <tr style="background:#eeeeee">
                        <td>Song</td>
                        <td id="song">---</td>
                    </tr>
                    <tr>
                        <td>Singer(s)</td>
                        <td id="singer">---</td>
                    </tr>
                    <tr style="background:#eeeeee">
                        <td>Music</td>
                        <td id="music">---</td>
                    </tr>
                    <tr >
                        <td>Album</td>
                        <td id="album">---</td>
                    </tr>
                    <tr style="background:#eeeeee">
                        <td>Lyrics</td>
                        <td id="lyrics">---</td>
                    </tr>
                    <tr >
                        <td>Label</td>
                        <td id="label">---</td>
                    </tr>
                </table>
            </form>
        </div>
    </center>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>$(document).ready(function(){$("#submit").click(function(t){$("#submit").attr("value","loading..."),$("#submit").attr("disabled","true"),$("#submit").css("opacity","0.5"),t.preventDefault(),$.ajax({type:"POST",url:"youtube.php",data:$("#url").serialize(),success:function(t){$("#submit").attr("value","Submit"),$("#submit").removeAttr("disabled"),$("#submit").css("opacity","1"),t.status&&($("#album").text(t.data.album?t.data.album:"---"),$("#singer").text(t.data.artist?t.data.artist:"---"),$("#label").text(t.data.label?t.data.label:"---"),$("#lyrics").text(t.data.lyrics?t.data.lyrics:"---"),$("#music").text(t.data.music?t.data.music:"---"),$("#song").text(t.data.song?t.data.song:"---"))},error:function(t){$("#submit").attr("value","Submit"),$("#submit").removeAttr("disabled"),$("#submit").css("opacity","1"),alert("ERROR: "+t.msg)}})})});</script>
    </body>
</html> 
