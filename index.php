<HTML>
<HEAD>
<meta charset="UTF-8"/>
 <TITLE>Moja filmoteka</TITLE>
 <link rel=stylesheet type="text/css" href="style.css">
 <link rel=stylesheet type="text/css" href="comments.css">
 <link rel=stylesheet href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
 <?php
 include_once('config.php');
 ?>
 <script>
        function zegarek()
        {
            var data = new Date();
            var godzina = data.getHours();
            var minuta = data.getMinutes();
            var sekunda = data.getSeconds();
            var dzien = data.getDate();
            var dzienN = data.getDay();
            var miesiac = data.getMonth();
            var rok = data.getFullYear();
           
            if (minuta < 10) minuta = "0" + minuta;
            if (sekunda < 10) sekunda = "0" + sekunda;
           
            var dni = new Array("niedziela", "poniedziałek", "wtorek", "środa", "czwartek", "piątek", "sobota");
            var miesiace = new Array("stycznia", "lutego", "marca", "kwietnia", "maja", "czerwca", "lipca", "sierpnia", "września", "października", "listopada", "grudnia");
           
            var pokazDate = "Dzisiaj jest " + dni[dzienN] + ', ' + dzien + ' ' + miesiace[miesiac] + ' ' + rok + " roku.<br />Godzina " + godzina + ':' + minuta + ':' + sekunda;
            document.getElementById("zegar").innerHTML = pokazDate;
           
            setTimeout(zegarek, 1000);            
        }        
    </script>
</HEAD>

<BODY onload="zegarek()">
<div id="menu">
<center>
<table border="1">
<tr height="30">
<th width="120"><a href="index.php">Główna</a></th>
<th width="120"><a href="horrory1.html">Horrory</a></th>
<th width="120"><a href="komedie1.html">Komedie</a></th>
<th width="120"><a href="thrillery1.html">Thrillery</a></th>
<th width="120"><a href="historyczne1.html">Historyczne</a></th>
<th width="120"><a href="fantasy1.html">Fantasy</a></th>
<th width="120"><a href="sci-fi1.html">Sci-Fi</a></th>
</tr>
</table>
</center>
</div>

<div class="container1">
    <div id="div_login">
        <h1>Login</h1>
        <div id="message"></div>
    <div>
        <input type="text" class="textbox" id="txt_uname" name="txt_uname" placeholder="Username"/>
    </div>
    <div>
        <input type="password" class="textbox" id="txt_pwd" name="txt_pwd" placeholder="Password"/>
    </div>
    <div>
        <input type="button" value="Submit" name="but_submit" id="but_submit"/>
    </div>
    </div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
    $("#but_submit").click(function(){
        var username = $("#txt_uname").val().trim();
        var password = $("#txt_pwd").val().trim();

        if( username != "" && password != "" ){
            $.ajax({
                url:'checkUser.php',
                type:'post',
                data:{username:username,password:password},
                success:function(response){
                    var msg = "";
                    if(response == 1){
                        window.location = "home.php";
                    }else{
                        msg = "Invalid username and password!";
                    }
                    $("#message").html(msg);
                }
            });
        }
    });
});
</script>

<p>Nie masz konta? <a href="rejestracja.php">UTWÓRZ JE</a></p>

<center>
<div id="zegar"></div>
</center>
<div id="container">
<p>
Przedstawiamy Wam zestawienie najlepszych filmów z niejednego gatunku. Sprawdź naszą stronę i dowiedz się więcej!
</p>


<div id="ad">
<a href="https://www.cda.pl/" target="blank"><img src="ad.png" alt="Reklama" width=100px height=500px></a>
</div>

<div class="news">
<div class="news_title">Nowy film scenarzystki Wcielenia - M3GAN<div>
<p>W styczniu tego roku wyszedł nowy film dla fanów horrorów. Opowiada on o humanoidalnej laleczce M3gan, która jest wynikiem eksperymentu pewnej uczonej kobiety. Laleczka zaprzyjaźnia się z jej córką i przysięga jej, że będzie ją chronić. M3gan nie pozwalając skrzywdzić swojej najlepszej przyjaciółki nie zawaha się przed niczym. Jest to doskonały film dla fanów tworów takich jak Laleczka Chucky, czy Anabelle!</p>
<iframe width="560" height="315" src="https://www.youtube.com/embed/BRb4U99OU80" title="M3GAN trailer" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
<br>
<br>
<button class="pushable">
<span class="front">
<a href="https://www.filmweb.pl/film/M3GAN-2022-10006003/reviews" target="_blank">Poznaj opinie fanów</a>
</span>
</button>
</div>
</div>
<br><br><br><br><br>
<div id="footer"><p>Created students from ZPSB</p></div>
<br>


<div class="rating">
    <i class="rating__star far fa-star"></i>
    <i class="rating__star far fa-star"></i>
    <i class="rating__star far fa-star"></i>
    <i class="rating__star far fa-star"></i>
    <i class="rating__star far fa-star"></i>
</div>
<script src="rating.js"></script>


        <div class="comments"></div>

<script>
const comments_page_id = 1; 
fetch("comments.php?page_id=" + comments_page_id).then(response => response.text()).then(data => {
	document.querySelector(".comments").innerHTML = data;
	document.querySelectorAll(".comments .write_comment_btn, .comments .reply_comment_btn").forEach(element => {
		element.onclick = event => {
			event.preventDefault();
			document.querySelectorAll(".comments .write_comment").forEach(element => element.style.display = 'none');
			document.querySelector("div[data-comment-id='" + element.getAttribute("data-comment-id") + "']").style.display = 'block';
			document.querySelector("div[data-comment-id='" + element.getAttribute("data-comment-id") + "'] input[name='name']").focus();
		};
	});
	document.querySelectorAll(".comments .write_comment form").forEach(element => {
		element.onsubmit = event => {
			event.preventDefault();
			fetch("comments.php?page_id=" + comments_page_id, {
				method: 'POST',
				body: new FormData(element)
			}).then(response => response.text()).then(data => {
				element.parentElement.innerHTML = data;
			});
		};
	});
});
</script>
 
</BODY>
</HTML>