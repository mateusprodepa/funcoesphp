<?php
// variáveis do Banco de Dados
$host = "10.1.1.45";
$usuario = "postgres";
$senha = "prodepaalmenara2011";
$banco = "seinfra_desenv";

function testarBanco(){
  global $host, $usuario, $senha, $banco;
  $str  = "host=" . $host;
  $str .= " port=5432";
  $str .= " dbname=" . $banco;
  $str .= " user=" . $usuario;
  $str .= " password=" . $senha;

  $conn = pg_connect($str);
    if($conn) { echo "Conexão com o banco funcionando normalmente"; }
    else { echo "Erro ao conectar com a base de dados"; }
  }

  function permissions($dir, $nome) {
    if($dir) {
      echo "Permissão para a pasta <strong>\"$nome\"</strong> concedida e funcionando normalmente. <br>";
    } else {
      echo "<strong style='color: #cd0000;''><i>ERRO:</i></strong> A pasta <strong>\"$nome\"</strong> não contém permissões de escrita. <br>";
    }
  }

  function testarPermissoes() {

    $tmpDir = "../php/tmp";
    $templatesDir = "../../templates";
    $uploadsDir = "../../uploads";

    $dirArr = array(
      $tmpDir,
      $templatesDir,
      $uploadsDir
    );

  foreach ($dirArr as $key) {
    if(is_dir($key)) {
      $t = is_writable($key);
      permissions($t, $key);
    } else {
      echo "<strong style='color: #cd0000;''><i>ERRO:</i></strong> O diretório <strong>\"$key\"</strong> não existe <br>";
      }
    }
}

function testarRedis() {
  try {
    if (!($redis = new Redis())) {
      throw new Exception("<strong style='color: #cd0000;''><i>ERRO:</i></strong> O <strong>\"Redis\"</strong> não está instalado. <br>");
    } else {
      if($redis->connect( 'localhost', 6379, 5 )) {
        echo "Foi possível conectar ao banco <strong>\"Redis\"</strong>. <br>";
      } else {
        echo "<strong style='color: #cd0000;''><i>ERRO:</i></strong> Não foi possível conectar ao banco <strong>\"Redis\"</strong>. <br>";
      }
    }
  } catch(Exception $e) {
    echo $e;
  }
}

function modulosApache($arr) {
  foreach ($arr as $key) {
    if (apache_get_modules($key)) {
      echo "Modulo $key instalado corretamente.<br>";
    } else {
      echo "<strong style='color: #cd0000;''><i>ERRO:</i></strong> O modulo <strong>\"$key\"</strong> não está instalado.";
    }
  }
}

call_user_func($_POST['function']);
?>
