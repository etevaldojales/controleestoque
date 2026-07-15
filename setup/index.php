<?php
/**
 * Assistente de Instalação do Controle de Estoque
 */

// Define helper functions
function get_current_config() {
    $config = [
        'local' => '127.0.0.1',
        'user' => 'root',
        'pass' => '',
        'bd' => 'controlestoque'
    ];
    
    $configFile = '../lib/classes/config.php';
    if (file_exists($configFile)) {
        $content = file_get_contents($configFile);
        
        if (preg_match('/\$CONF\[\'local\'\]\s*=\s*"(.*?)";/', $content, $matches)) {
            $config['local'] = $matches[1];
        }
        if (preg_match('/\$CONF\[\'user\'\]\s*=\s*"(.*?)";/', $content, $matches)) {
            $config['user'] = $matches[1];
        }
        if (preg_match('/\$CONF\[\'pass\'\]\s*=\s*"(.*?)";/', $content, $matches)) {
            $config['pass'] = $matches[1];
        }
        if (preg_match('/\$CONF\[\'bd\'\]\s*=\s*"(.*?)";/', $content, $matches)) {
            $config['bd'] = $matches[1];
        }
    }
    return $config;
}

function executeSqlFile($link, $filePath) {
    if (!file_exists($filePath)) {
        throw new Exception("Arquivo de instalação '$filePath' não encontrado.");
    }
    
    $sql = file_get_contents($filePath);
    // Remove comments
    $sql = preg_replace('/^[#\-].*$/m', '', $sql);
    
    // Split by semicolons at the end of lines
    $queries = preg_split('/;\s*$/m', $sql);
    
    foreach ($queries as $query) {
        $query = trim($query);
        if (empty($query)) continue;
        
        // Dynamically run DROP TABLE IF EXISTS before CREATE TABLE statements
        if (preg_match('/CREATE TABLE\s+(IF NOT EXISTS\s+)?`([^`]+)`/i', $query, $matches)) {
            $tableName = $matches[2];
            mysqli_query($link, "DROP TABLE IF EXISTS `$tableName`");
        }
        
        if (!mysqli_query($link, $query)) {
            throw new Exception("Erro ao executar SQL: " . mysqli_error($link) . "\nComando: " . substr($query, 0, 100) . "...");
        }
    }
}

// Security: check if installation lock exists
$locked = file_exists('install.lock');

// Handle AJAX actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    header('Content-Type: application/json; charset=utf-8');
    
    if ($locked) {
        echo json_encode(['success' => false, 'error' => 'A instalação já foi realizada e está bloqueada. Remova o arquivo setup/install.lock para reinstalar.']);
        exit;
    }
    
    $action = $_GET['action'];
    
    if ($action === 'test_connection') {
        $host = $_POST['host'] ?? '';
        $user = $_POST['user'] ?? '';
        $pass = $_POST['pass'] ?? '';
        $name = $_POST['name'] ?? '';
        
        if (empty($host) || empty($user) || empty($name)) {
            echo json_encode(['success' => false, 'error' => 'Campos obrigatórios ausentes.']);
            exit;
        }
        
        // Connect to mysql server
        $link = @mysqli_connect($host, $user, $pass);
        if (!$link) {
            echo json_encode(['success' => false, 'error' => mysqli_connect_error()]);
            exit;
        }
        
        // Select or create DB
        $db_selected = @mysqli_select_db($link, $name);
        if (!$db_selected) {
            $create_query = "CREATE DATABASE IF NOT EXISTS `" . mysqli_real_escape_string($link, $name) . "` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
            if (!@mysqli_query($link, $create_query)) {
                echo json_encode(['success' => false, 'error' => 'Não foi possível criar o banco de dados: ' . mysqli_error($link)]);
                @mysqli_close($link);
                exit;
            }
        }
        @mysqli_close($link);
        
        // Write config
        $configFile = '../lib/classes/config.php';
        if (!file_exists($configFile)) {
            echo json_encode(['success' => false, 'error' => 'Arquivo lib/classes/config.php não encontrado.']);
            exit;
        }
        
        $configContent = file_get_contents($configFile);
        $configContent = preg_replace('/\$CONF\[\'local\'\]\s*=\s*.*?;/', '$CONF[\'local\'] = "' . addslashes($host) . '";', $configContent);
        $configContent = preg_replace('/\$CONF\[\'user\'\]\s*=\s*.*?;/', '$CONF[\'user\'] = "' . addslashes($user) . '";', $configContent);
        $configContent = preg_replace('/\$CONF\[\'pass\'\]\s*=\s*.*?;/', '$CONF[\'pass\'] = "' . addslashes($pass) . '";', $configContent);
        $configContent = preg_replace('/\$CONF\[\'bd\'\]\s*=\s*.*?;/', '$CONF[\'bd\'] = "' . addslashes($name) . '";', $configContent);
        
        if (@file_put_contents($configFile, $configContent) === false) {
            echo json_encode(['success' => false, 'error' => 'Sem permissão de escrita no arquivo lib/classes/config.php.']);
            exit;
        }
        
        echo json_encode(['success' => true]);
        exit;
    }
    
    if ($action === 'install_db') {
        $config = get_current_config();
        
        $link = @mysqli_connect($config['local'], $config['user'], $config['pass'], $config['bd']);
        if (!$link) {
            echo json_encode(['success' => false, 'error' => 'Erro de conexão com o banco salvo: ' . mysqli_connect_error()]);
            exit;
        }
        
        mysqli_set_charset($link, 'utf8');
        
        try {
            executeSqlFile($link, 'structure.sql');
            executeSqlFile($link, 'seeds.sql');
            @mysqli_close($link);
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            @mysqli_close($link);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }
    
    if ($action === 'create_admin') {
        $config = get_current_config();
        
        $name = $_POST['name'] ?? '';
        $login = $_POST['login'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $projectName = $_POST['project_name'] ?? '';
        
        if (empty($name) || empty($login) || empty($password) || empty($projectName)) {
            echo json_encode(['success' => false, 'error' => 'Dados administrativos ou nome do projeto incompletos.']);
            exit;
        }
        
        $link = @mysqli_connect($config['local'], $config['user'], $config['pass'], $config['bd']);
        if (!$link) {
            echo json_encode(['success' => false, 'error' => 'Erro de conexão: ' . mysqli_connect_error()]);
            exit;
        }
        
        mysqli_set_charset($link, 'utf8');
        
        $nameEsc = mysqli_real_escape_string($link, $name);
        $loginEsc = mysqli_real_escape_string($link, $login);
        $emailEsc = mysqli_real_escape_string($link, $email);
        $passwordHash = md5(trim($password));
        
        // Insert admin user
        $query = "INSERT INTO usuarios (login, senha, email, nome, telefone, foto, ativo, tipo_usuario) 
                  VALUES ('$loginEsc', '$passwordHash', '$emailEsc', '$nameEsc', '', '', 1, 1)";
                  
        if (!mysqli_query($link, $query)) {
            echo json_encode(['success' => false, 'error' => 'Erro ao criar usuário no banco: ' . mysqli_error($link)]);
            @mysqli_close($link);
            exit;
        }
        
        $userId = mysqli_insert_id($link);
        
        // Map all sections to the admin
        $sections = [];
        $secRes = mysqli_query($link, "SELECT id FROM secoes");
        while ($row = mysqli_fetch_assoc($secRes)) {
            $secId = $row['id'];
            mysqli_query($link, "INSERT INTO usuarios_secoes (id_usuario, id_secoes) VALUES ($userId, $secId)");
            $sections[] = $secId;
        }
        
        // Map all subsections to the admin
        $mappedSections = [];
        $subRes = mysqli_query($link, "SELECT id, id_secao FROM subsecoes");
        while ($row = mysqli_fetch_assoc($subRes)) {
            $subId = $row['id'];
            $secId = $row['id_secao'];
            mysqli_query($link, "INSERT INTO usuarios_subsecoes (id_usuario, id_secao, id_subsecao) VALUES ($userId, $secId, $subId)");
            $mappedSections[$secId] = true;
        }
        
        // Handle sections that don't have subsections (map subsecao as 0)
        foreach ($sections as $secId) {
            if (!isset($mappedSections[$secId])) {
                mysqli_query($link, "INSERT INTO usuarios_subsecoes (id_usuario, id_secao, id_subsecao) VALUES ($userId, $secId, 0)");
            }
        }

        // Configure project name in the database
        $projectNameEsc = mysqli_real_escape_string($link, $projectName);
        $empRes = mysqli_query($link, "SELECT id FROM tblempresa WHERE id = 1");
        if (mysqli_num_rows($empRes) > 0) {
            mysqli_query($link, "UPDATE tblempresa SET nome = '$projectNameEsc', stativo = 1 WHERE id = 1");
        } else {
            mysqli_query($link, "INSERT INTO tblempresa (id, nome, stativo) VALUES (1, '$projectNameEsc', 1)");
        }
        
        @mysqli_close($link);
        
        // Create lock file
        if (@file_put_contents('install.lock', date('Y-m-d H:i:s') . "\n") === false) {
            echo json_encode(['success' => false, 'error' => 'Erro ao criar lock file. Verifique permissões da pasta setup.']);
            exit;
        }
        
        echo json_encode(['success' => true]);
        exit;
    }
}

// Load current configuration values
$current_config = get_current_config();
$folderName = basename(dirname(__DIR__));
$defaultProjectName = ucwords(str_replace(['_', '-'], ' ', $folderName));
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <title>Instalação do Controle de Estoque</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href="setup.css" rel="stylesheet" />
</head>
<body>

  <div class="setup-container">
    
    <?php if ($locked): ?>
      <!-- Lock Screen -->
      <div class="lock-panel">
        <i class="icon-lock"></i>
        <h2>Instalação Bloqueada</h2>
        <p>
          O sistema de controle de estoque já foi configurado e instalado com sucesso. 
          O arquivo de bloqueio de segurança <code>setup/install.lock</code> foi encontrado.
        </p>
        <div class="alert alert-error">
          <i class="icon-warning-sign"></i>
          <span>
            <strong>Atenção:</strong> Por motivos de segurança, você não pode reinstalar o banco de dados. 
            Se você deseja reinstalar o sistema do zero (o que excluirá os dados atuais!), 
            remova manualmente o arquivo <strong>setup/install.lock</strong> no servidor e recarregue esta página.
          </span>
        </div>
        <div class="actions" style="justify-content: center; margin-top: 40px;">
          <a href="../login.php" class="btn btn-primary" style="text-decoration: none;">
            Ir para a Tela de Login <i class="icon-signin"></i>
          </a>
        </div>
      </div>
      
    <?php else: ?>
      <!-- Wizard Steps Header -->
      <div class="setup-header">
        <h1>Instalação do Sistema</h1>
        <p>Configure o banco de dados e a conta de administrador inicial</p>
      </div>

      <div class="stepper">
        <div class="step-progress"></div>
        <div class="step active" data-step="1">
          <div class="step-icon">1</div>
          <div class="step-label">Conexão</div>
        </div>
        <div class="step" data-step="2">
          <div class="step-icon">2</div>
          <div class="step-label">Banco</div>
        </div>
        <div class="step" data-step="3">
          <div class="step-icon">3</div>
          <div class="step-label">Acesso</div>
        </div>
      </div>

      <!-- STEP 1: Database Credentials -->
      <div id="panel-step1" class="step-panel active">
        <div id="alert-step1" class="alert" style="display:none;"></div>
        
        <div class="form-group">
          <label for="db_host">Servidor do Banco de Dados <span style="color:var(--error-color)">*</span></label>
          <div class="input-wrapper">
            <i class="icon-hdd input-icon"></i>
            <input type="text" id="db_host" placeholder="Ex: localhost ou 127.0.0.1" value="<?= htmlspecialchars($current_config['local']) ?>" required />
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="db_user">Usuário <span style="color:var(--error-color)">*</span></label>
            <div class="input-wrapper">
              <i class="icon-user input-icon"></i>
              <input type="text" id="db_user" placeholder="Ex: root" value="<?= htmlspecialchars($current_config['user']) ?>" required />
            </div>
          </div>
          <div class="form-group">
            <label for="db_pass">Senha</label>
            <div class="input-wrapper">
              <i class="icon-key input-icon"></i>
              <input type="password" id="db_pass" placeholder="Senha do banco de dados" value="<?= htmlspecialchars($current_config['pass']) ?>" />
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="db_name">Nome do Banco de Dados <span style="color:var(--error-color)">*</span></label>
          <div class="input-wrapper">
            <i class="icon-briefcase input-icon"></i>
            <input type="text" id="db_name" placeholder="Ex: controlestoque" value="<?= htmlspecialchars($current_config['bd']) ?>" required />
          </div>
        </div>

        <div class="actions">
          <button type="button" id="btn-step1" class="btn btn-primary">
            Testar e Salvar Conexão <i class="icon-chevron-right"></i>
          </button>
        </div>
      </div>

      <!-- STEP 2: Database installation status -->
      <div id="panel-step2" class="step-panel">
        <div id="alert-step2" class="alert" style="display:none;"></div>
        
        <ul class="progress-list">
          <li class="progress-item" id="progress-structure">
            <div class="progress-icon">1</div>
            <div class="progress-text">Instalar estrutura de tabelas limpa</div>
          </li>
          <li class="progress-item" id="progress-seeds">
            <div class="progress-icon">2</div>
            <div class="progress-text">Popular dados padrão do sistema</div>
          </li>
        </ul>

        <div class="actions">
          <button type="button" id="btn-step2" class="btn btn-primary">
            Instalar Tabelas e Seeds <i class="icon-chevron-right"></i>
          </button>
        </div>
      </div>

      <!-- STEP 3: Administrator details -->
      <div id="panel-step3" class="step-panel">
        <div id="alert-step3" class="alert" style="display:none;"></div>

        <div class="form-group">
          <label for="project_name">Nome do Projeto / Empresa <span style="color:var(--error-color)">*</span></label>
          <div class="input-wrapper">
            <i class="icon-tag input-icon"></i>
            <input type="text" id="project_name" placeholder="Ex: Controle de Estoque" value="<?= htmlspecialchars($defaultProjectName) ?>" required />
          </div>
        </div>

        <div class="form-group">
          <label for="admin_name">Nome Completo <span style="color:var(--error-color)">*</span></label>
          <div class="input-wrapper">
            <i class="icon-user input-icon"></i>
            <input type="text" id="admin_name" placeholder="Ex: Administrador Geral" required />
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="admin_login">Usuário de Acesso <span style="color:var(--error-color)">*</span></label>
            <div class="input-wrapper">
              <i class="icon-lock input-icon"></i>
              <input type="text" id="admin_login" placeholder="Ex: admin" required />
            </div>
          </div>
          <div class="form-group">
            <label for="admin_email">E-mail</label>
            <div class="input-wrapper">
              <i class="icon-envelope input-icon"></i>
              <input type="email" id="admin_email" placeholder="Ex: admin@dominio.com" />
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="admin_pass">Senha de Acesso <span style="color:var(--error-color)">*</span></label>
          <div class="input-wrapper">
            <i class="icon-key input-icon"></i>
            <input type="password" id="admin_pass" placeholder="Defina a senha do administrador" required />
          </div>
        </div>

        <div class="actions">
          <button type="button" id="btn-step3" class="btn btn-primary">
            Finalizar Instalação <i class="icon-check"></i>
          </button>
        </div>
      </div>
      
    <?php endif; ?>
    
  </div>

  <script src="../js/jquery-1.8.3.min.js"></script>
  <script src="setup.js"></script>
</body>
</html>
