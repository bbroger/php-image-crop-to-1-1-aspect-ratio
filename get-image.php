<?php

// recebendo a url da imagem
$fileName = $_GET['src'];

// pegando as dimensoes reais da imagem, largura e altura
list($width, $height) = getimagesize($fileName);

// Set um tamnho máximo ou terá o tamanho máximo original
$maxSize = $_GET['maxSize'] ?? null;

// Set uma qualidade ou será 90
$quality = $_GET['quality'] ?? 90;


// se a altura for maior eu defino a altura como $maxSize
if($height >= $width)
{
    if(!ISSET($maxSize) || !$maxSize) $maxSize = $height;

	$newHeight = $maxSize;
    $newWidth = ($width / $height) * $newHeight;
    
    $x = ($maxSize-$newWidth) / 2;
    $y = 0;
}
// se a largura for maior eu defino a largura como $maxSize
else
{
    if(!ISSET($maxSize) || !$maxSize) $maxSize = $width;

	$newWidth = $maxSize;
    $newHeight = ($height / $width) * $newWidth;
    
    $x = 0;
    $y = ($maxSize-$newHeight) / 2;
}


// gerando a imagem
$image_p = imagecreatetruecolor($maxSize, $maxSize);            //  criando a imagem do tamanho desejado
$fundob = imagecolorallocate($image_p,255,255,255);             //  criando fundo branco
imagefill($image_p, 0, 0, $fundob);                             //  criando fundo branco
$image = imagecreatefromjpeg($fileName);                        //  criando a imagem do arquivo

// copiando imagem para imagem_p
imagecopyresampled($image_p, $image, $x, $y, 0, 0, $newWidth, $newHeight, $width, $height);

// Cabeçalho que ira definir a saida da pagina
header('Content-type: image/jpeg;');

// o 3º argumento é a qualidade de 0 a 100
imagejpeg($image_p, null, $quality); #imprimindo a imagem natela, com a qualidade desejada
imagedestroy($image);