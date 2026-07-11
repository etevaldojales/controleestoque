- [x] Inspecionar `lib/classes/config.php` e identificar credenciais/host do banco
- [x] Corrigir o host de conexão: `localhost` -> `127.0.0.1` em `lib/classes/config.php`
- [ ] Corrigir `lib/classes/class.pedido.php` para não acessar `$rs->EOF` quando `$rs` for `false` (causando warnings)
- [ ] Recarregar a aplicação e validar se os warnings/erros cessaram

