@echo off
:: UTF-8 codepage
chcp 65001 > nul

echo ==============================================================
echo   Configuração do Backup Automático do Controle de Estoque
echo ==============================================================
echo.
echo Este script registrará uma tarefa no Windows Task Scheduler.
echo Ela executará o backup a cada 12 horas.
echo.
echo NOTA: É recomendável executar este arquivo como Administrador.
echo.
pause

:: Create hourly task with 12-hour interval starting at 00:00
schtasks /create /tn "ControleEstoque_Backup" /tr "C:\xampp\php\php.exe c:\xampp\htdocs\controleestoque\cron_backup.php" /sc hourly /mo 12 /st 00:00 /f

if %errorlevel% equ 0 (
    echo.
    echo ==============================================================
    echo [SUCESSO] Tarefa registrada com êxito!
    echo O banco de dados controlestoque será salvo a cada 12 horas.
    echo os backups ficarão salvos em: c:\xampp\htdocs\controleestoque\backups\
    echo ==============================================================
) else (
    echo.
    echo ==============================================================
    echo [ERRO] Falha ao registrar a tarefa no Agendador do Windows.
    echo Por favor, clique com o botão direito no setup_task.bat e
    echo selecione "Executar como Administrador".
    echo ==============================================================
)
echo.
pause
