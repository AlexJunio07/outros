<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API - Dinheiro</title>
</head>

<body>
    <?php

    function extenso($valor = 0, $maiusculas = false)
    {
        if (!$maiusculas) {
            $singular = ["CENTAVO", "REAL", "MIL", "MILHÃO", "BILHÃO", "TRILHÃO", "QUATRILHÃO"];
            $plural = ["CENTAVOS", "REAIS", "MIL", "MILHÕES", "BILHÕES", "TRILHÕES", "QUATRILHÕES"];
            $u = ["", "UM", "DOIS", "TRÊS", "QUATRO", "CINCO", "SEIS",  "SETE", "OITO", "NOVE"];
        } else {
            $singular = ["CENTAVO", "REAL", "MIL", "MILHÃO", "BILHÃO", "TRILHÃO", "QUADRILHÃO"];
            $plural = ["CENTAVOS", "REAIS", "MIL", "MILHÕES", "BILHÕES", "TRILHÕES", "QUADRILHÕES"];
            $u = ["", "UM", "DOIS", "TRÊS", "QUATRO", "CINCO", "SEIS",  "SETE", "OITO", "NOVE"];
        }

        $c = ["", "CEM", "DUZENTOS", "TREZENTOS", "QUATROCENTOS", "QUINHENTOS", "SEISCENTOS", "SETECENTOS", "OITOCENTOS", "NOVECENTOS"];
        $d = ["", "DEZ", "VINTE", "TRINTA", "QUARENTA", "CINQUENTA", "SESSENTA", "SETENTA", "OITENTA", "NOVENTA"];
        $d10 = ["DEZ", "ONZE", "DOZE", "TREZE", "QUATORZE", "QUINZE", "DEZESSEIS", "DEZESETE", "DEZOITO", "DEZENOVE"];

        $z = 0;
        $rt = "";

        $valor = number_format($valor, 2, ".", ".");
        $inteiro = explode(".", $valor);
        for ($i = 0; $i < count($inteiro); $i++)
            for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++)
                $inteiro[$i] = "0" . $inteiro[$i];

        $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
        for ($i = 0; $i < count($inteiro); $i++) {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd &&
                $ru) ? " e " : "") . $ru;
            $t = count($inteiro) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ($valor == "000") $z++;
            elseif ($z > 0) $z--;
            if (($t == 1) && ($z > 0) && ($inteiro[0] > 0)) $r .= (($z > 1) ? " de " : "") . $plural[$t];
            if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? (($i < $fim) ? ", " : " e ") : " ") . $r;
        }

        if (!$maiusculas) {
            $return = $rt ? $rt : "zero";
        } else {
            if ($rt) $rt = preg_replace("[^A-Za-z0-9]", "", ucwords($rt));
            $return = ($rt) ? ($rt) : "Zero";
        }

        if (!$maiusculas) {
            return preg_replace("[^A-Za-z0-9]", "", ucwords($return));
        } else {
            return strtoupper($return);
        }
    }
    
    $valores = (object)array();
    $valores->valor = number_format($_GET["valor"],2,",",".");
    $valores->extenso = strtoupper(extenso($_GET["valor"]));
     echo $result = json_encode($valores);
    ?>



</body>

</html>