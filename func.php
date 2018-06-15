<?php
  function testarPermissoes() {

    $tmpDir = __DIR__ . "/../php/tmp";
    $templatesDir = __DIR__ . "/../../templates";
    $uploadsDir = __DIR__ . "/../../uploads";

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
      echo "<strong style='color: #f1c40f;''><i>AVISO:</i></strong> O diretório <strong>\"$key\"</strong> não existe <br>";
      }
    }
}

function testarRedis() {
  $dadosRedis = array(
    "COMBO_TIPO_PROCEDIMENTO",
    "PROCEDIMENTO_ATUACAO",
    "COMBO_AUTORIDADE",
    "COMBO_AUTORIDADE_USUARIO",
    "COMBO_BOP_STATUS",
    "COMBO_TIPO_PESSOA_ATUACAO",
    "COMBO_CAUSA_PRESUMIVEL",
    "COMBO_MEIO_EMPREGADO",
    "COMBO_INSTRUMENTO_UTILIZADO",
    "COMBO_UNIDADE",
    "COMBO_ESCRIVAO",
    "COMBO_LOCALOCORRENCIA",
    "COMBO_GRAUPARENTESCO",
    "COMBO_SEXO",
    "COMBO_GRUPO_SOCIAL",
    "COMBO_MORADIA",
    "COMBO_PROFISSAO",
    "COMBO_ESCOLARIDADE",
    "COMBO_ESTADOCIVIL",
    "COMBO_TIPODOCUMENTO",
    "COMBO_TIPODOCUMENTO_F",
    "COMBO_TIPODOCUMENTO_J",
    "COMBO_PAIS",
    "COMBO_UF",
    "COMBO_LOCALIDADE",
    "COMBO_BAIRRO",
    "LISTA_TIPO_OBJETO",
    "COMBO_CATEGORIA_OBJETO",
    "COMBO_OBJETO",
    "COMBO_OBJETOMARCA",
    "COMBO_PROCEDIMENTO_STATUS",
    "COMBO_TIPO_CONTATO",
    "COMBO_PERFIL",
    "COMBO_PERFIL_INTERNO",
    "COMBO_CARACTERISTICA_SOMATICA_GRUPO",
    "COMBO_CARACTERISTICA_SOMATICA",
    "COMBO_MODUS_OPERANDI",
    "COMBO_QUADRILHA",
  );

  try {
    if(class_exists('Redis')) {
      if (!($redis = new Redis())) {
        throw new Exception("<strong style='color: #e74c3c;''><i>ERRO:</i></strong> Não foi possível testar o banco <strong>\"Redis\"</strong>. <br>");
      } else {
        if($redis->connect( 'localhost', 6379, 5 )) {
          foreach ($dadosRedis as $key)
            if($redis->exists($key))
              echo "Arquivo REDIS $key gerado. <br>";
          echo "<strong style='color: #2ecc71;''><i>OK:</i></strong> O módulo <strong>\"Redis\"</strong> está instalado, e possível conectar ao banco. <br>";
        } else {
          echo "<strong style='color: #e74c3c;''><i>ERRO:</i></strong> O módulo <strong>\"Redis\"</strong> está instalado, mas não foi possível conectar ao banco <strong>\"Redis\"</strong>. <br>";
        }
      }
    } else {
      echo "<strong style='color: #e74c3c;''><i>ERRO:</i></strong> O módulo <strong>\"Redis\"</strong> não está instalado. <br>";
    }
  } catch(Exception $e) {
    echo $e;
  }
}

function modulosApache($arr) {
  $s = apache_get_modules($key);
  foreach ($arr as $modulo) {
      if(array_key_exists($modulo, $s)) {
        echo "<strong style='color: #2ecc71;''><i>OK:</i></strong> O modulo $modulo está instalado corretamente.<br>";
      } else {
        echo "<strong style='color: #e74c3c;''><i>ERRO:</i></strong> O modulo Apache <strong>\"$modulo\"</strong> não está instalado. <br>";
      }
  }
}

$modulosApache = array( "rewrite", "expires", "headers", "deflate", "auth" );
function testarModulosApache() {
  global $modulosApache;
  modulosApache($modulosApache);
}

function json($nome) {
  $hash = MD5($nome);
  if(file_exists("$hash.json") && filesize("$hash.json") > 10) {
    echo "<strong style='color: #2ecc71;''><i>OK:</i></strong> JSON $nome gerado e com conteúdo. <br>";
  } elseif (file_exists("$hash.json") && filesize("$hash.json") <= 10) {
    echo "<strong style='color: #f1c40f;''><i>AVISO:</i></strong> JSON $nome gerado, mas está vazio. <br>";
  } elseif (!file_exists("$hash.json")) {
    echo "<strong style='color: #e74c3c;''><i>ERRO:</i></strong> JSON $nome não encontrado. <br>";
  }
}

function verificarJson($arr) {
  foreach ($arr as $key) {
    json($key);
  }
}

$arquivosJson = array(
  "LISTA_TIPO_DESPACHO", "DESPACHO_ACAO_OCORRENCIA", "DESPACHO_ACAO_PROCEDIMENTO",
  "COMBO_PERICIA_REGIONAL", "COMBO_PERICIA_AREA_PERICIAL", "COMBO_PERICIA_TIPO_EXAME",
  "LISTA_TPL_CAMPO", "BOP_CATEGORIA", "COMBO_NATUREZA_BOP_CATEGORIA",
  "COMBO_NATUREZA", "COMBO_MEIO_EMPREGADO", "COMBO_CAUSA_PRESUMIVEL",
  "COMBO_GRUPO_OCORRENCIA", "COMBO_LOCALOCORRENCIA", "COMBO_UNIDADE",
  "COMPO_BOP_STATUS", "COMBO_PROCEDIMENTO_STATUS", "COMPO_TIPO_PROCEDIMENTO",
  "COMBO_PROCEDIMENTO_ORIGEM", "COMBO_TIPO_PESSOA_ATUACAO", "COMBO_ESTADOCIVIL",
  "COMBO_ESCOLARIDADE", "COMBO_PROFISSAO", "COMBO_MORADIA",
  "COMBO_GRUPO_SOCIAL", "COMBO_SEXO", "COMBO_MODUS_OPERANDI",
  "COMBO_TIPO_CONTATO", "COMBO_TIPODOCUMENTO"
);

function testarJson() {
  global $arquivosJson;
  verificarJson($arquivosJson);
};

call_user_func($_POST['function']);
?>
