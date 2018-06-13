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
    if(class_exists('Redis')) {
      if (!($redis = new Redis())) {
        throw new Exception("<strong style='color: #cd0000;''><i>ERRO:</i></strong> Não foi possível testar o banco <strong>\"Redis\"</strong>. <br>");
      } else {
        if($redis->connect( 'localhost', 6379, 5 )) {
          echo "O módulo <strong>\"Redis\"</strong> está instalado, e possível conectar ao banco. <br>";
        } else {
          echo "<strong style='color: #cd0000;''><i>ERRO:</i></strong> O módulo <strong>\"Redis\"</strong> está instalado, mas não foi possível conectar ao banco <strong>\"Redis\"</strong>. <br>";
        }
      }
    } else {
      echo "O módulo <strong>\"Redis\"</strong> não está instalado. <br>";
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

function json($nome) {
  $hash = MD5($nome);
  if(file_exists("$hash.json") && filesize("$hash.json") > 10) {
    echo "JSON $nome gerado e com conteúdo";
  } elseif (file_exists("$hash.json") && filesize("$hash.json") <= 10) {
    echo "JSON $nome gerado, mas está vazio";
  } elseif (!file_exists("$hash.json")) {
    echo "JSON $nome não encontrado";
  }
}

function verificarJson($arr) {
  foreach ($arr as $key) {
    json($key);
  }
}

$arquivosJson = array(
  "LISTA_TIPO_DESPACHO",
  "DESPACHO_ACAO_OCORRENCIA",
  "DESPACHO_ACAO_PROCEDIMENTO",
  "COMBO_PERICIA_REGIONAL",
  "COMBO_PERICIA_AREA_PERICIAL",
  "COMBO_PERICIA_TIPO_EXAME",
  "LISTA_TPL_CAMPO",
  "BOP_CATEGORIA",
  "COMBO_NATUREZA_BOP_CATEGORIA",
  "COMBO_NATUREZA",
  "COMBO_MEIO_EMPREGADO",
  "COMBO_CAUSA_PRESUMIVEL",
  "COMBO_GRUPO_OCORRENCIA",
  "COMBO_LOCALOCORRENCIA",
  "COMBO_UNIDADE",
  "COMPO_BOP_STATUS",
  "COMBO_PROCEDIMENTO_STATUS",
  "COMPO_TIPO_PROCEDIMENTO",
  "COMBO_PROCEDIMENTO_ORIGEM",
  "COMBO_TIPO_PESSOA_ATUACAO",
  "COMBO_ESTADOCIVIL",
  "COMBO_ESCOLARIDADE",
  "COMBO_PROFISSAO",
  "COMBO_MORADIA",
  "COMBO_GRUPO_SOCIAL",
  "COMBO_GRUPO_SOCIAL",
  "COMBO_SEXO",
  "COMBO_MODUS_OPERANDI",
  "COMBO_TIPO_CONTATO",
  "COMBO_TIPODOCUMENTO"
);

function testarJson() {
  global $arquivosJson;
  verificarJson($arquivosJson);
};

call_user_func($_POST['function']);
?>
