<?php

//Capitura o cep
$CEP = $_GET['cep'];
//criando o recurso cURL
$cr = curl_init();

//definindo a url de busca 
curl_setopt($cr, CURLOPT_URL, "http://www.buscacep.correios.com.br/sistemas/buscacep/resultadoBuscaCepEndereco.cfm");

//definindo a url de busca 
curl_setopt($cr, CURLOPT_RETURNTRANSFER, true);

//definino que o método de envio, será POST
curl_setopt($cr, CURLOPT_POST, TRUE);

//definindo os dados que serão enviados
curl_setopt($cr, CURLOPT_POSTFIELDS, "relaxation=".$CEP."&tipoCEP=ALL&semelhante=N");

header('Content-Type: text/html; charset=iso-8859-1');
//definindo uma variável para receber o conteúdo da página...
$retorno = curl_exec($cr);

//fechando-o para liberação do sistema.
curl_close($cr); //fechamos o recurso e liberamos o sistema...

///Limpa os dados parcialmente
$date = explode('<tr>', explode('</table>', explode('<table class="tmptabela">', $retorno)[1])[0])[1];

// Limpa ainda mais os dados e exibe
echo 	'{
    "Logradouro" : "'.str_replace('&nbsp;','',explode('<td width="150">', explode('</td>', $date)[0])[1]).'",
    "Bairro" : "'.str_replace('&nbsp;','',explode('<td width="90">', explode('</td>', $date)[1])[1]).'",
    "Localidade" : "'.explode('<td width="80">', explode('</td>', $date)[2])[1].'",
    "CEP" : "'.explode('<td width="55">', explode('</td>', $date)[3])[1].'"
}';

echo '<br>'.findCEP($_GET['cep']);

function findCep($CEP){
	$cr = curl_init();curl_setopt($cr, CURLOPT_URL, "http://www.buscacep.correios.com.br/sistemas/buscacep/resultadoBuscaCepEndereco.cfm");	curl_setopt($cr, CURLOPT_RETURNTRANSFER, true);	curl_setopt($cr, CURLOPT_POST, TRUE);curl_setopt($cr, CURLOPT_POSTFIELDS, "relaxation=".$CEP."&tipoCEP=ALL&semelhante=N");header('Content-Type: text/html; charset=iso-8859-1');$retorno = curl_exec($cr);curl_close($cr);$date = explode('<tr>', explode('</table>', explode('<table class="tmptabela">', $retorno)[1])[0])[1];return 	'{"Logradouro" : "'.str_replace('&nbsp;','',explode('<td width="150">', explode('</td>', $date)[0])[1]).'","Bairro" : "'.str_replace('&nbsp;','',explode('<td width="90">', explode('</td>', $date)[1])[1]).'","Localidade" : "'.explode('<td width="80">', explode('</td>', $date)[2])[1].'","CEP" : "'.explode('<td width="55">', explode('</td>', $date)[3])[1].'"}';
}

?>