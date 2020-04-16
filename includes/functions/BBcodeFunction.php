<?php

function bbcode($string) {
    $pattern = array(
        '/\\n/',
        '/\\r/',
        '/\[list\](.*?)\[\/list\]/ise',
        '/\[b\](.*?)\[\/b\]/is',
        '/\[strong\](.*?)\[\/strong\]/is',
        '/\[i\](.*?)\[\/i\]/is',
        '/\[u\](.*?)\[\/u\]/is',
        '/\[s\](.*?)\[\/s\]/is',
        '/\[del\](.*?)\[\/del\]/is',
        '/\[url=(.*?)\](.*?)\[\/url\]/ise',
        '/\[email=(.*?)\](.*?)\[\/email\]/is',
        '/\[img](.*?)\[\/img\]/ise',
        '/\[color=(.*?)\](.*?)\[\/color\]/is',
        '/\[quote\](.*?)\[\/quote\]/ise',
        '/\[code\](.*?)\[\/code\]/ise'
    );
   
    $replace = array(
        '',
        '',
        'sList(\'\\1\')',
        '<b>\1</b>',
        '<strong>\1</strong>',
        '<i>\1</i>',
        '<span style="text-decoration: underline;">\1</span>',
        '<span style="text-decoration: line-through;">\1</span>',
        '<span style="text-decoration: line-through;">\1</span>',
        'urlfix(\'\\1\',\'\\2\')',
        '<a href="mailto:\1" title="\1">\2</a>',
        'imagefix(\'\\1\')',
        '<span style="color: \1;">\2</span>',
        'sQuote(\'\1\')',
        'sCode(\'\1\')'
    );

    return preg_replace($pattern, $replace, nl2br(htmlspecialchars(stripslashes($string))));
}



function image($string)
        {
		//On va pas se casser le fion a lire les accents quand meme !!!!!!!
        $string = str_replace("&#39;", "'", $string);
		
	
		//Emoticones.... COPIEZ COLLEZ CES LIGNES POUR RAJOUTER LES VOTRES !
        $string = str_replace("Smile", "[img]../emoticones/Smile.png[/img]", $string);
		$string = str_replace("cool", "[img]../emoticones/cool.png[/img]", $string);
        $string = str_replace("grrr", "[img]../emoticones/grrr.png[/img]", $string);
        $string = str_replace("love", "[img]../emoticones/love.png[/img]", $string);
        $string = str_replace("msn", "[img]../emoticones/msn.png[/img]", $string);
        $string = str_replace("Oo", "[img]../emoticones/Oo.png[/img]", $string);
        $string = str_replace("perdu", "[img]../emoticones/perdu.png[/img]", $string);
        $string = str_replace("wink", "[img]../emoticones/wink.png[/img]", $string);
        $string = str_replace("wow", "[img]../emoticones/wow.png[/img]", $string);

        return $string;
        }




function sCode($string){
    $pattern =  '/\<img src=\\\"(.*?)img\/smilies\/(.*?).png\\\" alt=\\\"(.*?)\\\" \/>/s';
    $string = preg_replace($pattern, '\3', $string);
    return '<pre>' . trim($string) . '</pre>';
}
  
function sList($string) {
    $tmp = explode('[*]', stripslashes($string));
    $out = null;
    foreach($tmp as $list) {
        if(strlen(str_replace('', '', $list)) > 0) {
            $out .= '<li>' . trim($list) . '</li>';
        }
    }
    return '<ul>' . $out . '</ul>';
}

function imagefix($img) {
    if(substr($img, 0, 7) != 'http://') {
        $img = './images/' . $img;
    }
    return '<img src="' . $img . '" alt="' . $img . '" title="' . $img . '" />';
}

function urlfix($url, $title) {
    $title = stripslashes($title);
    return '<a href="' . $url . '" title="' . $title . '">' . $title . '</a>';
}
?><?php /*  Powered by OGameCN www.ogamecn.com  */ ?>