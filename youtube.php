<?php
//--------------------------------- RETURN HEADERS----------------------------------------//
header('Content-Type: application/json');

//---------------------------------HELPER FUNCTIONS---------------------------------------//
function resErr($msg){
    return json_encode(array(
        "status"=>FALSE,
        "msg"=>$msg
    ), JSON_PRETTY_PRINT);
}

require_once('HTMLdom.php'); // getYTDocument


//--------------------------------MAIN CODE BEINGS----------------------------------------//

$URL = isset($_POST['url'])?$_POST['url']:(isset($_GET['url'])?$_GET['url']:0);
if(!$URL){
    echo(resErr("Invalid Request. URL not provided"));
    exit();
}

$doc = getYTDocument($URL);
if(!$doc){
    resErr("Can't fetch document. Invalid URL or youtube server are down.");
}
// echo($doc);
$response = array(
    "song"=>NULL,   //
    "artist"=>NULL, // or aka singer
    "album"=>NULL,
    "label"=>NULL,   ///
    "lyrics"=>NULL, ///
    "music" => NULL //
);


foreach($doc->find('li.watch-meta-item') as $li){
    $key = trim($li->find('h4.title')[0]->innertext);
    $val = strip_tags($li->find('li')[0]->innertext);
    switch($key){
        case 'Song':
            $response['song'] = $val;
            break;
        case 'Artist':
            $response['artist'] = $val;
            break;
        case 'Album':
            $response['album'] = $val;
    }
}
$descText = strip_tags($doc->find('p#eow-description')[0]->innertext, "<p>, <br>");
$descTextLines = explode("<br />", $descText);

foreach($descTextLines as $descTextLine){
    // SONG
    if($response['song'] == NULL){
        if(preg_match("/^(Song)([-:\s]).*$/", $descTextLine, $match)){
            $response['song'] = trim(preg_split("/([-:]\s)/", $match[0])[1]);
        }
    }

    // MUSIC
    if($response['music'] == NULL){
        if(preg_match("/^(Music).*([-:]\s).*$/", $descTextLine, $match)){
            $response['music'] = trim(preg_split("/([-:]\s)/", $match[0])[1]);
        }
    }

    // LYRICS
    if($response['lyrics'] == NULL){
        if(preg_match("/^(Lyrics).*([-:]\s).*$/", $descTextLine, $match)){
            $response['lyrics'] = trim(preg_split("/([-:]\s)/", $match[0])[1]);
        }
    }

    // ARTIST/SINGER
    if($response['artist'] == NULL){
        if(preg_match("/^(Singer|Artist|Singers|Artists)([-:\s]).*$/", $descTextLine, $match)){
            $response['artist'] = trim(preg_split("/([-:]\s)/", $match[0])[1]);
        }
    }

    // ALBUM
    if($response['album'] == NULL){
        if(preg_match("/^(Album)([-:\s]).*$/", $descTextLine, $match)){
            $response['album'] = trim(preg_split("/([-:]\s)/", $match[0])[1]);
        }
    }

    // LABEL
    if($response['label'] == NULL){
        if(preg_match("/^(Label|Music Label)([-:\s]).*$/", $descTextLine, $match)){
            $response['label'] = trim(preg_split("/([-:]\s)/", $match[0])[1]);
        }
    }
    
}

$response['label'] = ($response['label']==NULL)?($doc->find('div.yt-user-info a')[0]->innertext):$response['label'];
echo(json_encode(array(
    "status" => TRUE,
    "data" => $response
)))
// https://www.googleapis.com/youtube/v3/videos?id=iJiVn8e21Oc&key=AIzaSyCbfi98v-NokQA32J3vH24-k8YP6vmlD1k&part=snippe
?>