<?php

/**
 * Debuga imprimindo numa \<div> com position fixed em cima de tudo.
 * @param mixed $var A variável a debugar.
 * @return void HTML com o debug
 */
function debug_absolute($var): void
{
?>
  <div style="position: fixed; top: 0; left: 0; width: 100%; background-color: white; z-index: 9999; padding: 20px; overflow: auto;">
    <pre>
<?= htmlspecialchars(print_r($var, true)); ?>
</pre>
  </div>
<?php
}

/**
 * Simplesmente imprime o var_dump já dentro da tag \<pre>.
 * @param mixed $var A variável a debugar.
 * @return void Imprime HTML com o debug.
 */
function debug_dump(mixed $var): void
{
?>
  <pre>
  <?= var_dump($var); ?>
</pre>
<?php
}

/**
 * Debuga usando a tag HTML de \<details>.
 * @param mixed $var A variável a debugar.
 * @param string $summary O título o summary da tag.
 * @return void Imprime HTML com o debug.
 */
function debug_details(mixed $var, string $summary = 'debug'): void
{
?>
  <details>
    <summary><?= $summary; ?></summary>
    <pre><?php var_dump($var); ?></pre>
  </details>
<?php
}

/**
 * Realça a sintaxe de uma variável e a exibe em um formato legível.
 *
 * Esta função recebe uma variável, converte seu valor para uma string legível usando `var_export`,
 * e então usa `highlight_string` para realçar a sintaxe PHP. Após isso, remove os primeiros e
 * últimos elementos <span> gerados pelo `highlight_string` para limpar a saída.
 * Finalmente, a execução do script é interrompida com `die()`.
 *
 * @param mixed $var A variável a ser exibida com realce de sintaxe.
 * @return void
 */
function debug_highlight(mixed $var): void
{
  highlight_string("<?php\n " . var_export($var, true) . "?>");
?>
  <script>
    document.getElementsByTagName("code")[0].getElementsByTagName("span")[1].remove();
    document.getElementsByTagName("code")[0].getElementsByTagName("span")[document.getElementsByTagName("code")[0].getElementsByTagName("span").length - 1].remove();
  </script>
<?php
  die();
}

/**
 * Gera um log para o Woo.
 * @param string $mensagem Mensagem a ser registrada no log
 * @param string $level Nível do log. Pode ser 'emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', ou 'debug'. Padrão é 'info'.
 * 
 * @return void
 */
function debug_woo(string $mensagem, string $level = 'info'): void
{
  if (!class_exists('WC_Logger')) return;

  $logger = new WC_Logger();
  $context = array('source' => 'alpina');
  $logger->log($level, $mensagem, $context);
}
