<?php
include("config_inicio.php");

// Restringir acesso apenas a administradores (tipo_usuario = 1)
if (!isset($_SESSION["tipo_usuario"]) || $_SESSION["tipo_usuario"] != 1) {
    header("Location: index.php");
    exit;
}

// Lógica de restauração via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'restaurar') {
    header('Content-Type: application/json; charset=utf-8');
    
    // Validar CSRF
    if (!$util->validate_csrf_token()) {
        echo json_encode(['success' => false, 'error' => 'Token CSRF inválido.']);
        exit;
    }
    
    require_once("lib/classes/class.logs.php");
    $_log = new logs($dbase);
    
    $restored_from = '';
    $file_path_to_restore = '';
    
    // Caso 1: Upload de Arquivo Local
    if (isset($_FILES['backup_upload']) && $_FILES['backup_upload']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['backup_upload']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'error' => 'Erro no upload do arquivo. Código do erro: ' . $_FILES['backup_upload']['error']]);
            exit;
        }
        
        $uploaded_name = $_FILES['backup_upload']['name'];
        $ext = strtolower(pathinfo($uploaded_name, PATHINFO_EXTENSION));
        if ($ext !== 'sql') {
            echo json_encode(['success' => false, 'error' => 'O arquivo enviado deve ter extensão .sql.']);
            exit;
        }
        
        // Copiar para a pasta backups/ com um nome padronizado para histórico
        $timestamp = date('Y-m-d_H-i-s');
        $new_filename = 'db_backup_uploaded_' . $timestamp . '.sql';
        $destination = __DIR__ . '/backups/' . $new_filename;
        
        if (!move_uploaded_file($_FILES['backup_upload']['tmp_name'], $destination)) {
            echo json_encode(['success' => false, 'error' => 'Não foi possível salvar o arquivo de upload no servidor.']);
            exit;
        }
        
        $file_path_to_restore = $destination;
        $restored_from = $new_filename;
    } 
    // Caso 2: Seleção de Backup no Servidor
    else {
        $backup_file = $_POST['backup_file'] ?? '';
        if (empty($backup_file)) {
            echo json_encode(['success' => false, 'error' => 'Nenhum arquivo de backup selecionado e nenhum upload enviado.']);
            exit;
        }
        
        // Segurança contra Directory Traversal (Garantir formato: db_backup_*.sql ou db_backup_uploaded_*.sql)
        if (!preg_match('/^db_backup_(?:uploaded_)?[0-9]{4}-[0-9]{2}-[0-9]{2}_[0-9]{2}-[0-9]{2}-[0-9]{2}\.sql$/', $backup_file)) {
            echo json_encode(['success' => false, 'error' => 'Nome de arquivo de backup inválido.']);
            exit;
        }
        
        $full_path = __DIR__ . '/backups/' . $backup_file;
        if (!file_exists($full_path)) {
            echo json_encode(['success' => false, 'error' => 'O arquivo de backup selecionado não existe.']);
            exit;
        }
        
        $file_path_to_restore = $full_path;
        $restored_from = $backup_file;
    }
    
    // Executar restauração
    $result = restore_backup($file_path_to_restore, $CONF);
    
    if ($result === true) {
        $_log->salvaLog("Backup restaurado com sucesso pelo administrador: " . $restored_from);
        echo json_encode(['success' => true]);
        exit;
    } else {
        $_log->salvaLog("Falha na restauração do backup " . $restored_from . " pelo administrador. Erro: " . $result);
        echo json_encode(['success' => false, 'error' => $result]);
        exit;
    }
}

// Função para processar o dump SQL e restaurar
function restore_backup($filename, $CONF) {
    // Conexão MySQLi dedicada para evitar conflitos de conexão
    $mysqli = new mysqli($CONF['local'], $CONF['user'], $CONF['pass'], $CONF['bd']);
    if ($mysqli->connect_errno) {
        return "Erro de conexão MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    
    $handle = fopen($filename, 'r');
    if (!$handle) {
        $mysqli->close();
        return "Não foi possível abrir o arquivo de backup.";
    }
    
    // Desabilitar checagem de chaves estrangeiras temporariamente
    $mysqli->query("SET foreign_key_checks=0;");
    
    $query = '';
    $success = true;
    $error_msg = '';
    
    while (($line = fgets($handle)) !== false) {
        // Ignorar linhas em branco, comentários e eventuais avisos/erros do PHP embutidos no dump (texto ou HTML)
        $trimmed = trim($line);
        if ($trimmed === '' || 
            strpos($trimmed, '#') === 0 || 
            strpos($trimmed, '--') === 0 ||
            strpos($trimmed, 'Deprecated:') === 0 ||
            strpos($trimmed, 'Warning:') === 0 ||
            strpos($trimmed, 'Notice:') === 0 ||
            strpos($trimmed, 'Fatal error:') === 0 ||
            strpos($trimmed, '<br />') === 0 ||
            strpos($trimmed, '<b>Deprecated</b>') !== false ||
            strpos($trimmed, '<b>Warning</b>') !== false ||
            strpos($trimmed, '<b>Notice</b>') !== false ||
            strpos($trimmed, '<b>Fatal error</b>') !== false) {
            continue;
        }
        
        $query .= $line;
        
        // Verifica se a linha termina com ponto e vírgula (fim da query)
        if (substr($trimmed, -1) === ';') {
            // Se for um comando CREATE TABLE, dropa a tabela antes para evitar erro de tabela existente
            if (preg_match('/^CREATE TABLE\s+(?:IF NOT EXISTS\s+)?`?([a-zA-Z0-9_-]+)`?/i', trim($query), $matches)) {
                $tableName = $matches[1];
                $mysqli->query("DROP TABLE IF EXISTS `$tableName`;");
            }

            if (!$mysqli->query($query)) {
                $success = false;
                $error_msg = "Erro na query: " . $mysqli->error;
                break;
            }
            $query = '';
        }
    }
    
    // Reabilitar checagem de chaves estrangeiras
    $mysqli->query("SET foreign_key_checks=1;");
    
    fclose($handle);
    $mysqli->close();
    
    if (!$success) {
        return $error_msg;
    }
    
    return true;
}

// Obter a lista de backups disponíveis e ordenar (mais recentes primeiro)
$backup_dir = __DIR__ . '/backups/';
$backups = glob($backup_dir . 'db_backup_*.sql');
usort($backups, function($a, $b) {
    return filemtime($b) - filemtime($a);
});

// Inicializa o token CSRF
$util->generate_csrf_token();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
   <meta charset="utf-8" />
   <title>Controle Estoque - Restaurar Backup</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
   <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
   <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
   <link href="css/style.css" rel="stylesheet" />
   <link href="css/style_responsive.css" rel="stylesheet" />
   <link href="css/style_gray.css" rel="stylesheet" type="text/css" id="style_color" />
   <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
   <link rel="stylesheet" type="text/css" href="css/estilo.css" />
</head>
<body class="fixed-top">
   <div id="header" class="navbar navbar-inverse navbar-fixed-top">
       <?php include("topo.php"); ?>
   </div>
   <div id="container" class="row-fluid">
       <div id="sidebar" class="nav-collapse collapse">
          <div class="sidebar-toggler hidden-phone"></div>
          <?php include("menu.php"); ?>
       </div>
       
       <div id="main-content">
          <div class="container-fluid">
             <div class="row-fluid">
                <div class="span12">
                   <h3 class="page-title">
                      Restaurar Backup
                      <small>Restauração do banco de dados do sistema</small>
                   </h3>
                </div>
             </div>
             
             <div class="row-fluid">
                <div class="span8">
                   <div class="widget" style="min-height: 450px;">
                      <div class="widget-title">
                         <h4><i class="icon-undo"></i> Selecionar ou Enviar Backup para Restauração</h4>
                      </div>
                      <div class="widget-body form">
                         <div class="alert alert-block alert-error fade in" style="border-radius: 8px;">
                            <h4 class="alert-heading" style="font-weight: 700;"><i class="icon-warning-sign"></i> Atenção!</h4>
                            <p style="margin-top: 8px; line-height: 1.5; font-size: 13px;">
                               A restauração do banco de dados irá sobrescrever todas as informações atuais (estoques, pedidos, clientes, produtos, etc.) com os dados do arquivo selecionado. Esta ação não pode ser desfeita. Recomendamos realizar um backup atual antes de prosseguir.
                            </p>
                         </div>
                         
                         <form class="form-horizontal" id="frmRestaurar" style="margin-top: 20px;" enctype="multipart/form-data">
                            <?= $util->get_csrf_token_html() ?>
                            
                            <div class="control-group">
                               <label class="control-label" style="font-weight: bold; width: 140px; text-align: left;">Backup no Servidor</label>
                               <div class="controls" style="margin-left: 160px;">
                                  <select name="backup_file" id="backup_file" class="span12" style="height: 40px; font-size: 14px; border-radius: 6px;">
                                     <option value="">-- Selecione um backup salvo no servidor --</option>
                                     <?php foreach ($backups as $b): 
                                         $name = basename($b);
                                         $mtime = date('d/m/Y H:i:s', filemtime($b));
                                         $size = number_format(filesize($b) / 1024, 2) . ' KB';
                                     ?>
                                         <option value="<?= htmlspecialchars($name) ?>">
                                            <?= htmlspecialchars($name) ?> (Gerado em: <?= $mtime ?> - Tamanho: <?= $size ?>)
                                         </option>
                                     <?php endforeach; ?>
                                  </select>
                               </div>
                            </div>
                            
                            <div style="text-align: center; margin: 15px 0 15px 160px; font-weight: bold; color: #666; font-size: 14px;">ou</div>
                            
                            <div class="control-group">
                               <label class="control-label" style="font-weight: bold; width: 140px; text-align: left;">Fazer Upload (.sql)</label>
                               <div class="controls" style="margin-left: 160px;">
                                  <input type="file" name="backup_upload" id="backup_upload" accept=".sql" style="font-size: 14px;" />
                                  <span class="help-block" style="font-size: 11px; color: #777;">Envie um arquivo de backup local do seu computador.</span>
                               </div>
                            </div>
                            
                            <div class="form-actions" style="padding-left: 160px; background-color: transparent; border-top: none;">
                               <button type="submit" class="btn btn-danger" id="btnRestaurar" style="border-radius: 6px; padding: 8px 20px; font-weight: 600;">
                                  <i class="icon-undo"></i> Iniciar Restauração
                               </button>
                            </div>
                         </form>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
   </div>
   
   <?php include("rodape.php"); ?>
   
   <script src="js/jquery-1.8.3.min.js"></script>
   <script src="assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="js/jquery.blockui.js"></script>
   <script src="js/scripts.js"></script>
   
   <script>
      jQuery(document).ready(function() {
         App.init();
         
         $('#frmRestaurar').on('submit', function(e) {
            e.preventDefault();
            
            var serverFile = $('#backup_file').val();
            var uploadFile = $('#backup_upload').val();
            
            if (!serverFile && !uploadFile) {
               window.showToast("Por favor, selecione um backup do servidor ou envie um arquivo local.", "warning");
               return;
            }
            
            var displayName = uploadFile ? uploadFile.split('\\').pop() : serverFile;
            
            window.customConfirm(
               "Deseja realmente restaurar o backup '" + displayName + "'? Todos os dados atuais serão substituídos!",
               function() {
                  App.blockUI('#main-content');
                  
                  var formData = new FormData($('#frmRestaurar')[0]);
                  formData.append('action', 'restaurar');
                  
                  $.ajax({
                     url: 'restaurar_backup.php',
                     type: 'POST',
                     data: formData,
                     processData: false,
                     contentType: false,
                     dataType: 'json',
                     success: function(response) {
                        App.unblockUI('#main-content');
                        if (response.success) {
                           window.showToast("Backup restaurado com sucesso! Redirecionando...", "success");
                           setTimeout(function() {
                              window.location.href = 'index.php';
                           }, 2500);
                        } else {
                           window.showToast("Erro ao restaurar backup: " + response.error, "error");
                        }
                     },
                     error: function(xhr, status, error) {
                        App.unblockUI('#main-content');
                        window.showToast("Erro na comunicação com o servidor.", "error");
                     }
                  });
               }
            );
         });
      });
   </script>
</body>
</html>
