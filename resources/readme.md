**`ready_prefixes.php`** — это заготовка готовых префиксов. Их можно использовать в командах `/setprefix` или `/prefix` вместо ввода самого префикса (заготовки должны начинаться с "!"). Например, при вводе команды `/setprefix !example` вместо "!example" будет установлен префикс "EXAMPLE", как указано в файле `ready_prefixes.yml` (так же и для метода `setPrefix`). Это очень полезно, если вы хотите использовать сложные префиксы. Команда с использованием заготовки доступна только при наличии разрешения **`pe.prefixes.ready.prefixes`**. В противном случае при использовании префикса, начинающегося со знака "!", игрок получит ошибку.
Формат префикса можно настроить в файле `messages.ini`.

**Список разрешений:**
- Команды `setprefix`, `delprefix`: **`pe.prefixes.default`**
- Команды `setprefixto`, `delprefixfrom`, `addreadyprefix`, `delreadyprefix` + игнорирование лимита: **`pe.prefixes.admin.commands`**
- Возможность использовать заготовленные префиксы: **`pe.prefixes.ready.prefixes`**