ready_prefixes.php, это заготовка готовых
префиксов. Их можно использовать для setPrefix
или /prefix вместо ввода самого префикса
(должны начинаться с "!"). Например
"/setprefix !example", тогда вместо "!example"
будет "EXAMPLE" как указано в ready_prefixes.yml
(так же и для метода setPrefix). Очень полезно
если хотите сохранить сложные префиксы.
Команда  с использованием заготовки доступна только с
разрешением "pe.prefixes.ready.prefixes", в ином
случае при использовании знака "!", игроку выкенет
ошибку.

Все разрешение списком ниже:
Команды setprefix, delprefix: pe.prefixes.default
Команды setprefixto, delprefixfrom, addfastprefix: pe.prefixes.admin.commands
Возможность использовать заготовленные префиксы: pe.prefixes.ready.prefixes